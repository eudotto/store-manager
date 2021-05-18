<template>
  <v-flex
    justify-center
    class="d-flex"
  >
    <v-form @submit.prevent="sendForm" justify-center>
      <v-text-field v-model="user.name" label="Nome"></v-text-field>
      <v-text-field v-model="user.email" label="E-mail"></v-text-field>
      <v-text-field v-model="user.password" label="Senha"></v-text-field>
      <v-card-actions>
        <v-btn type="submit" primary large block>Cadastrar</v-btn>
      </v-card-actions>
    </v-form>
  </v-flex>
</template>

<script>
export default {
  name: 'Register',

  data: () => {
    return {
      user: {
        name: '',
        email: '',
        password: '',
      }
    }
  },

  methods: {
    sendForm () {
      this.$http.post('register', this.user)
      .then(response => {
        this.$router.push({ name: 'login' });
      })
      .catch(error => {
        console.log(error.response.data);
      });
    }
  }
}
</script>
