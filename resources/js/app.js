import './bootstrap';
import Vue from "vue";
import VueRouter from 'vue-router';
import {routes} from './router/vue-routes';
import SideBar from './components/SideBar';

Vue.use(VueRouter);

const router = new VueRouter({
    routes
  })

Vue.component('side-bar', SideBar);

var app = new Vue({
    el: '#app',
    router,
})
