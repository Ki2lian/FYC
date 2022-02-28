<template>
    <div class="container__profil">
        <div class="block__first">
            <NavBar />
        </div>
        <div class="block__second">
            <div class="welcome">Bienvenue sur votre profile <i>Pseudo</i> !</div>
            <div class="personnal-information">
                <h3>Information personnelle</h3>
                <div class="username"><img class="icon__user" src="../img/user.svg" alt="icon user">Pseudo</div>
                <div class="mail"><img class="icon__mail" src="../img/mail.svg" alt="icon mail">Adresse mail</div>
            </div>
            <div class="infos__block row">
                <div class="infos__child col-md-6"><img class="icon__astuce" src="../img/astuce.svg" alt="icon astuce">[Nombre d'astuces postées]</div>
                <div class="infos__child col-md-6"><img class="icon__commentaire" src="../img/commentaire.svg" alt="icon commentaire">[Nombre de commentaires postées]</div>
                <div class="infos__child col-md-6"><div class="infos__tags">Tags des astuces postées<div class="temporary">CHARTJS</div></div></div>
                <div class="infos__child col-md-6">Note moyenne des annonces<img class="icon__commentaire" src="../img/temporary_stars.svg" alt="icon commentaire"></div>
            </div>
            <div class="data_users">
                <!-- datatable temporaire avec données temporaires -->
                <v-data-table
                    :headers="headers"
                    :items="desserts"
                    :items-per-page="5"
                    class="elevation-1"
                ></v-data-table>
            </div>
            <!-- Ajouter le pseudo dynamiquement -->
        </div>
        <Footer />
    </div>
</template>

<script>
import NavBar from "./component/NavBar.vue"
import Footer from "./component/FooterVue.vue"

export default {
    components: {
        NavBar,
        Footer,
    },

    data () {
        return {
            headers: [
            {
                text: 'Dessert (100g serving)',
                align: 'start',
                sortable: false,
                value: 'name',
            },
            { text: 'Calories', value: 'calories' },
            { text: 'Fat (g)', value: 'fat' },
            { text: 'Carbs (g)', value: 'carbs' },
            { text: 'Protein (g)', value: 'protein' },
            { text: 'Iron (%)', value: 'iron' },
            ],
            desserts: [
            {
                name: 'Frozen Yogurt',
                calories: 159,
                fat: 6.0,
                carbs: 24,
                protein: 4.0,
                iron: '1%',
            },
            {
                name: 'Ice cream sandwich',
                calories: 237,
                fat: 9.0,
                carbs: 37,
                protein: 4.3,
                iron: '1%',
            },
            {
                name: 'Eclair',
                calories: 262,
                fat: 16.0,
                carbs: 23,
                protein: 6.0,
                iron: '7%',
            },
            {
                name: 'Cupcake',
                calories: 305,
                fat: 3.7,
                carbs: 67,
                protein: 4.3,
                iron: '8%',
            },
            {
                name: 'Gingerbread',
                calories: 356,
                fat: 16.0,
                carbs: 49,
                protein: 3.9,
                iron: '16%',
            },
            {
                name: 'Jelly bean',
                calories: 375,
                fat: 0.0,
                carbs: 94,
                protein: 0.0,
                iron: '0%',
            },
            {
                name: 'Lollipop',
                calories: 392,
                fat: 0.2,
                carbs: 98,
                protein: 0,
                iron: '2%',
            },
            {
                name: 'Honeycomb',
                calories: 408,
                fat: 3.2,
                carbs: 87,
                protein: 6.5,
                iron: '45%',
            },
            {
                name: 'Donut',
                calories: 452,
                fat: 25.0,
                carbs: 51,
                protein: 4.9,
                iron: '22%',
            },
            {
                name: 'KitKat',
                calories: 518,
                fat: 26.0,
                carbs: 65,
                protein: 7,
                iron: '6%',
            },
            ],
        }
    },

    mounted() {

    },

    methods: {

    },
}
</script>

<style lang="scss" scoped>
$text: #272D2D;
$light_text: #383d3d;
$interactive_text: #5147C5;
$seconday_color: #EEEEEE;
$background: #D8D8D8;

.temporary {
    margin: 100px;
}

.container__profil {
    background-color: $background;
}

.block {
    &__first {
        // height temporaire
        @media (max-width: 768px) {
            height: 300px;
        }
        @media (min-width: 768px) {
            height: 400px;
        }
        @media (min-width: 992px) {
            height: 620px;
        }
        @media (min-width: 1200px) {
            height: 740px;
        }
        @media (min-width: 1800px) {
            height: 900px;
        }
        
        background-image: url("../img/background_profile.svg");
        background-size: 100%;
        background-repeat: no-repeat;
        background-color: rgb(125, 126, 128);
    }
}

.title {
    font-size: 64px;
    margin: 0 auto;
    text-shadow: 4px 4px 4px rgb(0 0 0 / 25%), 4px 4px 4px rgb(0 0 0 / 25%), 4px 4px 4px rgb(0 0 0 / 25%);
    color: white;
    line-height: 100%;
    text-align: center;
    margin-top: 15%;

    & .first {
        padding-right: 20vw;
    }
    @media (max-width: 768px) {
        font-size: 32px;
    }
}

.welcome {
    font-size: 46px;
    @media (max-width: 768px) {
        font-size: 23px;
    }
    margin: 2%;
    margin-left: 5%;
}

.personnal-information {
    width: 50%;
    @media (max-width: 768px) {
        width: 65%;
    }
    margin: 0 auto;
    padding: 10px;
    background: #EEEEEE;
    box-shadow: 5px 5px 4px rgba(83, 83, 83, 0.25);
    border-radius: 10px;
}


.icon {
    &__user {
        margin-left: 9px;
        width: 60px;
        height: 60px;
        @media (max-width: 768px) {
            margin-left: 1.5px;
            width: 30px;
        }
    }

    &__mail {
        width: 75px;
        height: auto;
        @media (max-width: 768px) {
            width: 32.5px;
        }
    }

    &__commentaire,
    &__astuce {
        width: 30%;
    }
}

.infos {
    &__block {
        text-align: center;
    }

    &__child {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        @media (max-width: 768px) {
            font-size: 16px;
        }
    }

    &__tags {
        background: #FFFFFF;
        box-shadow: 4px 4px 7px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 20px;
    }
    
}

.data_users {
    width: 80%;
    margin: 0 auto;
    margin-bottom: 20px;
    @media (max-width: 768px) {
        margin-top: 20px;
    }
}
</style>