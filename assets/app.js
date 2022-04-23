/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/global.scss';
import './styles/app.css';
import vuetify from "./plugins/vuetify.js"

import Vue from 'vue'
import Astuces from "./components/Astuces.vue"
import Profil from "./components/Profil.vue"

import BackOffice from "./components/BackOffice.vue"
import AdminCommentaires from "./components/backoffice/Commentaires.vue"
import AdminUtilisateurs from "./components/backoffice/Utilisateurs.vue"
import AddAstuce from "./components/AddAstuce.vue"

import VueApexCharts  from 'vue-apexcharts'

Vue.use(VueApexCharts)
Vue.component('apexchart', VueApexCharts)

new Vue({ 
    el: '#app', 
    components: {
        Astuces,
        Profil,
        BackOffice,
        AdminCommentaires,
        AdminUtilisateurs,
        AddAstuce
    },
    vuetify,
})

require('bootstrap');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
// start the Stimulus application
import './bootstrap';

const $ = require('jquery');
global.$ = global.jQuery = $;