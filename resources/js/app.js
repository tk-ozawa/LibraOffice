require('./bootstrap');

window.Vue = require('vue');

Vue.prototype.$http = window.axios;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('profile-edit-component', require('./components/ProfileEditComponent.vue').default);
Vue.component('timeline-component', require('./components/TimelineComponent.vue').default);

const app = new Vue({
	el: '#app',
});
