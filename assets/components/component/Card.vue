<template>
    <div class="container">
        <div class="tags">
            <!-- condition pour récupérer les 2 premiers tags -->
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
    </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>

// COLORS
$text: #272D2D;
$light_text: #383d3d;
$interactive_text: #5147C5;
$seconday_color: #EEEEEE;
$background: #D8D8D8;

.container {
    background-color: $seconday_color;
    box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
    margin: 15px;
    flex: 0 0 20.333333%;
}

.tags {
    display: flex;
    margin-bottom: 10px;
}

.tag {
    margin-right: 25px;
    padding: 5px;
    background: $seconday_color;
    border: 0.5px solid $background;
    box-sizing: border-box;
    box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
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

.btn {
    display: flex;
    justify-content: center;
}
a {
    width: 50%;
    border-radius: 15px;
    background-color: $interactive_text;
    color: $seconday_color;
    padding: 5px;
    text-decoration: none;
}

</style>