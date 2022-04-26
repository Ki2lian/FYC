<template>
  <div class="block">
    <div class="container">
      <img class="img-block" src="../../img/block_home.svg" alt="img_block" />
      <div class="contenu">
        <h1 class="title">FYC.</h1>
        <div>
            <p class="text">
                <span>Capturez les connaissances et les solutions pour </span
                >débloquer votre développement <span>et</span> partager vos astuces au
                monde en entier.
            </p>
        </div>
        
        <button type="button" class="btn">Faire un tour des astuces</button>
        <!-- <div class="btn">
          <a href="#" ref="urlAllTips">Faire un tour des astuces</a>
        </div> -->
        <div class="card__container d-inline-flex">
          <div class="card col">
            <img class="vector" src="../../img/Vector.svg" alt="vector" />
            <h1>Augmentation de la productivité</h1>
            <p>
              Si quelqu'un quelque part a la bonne réponse, tout à coup, vous
              l'avez aussi. Collaborez mieux dans un monde éloigné d'abord.
            </p>
          </div>
          <div class="card col">
              <div>
                <img class="vector" src="../../img/Vector.svg" alt="vector" />
                <h1>Collectif</h1>
                <p>
                    Aide à trouver des réponses fiables plus rapidement, à dialoguer
                    avec des experts en produits et à partager des connaissances sur
                    les technologies que vous utilisez le plus.
                </p>
              </div>
          </div>
          <div class="card col">
            <img class="vector" src="../../img/Vector.svg" alt="vector" />
            <h1>Intéractif</h1>
            <p>
              Favorise l'échange entre les utilisatuers et l'outil, donc entre
              nous !
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "block",
  props: {
    urlalltips: {
      type: String,
      default: "",
    },
  },
  mounted() {
    this.$refs.urlAllTips.href = this.urlalltips;
  },
};
</script>

<style lang="scss" scoped>
$background: #d8d8d8;
$seconday_color: #eeeeee;
$interactive_text: #5147c5;
$text: #b2b2b2;

.block {
  margin: 0 auto;
  margin-block: 80px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  position: relative;

  .container {
    .img-block {
      width: 90%;
      display: block;
      margin-left: auto;
      margin-right: auto;
      z-index: 1;
      position: relative;
    }
    .contenu {
      margin: 0 auto;
      width: 100%;
      height: 100%;
      z-index: 2;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      .card__container {
        position: absolute;
        top: 310px;
        left: 50%;
        transform: translate(-50%);
        @media only screen and (max-width: 1400px) {
          top: 277px;
        }
        @media only screen and (max-width: 1200px) {
            top: 241px;;
        }
        @media only screen and (max-width: 991px) {
            top: 183px;;
        }
        .card {
          background-color: #414141;
          border-color: #414141;
          z-index: 2;
          .vector {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 33px;
            @media only screen and (max-width: 991px) {
            width: 20px;
            }
          }
          h1 {
            font-size: 18px;
            text-align: center;
            color: $seconday_color;
            @media only screen and (max-width: 1400px) {
                font-size: 14px;
            }
            @media only screen and (max-width: 980px) {
                font-size: 11px;
            }
          }
          p {
            color: $text;
            @media only screen and (max-width: 1400px) {
                font-size: 10px;
            }
            @media only screen and (max-width: 980px) {
                font-size: 8px;
            }
          }
        }
      }
      .title {
        z-index: 2;
        position: absolute;
        left: 50%;
        top: 60px;
        transform: translate(-50%);
        color: $seconday_color;
        @media only screen and (max-width: 1200px) {
          font-size: 25px;
        }
        @media only screen and (max-width: 991px) {
          font-size: 18px;
          top: 44px;
        }
      }
      .text {
        max-width: 800px;
        text-align: center;
        z-index: 2;
        color: $interactive_text;
        font-size: 23.5px;
        top: 120px;
        left: 50%;
        transform: translate(-50%);
        position: absolute;
        span {
          color: $seconday_color;
        }
        @media only screen and (max-width: 1200px) {
          top: 95px;
          font-size: 20px;
        }
        @media only screen and (max-width: 980px) {
          font-size: 16px;
          top: 73px;
        }
      }
      .btn {
        z-index: 2;
        justify-content: center;
        left: 50%;
        transform: translate(-50%);
        position: absolute;
        top: 210px;
        border-radius: 15px;
        background-color: $interactive_text;
        color: $seconday_color;
        text-decoration: none;
        @media only screen and (max-width: 1458px) {
          top: 230px;
        }
        @media only screen and (max-width: 1200px) {
          top: 199px;
        }
        @media only screen and (max-width: 980px) {
          top: 151px;
        }
      }
    }
  }
}
</style>