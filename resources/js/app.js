/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import router from './routes/routes.js';

import Auth from './auth';
window.auth = new Auth();

import App from './components/App';

const app = new Vue({
    el: '#app',
    components: { App },
    router
});
