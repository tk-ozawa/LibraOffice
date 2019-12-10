require('./bootstrap');

window.Vue = require('vue');

Vue.prototype.$http = window.axios;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
});