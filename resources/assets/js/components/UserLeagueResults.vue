<template>
	<div class="chart"></div>
</template>

<script>
	import highcharts from 'highcharts';
	export default {
		props: [ 'data-title', 'data-series' ],
		
		mounted() {
			highcharts.chart({
				chart: {
					renderTo: this.$el,
				},
				
				title: {
					text: this.dataTitle ? this.dataTitle : null,
				},
				
				xAxis: {
					type: 'category',
				},
				
				series: this.dataSeries ? JSON.parse(this.dataSeries) : null,
			});
		}
	}
</script>
