<template>
  <v-app
    v-cloak
  >
    <v-app-bar
      app
      fixed
      dense
      color="rgba(255, 255, 255, 0.95)"
      height="64"
      class="layout-default app-bar"
    >
      <v-app-bar-nav-icon
        class="d-md-none"
        @click.stop="drawer.state = ! drawer.state"
      ></v-app-bar-nav-icon>
      <a href="/"
         class="d-none d-md-block"
      >
        <img
          src="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png"
          class="main-logo"
        />
      </a>
      <v-spacer></v-spacer>
      <div
        v-if="logged"
        class="d-none d-md-flex links-buttons"
      >
        <v-btn
          v-for="item in drawer.links"
          v-bind:key="item.text"
          :href="item.url"
          text
          color="#005AAB"
          class="font-weight-bold links"
        >
          {{ item.text }}
        </v-btn>

        <v-btn
          text
          color="#005AAB"
          class="font-weight-bold links"
          @click="logout"
        >
          Sair
        </v-btn>
      </div>
      <div
        class="account-buttons"
        v-else
      >
        <v-btn
          link
          outlined
          small
          href="/"
          color="#005AAB"
          class="ml-2"
        >
          ENTRAR
        </v-btn>
        <v-btn
          link
          outlined
          small
          href="/cadastro"
          color="#005AAB"
          class="ml-2"
        >
          CADASTRAR-SE
        </v-btn>
      </div>
    </v-app-bar>
    <v-navigation-drawer
      app
      v-model="drawer.state"
      temporary
      class="layout-default"
    >
      <v-list>
        <div
          class="d-flex align-center justify-center drawer-logo-wrapper"
        >
          <a href="/">
            <img
              class="main-logo"
              src="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png"
            />
          </a>
        </div>
        <v-divider></v-divider>
        <div v-if="logged">
        <v-list-item
          v-for="item in drawer.links"
          v-bind:key="item.text"
          :href="item.url"
          link
        >
          <v-list-item-content
            class="font-weight-bold common colors company-primary text"
          >
            {{ item.text }}
          </v-list-item-content>
        </v-list-item>
        <v-list-item @click="logout">
          <v-list-item-content
            class="font-weight-bold common colors company-primary text"
          >
            SAIR
          </v-list-item-content>
        </v-list-item>
        </div>
        <div v-else>
          <v-list-item
            href="/"
            link
          >
            <v-list-item-content
              class="font-weight-bold common colors company-primary text"
            >
              Entrar
            </v-list-item-content>
          </v-list-item>
          <v-list-item
            href="/cadastro"
            link
          >
            <v-list-item-content
              class="font-weight-bold common colors company-primary text"
            >
              Cadastrar-se
            </v-list-item-content>
          </v-list-item>
        </div>
      </v-list>
    </v-navigation-drawer>
    <br>
    <v-alert v-if="this.$store.state.alert.state"
             dense
             :type="this.$store.state.alert.type"
             outlined
    >
      {{ this.$store.state.alert.message }}
    </v-alert>
    <v-main>
      <router-view></router-view>
    </v-main>
    <v-footer
      class="justify-center"
      color="#292929"
      height="100"
    >
      <div class="title font-weight-light grey--text text--lighten-1 text-center">
        Daniel Dotto Wiersinski |
        eudotto@gmail.com
      </div>
    </v-footer>
  </v-app>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  name: 'App',

  data () {
    return {
      drawer: {
        state: false,
        links: [
          {
            text: 'USUÁRIOS',
            url: '/users'
          },
          {
            text: 'LOJAS',
            url: '/stores'
          },
        ]
      },
      group: null,
    }
  },

  methods: {
    logout () {
      this.$store.commit('LOGOUT');
      this.$router.push({ name: 'login' });
    },
    scrollToptop() {
      this.$vuetify.goTo(0);
    }
  },

  computed: {
    ...mapGetters(['logged'])
  }
}
</script>

<style>
#app {
  margin-top: 60px;
}

.main-logo {
  width: 50px;
}
</style>
