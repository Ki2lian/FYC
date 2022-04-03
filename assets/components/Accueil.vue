<template>
    <div data-app class="container-astuces">
        <div class="block__first">
        <NavBar class="fixed"/>
        </div>
        <div class="block__second">
            <h1 class="card__title">Les dernières astuces mises en ligne.</h1>
            <div class="container">
                <h4>{{ cards.length }} {{ "astuce" | pluralize(cards.length) }}</h4> 
                <div v-for="item in actualCards" :key="item.id">
                    <Card :tip="item" />
                </div>
            </div>
            <v-pagination
                v-model="page"
                :length="sliceAllCards.length"
                @input="onPageChange" color="rgba(81, 71, 197, 1)"
            ></v-pagination>
        </div>

        <Block :urlalltips="urlalltips" />

        <Footer />

    </div>
</template>

<script>
import NavBar from "./component/NavBar.vue"
import Card from "./component/Card.vue"
import Footer from "./component/FooterVue.vue"
import Block from "./component/Block.vue"
export default {
    props: {
        urlalltips: {
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
            // 
            textSearch: null,
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
        Block,
    },
    mounted() {
        this.cards = JSON.parse(this.tips)
        for(let i = 0; i < this.cards.length; i+= this.nombreCartesVisible) {
            const index = i + this.nombreCartesVisible
            this.sliceAllCards.push(this.cards.slice(i, index))
        }
        //init first page
        this.actualCards = this.sliceAllCards[0]
    },
    methods: {
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
        
        background-image: url("../img/backgroundHome.svg");
        background-size: 100%;
        background-repeat: no-repeat;
        background-color: rgb(125, 126, 128);
    }
    &__second {
        margin: 50px;
        margin-top: 20px;
    }
}

.card__title{
    text-align: center;
    margin-block: 60px;
}
</style>