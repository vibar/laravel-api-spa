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
        async fetchStates ({ commit, getters }, country) {
            let params = {country_id: country ? country.id : getters.defaultCountryId}
            let res = await api.states.index(params)
            commit('SET_STATES', res.data.data)
        },
        async fetchCities ({ commit }, state) {
            let res = await api.cities.index({state_id: state.id})
            commit('SET_CITIES', res.data.data)
        },
        async fetchContractTypes ({ commit }) {
            let res = await api.contractTypes.index()
            commit('SET_CONTRACT_TYPES', res.data.data)
        },
        async fetchProperties ({ commit }, params) {
            let res = await api.properties.index(params)
            commit('SET_PROPERTIES', res.data.data)
        },
        async addProperty ({ commit, dispatch }, property) {
            await api.properties.store(property)
            dispatch('fetchProperties')
        },
        async removeProperty ({ commit, dispatch }, property) {
            await api.properties.destroy(property)
            dispatch('fetchProperties')
        },
        async addContract ({ commit, dispatch }, contract) {
            await api.contracts.store(contract)
            dispatch('fetchProperties')
        }
    }
})

export default store
