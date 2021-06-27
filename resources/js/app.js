require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router'
import Vuex from 'vuex'
import axios from 'axios'
import VueAxios from 'vue-axios'
import BootstrapVue from "bootstrap-vue";
import FlashMessage from '@smartweb/vue-flash-message';
import VueConfirmDialog from 'vue-confirm-dialog'

import { library } from '@fortawesome/fontawesome-svg-core'
import {
    faKey,
    faMoon, 
    faSun } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
//Routes
import { routes } from './routes';

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import "../css/app.css";
import VueRecaptcha from 'vue-recaptcha';
 
Vue.use(VueRouter)
Vue.use(Vuex)
Vue.use(VueAxios, axios)
Vue.use(BootstrapVue)
Vue.use(FlashMessage);
Vue.use(VueConfirmDialog)
library.add(
    faKey,
    faMoon,
    faSun
)

Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.component('vue-confirm-dialog', VueConfirmDialog.default)
Vue.component('vue-recaptcha', VueRecaptcha)
Vue.config.productionTip = false;

//Register Routes
const router = new VueRouter({
    base: '/',
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    const authUser = JSON.parse(window.localStorage.getItem('authUser'));
    const is_staff = JSON.parse(window.localStorage.getItem('is_staff'));

    if (to.meta.requiresAuth) {
        if (authUser && authUser.access_token) {
            next();
        } else {
            next({
                name: 'Login'
            });
        }
    }
    if (to.meta.requiresStaff) {
        if (authUser && authUser.access_token && is_staff) {
            next();
        } else {
            next({
                name: 'Profile'
            });
        }
    }
    next();
});

console.log("%cDon't Paste Anything Here!", "color: red; padding: 10px; font-size: 60px; text-transform: uppercase; font-weight: bold");
console.log("%cAttackers Can Gain Access To Your Account Using Codes They Sent You To Paste Here", "color: #d4d4d4; padding: 10px; font-size: 20px; text-transform: uppercase");

const app = new Vue({
    router
}).$mount('#app')