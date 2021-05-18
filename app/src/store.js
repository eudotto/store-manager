import Vuex from 'vuex';
import Vue from 'vue';
import http from '@/http';

Vue.use(Vuex);

const state = {
  token: localStorage.getItem('token') || '',
  user: {},
  alert: {
    state: false,
    type: 'error',
    message: 'Aconteceu um erro'
  }
}

const mutations = {
  LOGIN (state, { token }) {
    state.token = token;
  },
  LOGOUT (state) {
    state.token = null;
    localStorage.removeItem('token');
  },
  ALERT_MESSAGE (state, { alert }) {
    state.alert = alert;
  }
}

const actions = {
  login ({ commit }, user) {
    return new Promise ((resolve, reject) => {
      http.post('authorization/token', user)
        .then(response => {
          commit('LOGIN', { token: response.data.access_token })
          localStorage.setItem('token', response.data.access_token);
          resolve(response.data);
        })
        .catch(error => {
          console.log(error);
          reject(error);
        })
    })
  },

  alertMessage ({ commit }, alert) {
    commit('ALERT_MESSAGE', alert);
  }
}

const getters = {
  logged: state => Boolean(state.token)
}

export default new Vuex.Store({
  state,
  mutations,
  actions,
  getters,
});
