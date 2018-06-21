
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window._ = require('lodash');


import BootstrapVue from 'bootstrap-vue'
// import VueCharts from 'vue-chartjs'
// import { Line, Bar } from 'vue-chartjs'
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(BootstrapVue);
Vue.use(VueAxios, axios);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('chart-component', require('./components/ChartComponent.vue'));
Vue.component('summary-component', require('./components/SummaryComponent.vue'));
Vue.component('test-chart', require('./components/OverviewChartComponent.vue'));
Vue.component('combined-component', require('./components/CombinedTempComponent.vue'));

const app = new Vue({
    el: '#app',
});
