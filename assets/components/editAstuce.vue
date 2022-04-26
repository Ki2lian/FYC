<template>
  <v-app class="background">
    <NavBar />
    <div class="title">
      <v-icon x-large class="mr-4" color="#5147C5">mdi-plus-box</v-icon>
      <h2>Modifier une astuce</h2>
    </div>
    <v-main>
      <v-form ref="form" v-model="validForm" class="mb-4">
        <v-container>
			<div class="alert alert-danger form-error mt-3" style="display: none;" role="alert"></div>
          <v-row class="justify-center">
            <v-col cols="12" sm="12" md="12" lg="12">
              <v-text-field
                v-model="form.title"
                label="Titre de votre astuce"
                prepend-icon="mdi-format-title"
                :rules="titleRules"
              />
              <v-autocomplete
                v-model="form.tags"
                :items="tags"
                label="Tags de votre astuce"
                prepend-icon="mdi-tag-multiple-outline"
                hint="Maximum de 5 tags"
                persistent-hint
                multiple
                chips
              ></v-autocomplete>
              <div class="mt-3">
                <editor
                  api-key="8gaq38a4l7phvys7xzkj0o9cu8xpkysca6vlbszoarqmeuwo"
                  v-model="form.content"
                  id="uuid"
                  :init="{
                    height: 500,
                    menubar: true,
                    language: 'fr_FR',
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
              </div>
              <div class="d-flex justify-content-center">
                <v-btn
                  elevation="0"
                  :disabled="!validForm"
                  color="success"
                  class="mr-4 mt-5"
                  @click="validate"
                >
                  Modifier mon astuce
                </v-btn>
              </div>
            </v-col>
          </v-row>
        </v-container>
      </v-form>
      <Footer />
    </v-main>
  </v-app>
</template>



<script>
	import Editor from "@tinymce/tinymce-vue";
	import Footer from "./component/FooterVue.vue";
	import NavBar from "./component/NavBar.vue";
	import axios from "axios";

	export default {
		props: {
			tagsObj: {
                type: String,
                default: "",
			},
			tipObj: {
                type: String,
                default: "",
			},
		},
        beforeMount() {
            this.tagsTemp = JSON.parse(this.tagsObj);
            this.tip = JSON.parse(this.tipObj);
            this.tagsTemp.forEach((tag) => {
                this.tags.push(tag.name);
            });
            this.form.title = this.tip.title;
            this.tip.tag.forEach((tag) => {
                this.form.tags.push(tag.name);
            });
            this.form.content = this.tip.content;
            
        },
		mounted() {
            
		},
		data() {
			return {
				form: {
					title: null,
					content: null,
					tags: [],
				},

				tags: [],
                tip: null,
				tagsTemp: [],

				validForm: true,

			// RULES
				titleRules: [(v) => !!v || "Veuillez préciser un titre à votre astuce."],
			};
		},
		watch: {
			form: {
				handler: function (val, oldVal) {
					if (val.tags.length > 5) {
						this.$nextTick(() => this.form.tags.pop());
					}
				},
				deep: true,
			},
		},

		components: {
			Editor,
			Footer,
			NavBar,
		},

		methods: {
			validate: function () {
				if (this.form.content == null) return;
				const formData = new FormData();
				formData.append("tip[title]", this.form.title);
				formData.append("tip_id", this.tip.id);
				formData.append("tip[content]", this.form.content);
				formData.append("tags", this.form.tags.join(","));
				$(".form-error").hide();
				axios.post("/api/tip/edit", formData, {
						headers: {
							"X-Requested-With": "XMLHttpRequest",
						},
					})
					.then((res) => {
						const response = res.data;
						if(!response.errors){
							// Redirection vers la page de l'astuce
							window.location.href = "/tip/" + response.info.id;
						}else{
							var errorsHtml = "";
							response.errors.forEach((error) => errorsHtml += `<li>${error.message}</li>`);
							$(".form-error").html(`<ul>${errorsHtml}</ul>`);
							$(".form-error").slideDown();
							$("html, body").animate({ scrollTop: 0 });
						}
					});
			},
		},
	};
</script>

<style scoped>
	.background {
	background-color: #d8d8d8;
	}

	.title {
	display: flex;
	justify-content: center;
	align-items: center;
	}

	h2 {
	margin-bottom: 0;
	}
</style>