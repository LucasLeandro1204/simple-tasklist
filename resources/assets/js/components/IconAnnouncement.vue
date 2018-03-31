<template>
  <div class="text-center p-4">
    <p class="text-5xl mb-1 text-indigo">
      <i class="fa" :class="icon"></i>
    </p>

    <slot></slot>
  </div>
</template>

<script>
  export default {
    props: {
      icon: {
        type: String,
        required: true,
      },
    },
  };
</script>
