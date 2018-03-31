<template>
  <div class="flex border-b pl-4 text-grey-darkest text-sm" :class="{ 'text-grey': task.status }" @click.prevent="$emit('toggle')">
    <i class="fa mr-2 text-indigo my-auto" :class="task.status ? 'fa-check-circle-o text-indigo-lighter' : 'fa-circle-o'"></i>
    <p class="py-4" :class="{ 'line-through': task.status }" v-text="task.title"></p>

    <button class="ml-auto px-4" @click.prevent.stop="$router.push({ name: 'task.show', params: { id: task.id }})">
      <i class="fa fa-angle-right my-auto"></i>
    </button>
  </div>
</template>

<script>
  export default {
    props: {
      task: {
        type: Object,
        required: true,
      },
    },
  };
</script>
