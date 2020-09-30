/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.component('Auth', require('./components/Auth').default);
Vue.component('App', require('./components/App').default);

Vue.component('pagination', require('laravel-vue-pagination'));

/* import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);
https://www.digitalocean.com/community/tutorials/vuejs-vue-sweetalert2#installation
*/
import Swal from 'sweetalert2';
window.Swal = Swal;

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

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
