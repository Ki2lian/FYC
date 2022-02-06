<template>
  <div class="block">
    <div class="container">
      <img class="img-block" src="../assets/block_home.svg" alt="img_block" />
      <div class="contenu">
        <h1 class="title">FYC.</h1>
        <p class="text">
          <span>Capturez les connaissances et les solutions pour </span>ébloquer
          votre développement <span>et</span> partager vos astuces au monde en
          entier.
        </p>
        <div class="btn">
          <a href="#">Faire un tour des astuces</a>
        </div>
        <div class="card__container row">
          <div class="card col">
            <img class="vector" src="../assets/Vector.svg" alt="vector" />
            <h1>Augmentation de la productivité</h1>
            <p>
              Si quelqu'un quelque part a la bonne réponse, tout à coup, vous
              l'avez aussi. Collaborez mieux dans un monde éloigné d'abord.
            </p>
          </div>
          <div class="card col">
            <img class="vector" src="../assets/Vector.svg" alt="vector" />
            <h1>Collectif</h1>
            <p>
              Aide à trouver des réponses fiables plus rapidement, à dialoguer
              avec des experts en produits et à partager des connaissances sur
              les technologies que vous utilisez le plus.
            </p>
          </div>
          <div class="card col">
            <img class="vector" src="../assets/Vector.svg" alt="vector" />
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
};
</script>

<style lang="scss" scoped>
$background: #d8d8d8;
$seconday_color: #eeeeee;
$interactive_text: #5147c5;
$text: #b2b2b2;

.block {
  margin: 0 auto;
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
        top: 270px;
        left: 51%;
        transform: translate(-50%);

        .card {
          background-color: #494949;
          border-color: #494949;
          z-index: 2;
          height: 250px;
          width: 350px;
          margin-inline: 40px;
          top: 60px;

          .vector {
            position: absolute;
            left: 50%;
            top: -30px;
            transform: translate(-50%);
            width: 33px;
          }

          h1 {
            font-size: 18px;
            text-align: center;
            color: $seconday_color;
          }

          p {
            color: $text;
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
      }

      span {
        color: $seconday_color;
      }

      .btn {
        z-index: 2;
        justify-content: center;
        left: 50%;
        transform: translate(-50%);
        position: absolute;
        top: 210px;

        a {
          width: 25%;
          border-radius: 15px;
          background-color: $interactive_text;
          color: $seconday_color;
          padding: 5px;
          padding-inline: 40px;
          text-decoration: none;
        }
      }
    }
  }
}
</style>