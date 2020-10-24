import Vue from 'vue'
import Vuex from 'vuex'
import api from './services'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        countryId: 1, // BR
        locale: 'pt-br',
        states: [],
        cities: [],
        contractTypes: [],
        properties: [],
    },
    getters: {
        defaultCountryId: state => {
            return state.countryId
        },
        currentLocale: state => {
            return state.locale
        },
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
        propertiesWithoutContract: (state, getters) => {
            return getters.allProperties.filter(property => !property.contract)
        },
        addContractEnabled: (state, getters) => {
            return getters.propertiesWithoutContract.length > 0
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
        fetchStates ({ commit, getters }, country) {
            let params = {country_id: country ? country.id : getters.defaultCountryId}
            return new Promise((resolve, reject) => {
                api.states.index(params).then(data => {
                    commit('SET_STATES', data)
                    resolve(data)
                }).catch(error => reject(error))
            })
        },
        fetchCities ({ commit }, state) {
            let params = {state_id: state.id}
            return new Promise((resolve, reject) => {
                api.cities.index(params).then(data => {
                    commit('SET_CITIES', data)
                    resolve(data)
                }).catch(error => reject(error))
            })
        },
        fetchContractTypes ({ commit }) {
            return new Promise((resolve, reject) => {
                api.contractTypes.index().then(data => {
                    commit('SET_CONTRACT_TYPES', data)
                    resolve(data)
                }).catch(error => reject(error))
            })
        },
        fetchProperties ({ commit }, params) {
            return new Promise((resolve, reject) => {
                api.properties.index(params).then(data => {
                    commit('SET_PROPERTIES', data)
                    resolve(data)
                }).catch(error => reject(error))
            })
        },
        addProperty ({ commit, dispatch }, property) {
            return new Promise((resolve, reject) => {
                api.properties.store(property)
                    .then(data => resolve(dispatch('fetchProperties')))
                    .catch(error => reject(error))
            })
        },
        removeProperty ({ commit, dispatch }, property) {
            return new Promise((resolve, reject) => {
                api.properties.destroy(property)
                    .then(data => resolve(dispatch('fetchProperties')))
                    .catch(error => reject(error))
            })
        },
        addContract ({ commit, dispatch }, contract) {
            return new Promise((resolve, reject) => {
                api.contracts.store(contract)
                    .then(data => resolve(dispatch('fetchProperties')))
                    .catch(error => reject(error))
            })
        }
    }
})

export default store
