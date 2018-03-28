<template>
  <section>
    <h5 class="text-indigo-dark" v-text="title"></h5>

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
    },
  };
</script>
