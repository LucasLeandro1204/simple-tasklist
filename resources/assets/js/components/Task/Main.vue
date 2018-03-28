<template>
  <task-section class="relative" title="Your Tasks">
    <card :task="task" :key="task.id" v-for="task in tasks" />

    <div class="buttons max-w-sm w-full pin-l">
      <button class="ml-auto mr-6 flex align-center bg-indigo-light rounded-full text-white justify-center w-10 h-10">
        <i class="fa fa-plus"></i>
      </button>
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

      Bus.wait('toggleStatus', (id, wait) => {
        wait(id, () => {
          const task = this.tasks.find(task => task.id == id);

          task.status = ! task.status;

          return this.update(task.id, { status: task.status })
            .catch((err) => {
              task.status = ! task.status;
            });
        });
      });
    },

    methods: {
      update (id, attributes) {

        return Service.update(id, attributes)
          .then(({ data }) => {
            const index = this.tasks.find(task => task.id == id);

            this.$set(this.tasks, index, data);
          });
      },

      fetch () {
        Service.all()
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
      }
    },
  };
</script>

<style scoped>
  .buttons {
    bottom: 15px;
    position: fixed;
  }
</style>
