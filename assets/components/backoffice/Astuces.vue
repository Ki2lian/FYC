<template>
  <div>
    <SideBar />
    <div class="admin__utilisateurs page-content" id="content">
      <!-- Toggle button -->
      <button
        id="sidebarCollapse"
        type="button"
        class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"
      >
        <i class="fa fa-bars mr-2"></i
        ><small class="text-uppercase font-weight-bold ms-2">Menu</small>
      </button>
      <h2 class="text-white">Astuces</h2>
      <div class="table">
        <v-data-table
          :headers="headers"
          :items="tips"
          :items-per-page="5"
          item-key="owner"
          class="elevation-1"
          :search="search"
          loading
          loading-text="Chargement en cours..."
          no-results-text="Pas d'astuces trouvées"
        >
          <template v-slot:top>
            <v-text-field
              v-model="search"
              label="Rechercher"
              class="mx-4"
            ></v-text-field>
          </template>

          <template v-slot:item.user="{ item }">
              <span>{{ item.user.pseudo }}</span>
          </template>
          <template v-slot:item.ratings="{ item }">
              <span v-html="getStars(item.ratings)"></span>
          </template>
          <template v-slot:item.comments="{ item }">
              <span>{{ item.comments.length }}</span>
          </template>
          <template v-slot:item.createdAt="{ item }">
              <span>{{ getCreatedAt(item.createdAt) }}</span>
          </template>
          <template v-slot:item.action="{ item }">
            <div class="d-flex align-items-center">
              <button class="btn p-1" @click="showTip(item)"><i class="fas fa-eye text-secondary"></i></button>
              <button class="btn p-1" @click="editTip(item)"><i class="fas fa-edit text-primary"></i></button>
              <v-simple-checkbox
                @click.prevent="validTip(item, $event)"
                v-model="item.isValid"
              ></v-simple-checkbox>
              <button class="btn p-1" @click="deleteTip(item)"><i class="fas fa-trash text-danger"></i></button>
            </div>
          </template>
        </v-data-table>
      </div>
    </div>
  </div>
</template>

<script>
import SideBar from "./SidebarBackOffice.vue";
import axios from "axios";

export default {
  props: {
      tipsObj: {
          type: String,
          required: true
      }
  },
  data() {
    return {
      headers: [
        { text: "ID", align: 'start', value:"id" },
        { text: "Auteur", value:"user" },
        { text: "Titre", value:"title" },
        { text: "Note (moyenne)", value:"ratings" },
        { text: "Commentaires", value:"comments" },
        { text: "Date de création", value:"createdAt" },
        { text: "Action", value:"action", sortable: false, align: 'center' },
      ],
      search: "",
      tips: [],
    };
  },
  beforeMount() {
    this.tips = JSON.parse(this.tipsObj);
  },
  mounted() {
    
  },

  components: {
    SideBar,
  },

  methods: {
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
    getCreatedAt(createdAt) {
        let date = new Date(createdAt)
        let day = ("0" + date.getDate()).slice(-2)
        let month = ("0" + (date.getMonth() + 1)).slice(-2)
        let year = date.getFullYear()
        return `${day}/${month}/${year}`
    },
    showTip(tip) {
        window.open(
            `/tip/${tip.id}`,
            '_blank'
        );
    },
    editTip(tip) {
        window.open(
            `/edit_tip/${tip.id}`,
            '_blank'
        );
    },
    deleteTip(tip) {
        if(!window.confirm(`Voulez-vous vraiment supprimer cette astuce ? (${tip.title})`)) return;
		const formData = new FormData();
		formData.append('id', tip.id)
		axios.delete(`/api/tip/${tip.id}`, { headers: {"X-Requested-With": "XMLHttpRequest"} })
			.then(res => {
				const response = res.data;
				if(!response.errors){
					this.tips = this.tips.filter(t => t.id !== tip.id)
				}else{
					var errorsHtml = "";
					response.errors.forEach((error) => errorsHtml += `<li>${error.message}</li>`);
					$(".form-error").html(`<ul>${errorsHtml}</ul>`);
					$(".form-error").slideDown();
				}
			});
    },
	validTip(tip, e) {
    var sentence = "Voulez-vous valider cette astuce ?"
    if(!tip.isValid) sentence = "Voulez-vous ne plus afficher cette astuce ?"
		if(!window.confirm(`${sentence} (${tip.title})`)){
			tip.isValid = !tip.isValid;
			return;
		};
		const formData = new FormData();
		formData.append('id', tip.id)
		formData.append('isValid', tip.isValid)
		axios.post(`/api/backoffice/valid_tip`, formData, { headers: {"X-Requested-With": "XMLHttpRequest"} })
			.catch(err => {
				tip.isValid = !tip.isValid
				console.error(err)
			});
	},
  },
};
</script>

<style lang="scss" scoped>
$interactive_text: #5147c5;
$interactive_text_dark: #413999;

.form-switch{
	min-height: 0px;
    padding-left: 2.8em;
}
.admin__utilisateurs {
  display: flex;
  flex-direction: column;
  align-items: center;
  background: #5147c5;
  background: -webkit-linear-gradient(to right, #5147c5, #d8d8d8);
  background: linear-gradient(to right, #5147c5, #d8d8d8);
  min-height: 100vh;
  overflow-x: hidden;
}

.table {
  width: 80%;
}

h2 {
  margin: 1em 0px 1em 0px;
}

.pointer {
  cursor: pointer;
}

a {
  color: $interactive_text;
  text-decoration: none;
}

.icon_color {
  color: #C82323;
}

.page-content {
  width: calc(100% - 17rem);
  margin-left: 17rem;
  transition: all 0.4s;
}

#content.active {
  width: 100%;
  margin: 0;
}

@media (max-width: 768px) {
  #content {
    width: 100%;
    margin: 0;
  }
  #content.active {
    margin-left: 17rem;
    width: calc(100% - 17rem);
  }
}

#sidebarCollapse {
  align-self: start;
  margin-left: 2em;
  margin-top: 2em;
}
</style>