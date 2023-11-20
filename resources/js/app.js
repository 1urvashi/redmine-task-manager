import './bootstrap';

import Vue from 'vue';

Vue.component('task-manager', require('./components/TaskManager.vue').default);

const app = new Vue({
    el: '#app',
});