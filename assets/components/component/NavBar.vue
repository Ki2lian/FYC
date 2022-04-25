<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-xl-light">
        <div class="container-fluid">
            <div class="logo">
                <a class="d-flex text-decoration-none text-dark" href="/">FYC.
                    <vue-typed-js   :strings="[ 'css',
                                                'html',
                                                'py',
                                                'js',
                                                'php',
                                                'vue',
                                                'apk',
                                                'asp',
                                                'bat',
                                                'bin',
                                                'c',
                                                'cpp',
                                                'cs',
                                                'dev',
                                                'dart',
                                                'exe',
                                                'p',
                                                'xml',
                                                'yaml',
                                                'json',
                                                'twig',
                                                'sql',
                                                'java',
                                                'md',
                                                'sh',
                                                'ts'
                                    ]"
                                    :startDelay="0"
                                    :backDelay="5000"
                                    :typeSpeed="50"
                                    :backSpeed="50"
                                    :shuffle="true"
                                    :loop="true"
                    >
                        <span class="typing"></span>
                    </vue-typed-js>
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavigation" aria-controls="menuNavigation" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuNavigation">
                <ul class="navbar-nav me-auto mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/add_tip">Ajouter une astuce</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/tips">Astuces</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/account">Profil</a>
                    </li>
                </ul>
                <form class="d-flex" @submit.prevent="checkSearch()">
                     <input class="search__input" type="text" placeholder="Rechercher..." v-model="textSearch"/>
                </form>
            </div>
        </div>
    </nav>
  </div>
</template>

<script>
export default {
    data() {
        return {
            textSearch: "",
        }
    },
    methods: {
        checkSearch() {
            if(this.textSearch != "") window.location.replace("/tips/search/" + this.textSearch);
        },
    }
}
</script>

<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');

// COLORS
$text: #272D2D;
$light_text: #383d3d;
$interactive_text: #5147C5;
$seconday_color: #EEEEEE;

#nav-bar {
    font-family: 'Roboto Slab', serif;
    width: 100%;
}

.logo {
    @media (max-width: 768px) {
        font-size: 16px;
    }
    font-size: 32px;
    margin-right: 5%;
    width: 100px;
}

.menus {
    padding-left: 2%;
}

.nav-item{
    margin: 10px;
}

.nav-link, button {
    @media (max-width: 768px) {
        font-size: 16px;
    }
    padding: 0.375rem 0.75rem;
    background-color: transparent;
    color: $text!important;
    border: none;
    font-size: 24px;

    &:hover {
        color: $light_text;
        background-color: transparent;
    }
    &:focus {
        color: $light_text;
        background-color: transparent;
        box-shadow: none;
    }
    &:active {
        color: $light_text;
        background-color: transparent;
        &:focus {
            box-shadow: none;
        }
    }
}

.search {
    
    &__input {
        background-color: $seconday_color !important;
        width: 90%;
        padding: 12px 24px;

        background-color: $seconday_color;
        transition: transform 250ms ease-in-out;
        font-size: 14px;
        line-height: 18px;
        
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        color: $text;
        background-color: transparent;

        border-radius: 30px;
        border: 0.15rem solid $text;
        transition: all 250ms ease-in-out;
        
        &::placeholder {
            color: $text;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        &:hover,
        &:focus {
            color: $text;
            padding: 12px;
            outline: 0;
        }
    }
}
</style>