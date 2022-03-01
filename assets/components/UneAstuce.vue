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

    <div class="body-container">
        <div class="astuce">
          <p class="astuce-text">
            Thalassius vero ea tempestate praefectus praetorio praesens 
            ipse quoque adrogantis ingenii, considerans incitationem eius ad 
            multorum augeri discrimina, non maturitate vel consiliis mitigabat, ut 
            aliquotiens celsae potestates iras principum molliverunt, 
            sed adversando iurgandoque cum parum congrueret,
             eum ad rabiem potius evibrabat, 
             Augustum actus eius exaggerando creberrime docens, 
             idque, incertum qua mente, ne lateret adfectans. quibus mox Caesar acrius efferatus,
             velut contumaciae quoddam vexillum altius erigens, 
             sine respectu salutis alienae vel suae ad vertenda opposita instar rapidi fluminis irrevocabili impetu ferebatur.
            Intellectum est enim mihi quidem in multis, et maxime in me ipso,
            sed paulo ante in omnibus, cum M. Marcellum senatui reique publicae 
            concessisti, commemoratis praesertim offensionibus, te auctoritatem huius 
            ordinis dignitatemque rei publicae tuis vel doloribus vel suspicionibus 
            anteferre. Ille quidem fructum omnis ante actae vitae hodierno die maximum 
            cepit, cum summo consensu senatus, tum iudicio tuo gravissimo et maximo. Ex quo profecto intellegis quanta in dato beneficio sit laus, cum in accepto sit tanta gloria.
            </p>
        </div>
    </div>

    <div class="commentaire">
      <div class="container">
        <p>Votre commentaire :</p>

        <editor
       api-key="no-api-key"
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
    </div>

    <Footer />
  </div>
</template>

<script>
import NavBar from "./component/NavBar.vue";
import Footer from "./component/FooterVue.vue";
import Editor from '@tinymce/tinymce-vue'

export default {
  components: {
    NavBar,
    Footer,
    'editor': Editor,
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

  .body-container{
    margin: 0 auto;
    width: 70%; 

    .astuce{
      .astuce-text{
        margin-left: auto;
        margin-right: auto;
        text-align: justify;
      }
    }
  }

  .commentaire{
  }
}
</style>