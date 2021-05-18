import Vue from "vue";
import VueRouter from "vue-router";

import Login from "./pages/Login";
import Register from "./pages/User/Register";
import UserList from "./pages/User/List";
import StoreList from "./pages/Store/List";

import store from "@/store";

Vue.use(VueRouter);

const routes = [
  { name: 'login', path: '', component: Login, meta: { public: true }},
  { name: 'user.register', path: '/cadastro', component: Register, meta: { public: true }},
  { name: 'user.list', path: '/users', component: UserList},
  { name: 'store.list', path: '/stores', component: StoreList},
];

const router = new VueRouter({
  mode: 'history',
  routes
});

router.beforeEach((routeTo, routeFrom, next) => {
  if (!routeTo.meta.public && !store.state.token) {
    return next({path: '/'});
  }
  next();
});

export default router;

