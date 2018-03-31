<template>
  <task-section :back="{ name: id ? 'task.show' : 'task.index', params: { id, } }" v-if="id ? task == true : true">
    <h1 class="text-3xl font-normal mr-2" slot="header" v-text="header"></h1>

    <form class="p-4" @submit.prevent="save">
      <input class="p-2 w-full mb-3 rounded bg-indigo-lightest" type="text" placeholder="Task Title" v-model="title" required>

      <textarea class="p-2 w-full mb-3 rounded bg-indigo-lightest" rows="10" placeholder="Your task description (you can use markdown =D)" v-model="description"></textarea>

      <button
        class="bg-indigo text-white rounded px-3 py-2 shadow-md hover:shadow-lg"
        :class="{ 'bg-indigo-light cursor-not-allowed': status }"
        type="submit"
        v-text="button">
      </button>

      <i class="ml-2 text-indigo-light fa fa-spinner fa-spin" v-if="status"></i>
    </form>
  </task-section>

  <task-not-found v-else-if="task === false" />
</template>

<script>
  import Service from 'services/task';
  import TaskSection from '@/Section.vue';
  import TaskNotFound from './NotFound.vue';

  export default {
    components: {
      TaskSection,
      TaskNotFound,
    },

    data () {
      return {
        title: '',
        status: false,
        task: undefined,
        description: '',
      };
    },

    props: {
      id: {
        validate (id) {
          return Number.isInteger(id);
        },
      },
    },

    created () {
      if (! this.id) {
        return;
      }

      Service.find(this.id)
        .then(({ data }) => {
          this.task = true;
          this.title = data.title;
          this.description = data.description;
        })
        .catch(() => {
          this.task = false;
        });
    },

    computed: {
      header () {
        return this.id ? 'Edit task' : 'Create task';
      },

      button () {
        return this.id ? 'Update task' : 'Save task';
      },
    },

    methods: {
      save () {
        this.status = true;

        this.operation()
          .then(({ data }) => {
            this.$router.push({
              name: 'task.show',
              params: {
                id: data.id,
              },
            });
          });
      },

      operation () {
        const data = {
          title: this.title,
          description: this.description,
        };

        if (this.id) {
          return Service.update(this.id, data);
        }

        return Service.store(data);
      },
    },
  };
</script>
