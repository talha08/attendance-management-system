<template>
  <div class="basic">
    <div class="basic-layout d-flex align-items-center justify-content-center m-0 bg-white">
      <router-view />
    </div>
  </div>
</template>

<script>
export default {
  name: 'BasicLayout'
}
</script>

<style>
.basic-layout {
  color: #636b6f;
  height: 100vh;
  font-weight: 100;
  position: relative;
}
</style>
