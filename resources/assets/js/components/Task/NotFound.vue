<template>
  <task-section :back="{ name: 'task.index' }">
    <h2 class="text-3xl font-normal mr-2" slot="header">
      Task not found
    </h2>

    <icon-announcement icon="fa-exclamation-circle">
      <h4 class="mb-1">Oooppsss....</h4>
      <p>This task does not exist =(</p>
    </icon-announcement>
  </task-section>
</template>

<script>
  import TaskSection from '@/Section.vue';
  import IconAnnouncement from '@/IconAnnouncement.vue';

  export default {
    components: {
      TaskSection,
      IconAnnouncement,
    },
  };
</script>
