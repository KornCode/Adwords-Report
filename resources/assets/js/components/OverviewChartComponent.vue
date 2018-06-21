<script>
import { Line, Bar, mixins } from 'vue-chartjs'

export default {
  	extends: Line,
  	props: ['options'],
	mixins: [mixins.reactiveProp],
	watch: {
		options: {
			handler(newVal, oldVal){
				var self = this;
				// console.log(newVal, oldVal);
				self.renderChart(self.chartData, newVal);
			},
			deep: true
		}
	},
  	mounted () {
  		// console.log(this.chartData);
    	// Overwriting base render method with actual data.
    	this.renderChart(this.chartData, this.options);
  	}
}
</script>