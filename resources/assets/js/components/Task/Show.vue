<template>
  <task-section :title="task.title" :back="{ name: 'task.index' }" v-if="task">
    <article class="flex">
      <div v-html="content"></div>
    </article>
  </task-section>

  <task-section title="Finding the task" :back="{ name: 'task.index' }" v-else-if="task === null">
    Relax
  </task-section>

  <task-section title="Where we are???" :back="{ name: 'task.index' }" v-else>
    Task not found
  </task-section>
</template>

<script>
  import Marked from 'marked';
  import TaskSection from '@/Section.vue';
  import TaskService from 'services/task';

  export default {
    components: {
      TaskSection,
    },

    props: {
      id: {
        required: true,
        validate (id) {
          return Number.isInteger(id);
        }
      },
    },

    data () {
      return {
        task: null,
      };
    },

    computed: {
      content () {
        return Marked(this.task.description);
      },
    },

    created () {
      TaskService.find(this.id)
        .then(({ data }) => {
          this.task = data;
        })
        .catch(() => {
          this.task = false;
        });
    },
  };
</script>
