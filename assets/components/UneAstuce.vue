<template>
  <div class="container__astuce">
    <NavBar class="fixed" />

    <div class="block__first row">
      <div class="title col-6">
        <h1>L’astuce (titre de l’astuce)</h1>
      </div>

      <div class="btn col-6">
        <a href="#">Donne une astuce</a>
      </div>
    </div>

    <div class="row jumbotron">
      <p class="text__trait col">
        Créer: 
      </p>
      <p class="text__trait col">
        Dernière activité:
      </p>
      <p class="text__trait col">
        Vue:
      </p>
      <hr class="trait my-4">
    </div>

    <Footer />
  </div>
</template>

<script>
import NavBar from "./component/NavBar.vue";
import Footer from "./component/FooterVue.vue";

export default {
  components: {
    NavBar,
    Footer,
  },
};
</script>

<style lang="scss" scoped>
$background: #d8d8d8;
$seconday_color: #eeeeee;
$interactive_text: #5147c5;
$text: #b2b2b2;

.container__astuce {
  .block__first {
    margin-bottom: 50px;

    .title {
      text-align: end;
    }

    .btn {
      text-align: start;

      a {
        width: 25%;
        border-radius: 15px;
        background-color: $interactive_text;
        color: $seconday_color;
        padding: 10px;
        padding-inline: 16px;
        text-decoration: none;
        position: relative;
        font-size: 18px;
        top: 25px;
      }
    }
  }
  
  .row{
    margin-block: 30px;

    .trait{
        height: 3px;
    }

    .text__trait{
        margin-bottom: -35px;
        left: 10px;
        position: relative;
    }
  }
}
</style>