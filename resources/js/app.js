import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import Routes from './routes'
import LightTheme from './light-theme'
import VueRouter from 'vue-router'
import VueJsonPretty from 'vue-json-pretty'
import moment from 'moment-timezone'
import VeeValidate from 'vee-validate'
import App from './App'
import './plugins'

window._ = require('lodash')
window.Popper = require('popper.js').default


require('bootstrap')

Vue.use(VueRouter)
Vue.use(LightTheme)
Vue.use(BootstrapVue)
Vue.use(VeeValidate)


moment.tz.setDefault(Amana.timezone)


const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    base: `/${window.Amana.path}/`,
    linkActiveClass: 'nav-item active',
});

Vue.component('vue-json-pretty', VueJsonPretty);
Vue.component('alert', require('./components/Alert.vue').default)

new Vue({
    router,
    render: h => h(App)
}).$mount('#amana');
