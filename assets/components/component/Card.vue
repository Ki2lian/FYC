<template>
    <div class="tip">
        <div class="row">
            <div class="col-2 d-flex flex-column ms-5">
                <p>{{ tip.ratings.length }} {{ "vote" | pluralize(tip.ratings.length) }}</p>
                <p>{{ tip.comments.length }} {{ "commentaire" | pluralize(tip.comments.length) }}</p>
            </div>
            <div class="col">
                <a :href="'/tip/' + tip.id">{{ tip.title }}</a>
            </div>
        </div>
        <div class="row mt-0">
            <div class="col-2 ms-5"></div>
            <div class="col">
                <div class="d-flex justify-content-between" :class="tip.tag.length > 0 ? 'mb-3' : ''">
                    <div class="tags w-50">
                        <a class="tag text-dark mb-1" :href="'/tips/tagged/' + tag.name" v-for="tag in tip.tag" :key="tag.id">{{ tag.name }}</a>
                    </div>
                    <p></p>
                    <div class="info me-5">
                        <span><a href="#" class="mx-1">{{ tip.user.pseudo }}</a> <span class="mx-1">{{ dateFromNow(tip.createdAt) }}</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as moment from 'moment'
moment.locale("fr")
export default {
    props: {
        tip: {
            type: Object,
            required: true
        },
    },
    mounted() {
    },
    methods: {
        dateFromNow(date) {
            return moment(date).fromNow();
        }
    },
    name: 'card',
    components: {
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

.tip{
    background-color: $seconday_color;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
}


.container {
    background-color: $seconday_color;
    box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
    margin: 15px;
    flex: 0 0 20.333333%;
}

// .tags{
//     overflow-x: scroll;
// }

.tags .tag:hover{
    color: rgba(0, 0, 0, 0.3);
    cursor: pointer;
}

.tag {
    margin: 0px 10px 10px 0px;
    padding: 5px;
    background: $seconday_color;
    border: 0.5px solid $background;
    box-sizing: border-box;
    box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
}

.tag:hover{
    background: $background;
}

.title {
    font-size: larger;
}

.owner {
    color: #707070;
}

hr {
    border: 1px solid black;
}

.content {
    text-align: center;
}

a {
    color: $interactive_text;
    text-decoration: none;
}

</style>