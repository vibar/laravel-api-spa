/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')

import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)

import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        locale: 'pt-br',
        states: [],
        cities: [],
        contractTypes: [],
        properties: [],
    },
    getters: {
        allStates: state => {
            return state.states
        },
        allCities: state => {
            return state.cities
        },
        allContractTypes: state => {
            return state.contractTypes
        },
        allProperties: state => {
            return state.properties
        },
        propertiesWithoutContract: state => {
            return state.properties.filter(property => !property.contract)
        },
    },
    mutations: {
        SET_STATES (state, states) {
            state.states = states
        },
        SET_CITIES (state, cities) {
            state.cities = cities
        },
        SET_CONTRACT_TYPES (state, contractTypes) {
            state.contractTypes = contractTypes
        },
        SET_PROPERTIES (state, properties) {
            state.properties = properties
        },
    },
    actions: {
        fetchStates ({ commit }, country) {
            // TODO: cache
            let defaultCountryId = 1
            let params = {country_id: country ? country.id : defaultCountryId}
            return new Promise((resolve, reject) => {
                axios.get('/api/states?' + $.param(params))
                    .then(response => {
                        let data = response.data.data
                        commit('SET_STATES', data)
                        resolve(data)
                    })
                    .catch(error => reject(error))
            })
        },
        fetchCities ({ commit }, state) {
            // TODO: cache
            let params = {state_id: state.id}
            return new Promise((resolve, reject) => {
                axios.get('/api/cities?' + $.param(params))
                    .then(response => {
                        let data = response.data.data
                        commit('SET_CITIES', data)
                        resolve(data)
                    })
                    .catch(error => reject(error))
            })
        },
        fetchContractTypes ({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/contracts/types')
                    .then(response => {
                        let data = response.data.data
                        commit('SET_CONTRACT_TYPES', data)
                        resolve(data)
                    })
                    .catch(error => reject(error))
            })
        },
        fetchProperties ({ commit }, params) {
            return new Promise((resolve, reject) => {
                axios.get('/api/properties?' + $.param(params))
                    .then(response => {
                        let data = response.data.data
                        commit('SET_PROPERTIES', data)
                        resolve(data)
                    })
                    .catch(error => reject(error))
            })
        },
        addProperty ({ commit, dispatch }, property) {
            return new Promise((resolve, reject) => {
                axios.post('/api/properties', property)
                    .then(response => {
                        resolve(dispatch('fetchProperties'))
                    })
                    .catch(error => reject(error))
            })
        },
        removeProperty ({ commit, dispatch }, property) {
            return new Promise((resolve, reject) => {
                axios.delete('/api/properties/' + property.id)
                    .then(response => {
                        resolve(dispatch('fetchProperties'))
                    })
                    .catch(error => reject(error))
            })
        },
        addContract ({ commit, dispatch }, contract) {
            return new Promise((resolve, reject) => {
                axios.post('/api/contracts', contract)
                    .then(response => {
                        resolve(dispatch('fetchProperties'))
                    })
                    .catch(error => reject(error))
            })
        }
    }
})

import VueI18n from 'vue-i18n'

Vue.use(VueI18n)

let locale = 'pt-br'

// Ready translated locale messages
const messages = {
    [locale]: require('./messages/' + locale).default
}

// Create VueI18n instance with options
const i18n = new VueI18n({
    locale: locale,
    messages,
})

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
Vue.component('modal', require('./components/Modal').default)
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
            return this.$store.getters.propertiesWithoutContract.length > 0
        },
    },
})
