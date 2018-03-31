<template>
  <task-section v-if="this.task" :back="{ name: 'task.index' }">
    <p slot="header" class="font-bold" v-text="task.title"></p>

    <template slot="buttons">
      <button class="flex w-10 h-10 ml-2 text-white flex shadow-md rounded-full bg-indigo-dark" @click.prevent="toggle">
        <i class="fa m-auto" :class="task.status ? 'fa-check' : 'fa-circle-o'"></i>
      </button>
    </template>

    <div class="border-b p-4 text-xs">
      <p class="mb-1"><span class="font-bold mr-1 text-grey-darkest">Created at:</span> {{ task.created_at | fromNow }} </p>
      <p><span class="font-bold mr-1 text-grey-darkest">Last update:</span> {{ task.updated_at | fromNow }} </p>
    </div>

    <div class="px-4 py-4 text-sm" v-html="content" v-if="task.description"></div>
  </task-section>
</template>

<script>
  import Marked from 'marked';
  import Moment from 'moment';
  import Service from 'services/task';
  import { wait } from 'core/helpers';
  import TaskSection from '@/Section.vue';

  export default {
    props: {
      id: {
        required: true,
        validate (id) {
          return Number.isInteger(id);
        },
      },
    },

    components: {
      TaskSection,
    },

    filters: {
      fromNow (date) {
        return Moment(date).fromNow();
      },
    },

    computed: {
      content () {
        return Marked(this.task.description, {
          sanitize: true,
        });
      },
    },

    data () {
      return {
        task: false,
      };
    },

    created () {
      Service.find(this.id)
        .then(({ data }) => {
          this.task = data;
        });
    },

    methods: {
      toggle () {
        wait(this.id, () => {
          const status = this.task.status = ! this.task.status;

          return Service.update(this.id, {
            status,
          })
          .then(({ data }) => {
            this.task = data;
          })
          .catch(() => {
            this.task.status = ! status;
          });
        });
      },
    },
  };
</script>
