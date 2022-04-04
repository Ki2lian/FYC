<template>
  <div class="backoffice___content">

    <!-- Vertical navbar -->
    <div class="vertical-nav bg-white" id="sidebar">
      <div class="py-4 px-3 mb-4 bg-light">
        <div class="media d-flex align-items-center">
          <i class="fa fa-cogs fa-3x rounded-circle img-thumbnail shadow-sm"></i>
          <div class="media-body">
            <h4 class="m-0 ms-2">FYC.</h4>
            <p class="font-weight-light text-muted mb-0 ms-2">Web company</p>
          </div>
        </div>
      </div>

      <p class="text-gray font-weight-bold text-uppercase px-3 small pb-4 mb-0">Administration</p>

      <ul class="nav flex-column bg-white mb-0">
        <li class="nav-item">
          <a href="#" class="nav-link text-dark font-italic bg-light">
            <i class="fa fa-comments mr-3 fa-fw icon_color"></i>
            Commentaires
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link text-dark font-italic">
            <i class="fa fa-users mr-3 fa-fw icon_color"></i>
            Utilisateurs
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link text-dark font-italic">
            <i class="fa fa-tags mr-3 fa-fw icon_color"></i>
            Ajouter des tags
          </a>
        </li>
      </ul>

      <p class="text-gray font-weight-bold text-uppercase px-3 small py-4 mb-0">Statistiques</p>

      <ul class="nav flex-column bg-white mb-0">
        <li class="nav-item">
          <a href="#" class="nav-link text-dark font-italic">
            <i class="fa fa-server mr-3 fa-fw icon_color"></i>
            Utilisateurs
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link text-dark font-italic">
            <i class="fa fa-comment mr-3 fa-fw icon_color"></i>
            Astuces publiées
          </a>
        </li>
      </ul>
    </div>
    <!-- End vertical navbar -->
    <!-- Page content holder -->
    <div class="page-content p-5" id="content">
      <!-- Toggle button -->
      <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"><i class="fa fa-bars mr-2"></i><small class="text-uppercase font-weight-bold ms-2">Menu</small></button>

      <h2 class="display-4 text-white">Back Office</h2>
      <apexchart width="500" type="bar" :options="options" :series="series" id="vuechart-example"></apexchart>
    </div>

  </div>
</template>

<script>

export default {

  data() {
    return {
      options: {
        chart: {
          id: 'vuechart-example'
        },
        xaxis: {
          categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]
        }
      },
      series: [{
        name: 'series-1',
        data: [30, 40, 45, 50, 49, 60, 70, 91]
      }]
    }
  },

  mounted() {
    const sidebarToggle = document.querySelector('#sidebarCollapse')
    sidebarToggle.addEventListener("click", () => {
      const sidebar = document.querySelector('#sidebar')
      const content = document.querySelector('#content')

      sidebar.classList.toggle('active')
      content.classList.toggle('active')
    })
  },

}
</script>

<style lang="scss" scoped>
.page-content {
  background: #5147C5;
  background: -webkit-linear-gradient(to right, #5147C5, #D8D8D8);
  background: linear-gradient(to right, #5147C5, #D8D8D8);
  min-height: 100vh;
  overflow-x: hidden;
}

.vertical-nav {
  min-width: 17rem;
  width: 17rem;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.1);
  transition: all 0.4s;
}

.page-content {
  width: calc(100% - 17rem);
  margin-left: 17rem;
  transition: all 0.4s;
}

/* for toggle behavior */

#sidebar.active {
  margin-left: -17rem;
}

#content.active {
  width: 100%;
  margin: 0;
}

@media (max-width: 768px) {
  #sidebar {
    margin-left: -17rem;
  }
  #sidebar.active {
    margin-left: 0;
  }
  #content {
    width: 100%;
    margin: 0;
  }
  #content.active {
    margin-left: 17rem;
    width: calc(100% - 17rem);
  }
}

.icon_color {
  color: #5147C5;
}
</style>