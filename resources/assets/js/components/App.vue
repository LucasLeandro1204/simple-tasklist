<template>
  <main class="bg-grey-lightest py-8 px-4 min-h-screen">
    <router-view class="max-w-xs mx-auto shadow-md bg-white"></router-view>
  </main>
</template>

<script>
  import router from 'core/router';

  export default {
    router,

    data: {
      tasks: false,
    },
  };
</script>
