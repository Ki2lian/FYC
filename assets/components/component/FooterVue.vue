<template>
  <div class="footer py-5">
    <button @click="goToTop" class="btn__top"><img src="../../img/top_arrow.svg" alt=""></button>
    <div class="row">
      <div class="col-6 col-md">
        <h5>FYC.</h5>
        <ul class="list-unstyled text-small">
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Mentions légales</a></li>
          <li><a href="/tips">Toutes les astuces</a></li>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h5>Entreprise</h5>
        <ul class="list-unstyled text-small">
          <li><a href="#">À propos de FYC.</a></li>
          <li><a href="#">Politique de confidentalité</a></li>
          <li><a href="#">Politique des Cookies</a></li>
          <li><a href="#">Paramètre des Cookies</a></li>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h5>Tags populaires</h5>
        <ul class="list-unstyled text-small">
          <li><a href="/tips/tagged/js">JS</a></li>
          <li><a href="/tips/tagged/python">Python</a></li>
          <li><a href="/tips/tagged/css">CSS</a></li>
          <li><a href="/tips/tagged/docker">Docker</a></li>
        </ul>
      </div>
      <div class="col-8 col-md">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="d-block mb-2 svg"
        >
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="14.31" y1="8" x2="20.05" y2="17.94"></line>
          <line x1="9.69" y1="8" x2="21.17" y2="8"></line>
          <line x1="7.38" y1="12" x2="13.12" y2="2.06"></line>
          <line x1="9.69" y1="16" x2="3.95" y2="6.06"></line>
          <line x1="14.31" y1="16" x2="2.83" y2="16"></line>
          <line x1="16.62" y1="12" x2="10.88" y2="21.94"></line>
        </svg>
        <p class="footer-desc">Développeurs: Emeric, Joris, Adel et Killian
        </p>
        <small class="d-block mb-3">&copy; 2021-2022</small>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "FooterVue",

  methods: {

    goToTop() {
      document.body.scrollTop = 0; // Safari
      document.documentElement.scrollTop = 0; // Chrome, Firefox, IE and Opera
    },
  },
}
</script>

<style lang="scss" scoped>
$text: #272D2D;
$light_text: #383d3d;
$interactive_text: #5147C5;
$seconday_color: #EEEEEE;
$background_color: #494949;

.footer{

  background: $background_color;
  padding-top: 0 !important;

  .footer-desc{
    color: #747474;
  }

  h5{

    color: #A8A8A8;
  }

  ul{

    li{

      a{
        text-decoration: none;
        color: #747474;
      }

      a:hover{
        color: #EEEEEE;
      }
    }
  }

  .svg{
    color: #A8A8A8;
  }

  small{
    color: #A8A8A8;
  }
}

.btn__top {
  display: flex;
  margin: 0 auto;
  transform: translateY(-15px);
  background-color: $interactive_text;
  border-radius: 50%;
}

.col-md{

  padding-left: 50px;
}
</style>