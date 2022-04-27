<template>
  <div class="container__astuce">
    <NavBar class="fixed" />

    <div class="title d-flex">
      <h1>{{ tip.title }}</h1>
    </div>

    <div class="container">
		<div class="row jumbotron">
		<p class="text__trait col">Auteur : {{ tip.user.pseudo }}</p>
		<p class="text__trait col">Créer : {{ dateFromNow(tip.createdAt) }}</p>
		<p class="text__trait col">Modifier : {{ dateFromNow(tip.updatedAt) }}</p>
		<p class="text__trait col">Note : <span v-html="getStars(tip.ratings)"></span></p>
		<hr class="trait my-4" />
		</div>
		<div class="body-container">
			<div class="astuce">
				<div v-html="tip.content"></div>
				<div class="tags mb-4">
					<a class="tag text-dark mb-1" :href="'/tips/tagged/' + tag.name" v-for="tag in tip.tag" :key="tag.id">{{ tag.name }}</a>
				</div>
				<div class="d-flex align-items-center">
					<span class="me-1">L'astuce vous a été utile ?</span>
					<button class="btn p-0 mx-1" @click="vote(1)"><i class="fas fa-thumbs-up text-success"></i></button>
					<span class="mx-1">(<span>{{ note(tip.ratings) }}</span>)</span>
					<button class="btn p-0 ms-1" @click="vote(-1)"><i class="fas fa-thumbs-down text-danger"></i></button>
				</div>
			</div>
		</div>

		<div class="tips">
			<p>{{ tip.comments.length }} {{ "réponse" | pluralize(tip.comments.length) }}</p>
			<div class="container__tips">

				<div v-for="comment in tip.comments" :key="comment.id">
					<div v-html="comment.content"></div>
					<div class="container__card">
						<div class="card">
							<div class="card-body">
								<p class="card-title">Répondu {{ dateFromNow(comment.createdAt) }}</p>
								<div class="logo d-flex">
									<img src="../img/user-solid.svg" :alt="'Image de profil de ' + comment.user.pseudo" />
									<p>{{ comment.user.pseudo }}</p>
								</div>
							</div>
						</div>
					</div>
					<hr class="my-12" />
				</div>
			</div>
		</div>

		<div class="commentaire">
		<div class="container">
			<p>Votre commentaire :</p>
			<div class="alert alert-danger form-error mt-2" style="display: none;" role="alert"></div>
			<editor
			api-key="8gaq38a4l7phvys7xzkj0o9cu8xpkysca6vlbszoarqmeuwo"
			id="addComment"
			v-model="comment"
			:init="{
				height: 300,
				menubar: true,
				plugins: [
				'advlist autolink lists link image charmap print preview anchor',
				'searchreplace visualblocks code fullscreen',
				'insertdatetime media table paste code help wordcount codesample',
				],
				toolbar:
				'undo redo | formatselect | bold italic backcolor | \
				alignleft aligncenter alignright alignjustify | \
				bullist numlist outdent indent | removeformat | help codesample',
				codesample_languages: [
					{text: 'HTML/XML', value: 'html'},
					{text: 'JavaScript', value: 'javascript'},
					{text: 'CSS', value: 'css'},
					{text: 'PHP', value: 'php'},
					{text: 'Ruby', value: 'ruby'},
					{text: 'Python', value: 'python'},
					{text: 'Java', value: 'java'},
					{text: 'C', value: 'c'},
					{text: 'C#', value: 'csharp'},
					{text: 'C++', value: 'cpp'}
				],
			}"
			/>

			<div class="text-privacy d-flex flex-column justify-content-center align-items-center">
				<button class="btn btn-add-comment" @click="addComment">Commenter</button>
				<div class="">
					<p>
					En cliquant sur "Commenter", vous acceptez notre
					<a href="#"> politique de confidentialité </a> et notre
					<a href=""> politique en matière de cookies</a>.
					</p>
				</div>
			</div>
		</div>
		</div>

	</div>


    <Footer />
  </div>
</template>

<script>
import NavBar from "./component/NavBar.vue";
import Footer from "./component/FooterVue.vue";
import Editor from "@tinymce/tinymce-vue";
import hljs from "highlight.js";
import 'highlight.js/styles/stackoverflow-light.css';
import * as moment from 'moment'
import axios from "axios";
moment.locale("fr")

export default {
	props: {
		tipObj: {
			type: String,
			default: "",
		},
	},
	data() {
		return {
			tip: {},
			comment: null,
		};
	},
  	components: {
		NavBar,
		Footer,
		editor: Editor,
		hljs,
  	},
  	beforeMount() {
		this.tip = JSON.parse(this.tipObj);
	},
	mounted() {
		hljs.highlightAll();
	},
	methods: {
        dateFromNow(date) {
            return moment(date).fromNow();
        },
		getStars(ratings) {
            let note = 0
            ratings.forEach(rating => note += rating.value)
            let average = Math.round((note / ratings.length) * 5)

            let html = ''
            for (let i = 1; i <= 5; i++) {
                if(i <= average) html += '<i class="fas fa-star fa-lg" style="color: #FFD700; filter: drop-shadow(0px 0px 2px #000);"></i>'
                else html += '<i class="far fa-star fa-lg" style="color: #FFD700; filter: drop-shadow(0px 0px 2px #000);"></i>'
            }
            return html
        },
		addComment() {
			if (this.comment == null) return;
			$(".form-error").hide();
			const formData = new FormData();
			formData.append("comment[content]", this.comment);
			formData.append("tip_id", this.tip.id);
			axios.post("/api/comment", formData, {
						headers: {
							"X-Requested-With": "XMLHttpRequest",
						},
					})
				.then(res => {
					const response = res.data;
					if(!response.errors){
						this.tip.comments.push(response.info);
						setTimeout(() => {
							hljs.highlightAll();
						}, 1);
						tinymce.get("addComment").setContent("<p></p>");
					}else{
						var errorsHtml = "";
						response.errors.forEach((error) => errorsHtml += `<li>${error.message}</li>`);
						$(".form-error").html(`<ul>${errorsHtml}</ul>`);
						$(".form-error").slideDown();
					}
				})
			
		},
		vote(number) {
			const formData = new FormData();
			formData.append("tip_id", this.tip.id);
			formData.append("rating[value]", number);
			axios.post("/api/rating", formData, {
						headers: {
							"X-Requested-With": "XMLHttpRequest",
						},
					})
				.then(res => {
					const response = res.data;
					this.tip.ratings.forEach((rating, idx) => {
						if(rating.user.id == response.info.user.id) {
							rating.value = response.info.value;
						}
						else if(idx == this.tip.ratings.length - 1){
							this.tip.ratings.push(response.info);
						}
					});
					if(this.tip.ratings.length == 0) this.tip.ratings.push(response.info);
				})
		},
		note(ratings){
			let note = 0
			ratings.forEach(rating => note += rating.value)
			return note
		},
    },

  	computed:{
  	}
};
</script>

<style lang="scss" scoped>
$background: #d8d8d8;
$seconday_color: #eeeeee;
$interactive_text: #5147c5;
$text: #b2b2b2;

.btn-add-comment{
	background: $interactive_text;
	color: $seconday_color;
}

.tags .tag:hover{
    color: rgba(0, 0, 0, 0.3);
    cursor: pointer;
}

.tag {
    margin: 0px 10px 10px 0px;
    padding: 5px;
    background: $seconday_color;
    border: 0.5px solid $background;
    box-sizing: border-box;
    box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
	color: $interactive_text;
    text-decoration: none;
}

.tag:hover{
    background: $background;
}

.container__astuce {
  .title {
    text-align: center;
    justify-content: center;

    a {
      width: 200px;
      border-radius: 15px;
      background-color: $interactive_text;
      color: $seconday_color;
      padding: 10px;
      padding-inline: 16px;
      text-decoration: none;
      position: relative;
      font-size: 18px;
      margin-left: 10px;
    }
  }

  .row {
    margin-block: 30px;

    .trait {
      height: 3px;
    }

    .text__trait {
      margin-bottom: -35px;
      left: 10px;
      position: relative;
    }
  }

  .body-container {
    margin: 0 auto;
    width: 91%;

    .astuce {
      .astuce-text {
        margin-left: auto;
        margin-right: auto;
        text-align: justify;
      }
    }

    .container__card {
      margin-top: 40px;
      width: 100%;
      display: flex;
      justify-content: end;
      .card {
        display: inline-flex;
        .card-body {
          .logo {
            height: 40px;
            p {
              margin-left: 10px;
            }
          }
          .card-title {
            font-size: 12px;
            color: "#494949";
          }
        }
      }
    }

  }

  .commentaire {
    .container {
      margin-block: 20px;

      .btn {
        a {
          width: 25%;
          border-radius: 15px;
          background-color: $interactive_text;
          color: $seconday_color;
          padding: 10px;
          text-decoration: none;
        }
      }
    }

    .text-privacy {
      margin-block: 15px;
      a {
        color: $interactive_text;
        text-decoration: none;
      }
      p {
        margin-top: 15px;
      }
    }
  }

  .tips {
    margin-top: 40px;
    margin-inline: 55px;

    .container__tips {
      margin-inline: 25px;
      .container__card {
        margin-top: 40px;
        width: 100%;
        display: flex;
        justify-content: end;
        .card {
          display: inline-flex;
          .card-body {
            .logo {
              height: 40px;
              p {
                margin-left: 10px;
              }
            }
            .card-title {
              font-size: 12px;
              color: "#494949";
            }
          }
        }
      }
    }
  }
}
</style>