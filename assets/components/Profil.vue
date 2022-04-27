<template>
    <div class="container__profil">
        <div class="block__first">
            <NavBar />
        </div>
        <div class="block__second">
            <div class="welcome">Bienvenue sur votre profil {{ user.pseudo }} !</div>
            <div class="personnal-information">
                <h3>Informations personnelles</h3>
                <div class="username"><img class="icon__user" src="../img/user.svg" alt="icon user">{{ user.pseudo }}</div>
                <div class="mail"><img class="icon__mail" src="../img/mail.svg" alt="icon mail">{{ user.email }}</div>
                <a href="/logout" class="btn btn-primary btn-logout">Se déconnecter</a>
            </div>
            <div class="infos__block row mb-4">
                <div class="infos__child col-md-4">
                    <img class="icon__astuce" src="../img/astuce.svg" alt="icon astuce">
                    <span class="tipsPosted">{{ user.nbTips }} {{ "astuce" | pluralize(user.nbTips) }} {{ "postée" | pluralize(user.nbTips) }}</span>
                </div>

                <div class="infos__child col-md-4">
                    <span>Note moyenne des annonces</span>
                    <div v-if="user.note == null">
                        <span>Aucune note</span>
                    </div>
                    <div class="d-flex" v-else>
                        <span v-for="_ in 5" :key="_">
                            <i v-if="_ <= user.note" class="fas fa-star fa-lg"></i>
                            <i v-else class="far fa-star fa-lg"></i>
                        </span>
                    </div>
                </div>

                <div class="infos__child col-md-4"><img class="icon__commentaire" src="../img/commentaire.svg" alt="icon commentaire">
                    {{ user.nbComments }} {{ "commentaire" | pluralize(user.nbComments) }} {{ "posté" | pluralize(user.nbComments) }}
                </div>
    
                
            </div>
            <div class="data_users">
                <div class="alert alert-danger form-error mt-3" style="display: none;" role="alert"></div>
                <v-data-table
                    :headers="headers"
                    :items="tips"
                    :items-per-page="5"
                    locale="fr"
                    class="elevation-1"
                >

                <template v-slot:item.ratings="{ item }">
                    <span v-html="getStars(item.ratings)"></span>
                </template>

                <template v-slot:item.comments="{ item }">
                    <span>{{ item.comments.length }}</span>
                </template>

                <template v-slot:item.createdAt="{ item }">
                    <span>{{ getCreatedAt(item.createdAt) }}</span>
                </template>

                <template v-slot:item.isValid="{ item }">
                    <span v-if="item.isValid">Oui</span>
                    <span v-else>Non</span>
                </template>

                <template v-slot:item.action="{ item }">
                    <button class="btn p-1" @click="showTip(item)"><i class="fas fa-eye text-secondary"></i></button>
                    <button class="btn p-1" @click="editTip(item)"><i class="fas fa-edit text-primary"></i></button>
                    <button class="btn p-1" @click="deleteTip(item)"><i class="fas fa-trash text-danger"></i></button>
                </template>
                </v-data-table>
            </div>
        </div>
        <Footer class="mt-5" />
    </div>
</template>

<script>
import NavBar from "./component/NavBar.vue"
import Footer from "./component/FooterVue.vue"
import axios from "axios";
export default {
    props: {
        appUser: {
            type: String,
            required: true
        }
    },
    components: {
        NavBar,
        Footer,
    },
    data () {
        return {
            user: {},
            headers: [
                { text: 'Titre', align: 'start', value: 'title',},
                { text: 'Note (moyenne)', value: 'ratings' },
                { text: 'Commentaires', value: 'comments' },
                { text: 'Date de création', value: 'createdAt' },
                { text: 'En ligne', value: 'isValid' },
                { text: 'Action',  value: 'action', sortable: false, align: 'center' },
            ],
            tips: [],
        }
    },
    mounted() {
        this.user = JSON.parse(this.appUser)
        this.tips = this.user.tips
    },
    methods: {
        getStars(ratings) {
            let note = 0
            ratings.forEach(rating => note += rating.value)
            let average = Math.round((note / ratings.length) * 5)

            let html = ''
            for (let i = 1; i <= 5; i++) {
                if(i <= average) html += '<i class="fas fa-star fa-lg" style="color: #FFD700; filter: drop-shadow(0px 0px 2px #000);"></i>'
                else html += '<i class="far fa-star fa-lg" style="color: #FFD700; filter: drop-shadow(0px 0px 2px #000);"></i>'
            }
            return html
        },
        getCreatedAt(createdAt) {
            let date = new Date(createdAt)
            let day = ("0" + date.getDate()).slice(-2)
            let month = ("0" + (date.getMonth() + 1)).slice(-2)
            let year = date.getFullYear()
            return `${day}/${month}/${year}`
        },
        showTip(tip) {
            window.open(
                `/tip/${tip.id}`,
                '_blank'
            );
        },
        editTip(tip) {
            // page de modification
        },
        deleteTip(tip) {
            if(!window.confirm(`Voulez-vous vraiment supprimer cette astuce ? (${tip.title})`)) return;
            const formData = new FormData();
            formData.append('id', tip.id)
            axios.delete(`/api/tip/${tip.id}`, { headers: {"X-Requested-With": "XMLHttpRequest"} })
                .then(res => {
                    const response = res.data;
                    if(!response.errors){
                        this.tips = this.tips.filter(t => t.id !== tip.id)
                        const pluralize = this.tips.length > 1 ? 's' : ''
                        $(".tipsPosted").html(`
                            ${this.tips.length} astuce${pluralize} postée${pluralize}
                        `);
                    }else{
                        var errorsHtml = "";
                        response.errors.forEach((error) => errorsHtml += `<li>${error.message}</li>`);
                        $(".form-error").html(`<ul>${errorsHtml}</ul>`);
                        $(".form-error").slideDown();
                    }
                });
        }
    },
}
</script>

<style lang="scss" scoped>
$text: #272D2D;
$light_text: #383d3d;
$interactive_text: #5147C5;
$seconday_color: #EEEEEE;
$background: #D8D8D8;

.btn-logout{
    background-color: #5147C5;
    color: #fff;
}

.fa-star{
    color: #FFD700;
    filter: drop-shadow(0px 0px 2px #000);
}
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