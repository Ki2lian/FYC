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
      <h2>Administration des utilisateurs</h2>
      <div class="table">
        <v-data-table
          :headers="headers"
          :items="users"
          :items-per-page="5"
          item-key="owner"
          class="elevation-1"
          :search="search"
          loading
          loading-text="Chargement en cours..."
          no-results-text="Pas de utilisateurs trouvés"
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
                <a href="#">{{ props.item.owner }}</a>
              </td>
              <td v-if="props.item.content.length < 150">
                {{ props.item.content.substring(0, 150) + " ..." }}
              </td>
              <td v-else>
                {{ props.item.content.substring(0, 150) + " ..." }}
              </td>
              <td class="pointer" v-on:click="supprimer" align="center">
                <i class="fa fa-solid fa-trash icon_color"></i>
              </td>
            </tr>
          </template>
        </v-data-table>
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
          value:"owner"
        },
        {
          text: "Content",
          value: "content"
        },
        {
          text: "Supprimer",
          value: "delete"
        }
      ],
      search: "",
      users: [
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

  mounted() {},

  components: {
    SideBar,
  },

  methods: {
    /**
     * Methode à implémenter pour supprimer un utilisateur
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