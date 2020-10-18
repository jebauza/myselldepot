/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en';
Vue.use(ElementUI, { locale })


import Swal from 'sweetalert2';
window.Swal = Swal;
/* import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);
https://www.digitalocean.com/community/tutorials/vuejs-vue-sweetalert2#installation
*/

Vue.component('pagination', require('laravel-vue-pagination'));

export const EventBus = new Vue();
window.EventBus = EventBus;

/*  //Moment date
window.moment = require('moment'); */

/* Componentes de la app */
Vue.component('Auth', require('./components/Auth').default);
Vue.component('App', require('./components/App').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import router from './routes.js'
const app = new Vue({
    el: '#app',
    router
});
