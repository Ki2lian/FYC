<template>
  <v-app class="background">
    <NavBar />
    <div class="title">
      <v-icon x-large class="mr-4" color="#5147C5">mdi-plus-box</v-icon>
      <h2>Ajouter une astuce</h2>
    </div>
    <v-main>
      <v-form ref="form" v-model="validForm">
        <v-container>
          <v-row class="justify-center">
            <v-col cols="12" sm="12" md="12" lg="12">
              <v-text-field
                v-model="form.title"
                label="Titre de votre astuce"
                prepend-icon="mdi-format-title"
                :rules="titleRules"
              />
              <v-combobox
                v-model="form.tags"
                :items="tags"
                label="Tags de votre astuce"
                prepend-icon="mdi-tag-multiple-outline"
                multiple
                chips
              ></v-combobox>
              <div>
                <editor
                  api-key="8gaq38a4l7phvys7xzkj0o9cu8xpkysca6vlbszoarqmeuwo"
                  v-model="form.content"
                  id="uuid"
                  :init="{
                    height: 500,
                    menubar: true,
                    plugins: [
                      'advlist autolink lists link image charmap print preview anchor',
                      'searchreplace visualblocks code fullscreen',
                      'insertdatetime media table paste code help wordcount',
                    ],
                    toolbar:
                      'undo redo | formatselect | bold italic backcolor | \
                                        alignleft aligncenter alignright alignjustify | \
                                        bullist numlist outdent indent | removeformat | help',
                  }"
                />
              </div>
              <v-btn
                elevation="0"
                :disabled="!validForm"
                color="success"
                class="mr-4 mt-5"
                @click="validate"
              >
                Créer mon astuce
              </v-btn>
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

export default {
  data() {
    return {
      form: {
        title: null,
        content: null,
        tags: [],
      },

      tags: ["PHP", "JAVA", "JS", "HTML", "CSS"],

      validForm: true,

      // RULES
      titleRules: [(v) => !!v || "Veuillez préciser un titre à votre astuce."],
    };
  },

  components: {
    Editor,
    Footer,
    NavBar,
  },

  methods: {
    validate: function () {
      this.$refs.form.validate();
      // ...
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