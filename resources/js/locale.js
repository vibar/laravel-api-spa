import Vue from 'vue'
import VueI18n from 'vue-i18n'
import store from './store'

Vue.use(VueI18n)

let locale = store.getters.currentLocale

// Ready translated locale messages
const messages = {
    [locale]: require('./messages/' + locale).default
}

// Create VueI18n instance with options
const i18n = new VueI18n({
    locale: locale,
    messages,
})

export default i18n
