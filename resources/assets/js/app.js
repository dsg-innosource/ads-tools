import Vue from 'vue';
import axios from 'axios'
import moment from 'moment';

Vue.component('connections-index', require('./components/connections/index.vue'))
Vue.component('connections-show', require('./components/connections/show.vue'))
Vue.component('resource-database', require('./components/connections/database.vue'))

new Vue({
    el: '#ads-tools',
});