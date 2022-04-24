<template>
  <div>
    <SideBar />
    <div class="admin__commentaires page-content" id="content">
      <!-- Toggle button -->
      <button
        id="sidebarCollapse"
        type="button"
        class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"
      >
        <i class="fa fa-bars mr-2"></i
        ><small class="text-uppercase font-weight-bold ms-2">Menu</small>
      </button>
      <h2>Commentaires de l'astuce <i>Title</i></h2>

      <div class="table">
        <v-data-table
          :headers="headers"
          :items="commentaires"
          :items-per-page="5"
          item-key="owner"
          class="elevation-1"
          :search="search"
          loading
          loading-text="Chargement en cours..."
          no-results-text="Pas de commentaires trouvés"
        >
          <template v-slot:top>
            <v-text-field
              v-model="search"
              label="Rechercher"
              class="mx-4"
            ></v-text-field>
          </template>
          <template v-slot:[`item`]="props">
            <tr>
              <td>
                {{ props.item.owner }}
              </td>
              <td v-if="props.item.content.length < 150">
                {{ props.item.content.substring(0, 150) + " ..." }}
              </td>
              <td v-else>
                {{ props.item.content.substring(0, 150) + " ..." }}
              </td>
              <td
                  class="pointer"
                  data-bs-toggle="modal"
                  data-bs-target="#modifierModal"
                  align="center"
                >
                  <i class="fa fa-solid fa-marker icon_color_edit"></i>
                </td>
              <td class="pointer" v-on:click="supprimer" align="center">
                <i class="fa fa-solid fa-trash icon_color_delete"></i>
              </td>
            </tr>
          </template>
        </v-data-table>
      </div>

      <button
        type="button"
        class="btn btn-interactive"
        data-bs-toggle="modal"
        data-bs-target="#modifierModal"
      >
        Modal "Modifier" (à implémenter)
      </button>

      <div
        class="modal fade"
        id="modifierModal"
        tabindex="-1"
        aria-labelledby="modifierModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                Modifier le commentaire
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">FORMULAIRE À IMPLÉMENTER</div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Annuler
              </button>
              <button type="button" class="btn btn-interactive">
                Modifier
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SideBar from "./SidebarBackOffice.vue";

export default {
  data() {
    return {
      headers: [
        {
          text: "Owner",
          value: "owner",
        },
        {
          text: "Content",
          value: "content",
        },
        {
          text: "Modifier",
          value: "edit",
        },
        {
          text: "Supprimer",
          value: "delete",
        },
      ],

      commentaires: [
        {
          owner: "Owner 1",
          content:
            "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
        },
        {
          owner: "Owner 2",
          content:
            "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
        },
        {
          owner: "Owner 3",
          content:
            "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
        },
        {
          owner: "Owner 4",
          content:
            "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
        },
        {
          owner: "Owner 5",
          content:
            "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
        },
        {
          owner: "Owner 6",
          content:
            "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
        },
        {
          owner: "Owner 7",
          content:
            "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
        },
        {
          owner: "Owner 8",
          content:
            "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
        },
        {
          owner: "Owner 9",
          content:
            "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
        },
        {
          owner: "Owner 10",
          content:
            "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
        },
      ],
    };
  },

  components: {
    SideBar,
  },

  mounted() {},

  methods: {
    /**
     * Methode à implémenter pour supprimer un commentaire
     */
    supprimer: function () {
      console.log("click");
    },
  },
};
</script>

<style lang="scss" scoped>
$interactive_text: #5147c5;
$interactive_text_dark: #413999;

.admin__commentaires {
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
  margin-bottom: 1em;
}

.pointer {
  cursor: pointer;
}

.btn-interactive {
  background-color: $interactive_text;
  color: white;

  &:hover {
    background-color: $interactive_text_dark;
  }
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

.icon_color {
  &_delete {
    color: #C82323;
  }

  &_edit {
    color: #DB8A2F;
  }
}
</style>