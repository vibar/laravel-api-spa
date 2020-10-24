/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')

import store from './store'
import i18n from './locale'
import VueTheMask from 'vue-the-mask'

Vue.use(VueTheMask)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('property-list', require('./components/PropertyList').default)
Vue.component('property-form', require('./components/PropertyForm').default)
Vue.component('contract-form', require('./components/ContractForm').default)
Vue.component('modal', require('./components/general/Modal').default)
Vue.component('Form', require('./components/mixins/Form').default)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    i18n,
    el: '#app',
    store,
    computed: {
        addContractEnabled() {
            return this.$store.getters.addContractEnabled
        },
    },
    methods: {
        addProperty() {
            this.$refs.propertyForm.$emit('open')
        },
        addContract() {
            this.$refs.contractForm.$emit('open')
        },
    },
})
