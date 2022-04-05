<template>
    <div data-app class="container-astuces">
        <div class="block__first">
        <NavBar class="fixed"/>
        <div class="container__filter">
            <div class="container__search">
                <form @submit.prevent="checkSearch()">
                    <div class="selector">
                        <v-select
                        class="select_search"
                        v-model="selectedTag"
                        :items="optionsTags"
                        label="Tags"
                        solo
                        ></v-select>
                        <input type="text" v-model="textSearch" placeholder="Rechercher dans cette page...">
                    </div>
                    <v-checkbox
                    class="checkbox_search"
                    v-model="checkbox__note"
                    :label="'Voir les mieux notés'"
                    ></v-checkbox>
                    <label for="date_search">Trier par date</label>
                    <input type="date" name="date_search">
                    <div><input type="submit" value="Valider"></div>
                </form>
            </div>
        </div>
        </div>
        <div class="block__second">
            <!-- Visualisation de 12 en 12, changer nombreCartesVisible si l'on veut autre chose -->
            <div class="row justify-content-center ">
                <div v-for="item in actualCards" :key="item.id" class="col-12 p-0 ">
                    <!-- col-xl-3 col-lg-4 col-sm-6  (css pour les cartes) -->
                    <!-- Sûrement faire du props pour récupérer les datas à envoyer au component -->
                    <Astuce v-bind:data="item"/>
                </div>
                <!-- Changer la length plus tard quand on les aura dynamiquement -->
            </div>
            <v-pagination
                v-model="page"
                :length="sliceAllCards.length"
                @input="onPageChange" color="rgba(81, 71, 197, 1)"
            ></v-pagination>
        </div>
        <Footer />
    </div>
</template>

<script>
import NavBar from "./component/NavBar.vue"
// import Card from "./component/Card.vue"
import Astuce from "./component/Astuce.vue"
import Footer from "./component/FooterVue.vue"

export default {
    data() {
        return {

            // TAGS DATA
            selectedTag: null,
            optionsTags: ["Option 1","Option 2","Option 3"],
            // 

            textSearch: null,
            checkbox__note: false,

            //cards
            page: 1,
            cards: [
                {name: "Card 1"},
                {name: "Card 2"},
                {name: "Card 3"},
                {name: "Card 4"},
                {name: "Card 5"},
                {name: "Card 6"},
                {name: "Card 7"},
                {name: "Card 8"},
                {name: "Card 9"},
                {name: "Card 10"},
                {name: "Card 11"},
                {name: "Card 12"},
                {name: "Card 13"},
                {name: "Card 14"},
                {name: "Card 15"},
                {name: "Card 16"},
                {name: "Card 17"},
                {name: "Card 18"}
            ],
            actualCards : [],
            sliceAllCards : [],
            nombreCartesVisible: 12,
        }
    },

    components: {
        NavBar,
        // Card,
        Astuce,
        Footer,
    },

    mounted() {

        for(let i = 0; i < this.cards.length; i+= this.nombreCartesVisible) {
            const index = i + this.nombreCartesVisible
            this.sliceAllCards.push(this.cards.slice(i, index))
        }
        //init first page
        this.actualCards = this.sliceAllCards[0]
        // console.log(this.actualCards);

        // hide container filter if user wants to see menu items
        const filter = document.querySelector(".container__filter")
        const navbarToggler = document.querySelector(".navbar-toggler-icon")
        navbarToggler.addEventListener("click", () => {
            
            if(filter.classList.contains("hide")) {
                setTimeout(()=>{
                    filter.classList.toggle("hide")
                },250)
            }
            else {
                filter.classList.toggle("hide")
            }
        })
    },

    methods: {

        checkSearch() {
            console.log("on check search");
        },

        onPageChange() {
            this.actualCards = this.sliceAllCards[this.page-1]
            document.body.scrollTop = 0; // Safari
            document.documentElement.scrollTop = 0; // Chrome, Firefox, IE and Opera
        }
    }

}
</script>

<style lang="scss" scoped>

// COLORS
$text: #272D2D;
$light_text: #383d3d;
$interactive_text: #5147C5;
$seconday_color: #EEEEEE;
$background: #D8D8D8;

//main container
.block {
    &__first {
        // height temporaire
        @media (max-width: 768px) {
            height: 450px;
        }
        @media (min-width: 768px) {
            height: 450px;
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
        
        background-image: url("../img/background.png");
        background-size: 100%;
        background-repeat: no-repeat;
        background-color: rgb(125, 126, 128);
    }

    &__second {
        margin: 50px;
        margin-top: 20px;
    }
}

.container{
    &__filter {
    width: 75%;
    background-color: $background;
    margin: 0 auto;
    margin-top: 50px;
    border-radius: 10px;
    padding: 50px;
    }

    &__search {
        border-radius: 10px;

        & .selector {
            display: flex;
            border-radius: 10px;
            height: 50px;

            & .select_search {
                border: 1px solid #CECECE;
                border-radius: 10px 0px 0px 10px;
            }

            & input[type=text] {
                background-color: $seconday_color;
                width: 100%;
                border: 1px solid #CECECE;
                border-radius: 0px 10px 10px 0px;
                box-shadow: 3px 3px 2px -2px rgba(0, 0, 0, 30%);
                

                &::placeholder {
                    padding-left: 10px;
                    color: $text;
                }
            }
        }

        & input[type=date] {
            border: 2px solid $text;
            border-radius: 10px;
            padding: 5px;
        }

        & input[type=submit] {
            border: 2px solid $text;
            border-radius: 10px;
            padding: 5px;
            background-color: $interactive_text;
            color: $seconday_color;
        }
    }
}

.hide {
    opacity: 0;
}

</style>