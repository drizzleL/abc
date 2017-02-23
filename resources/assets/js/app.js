
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);
Vue.component('example', require('./components/Example.vue'));

const LeadForm = Vue.component('lead-form', require('./components/LeadForm.vue'));
const JobIndex = Vue.component('job-index', require('./components/JobIndex.vue'));

Vue.use(Router);

const Bar = { template: '<div>bar</div>' }

const routes = [
  { path: '/jobs', component: JobIndex },
  { path: '/bar', component: Bar },
  { path: '/leads/create', component: LeadForm },
]

const router = new Router({
  routes // （缩写）相当于 routes: routes
})

const app = new Vue({
  router
}).$mount('#app')

//const app = new Vue({
//    el: '#app'
//});
