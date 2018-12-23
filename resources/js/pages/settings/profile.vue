<template>
  <card title="Your Info">
    <el-row :gutter="20">
      <el-col :span="16">
        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
          <alert-success :form="form" message="Info Updated" />
          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Name</label>
            <div class="col-md-7">
              <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="name" />
            </div>
          </div>
          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Email</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email" disabled>
              <has-error :form="form" field="email" />
            </div>
          </div>
          <!-- Submit Button -->
          <div class="form-group row">
            <div class="col-md-9 ml-md-auto">
              <el-button :loading="form.busy" type="primary" plain round>Update</el-button>
            </div>
          </div>

        </form>
      </el-col>
      <el-col :span="8">
        <photo-upload />
      </el-col>
    </el-row>
  </card>
</template>

<script>
import photoUpload from './photo'
import Form from 'vform'
import { mapGetters } from 'vuex'
import { UPDATE_PROFILE } from '../../const/api'
import Types from '../../store/types'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: 'Settings' }
  },
  components: {
    photoUpload
  },

  data: () => ({
    form: new Form({
      name: '',
      email: ''
    })
  }),

  computed: mapGetters({
    user: 'user'
  }),

  created () {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async update () {
      const { data } = await this.form.patch(UPDATE_PROFILE)
      this.$store.dispatch(Types.actions.ACTION_UPDATE_USER, { user: data })
    }
  }
}
</script>
