import axios from 'axios'

// create an axios instance with default options
const http = axios.create({
    baseURL: '/api',
    paramsSerializer: params => {
        // TODO: serializer without jquery
        return $.param(params)
    },
})

export default {
    states: {
        index(params) {
            return http.get('states', {params})
        }
    },
    cities: {
        index(params) {
            return http.get('cities', {params})
        }
    },
    contractTypes: {
        index(params) {
            return http.get('contracts/types', {params})
        }
    },
    properties: {
        index(params) {
            return http.get('properties', {params})
        },
        store(property) {
            return http.post('properties', property)
        },
        destroy(property) {
            return http.delete('properties/' + property.id)
        },
    },
    contracts: {
        store(contract) {
            return http.post('contracts', contract)
        },
    },
}
