<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white container-fluid">
    <div class="container">
      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
        <fa icon="home" /> {{ appName }}
      </router-link>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
        <span class="navbar-toggler-icon" />
      </button>
      <ul class="navbar-nav ml-auto">
        <!-- Authenticated -->
        <li v-if="user" class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-dark"
             href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
          >
            <img :src="user.userInfo.photo" class="rounded-circle profile-photo mr-1">
            {{ user.name }}
          </a>
          <div class="dropdown-menu">
            <router-link :to="{ name: 'home' }" class="dropdown-item pl-3">
              <fa icon="home" fixed-width />
              Dashboard
            </router-link>

            <div class="dropdown-divider" />
            <router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
              <fa icon="cog" fixed-width />
              Profile Update
            </router-link>

            <router-link :to="{ name: 'settings.password' }" class="dropdown-item pl-3">
              <fa icon="cog" fixed-width />
              Password Update
            </router-link>
            <div class="dropdown-divider" />
            <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
              <fa icon="sign-out-alt" fixed-width />
              Logout
            </a>
          </div>
        </li>
        <!-- Guest -->
        <template v-else>
          <li class="nav-item">
            <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
              Login
            </router-link>
          </li>
          <!-- <li class="nav-item">
            <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
              Register
            </router-link>
          </li> -->
        </template>
      </ul>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import Types from '../store/types'
export default {
  data: () => ({
    appName: window.config.appName
  }),
  computed: mapGetters({
    user: 'user'
  }),
  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch(Types.actions.ACTION_LOGOUT)
      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
</style>
