/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import Vue from 'vue';
import routes from './routes';
import vuetify from './plugin/vuetify'
require('./bootstrap');

const app = new Vue({
    router: routes,
    vuetify,
}).$mount('#app');
