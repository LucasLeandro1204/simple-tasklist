<template>
  <main class="bg-grey-lighter r px-6 py-6 w-screen min-h-screen font-sans">
    <router-view></router-view>
  </main>
</template>

<script>
  import router from 'core/router';

  export default {
    router,
  };
</script>

<style lang="scss" scoped>

</style>
