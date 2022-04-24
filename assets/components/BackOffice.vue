<template>
  <div class="backoffice___content">
    <SideBar />
    
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
import SideBar from "./backoffice/SidebarBackOffice.vue"

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

  components: {
    SideBar
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

.icon_color {
  color: #5147C5;
}
</style>