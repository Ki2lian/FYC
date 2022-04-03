<template>
    <!-- <div class="container">
        <div class="tags">
            condition pour récupérer les 2 premiers tags
            <div class="tag">Programmation</div>
            <div class="tag">C #</div>
        </div>
        <div class="title">Title</div>
        <div class="owner">Owner</div>
        <hr>
        <div class="content">
            Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus.
        </div>
        <div class="btn">
            <a href="#">Voir</a>
        </div>
    </div> -->

    <!-- <div class="card">
        <div class="card-header">
            <simplebar data-simplebar-auto-hide="false" style="height: 40px;" class="mt-1">
                <div class="tags d-flex flex-nowrap py-0">
                    <a class="nav-link btn btn-primary p-0 px-2 mx-1 text-light" href="#">Programmation</a>
                    <a class="nav-link btn btn-primary p-0 px-2 mx-1 text-light" href="#">C#</a>
                </div>
            </simplebar>
        </div>
        <div class="card-body">
            <h3 class="card-title">Title</h3>
            <p class="card-text text-muted">Owner</p>
            <hr/>
        </div>
    </div> -->

    <div class="row tip">
        <div class="col-2 d-flex flex-column ms-5">
            <p>{{ tip.ratings.length }} {{ "vote" | pluralize(tip.ratings.length) }}</p>
            <p>{{ tip.comments.length }} {{ "commentaire" | pluralize(tip.comments.length) }}</p>
        </div>
        <div class="col">
            <a href="#">{{ tip.title }}</a>
            <div class="d-flex justify-content-between mt-3">
                <div class="tags">
                    <a class="tag btn btn-outline-info p-1 py-0 me-1 text-dark" :href="'/tips/tagged/' + tag.name" v-for="tag in tip.tag" :key="tag.id">{{ tag.name }}</a>
                    
                </div>
                <p></p>
                <div class="info me-5">
                    <!-- 10 sec ago | 03/12/2022 à 18h46 -->
                    <span><a href="#" class="mx-1">{{ tip.user.pseudo }}</a> <span class="mx-1">{{ dateFromNow(tip.createdAt) }}</span></span>
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

// .tags {
//     display: flex;
//     margin-bottom: 10px;
// }

// .tag {
//     margin-right: 25px;
//     padding: 5px;
//     background: $seconday_color;
//     border: 0.5px solid $background;
//     box-sizing: border-box;
//     box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.25);
//     border-radius: 10px;
// }

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