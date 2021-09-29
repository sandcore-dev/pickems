import 'bootstrap-sass';

import Vue from 'vue';

Vue.component('user-league-results', require('./components/UserLeagueResults.vue').default);

const app = new Vue({
    el: '#app'
});

