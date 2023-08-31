import './bootstrap';
import Vue from "vue";
import VueRouter from 'vue-router';
import {routes} from './router/vue-routes';

Vue.use(VueRouter);

const router = new VueRouter({
    routes
  })

var app = new Vue({
    el: '#app',
    router,
})
