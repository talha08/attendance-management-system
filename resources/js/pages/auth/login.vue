<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card title="Login">
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Email</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
              <has-error :form="form" field="email" />
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Password</label>
            <div class="col-md-7">
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
              <has-error :form="form" field="password" />
            </div>
          </div>

          <!-- Remember Me -->
          <div class="form-group row">
            <div class="col-md-3" />
            <div class="col-md-7 d-flex">
              <checkbox v-model="remember" name="remember">
                Remember Me
              </checkbox>

              <router-link :to="{ name: 'password.request' }" class="small ml-auto my-auto">
                Forgot Password
              </router-link>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="form.busy">
                Log In
              </v-button>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import { LOGIN } from '../../const/api'
import Types from '../../store/types'

export default {
  middleware: 'guest',
  metaInfo () {
    return { title: 'Login' }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
    async login () {
      // Submit the form.
      const { data } = await this.form.post(LOGIN)
      // Save the token.
      this.$store.dispatch(Types.actions.ACTION_SAVE_TOKEN, {
        token: data.token,
        remember: this.remember
      })
      // Fetch the user.
      await this.$store.dispatch(Types.actions.ACTION_FETCH_USER)
      // Redirect home.
      this.$router.push({ name: 'home' })
    }
  }
}
</script>

<style scoped>
.col-lg-8.m-auto {
  position: fixed;
  top: 50%;
  left: 50%;
  /* bring your own prefixes */
  transform: translate(-50%, -50%);
}
</style>
