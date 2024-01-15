window.$ = window.jQuery = require('jquery');
window.Popper = require('popper.js');
import './bootstrap';
import Vue from "vue";
import VueRouter from 'vue-router';
import {routes} from './router/vue-routes';
import SideBar from './components/SideBar';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import _ from 'lodash';

// // Import Bootstrap and BootstrapVue CSS files (order is important)
// import 'bootstrap/dist/css/bootstrap.css';
// import 'bootstrap-vue/dist/bootstrap-vue.css';

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);

Vue.use(VueRouter);

const router = new VueRouter({
    routes
  })

Vue.component('side-bar', SideBar);

var app = new Vue({
    el: '#app',
    router,
})
