<template>
  <div>
    <SideBar />
    <div class="page-content admin__add_tag" id="content">
      <!-- Toggle button -->
      <button
        id="sidebarCollapse"
        type="button"
        class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"
      >
        <i class="fa fa-bars mr-2"></i
        ><small class="text-uppercase font-weight-bold ms-2">Menu</small>
      </button>
      	<h2 class="text-white">Tags</h2>
		<div class="table">
			<v-data-table
				:headers="headers"
				:items="tags"
				:items-per-page="5"
				:sort-by.sync="sortBy"
      			:sort-desc.sync="sortDesc"
				item-key="owner"
				class="elevation-1"
				:search="search"
				loading
				loading-text="Chargement en cours..."
				no-results-text="Aucun tag trouvé"
				>
				<template v-slot:top>
					<v-text-field
						v-model="search"
						label="Rechercher"
						class="mx-4"
					></v-text-field>
				</template>

				<template v-slot:item.name="{ item }">
					<a class="text-decoration-none" style="color: #5147c5;" target="_BLANK" :href="'/tips/tagged/'+item.name"><span>{{ item.name }}</span></a>
				</template>

				<template v-slot:item.tips="{ item }">
					<a class="text-decoration-none" style="color: #5147c5;" target="_BLANK" :href="'/tips/tagged/'+item.name"><span>{{ item.tips.length }}</span></a>
				</template>
				<template v-slot:item.createdAt="{ item }">
					<span>{{ getCreatedAt(item.createdAt) }}</span>
				</template>
				<template v-slot:item.action="{ item }">
					<button class="btn p-1" @click="deleteTag(item)"><i class="fas fa-trash text-danger"></i></button>
				</template>
			</v-data-table>
		</div>
		<button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addTagModal">
			Ajouter un tag
		</button>
    </div>
	<div class="modal fade" id="addTagModal" tabindex="-1" aria-labelledby="addTagModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="addTagModalLabel">Ajouter un tag</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="input-group mb-3">
						<span class="input-group-text" id="icon-tags"><i class="fa fa-tags"></i></span>
						<input v-model="tag" type="text" class="form-control" placeholder="Nom du tag" aria-label="Nom du tag" aria-describedby="icon-tags">
					</div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
				<button @click="validate" type="button" class="btn btn-primary" data-bs-dismiss="modal">Ajouter</button>
				</div>
			</div>
		</div>
	</div>
  </div>
</template>

<script>
import SideBar from "./SidebarBackOffice.vue";
import axios from "axios";

export default {
	props: {
        tagsObj: {
            type: String,
            default: ""
        },
    },
	data() {
		return {
			sortBy: 'id',
        	sortDesc: true,
			search: "",
			headers: [
				{ text: "ID", align: 'start', value:"id" },
				{ text: "Nom", value:"name" },
				{ text: "Astuces", value:"tips" },
				{ text: "Date d'ajout", value:"createdAt" },
				{ text: "Action", value:"action", sortable: false, align: 'center' },
			],
			tags: null,
			tag: "",
		};
	},

	components: {
		SideBar,
	},

	methods: {
		validate() {
			if(this.tag.length == 0) return;
			const formData = new FormData();
			formData.append('tag[name]', this.tag)
			axios.post(`/api/tag`, formData, { headers: {"X-Requested-With": "XMLHttpRequest"} })
			.then(response => {
				this.tags.push(response.data.info);
				this.tag = "";
			}).catch(error => {
				console.error(error);
			});
		},
		getCreatedAt(createdAt) {
			let date = new Date(createdAt)
			let day = ("0" + date.getDate()).slice(-2)
			let month = ("0" + (date.getMonth() + 1)).slice(-2)
			let year = date.getFullYear()
			return `${day}/${month}/${year}`
		},
		deleteTag(tag) {
			if(!window.confirm(`Voulez-vous vraiment supprimer ce tag ? (${tag.name})`)) return;
			axios.delete(`/api/tag/${tag.id}`, { headers: {"X-Requested-With": "XMLHttpRequest"} })
				.then(response => {
					this.tags = this.tags.filter(t => t.id !== tag.id)
				})
				.catch(error => {
					console.log(error)
				})
		},
	},
	beforeMount() {
		this.tags = JSON.parse(this.tagsObj);

	},
	mounted() {
	},
};
</script>

<style lang="scss" scoped>
.admin__add_tag {
  display: flex;
  flex-direction: column;
  align-items: center;
  background: #5147c5;
  background: -webkit-linear-gradient(to right, #5147c5, #d8d8d8);
  background: linear-gradient(to right, #5147c5, #d8d8d8);
  min-height: 100vh;
  overflow-x: hidden;
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

h2 {
  margin: 1em 0px 1em 0px;
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

.table {
  width: 80%;
}
</style>