require('./bootstrap');

window.Vue = require('vue');

Vue.prototype.$http = window.axios;

Vue.component('paginate', require('vuejs-paginate'));
Vue.component('purchases-list-component', require('./components/PurchasesListComponent.vue').default);
Vue.component('book-component', require('./components/BookComponent.vue').default);
Vue.component('rentals-list-component', require('./components/RentalsListComponent.vue').default);
Vue.component('rental-component', require('./components/RentalComponent.vue').default);
Vue.component('profile-edit-component', require('./components/ProfileEditComponent.vue').default);
Vue.component('timeline-component', require('./components/TimelineComponent.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
	el: '#app',
});
