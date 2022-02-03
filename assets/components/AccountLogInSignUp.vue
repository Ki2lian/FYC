<template>
    <div>
        <NavBar/>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-lg-8">
                    <div id="register" ref="formRegister"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavBar from "./component/NavBar.vue"
export default {
    name: "AccountLogInSignUp",
     props: {
        formRegister: {
            type: String,
            default: ""
        }
    },
    components: {
        NavBar,
    },
    mounted() {
        this.$refs.formRegister.innerHTML = this.formRegister
    },

}
</script>

<style lang="scss">
$interactive_text: #5147C5;

.bg-interactive{
    background-color: $interactive_text;
    color: #eee;
}
.bg-interactive:hover{
    color: #fff;
}

#register .card .card-header{
    border-radius: 10px 10px 0px 0px;
}
#register .card .card-footer{
    border-radius: 0px 0px 10px 10px;
}

.card-form{
    background: #EEEEEE;
    box-shadow: 15px 15px 4px rgb(0 0 0 / 25%);
    border-radius: 10px;
}

.border-form{
    background-color: #E4E4E4;
    width: 9px;
    position: absolute;
    height: 91.15%;
    top: 4.4%;
}
</style>