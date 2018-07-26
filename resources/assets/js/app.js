
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('admin-lte/dist/js/adminlte');
require('bootstrap-select/js/bootstrap-select');

window.Vue = require('vue');
window._ = require('lodash');

$(document).ready(function() {
    $(".widget_tab").click(function () {
        $(".widget_tab").removeClass("active");
        // $(".tab").addClass("active"); // instead of this do the below 
        $(this).addClass("active");   
    });
});

import BootstrapVue from 'bootstrap-vue'
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(BootstrapVue);
Vue.use(VueAxios, axios);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('test-chart', require('./components/OverviewChartComponent.vue'));
Vue.component('overview-component', require('./components/OverviewComponent.vue'));

const app = new Vue({
    el: '#app',
});
