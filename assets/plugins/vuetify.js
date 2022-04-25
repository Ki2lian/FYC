import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'
import fr from 'vuetify/src/locale/fr.ts'

Vue.use(Vuetify)

// const opts = {}
// export default new Vuetify(opts)

export default new Vuetify({
    lang: {
      locales: { fr },
      current: 'fr',
    },
  })