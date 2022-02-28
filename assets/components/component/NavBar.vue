<template>
  <div>
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <div class="logo">FYC.</div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav me-auto mb-lg-0">
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuAstuces" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Astuces
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuAstuces">
                                <a class="dropdown-item" href="#">Toutes les astuces</a>
                                <a class="dropdown-item" href="#">Rechercher une astuce</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuItems" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Items
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuItems">
                                <a class="dropdown-item" href="#">Item 1</a>
                                <a class="dropdown-item" href="#">Item 2</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuProfil" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Profil
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuProfil">
                                <a class="dropdown-item" href="#">Voir</a>
                                <a class="dropdown-item" href="#">Modifier</a>
                            </div>
                        </div>
                    </li>
                </ul>
                <form class="d-flex">
                     <input class="search__input" type="text" placeholder="Rechercher...">
                     <button class="btn btn-outline-success" type="submit">Rechercher</button>
                     <!-- Bouton de validation à changer/enlever -->
                </form>
            </div>
        </div>
    </nav>
  </div>
</template>

<script>
export default {

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
}

.menus {
    padding-left: 2%;
}

.dropdown {
    margin: 10px;
}

button {
    @media (max-width: 768px) {
        font-size: 16px;
    }
    background-color: transparent;
    color: $text;
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
            padding: 12px 0;
            outline: 0;
            border: 1px solid transparent;
            border-bottom: 2px solid $text;
            border-radius: 0;
        }
    }
}
</style>