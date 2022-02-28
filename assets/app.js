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
import Tag from './components/Tag.vue'
import AccountLogInSignUp from './components/AccountLogInSignUp.vue'
import Accueil from "./components/Accueil.vue"
import UneAstuce from "./components/UneAstuce.vue"

new Vue({ 
    el: '#app', 
    components: {
        Astuces,
        Profil,
        Tag,
        AccountLogInSignUp,
        Accueil,
        UneAstuce,
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