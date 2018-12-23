<template>
  <div class="text-center">
    <div class="title mb-4">
      {{ title }}
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
// https://colorlib.com/etc/ca/index.html
export default {
  layout: 'basic',
  metaInfo () {
    return { title: 'Home' }
  },
  data: () => ({
    title: window.config.appName
  }),
  computed: mapGetters({
    authenticated: 'check'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}

.text-center{
  position: fixed;
  top: 50%;
  left: 50%;
  /* bring your own prefixes */
  transform: translate(-50%, -50%);
}
</style>
