<template>
  <v-flex
    justify-center md-6
    class="d-flex flex-row"
  >
    <v-card>
      <h3>Usuários</h3>
      <v-card-title style="background-color: #42505F">
        <v-row>
          <v-col class="d-flex pt-0 pb-0">
            <v-text-field
              v-model="search"
              label="Busca por nome"
              hide-details
              outlined
              dense
              dark
              append-outer-icon="mdi-magnify"
              @click:append-outer="searchSubmit()"
              @keydown.enter="searchSubmit()"
            ></v-text-field>
            <v-btn
              icon
              color="white"
              :loading="loading"
            >
              <v-icon @click="searchClear()">mdi-filter-remove</v-icon>
            </v-btn>
          </v-col>
        </v-row>
      </v-card-title>
      <v-divider></v-divider>
      <v-data-table
        :headers="headers"
        :items="users"
        :options.sync="options"
        :server-items-length="totalUsers"
        :loading="loading"
        class="elevation-1"
      ></v-data-table>
    </v-card>
  </v-flex>
</template>

<script>
export default {
  name: 'List',

  data() {
    return {
      search: '',
      users: [],
      totalUsers: 0,
      loading: true,
      options: {
        itemsPerPage: 5
      },
      headers: [
        {
          text: 'Nome',
          align: 'start',
          sortable: false,
          value: 'name',
        },
        {text: 'email', value: 'email'},
      ],
    }
  },

  watch: {
    options: {
      handler () {
        this.getDataFromApi()
      },
      deep: true,
    },
  },

  methods: {
    getDataFromApi() {
      this.loading = true
      this.$http.get('api/v1/user', {
        params: {
          q: this.search,
          page: this.options.page,
          per_page: this.options.itemsPerPage,
          sort_by: this.options.sortBy[0],
          sort_desc: this.options.sortDesc[0]
        }
      })
        .then(response => {
          this.users = response.data.data;
          this.totalUsers = response.data.total;
          console.log('options: ', this.options);
          console.log('data: ', response.data);
        })
        .catch(error => {
          console.log(error.response.data);
        })
        .finally(() => {
          this.loading = false;
        });
    },

    searchSubmit () {
      if (! this.loading) {
        this.getDataFromApi();
      }
    },

    searchClear () {
      this.search = '';
      this.options.page = 1;
      this.options.itemsPerPage = 5;
      this.getDataFromApi();
    },
  },

  mounted() {
    this.getDataFromApi();
  }
}
</script>
