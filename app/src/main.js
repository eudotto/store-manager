import Vue from 'vue';
import App from './App.vue';

Vue.config.productionTip = false

import vuetify from './vuetify';
import router from './routes';
import store from './store';

import http from "@/http";
Vue.prototype.$http = http;

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App),
}).$mount('#app');
