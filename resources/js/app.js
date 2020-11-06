require('./bootstrap');
// vue js
window.Vue = require('vue');

// VForm
import { Form, HasError, AlertError } from 'vform'

/* Globally declare */
window.Form = Form
/*For show Error*/
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

/* sweet alert*/

import Swal from 'sweetalert2'

window.Swal = Swal

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.Toast = Toast

/* Toaster */

import  toastr from 'toastr'
/* For globally use*/

window.toastr = toastr

// Moment js

import{moment} from "./Filter/filter"
// VUe router
import VueRouter from 'vue-router'

Vue.use(VueRouter)
// Routes
import{routes} from './routes/routes.js'


const router = new VueRouter({
    routes,
    // mode:'history'
})
/* For Vuex*/
import Vuex from 'vuex'
Vue.use(Vuex)
import storeData from "./store/store";

const store = new Vuex.Store(
    storeData
)
/*For ck Editor*/
import CKEditor from '@ckeditor/ckeditor5-vue';

Vue.use( CKEditor );

/*Vue.component('home', require('./components/backend/home.vue').default);*/
import "./Mixin/mixins"
/* For fire*/
window.Fire = new Vue();

/*For paginate */

Vue.component('pagination', require('laravel-vue-pagination'));

const app = new Vue({
    el: '#content',
    router,
    store,
    data() {
        return {
            search: ''
        }
    },
    methods:{
        searchHit() {
            Fire.$emit('searching', this.search)
        }
    }
});
