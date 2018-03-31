<template>
  <button
    class="py-4 px-3 -mb-px text-grey-darkest font-bold text-xs border-b no-outline focus:border-indigo hover:border-indigo">
    <slot>
      <i class="fa" :class="icon"></i>
    </slot>
  </button>
</template>

<script>
  export default {
    props: {
      icon: {
        type: String,
      },
    },
  };
</script>
