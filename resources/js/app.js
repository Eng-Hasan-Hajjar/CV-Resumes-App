/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import VueToastr2 from 'vue-toastr-2';
import VueHtml2pdf from 'vue-html2pdf';

import 'vue-toastr-2/dist/vue-toastr-2.min.css';
import 'sweetalert2/dist/sweetalert2.min.css';

window.toastr = require('toastr');

Vue.use(VueToastr2);
Vue.use(VueSweetalert2);
Vue.use(VueHtml2pdf);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('profiles-component', require('./components/admin/ProfilesComponent.vue').default);
Vue.component('profile-detail-component', require('./components/admin/ProfileDetailComponent.vue').default);
Vue.component('daftar-cv', require('./components/CVList.vue').default);


//add new CV templates here
Vue.component('cv-template-first',require('./components/cvtemplates/first/MainComponent.vue').default);
Vue.component('cv-template-second',require('./components/cvtemplates/second/MainComponent.vue').default);

// Detail CV
Vue.component('cv-detail',require('./components/admin/CVDetail.vue').default);

/**
 * Create new CV
 */
Vue.component('cv-register-profile-select', require('./components/cvregister/profile-select.vue').default);
Vue.component('cv-register-fill-identity', require('./components/cvregister/fill-identity.vue').default);
Vue.component('cv-register-fill-experience', require('./components/cvregister/fill-experience.vue').default);
Vue.component('cv-register-fill-education', require('./components/cvregister/fill-education.vue').default);
Vue.component('cv-register-fill-skill', require('./components/cvregister/fill-skill.vue').default);
Vue.component('cv-register-fill-custom', require('./components/cvregister/fill-custom.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
