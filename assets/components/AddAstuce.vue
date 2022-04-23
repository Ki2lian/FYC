<template>
    <v-app>
        <v-app-bar app color="#5147C5">
            <v-icon x-large class="mr-4" color="white">mdi-plus-box</v-icon>
            <v-toolbar-title class="text-4xl font-semibold text-white">Ajouter une astuce</v-toolbar-title>
        </v-app-bar>
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
                                        'insertdatetime media table paste code help wordcount'
                                        ],
                                        toolbar:
                                        'undo redo | formatselect | bold italic backcolor | \
                                        alignleft aligncenter alignright alignjustify | \
                                        bullist numlist outdent indent | removeformat | help'
                                    }"
                                />
                            </div>
                            <v-btn
                                elevation="0"
                                :disabled="!validForm"
                                color="success"
                                class="mr-4 mt-5"
                                @click="validate">
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
import Editor from '@tinymce/tinymce-vue';
import Footer from "./component/FooterVue.vue"

export default {

    data() {
        return {
            form: {
                title: null,
                content: null,
            },

            validForm: true,

            // RULES
            titleRules: [(v) => !!v || "Veuillez préciser un titre à votre astuce."],
        }
    },

    components: {
        Editor,
        Footer,
    },

    methods: {
        validate: function() {
            this.$refs.form.validate()
            // ...
        },
    }

}
</script>

<style>

</style>