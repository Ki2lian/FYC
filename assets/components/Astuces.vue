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
            <div class="row justify-content-center">
                <div v-for="item in actualCards" :key="item.id" class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    <!-- Sûrement faire du props pour récupérer les datas à envoyer au component Card -->
                    <Card />
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
import Card from "./component/Card.vue"
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
            cards: ["Card 1","Card 2","Card 3","Card 4",
            "Card 5","Card 6","Card 7","Card 8",
            "Card 9","Card 10","Card 11","Card 12",
            "Card 13","Card 14","Card 15","Card 16",
            "Card 17","Card 18"],
            actualCards : [],
            sliceAllCards : [],
            nombreCartesVisible: 12,
        }
    },

    components: {
        NavBar,
        Card,
        Footer,
    },

    mounted() {

        for(let i = 0; i < this.cards.length; i+= this.nombreCartesVisible) {
            const index = i + this.nombreCartesVisible
            this.sliceAllCards.push(this.cards.slice(i, index))
        }
        //init first page
        this.actualCards = this.sliceAllCards[0]
        console.log(this.actualCards);
    },

    methods: {

        checkSearch() {
            console.log("on check search");
        },

        onPageChange() {
            this.actualCards = this.sliceAllCards[this.page-1]
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
        height: 620px;
        background-image: url("../img/background.png");
        background-size: 100%;
        background-repeat: no-repeat;
    }

    &__second {
        margin: 50px;
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

</style>