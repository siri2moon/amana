import axios from 'axios'
import Vue from "vue";

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
}

const client = axios.create({
  baseURL: `${window.origin}/${window.Amana.path}/api/`,
})

Vue.prototype.$http = client

export default client
