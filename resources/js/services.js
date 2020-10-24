import axios from 'axios'

// create an axios instance with default options
const http = axios.create({
    baseURL: '/api',
    paramsSerializer: params => {
        // TODO: serializer without jquery
        return $.param(params)
    },
})

const api = {}

api.states = {
    index(params) {
        // TODO: cache
        return new Promise((resolve, reject) => {
            http.get('states', {params})
                .then(response => resolve(response.data.data))
                .catch(error => reject(error))
        })
    }
}

api.cities = {
    index(params) {
        // TODO: cache
        return new Promise((resolve, reject) => {
            http.get('cities', {params})
                .then(response => resolve(response.data.data))
                .catch(error => reject(error))
        })
    }
}

api.contractTypes = {
    index(params) {
        // TODO: cache
        return new Promise((resolve, reject) => {
            http.get('contracts/types', {params})
                .then(response => resolve(response.data.data))
                .catch(error => reject(error))
        })
    }
}

api.properties = {
    index(params) {
        return new Promise((resolve, reject) => {
            http.get('properties', {params})
                .then(response => resolve(response.data.data))
                .catch(error => reject(error))
        })
    },
    store(property) {
        return new Promise((resolve, reject) => {
            http.post('properties', property)
                .then(response => resolve(response.data.data))
                .catch(error => reject(error))
        })
    },
    destroy(property) {
        return new Promise((resolve, reject) => {
            http.delete('properties/' + property.id)
                .then(response => resolve(response.data.data))
                .catch(error => reject(error))
        })
    },
}

api.contracts = {
    store(contract) {
        return new Promise((resolve, reject) => {
            http.post('contracts', contract)
                .then(response => resolve(response.data.data))
                .catch(error => reject(error))
        })
    },
}

export default api
