<template>
  <v-flex
    justify-center
    class="d-flex"
  >
    <v-form @submit.prevent="login" justify-center>
      <v-text-field v-model="user.email" label="E-mail"></v-text-field>
      <v-text-field v-model="user.password" label="Senha" type="password"></v-text-field>
      <v-card-actions>
        <v-btn type="submit" primary large block>Entrar</v-btn>
      </v-card-actions>
    </v-form>
  </v-flex>
</template>

<script>
export default {
  name: 'Login',

  data () {
    return {
      user: {
        email: '',
        password: ''
      }
    }
  },

  methods: {
    login () {
      this.$store.dispatch('login', this.user)
      .then(() => this.$router.push({ name: 'store.list' }))
      .catch(error => {
        if (error.request.status === 422 || error.request.status === 401) {
          this.$store.dispatch('alertMessage', { alert: {
            state: true,
            type: 'error',
            message: 'Usuário ou senha incorretos'
          }});
        }
      })
    }
  }
}
</script>
