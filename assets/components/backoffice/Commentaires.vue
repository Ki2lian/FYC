<template>
    <div class="admin__commentaires">
        <h2>Commentaires de l'astuce <i>Title</i></h2>
        <div class="table">
            <v-simple-table >
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th class="text-left">Owner</th>
                        <th class="text-left">Content</th>
                        <th class="text-left">Modifier</th>
                        <th class="text-left">Supprimer</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(commentaire, index) in commentaires" :key="index">
                        <td>{{ commentaire.owner }}</td>

                        <td v-if="commentaire.content.length < 150">{{ commentaire.content }}</td>
                        <td v-else>{{ commentaire.content.substring(0, 150) + " ..." }}</td>

                        <td class="pointer" v-on:click="test"><i class="fa fa-solid fa-marker"></i></td>
                        <td class="pointer" v-on:click="test"><i class="fa fa-solid fa-trash"></i></td>
                    </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </div>

        <button type="button" class="btn btn-interactive" data-bs-toggle="modal" data-bs-target="#modifierModal">Modal "Modifier" (à implémenter)</button>

        <div class="modal fade" id="modifierModal" tabindex="-1" aria-labelledby="modifierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier le commentaire</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    FORMULAIRE À IMPLÉMENTER
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-interactive">Modifier</button>
                </div>
            </div>
        </div>
        </div>
        
    </div>
</template>

<script>
export default {
    data () {
      return {
        commentaires: [
          {
            owner: 'Owner 1',
            content: "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
          },
          {
            owner: 'Owner 2',
            content: "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
          },
          {
            owner: 'Owner 3',
            content: "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
          },
          {
            owner: 'Owner 4',
            content: "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
          },
          {
            owner: 'Owner 5',
            content: "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
          },
          {
            owner: 'Owner 6',
            content: "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
          },
          {
            owner: 'Owner 7',
            content: "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
          },
          {
            owner: 'Owner 8',
            content: "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
          },
          {
            owner: 'Owner 9',
            content: "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
          },
          {
            owner: 'Owner 10',
            content: "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.",
          },
        ],
      }
    },

    mounted() {

    },

    methods: {
        test: function() {
            console.log("click")
        }
    },

}
</script>

<style lang="scss" scoped>
$interactive_text: #5147C5;
$interactive_text_dark: #413999;

.admin__commentaires {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: #5147C5;
    background: -webkit-linear-gradient(to right, #5147C5, #D8D8D8);
    background: linear-gradient(to right, #5147C5, #D8D8D8);
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

.btn-interactive {
    background-color: $interactive_text;
    color: white;

    &:hover {
        background-color: $interactive_text_dark;
    }
}
</style>