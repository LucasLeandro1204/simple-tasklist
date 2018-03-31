<template>
  <task-section :back="{ name: 'task.index' }">
    <h2 class="text-3xl font-normal mr-2" slot="header">
      Task not found
    </h2>

    <div class="text-center p-4">
      <p class="text-5xl mb-1 text-indigo">
        <i class="fa fa-exclamation-circle"></i>
      </p>
      <h4 class="mb-1">Oooppsss....</h4>
      <p>This task does not exist =(</p>
    </div>
  </task-section>
</template>

<script>
  import TaskSection from '@/Section.vue';

  export default {
    components: {
      TaskSection,
    },
  };
</script>
