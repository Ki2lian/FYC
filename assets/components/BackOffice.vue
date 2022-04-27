<template>
  <div class="backoffice___content">
    <SideBar />
    
    <!-- Page content holder -->
    <div class="page-content p-5" id="content">
      	<!-- Toggle button -->
		<button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"><i class="fa fa-bars mr-2"></i><small class="text-uppercase font-weight-bold ms-2">Menu</small></button>

		<h2 class="display-4 text-white">Statistiques</h2>
		<div class="row">
			<div class="col-sm-6 col-lg-3">
				<div class="card shadow-none m-0 border-start">
					<div class="card-body text-center">
						<i class="fas fa-users text-muted h4"></i>
						<h3><span>{{ chartsData.users.nb_users }}</span></h3>
						<p class="text-muted font-15 mb-0">{{ "Utilisateur" | pluralize(chartsData.users.nb_users) }}</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3">
				<div class="card shadow-none m-0 border-start">
					<div class="card-body text-center">
						<i class="fas fa-lightbulb text-muted h4"></i>
						<h3><span>{{ chartsData.tips.nb_tips }}</span></h3>
						<p class="text-muted font-15 mb-0">{{ "Astuce" | pluralize(chartsData.tips.nb_tips) }}</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3">
				<div class="card shadow-none m-0 border-start">
					<div class="card-body text-center">
						<i class="fas fa-tags text-muted h4"></i>
						<h3><span>{{ chartsData.tags.nb_tags }}</span></h3>
						<p class="text-muted font-15 mb-0">{{ "Tag" | pluralize(chartsData.tags.nb_tags) }}</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-lg-3">
				<div class="card shadow-none m-0 border-start">
					<div class="card-body text-center">
						<i class="fas fa-comments text-muted h4"></i>
						<h3><span>{{ chartsData.comments.nb_comments }}</span></h3>
						<p class="text-muted font-15 mb-0">{{ "Commentaire" | pluralize(chartsData.comments.nb_comments) }}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 mb-2" v-for="chart in charts" :key="chart.id">
				<div class="card h-100">
						<div class="card-header">
							<span class="header-title h4 font-14">{{ chart.name }}</span>
						</div>
						<div class="card-body">
							<apexchart v-if="chart.type.toLowerCase() == 'bar'" type="bar" :options="chart.options" :series="chart.series" :id="chart.id"></apexchart>
							<apexchart v-else-if="chart.type.toLowerCase() == 'pie'" type="pie" :options="chart.chartOptions" :series="chart.series" :id="chart.id"></apexchart>
						</div>
				</div>
			</div>
		</div>

		<h3 class="display-5 text-white">Les 10 derniers inscrits</h3>
		<div class="table-responsive">
			<table class="table table-striped table-hover bg-light rounded">
				<thead>
					<tr>
						<th>ID</th>
						<th>Pseudo</th>
						<th>Email</th>
						<th>Date de création</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="user in chartsData.users.last_users" :key="user.id">
						<th>{{ user.id }}</th>
						<td>{{ user.pseudo }}</td>
						<td>{{ user.email }}</td>
						<td>{{ dateFromNow(user.createdAt) }}</td>
					</tr>
				</tbody>
			</table>
		</div>
    </div>
  </div>
</template>

<script>
import SideBar from "./backoffice/SidebarBackOffice.vue";
import fr from "apexcharts/dist/locales/fr.json";
import * as moment from 'moment';
moment.locale("fr");
export default {
	props: {
		data: {
			type: String,
			default: ""
		},
	},
	data() {
		return {
			chartsData: null,
			charts: [
				/*{
					id: "chart-utilisateurs",
					name: "Utilisateurs",
					type: "bar",
					options: {
						chart: {
							id: 'chart-utilisateurs'
						},
						xaxis: {
							categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]
						}
					},
					series: [{
						name: 'series-1',
						data: [30, 40, 45, 50, 49, 60, 70, 91]
					}]
				}*/
			],
			
		}
	},
	beforeMount() {
		this.chartsData = JSON.parse(this.data);
	},
	mounted() {
		Apex.chart = {
			locales: [fr],
			defaultLocale: 'fr',
		}
		Apex.legend = {
			show: true,
			showForSingleSeries: true,
			position: 'bottom'
		}
		this.getBarChart(
			"chart-utilisateurs",
			"Utilisateurs",
			["Utilisateurs"],
			[
				{
					name: "Utilisateurs",
					data: [this.chartsData.users.nb_users],
				},
				{
					name: "Utilisateurs ayant crée une astuce",
					data: [ this.chartsData.users.nb_owner_tips],
				}
			]
		);
		this.getPieChart(
			"chart-astuces",
			"Astuces",
			["Astuces", "Astuces validées", "Astuces non validées"],
			[this.chartsData.tips.nb_tips, this.chartsData.tips.nb_tips_valid, this.chartsData.tips.nb_tips_invalid]
		);
	},
	components: {
		SideBar
	},
	methods: {
		getBarChart(id, name, categories, series) {
			this.charts.push({
				id,
				name,
				type:"bar",
				options: {
					chart: {
						id
					},
					xaxis: {
						categories
					}
				},
				series
			});
		},
		getPieChart(id, name, labels, series){
			this.charts.push({
				id,
				name,
				type: "pie",
				series,
				chartOptions: {
					chart: {
						type: "pie",
					},
					labels
				},
			});
		},
		dateFromNow(date) {
			const dateString = new Date(date);
			const day = ('0' + dateString.getDate()).slice(-2);
			const month = ('0' + (dateString.getMonth()+1)).slice(-2);
			const year = dateString.getFullYear();
			return moment(date).fromNow() + ` (${day}/${month}/${year})`;
		}
	}

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