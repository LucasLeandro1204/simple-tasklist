<template>
  <section class="rounded-sm text-black">
    <header class="flex px-8 py-6 bg-indigo-lighter text-white rounded-tl rounded-tr relative">
      <slot name="header"></slot>

      <button class="absolute pin-r -mt-4 text-white p-4" @click.prevent="$router.push(back)" v-if="back">
        <i class="fa fa-angle-left"></i>
      </button>

      <div class="flex buttons absolute pin-r pin-b -mb-5 mr-8" v-if="$slots['header-buttons']">
        <slot name="header-buttons"></slot>
      </div>
    </header>

    <div class="border-b px-4 flex" v-if="$slots['section-buttons']">
      <slot name="section-buttons"></slot>
    </div>

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
