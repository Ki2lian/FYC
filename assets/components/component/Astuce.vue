<template>
    <div class="astuce__content">
        <hr>
        <div class="title">
            <a href="#">{{ data.name }}</a>
        </div>
        <div class="content__desc">
            <div v-if="description.length < 250"> {{ description }} </div>
            <div v-else>{{ description.substring(0, 250) + " ..." }}</div>
        </div>
        <div class="tags">
            <div class="tag">SQL</div>
            <div class="tag">Python</div>
            <div class="tag">JAVA</div>
            <div class="tag">TS</div>
            <div class="tag">Symfony</div>
            <div class="tag">VueJS</div>
        </div>
        <div class="owner"><a href="#">Owner</a></div>
        <!-- Redirection vers le profil utilisateur -->
    </div>
</template>

<script>
export default {

    data() {
        return {
            description: "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere oribus."
        }
    },

    props: {
        data: {
            Object,
            default: {
                name: "Default title",
            }
        }
    },

    mounted() {
        
    },
}
</script>

<style lang="scss" scoped>
// COLORS
$text: #272D2D;
$light_text: #383d3d;
$interactive_text: #5147C5;
$seconday_color: #EEEEEE;
$background: #D8D8D8;

.title {
    font-size: 1.5em;
    word-wrap: break-word;
}

a {
    text-decoration: none;
    color: $interactive_text;
}

.tags {
    display: flex;
    flex-wrap: wrap;
    margin: 10px 0px 10px 0px;
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

.owner {
    text-align: right;
    color: $interactive_text;
    font-size: 1.15em;
}

</style>