<template>
  <section>
    <h4 class="text-indigo-dark mb-4 flex">
      <span class="mr-4" v-text="title"></span> <i class="back ml-auto mb-auto cursor-pointer bg-indigo-dark px-2 py-1 rounded text-white fa fa-arrow-left" @click="$router.push(back)" v-if="back"></i>
    </h4>

    <slot></slot>
  </section>
</template>

<script>
  export default {
    props: {
      title: {
        type: String,
        required: true,
      },

      back: {
        type: Object,
      },
    },
  };
</script>

<style scoped>
  .back {
    font-size: 11px;
  }
</style>
