<template>
  <div>
    <SideBar />
    <div class="page-content admin__add_tag" id="content">
      <!-- Toggle button -->
      <button
        id="sidebarCollapse"
        type="button"
        class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"
      >
        <i class="fa fa-bars mr-2"></i
        ><small class="text-uppercase font-weight-bold ms-2">Menu</small>
      </button>
      <h2>Ajouter un tag</h2>
      <form @submit.prevent="validate">
        <input type="text" v-model="tag" placeholder="Nom du tag" />
        <br>
        <input type="submit" value="Créer" />
      </form>
    </div>
  </div>
</template>

<script>
import SideBar from "./SidebarBackOffice.vue";

export default {
  data() {
    return {
      tag: null,
    };
  },

  components: {
    SideBar,
  },

  methods: {
    validate: function () {
      console.log("submit");
    },
  },
};
</script>

<style lang="scss" scoped>
.admin__add_tag {
  display: flex;
  flex-direction: column;
  align-items: center;
  background: #5147c5;
  background: -webkit-linear-gradient(to right, #5147c5, #d8d8d8);
  background: linear-gradient(to right, #5147c5, #d8d8d8);
  min-height: 100vh;
  overflow-x: hidden;
}

.page-content {
  width: calc(100% - 17rem);
  margin-left: 17rem;
  transition: all 0.4s;
}

#content.active {
  width: 100%;
  margin: 0;
}

@media (max-width: 768px) {
  #content {
    width: 100%;
    margin: 0;
  }
  #content.active {
    margin-left: 17rem;
    width: calc(100% - 17rem);
  }
}

#sidebarCollapse {
  align-self: start;
  margin-left: 2em;
  margin-top: 2em;
}

form {
  margin: 2em;
}
input[type="text"] {
  &::placeholder {
    color: #5147c5;
    font-size: 24px;
  }
  border: 2px solid black;
  font-size: 24px;
  padding: 10px;
  color: #5147c5;
}

input[type="submit"] {
    font-size: 24px;
    font-weight: 500;
    width: -webkit-fill-available;
    padding: 10px;
}
</style>