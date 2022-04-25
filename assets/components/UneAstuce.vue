<template>
  <div class="container__astuce">
    <NavBar class="fixed" />

    <div class="title d-flex">
      <h1>L’astuce (titre de l’astuce)</h1>
      <a href="#">Donne une astuce</a>
    </div>

    <div class="row jumbotron">
      <p class="text__trait col">Créer :</p>
      <p class="text__trait col">Dernière activité :</p>
      <p class="text__trait col">Vue :</p>
      <hr class="trait my-4" />
    </div>

    <div class="body-container">
      <div class="astuce">
        <p class="astuce-text">
          Thalassius vero ea tempestate praefectus praetorio praesens ipse
          quoque adrogantis ingenii, considerans incitationem eius ad multorum
          augeri discrimina, non maturitate vel consiliis mitigabat, ut
          aliquotiens celsae potestates iras principum molliverunt, sed
          adversando iurgandoque cum parum congrueret, eum ad rabiem potius
          evibrabat, Augustum actus eius exaggerando creberrime docens, idque,
          incertum qua mente, ne lateret adfectans. quibus mox Caesar acrius
          efferatus, velut contumaciae quoddam vexillum altius erigens, sine
          respectu salutis alienae vel suae ad vertenda opposita instar rapidi
          fluminis irrevocabili impetu ferebatur. Intellectum est enim mihi
          quidem in multis, et maxime in me ipso, sed paulo ante in omnibus, cum
          M. Marcellum senatui reique publicae concessisti, commemoratis
          praesertim offensionibus, te auctoritatem huius ordinis dignitatemque
          rei publicae tuis vel doloribus vel suspicionibus anteferre. Ille
          quidem fructum omnis ante actae vitae hodierno die maximum cepit, cum
          summo consensu senatus, tum iudicio tuo gravissimo et maximo. Ex quo
          profecto intellegis quanta in dato beneficio sit laus, cum in accepto
          sit tanta gloria.
        </p>

        <div v-html="codeExample">

        </div>
      </div>

      <div class="container__card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">Publié le 2 janv à 13h50</p>
            <div class="logo d-flex">
              <img src="../img/user-solid.svg" alt="" />
              <p>Emeric GABIN</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="tips">
      <p>Nombre de commentaire 1</p>
      <div class="container__tips">
        <p class="desc__tips">
          Altiora gestis artissime conpertis an agens qui agens gener tenebatur
          exindeque ad meditantis qui paulo altiora ad conpertis ante iam.
        </p>

        <div class="container__card">
          <div class="card">
            <div class="card-body">
              <p class="card-title">Publié le 2 janv à 13h50</p>
              <div class="logo d-flex">
                <img src="../img/user-solid.svg" alt="" />
                <p>Emeric GABIN</p>
              </div>
            </div>
          </div>
        </div>

        <hr class="my-12" />
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
              'insertdatetime media table paste code help wordcount codesample',
            ],
            toolbar:
              'undo redo | formatselect | bold italic backcolor | \
              alignleft aligncenter alignright alignjustify | \
              bullist numlist outdent indent | removeformat | help codesample',
          }"
        />

        <div
          class="text-privacy d-flex justify-content-center align-items-center"
        >
          <div class="btn">
            <a href="#">Commenter</a>
          </div>
          <div class="">
            <p>
              En cliquant sur "Commenter", vous acceptez notre
              <a href="#"> politique de confidentialité </a> et notre
              <a href=""> politique en matière de cookies </a>.
            </p>
          </div>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script>
import NavBar from "./component/NavBar.vue";
import Footer from "./component/FooterVue.vue";
import Editor from "@tinymce/tinymce-vue";
import hljs from "highlight.js";
import 'highlight.js/styles/stackoverflow-light.css';
import { marked } from 'marked';

export default {
  components: {
    NavBar,
    Footer,
    editor: Editor,
    hljs,
  },

  computed:{
    // A modifier !!!
    codeExample(){
      console.log(hljs);
      return marked('``` <div align="center">you content</div> <div id="myDiv">you content</div> ```', {
        hljs(md){
          return hljs.highlightAuto(md).value
        }
      });
    }
  }
};
</script>

<style lang="scss" scoped>
$background: #d8d8d8;
$seconday_color: #eeeeee;
$interactive_text: #5147c5;
$text: #b2b2b2;

.container__astuce {
  .title {
    text-align: center;
    justify-content: center;

    a {
      width: 200px;
      border-radius: 15px;
      background-color: $interactive_text;
      color: $seconday_color;
      padding: 10px;
      padding-inline: 16px;
      text-decoration: none;
      position: relative;
      font-size: 18px;
      margin-left: 10px;
    }
  }

  .row {
    margin-block: 30px;

    .trait {
      height: 3px;
    }

    .text__trait {
      margin-bottom: -35px;
      left: 10px;
      position: relative;
    }
  }

  .body-container {
    margin: 0 auto;
    width: 91%;

    .astuce {
      .astuce-text {
        margin-left: auto;
        margin-right: auto;
        text-align: justify;
      }
    }

    .container__card {
      margin-top: 40px;
      width: 100%;
      display: flex;
      justify-content: end;
      .card {
        display: inline-flex;
        .card-body {
          .logo {
            height: 40px;
            p {
              margin-left: 10px;
            }
          }
          .card-title {
            font-size: 12px;
            color: "#494949";
          }
        }
      }
    }

  }

  .commentaire {
    .container {
      margin-block: 20px;

      .btn {
        a {
          width: 25%;
          border-radius: 15px;
          background-color: $interactive_text;
          color: $seconday_color;
          padding: 10px;
          text-decoration: none;
        }
      }
    }

    .text-privacy {
      margin-block: 15px;
      a {
        color: $interactive_text;
        text-decoration: none;
      }
      p {
        margin-top: 15px;
      }
    }
  }

  .tips {
    margin-top: 40px;
    margin-inline: 55px;

    .container__tips {
      margin-inline: 25px;
      .container__card {
        margin-top: 40px;
        width: 100%;
        display: flex;
        justify-content: end;
        .card {
          display: inline-flex;
          .card-body {
            .logo {
              height: 40px;
              p {
                margin-left: 10px;
              }
            }
            .card-title {
              font-size: 12px;
              color: "#494949";
            }
          }
        }
      }
    }
  }
}
</style>