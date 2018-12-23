<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card title="Reset Password">
        <form @submit.prevent="send" @keydown="form.onKeydown($event)">
          <alert-success :form="form" :message="status" />

          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Email</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
              <has-error :form="form" field="email" />
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-group row">
            <div class="col-md-9 ml-md-auto">
              <v-button :loading="form.busy">
                Send Password Reset Link
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
import { SEND_PASSWORD_RESET_EMAIL } from '../../../const/api'

export default {
  middleware: 'guest',

  metaInfo () {
    return { title: 'Reset Password' }
  },

  data: () => ({
    status: '',
    form: new Form({
      email: ''
    })
  }),

  methods: {
    async send () {
      const { data } = await this.form.post(SEND_PASSWORD_RESET_EMAIL)
      this.status = data.status
      this.form.reset()
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
