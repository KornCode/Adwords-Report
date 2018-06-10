
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');

import Chartkick from 'chartkick'
import VueChartkick from 'vue-chartkick'
import Chart from 'chart.js'

Vue.use(VueChartkick, { Chartkick })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('sidebar-component', require('./components/SidebarComponent.vue'));
Vue.component('chart-component', require('./components/ChartComponent.vue'));
Vue.component('keywords-component', require('./components/KeywordsComponent.vue'));
Vue.component('searches-component', require('./components/SearchesComponent.vue'));
Vue.component('most-shown-ads-component', require('./components/MostShownAdsComponent.vue'));
Vue.component('devices-component', require('./components/DevicesComponent.vue'));
Vue.component('locations-component', require('./components/LocationsComponent.vue'));
Vue.component('networks-component', require('./components/NetworksComponent.vue'));
Vue.component('day-hour-component', require('./components/DayHourComponent.vue'));

const app = new Vue({
    el: '#app',
});
