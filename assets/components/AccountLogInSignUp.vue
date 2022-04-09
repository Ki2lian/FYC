<template>
    <div>
        <NavBar/>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-lg-8 forms">
                    <div id="login" ref="formLogin">
                        <div class="card card-form mt-5">
                            <div class="card-header pb-3 bg-interactive"></div>
                            <div class="border-form"></div>
                            <div class="card-body p-4">
                                <div class="text-center w-75 m-auto info">
                                    <h4 class="text-dark-50 mt-0 fw-bold">Connexion</h4>
                                    <p class="text-muted mb-4">Connectez-vous pour accéder aux différentes fonctionnalités</p>
                                </div>
                                <form :action="pathLogin" method="post">
                                    <div v-if="error" class="alert alert-danger" role="alert">
                                        <span>Email ou mot de passe incorrect</span>
                                    </div>
                                    <div class="container mt-1 ms-1">
                                        <div class="mb-3">
                                            <label for="username">Email:</label>
                                            <input type="text" id="username" name="_username" :value="lastusername" required="required" class="form-control border-bottom border-dark border-top-0 border-start-0 border-end-0 border-2" :placeholder="email" autocomplete="email" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="password">Password:</label>
                                            <input type="password" id="password" name="_password" required="required" class="form-control border-bottom border-dark border-top-0 border-start-0 border-end-0 border-2" :placeholder="password" minlength="8" maxlength="4096" autocomplete="off"/>
                                        </div>
                                        <input type="hidden" name="_csrf_token" :value="token">
                                        <div class="mb-3 text-center">
                                            <button class="btn bg-interactive" type="submit" name="login">Se connecter</button>
                                        </div>
                                    </div>
                                </form>
                                <p class="text-muted text-center">Vous n'avez pas de compte ? <span class="ms-1 toggle-forms"><b>Inscrivez-vous</b></span></p>
                            </div>
                            <div class="border-form end-0"></div>
                            <div class="card-footer bg-interactive pt-3"></div>
                        </div>
                    </div>
                    <div id="register" style="display: none;" ref="formRegister"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavBar from "./component/NavBar.vue"
import passtrength from "../jquery.passtrength.min.js"
export default {
    name: "AccountLogInSignUp",
    props: {
        formRegister: {
            type: String,
            default: ""
        },
        pathLogin: {
            type: String,
            default: ""
        },
        lastusername: {
            type: String,
            default: ""
        },
        error: {
            type: String,
            default: ""
        },
        token: {
            type: String,
            default: ""
        },
        email: {
            type: String,
            default: ""
        },
        password: {
            type: String,
            default: ""
        }
    },
    components: {
        NavBar,
    },
    mounted() {
        this.$refs.formRegister.innerHTML = this.formRegister
        if(this.$refs.formRegister.querySelector("form").querySelector(".alert")){
            $("#login").hide();
            $("#register").show();
        }
    },

}

$(document).ready(function(){
    var formRegister = false;
    $("#register .card .card-body").append(`
        <p class="text-muted text-center">Vous avez déjà un compte ? <span class="ms-1 toggle-forms"><b>Connectez-vous</b></span></p>
    `);

    $("#registration_form_plainPassword").passtrength({
        minChars: 8,
        passwordToggle: false,
        tooltip: true,
        textWeak: "Faible",
        textMedium: "Moyen",
        textStrong: "Fort",
        textVeryStrong: "Très fort"
    });

    $("#register, #login").on('click', '.toggle-forms', function(){
        if(formRegister) {
            $("#register").fadeOut(() => {
                $("#login").fadeIn();
            });
        } else {
            $("#login").fadeOut(() => {
                $("#register").fadeIn();
            });
        }
        formRegister = !formRegister;
    });
});
</script>

<style lang="scss">
$interactive_text: #5147C5;

.toggle-forms{
    cursor: pointer;
    color: $interactive_text;
}

.bg-interactive{
    background-color: $interactive_text;
    color: #eee;
}
.bg-interactive:hover{
    color: #fff;
}

.forms .card .card-header{
    border-radius: 10px 10px 0px 0px;
}
.forms .card .card-footer{
    border-radius: 0px 0px 10px 10px;
}

.card-form{
    background: #EEEEEE;
    box-shadow: 15px 15px 4px rgb(0 0 0 / 25%);
    border-radius: 10px;
}

#register .border-form{
    background-color: #E4E4E4;
    width: 9px;
    position: absolute;
    height: 91.15%;
    top: 4.4%;
}

#login .border-form{
    background-color: #E4E4E4;
    width: 9px;
    position: absolute;
    height: 87%;
    top: 6.5%;
}
</style>