<template>
  <div id="app">
    <router-view name="navbar" />
    <router-view />
    <router-view name="footer" />
  </div>
</template>

<script>
export default {
  el: '#app',
  metaInfo () {
    const { appName } = window.config
    return {
      title: appName,
      titleTemplate: `%s · ${appName}`
    }
  }
}
</script>
