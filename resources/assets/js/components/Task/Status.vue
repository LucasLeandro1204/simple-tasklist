<template>
  <i
    :class="['text-indigo cursor-pointer pl-3 pb-3 fa', status ? 'fa-check-square-o' : 'fa-square-o']"
    @click.stop="$bus('toggleStatus', task)">
  </i>
</template>

<script>
  export default {
    props: {
      task: {
        type: Number,
        required: true,
      },

      status: {
        type: Boolean,
        required: true,
      },
    },
  };
</script>
