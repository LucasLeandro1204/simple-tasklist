<template>
  <task-section title="Your Tasks">
    <div>
      <card :task="task" :key="task.id" v-for="task in tasks" />
    </div>
  </task-section>
</template>

<script>
  import Axios from 'axios';
  import Card from '@/Task/Card.vue';
  import TaskSection from '@/Section.vue';

  export default {
    components: {
      Card,
      TaskSection,
    },

    data () {
      return {
        tasks: false,
      };
    },

    created () {
      Axios.get('/api/task')
        .then(({ data }) => {
          if (! data.length) {
            throw new Error('Empty');
          }

          this.tasks = data;
        })
        .catch(({ message }) => {
          if (message === 'Empty') {
            this.tasks = [];
          }
        });
    },
  };
</script>
