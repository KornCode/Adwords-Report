<script>
import { Line, mixins } from 'vue-chartjs'

export default {
  	extends: Line,
  	props: ['options'],
  	mixins: [mixins.reactiveProp],
  	mounted () {
  		console.log(this.chartData);
    	// Overwriting base render method with actual data.
    	this.renderChart(this.chartData, this.options);
  	}
}
</script>