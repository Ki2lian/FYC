<template>
  <!-- Vertical navbar -->
    <div class="vertical-nav bg-white" id="sidebar">
      	<div class="py-4 px-3 mb-4 bg-light">
			<a href="/administration" class="text-decoration-none" style="color: initial;">
				<div class="media d-flex align-items-center">
					<i class="fa fa-cogs fa-3x rounded-circle img-thumbnail shadow-sm"></i>
					<div class="media-body">
						<h4 class="m-0 ms-2">FYC.</h4>
					</div>
				</div>
			</a>
		</div>

      <ul class="nav flex-column bg-white mb-0">
		  <li class="nav-item">
          <a href="/" class="nav-link text-dark font-italic">
            <i class="fa fa-home mr-3 fa-fw icon_color"></i>
            Accueil
          </a>
        </li>
      </ul>

      <p class="text-gray font-weight-bold text-uppercase px-3 small pb-4 mb-0">Administration</p>

      <ul class="nav flex-column bg-white mb-0">
        <li class="nav-item">
          <a href="/administration/astuces" class="nav-link text-dark font-italic">
            <i class="fa fa-lightbulb mr-3 fa-fw icon_color"></i>
            Astuces
          </a>
        </li>
        <li class="nav-item">
          <a href="/administration/tags" class="nav-link text-dark font-italic">
            <i class="fa fa-tags mr-3 fa-fw icon_color"></i>
            Tags
          </a>
        </li>
      </ul>
    </div>
    <!-- End vertical navbar -->
</template>

<script>
export default {

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

/* for toggle behavior */

#sidebar.active {
  margin-left: -17rem;
}

@media (max-width: 768px) {
  #sidebar {
    margin-left: -17rem;
  }
  #sidebar.active {
    margin-left: 0;
  }
}

</style>