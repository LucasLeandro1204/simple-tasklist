<template>
  <task-section title="Your Tasks">
    <div>
      <card :task="task" :key="task.id" v-for="task in tasks" />
    </div>
  </task-section>
</template>

<script>
  import Bus from 'core/bus';
  import Card from '@/Task/Card.vue';
  import Service from 'services/task';
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
      this.fetch();

      Bus.wait('toggleStatus', (id) => {
        const task = this.tasks.find(task => task.id == id);

        task.status = ! task.status;

        return this.update(task.id, { status: task.status })
          .catch((err) => {
            task.status = ! task.status;
          });
      });
    },

    methods: {
      update (id, attributes) {

        return Service.update(id, attributes)
          .then(({ data }) => {
            const index = this.tasks.findIndex(task => task.id == id);

            this.$set(this.tasks, index, data);
          });
      },

      fetch () {
        Service.all()
          .then(({ data }) => {
            console.log(data);
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
      }
    },
  };
</script>
