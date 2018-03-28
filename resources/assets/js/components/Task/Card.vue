<template>
  <div class="p-4 mb-4 shadow bg-white flex rounded">
    <div class="cursor-pointer" @click="$router.push({ name: 'task.show', params: { id: task.id } })">
      <h4 v-text="task.title"></h4>
      <p class="text-xs text-grey-darker mt-2" v-text="task.created_at"></p>
    </div>
    <div class="ml-auto">
      <status :task="task.id" :status="task.status" />
    </div>
  </div>
</template>

<script>
  import Status from '@/Task/Status.vue';

  export default {
    props: {
      task: {
        type: Object,
        required: true,
      },
    },

    components: {
      Status,
    },
  };
</script>
