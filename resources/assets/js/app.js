
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window._ = require('lodash');

// import Chartkick from 'chartkick'
// import VueChartkick from 'vue-chartkick'
// import Chart from 'chart.js'
// import PrettyCheckbox from 'pretty-checkbox-vue';
import BootstrapVue from 'bootstrap-vue'
import VueCharts from 'vue-chartjs'
import { Line, Bar } from 'vue-chartjs'
import axios from 'axios'
import VueAxios from 'vue-axios'

// Vue.use(VueChartkick, { Chartkick })
// Vue.use(Chart);
Vue.use(BootstrapVue);
// Vue.use(VueCharts, { Line });
// Vue.use(VueCharts, { Bar });

Vue.use(VueAxios, axios)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('chart-component', require('./components/ChartComponent.vue'));
Vue.component('summary-component', require('./components/SummaryComponent.vue'));
Vue.component('test-chart', require('./components/OverviewChartComponent.vue'));

const app = new Vue({
    el: '#app',
});
