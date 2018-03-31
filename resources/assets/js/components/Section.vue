<template>
  <section class="rounded-sm text-black">
    <header class="flex px-8 py-6 bg-indigo-lighter text-white rounded-tl rounded-tr relative">
      <slot name="header"></slot>

      <button class="absolute pin-r -mt-4 text-white p-4" @click.prevent="$router.push(back)" v-if="back">
        <i class="fa fa-angle-left"></i>
      </button>

      <div class="flex buttons absolute pin-r pin-b -mb-5 mr-8">
        <slot name="buttons"></slot>
      </div>
    </header>

    <slot></slot>
  </section>
</template>

<script>
  export default {
    props: {
      back: {
        type: Object,
      },
    },
  };
</script>

<style lang="scss" scoped>
  .buttons {
    button {
      font-size: 14px;
    }
  }
</style>
