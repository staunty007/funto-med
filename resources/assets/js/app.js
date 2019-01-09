
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import moment from 'moment';

import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

window.Fire = new Vue();

import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
})


import VueRouter from 'vue-router'
Vue.use(VueRouter)

import { Form, HasError, AlertError } from 'vform'

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)



let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue') },
    { path: '/doctor/dashboard', component: require('./components/DocDashboard.vue') },
    { path: '/doctors', component: require('./components/Doctors.vue') },
    { path: '/med-products', component: require('./components/MedProducts.vue') },
    { path: '/patients', component: require('./components/Patient.vue') }
  ]

  const router = new VueRouter({
      mode:'history',
    routes 
  })
  
  Vue .filter('regDate',function(created) {
    return moment(created).format('LL');  
})
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    router
});
