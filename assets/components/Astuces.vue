<template>
    <div data-app class="container-astuces">
        <div class="block__first">
        <NavBar class="fixed"/>
        <div class="container__filter">
            <div class="container__search">
                <form @submit.prevent="checkSearch()">
                    <div class="row">
                        <div class="col-4">
                            <select class="form-control" ref="selectTags" name="">
                                <option value="none">Aucun tag</option>
                                <option v-for="tag in optionsTags" :key="tag.id">{{ tag.name }}</option>
                            </select>
                        </div>
                        <div class="col">
                            <input class="form-control" type="text" v-model="textSearch" placeholder="Rechercher..."/>
                        </div>
                    </div>
                    <!-- <v-checkbox
                    class="checkbox_search"
                    v-model="checkbox__note"
                    :label="'Voir les mieux notés'"
                    ></v-checkbox> -->
                    <div class="mt-5 text-center">
                        <input type="submit" class="btn btn-primary" value="Valider" style="background-color: #5147C5;" />
                    </div>
                </form>
            </div>
        </div>
        </div>
        <div class="container">
            <h4>{{ cards.length }} {{ "astuce" | pluralize(cards.length) }}</h4> 
            <div v-for="item in actualCards" :key="item.id">
                <Card :tip="item" />
            </div>
        </div>
        <div class="block__second">
            <!-- Visualisation de 12 en 12, changer nombreCartesVisible si l'on veut autre chose -->
            <div class="row justify-content-center">
                
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
    props: {
        tags: {
            type: String,
            default: ""
        },
        tips: {
            type: String,
            default: ""
        },
    },
    data() {
        return {
            // TAGS DATA
            selectedTag: null,
            optionsTags: [],
            // 
            textSearch: "",
            checkbox__note: false,
            //cards
            page: 1,
            cards: [],
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
        this.optionsTags = JSON.parse(this.tags)
        this.cards = JSON.parse(this.tips)
        for(let i = 0; i < this.cards.length; i+= this.nombreCartesVisible) {
            const index = i + this.nombreCartesVisible
            this.sliceAllCards.push(this.cards.slice(i, index))
        }
        //init first page
        this.actualCards = this.sliceAllCards[0]
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

        this.$refs.selectTags.selectedIndex = 0
    },
    methods: {
        checkSearch() {
            const valueTags = this.$refs.selectTags.value;
            if(valueTags != "none") window.location.replace("/tips/tagged/" + valueTags);
            else if(this.textSearch != "") window.location.replace("/tips/search/" + this.textSearch);
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
    @media (max-width: 768px) {
        margin-top: calc(450px/4);
    }
    @media (min-width: 768px) {
        margin-top: calc(450px/4);
    }
    @media (min-width: 992px) {
        margin-top: calc(620px/4);
    }
    @media (min-width: 1200px) {
        margin-top: calc(740px/4);
    }
    @media (min-width: 1800px) {
        margin-top: calc(900px/4);
    }
    
    border-radius: 10px;
    padding: 30px;
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
       /*& input[type=date] {
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
        }*/
    }
}
.hide {
    opacity: 0;
}
</style>