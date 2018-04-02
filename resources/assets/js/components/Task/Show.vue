<template>
  <task-section v-if="this.task" :back="{ name: 'task.index' }">
    <p slot="header" class="font-bold" v-text="task.title"></p>

    <template slot="header-buttons">
      <button class="flex w-10 h-10 ml-2 text-white flex shadow-md rounded-full bg-indigo-dark" @click.prevent="toggle">
        <i class="fa m-auto" :class="task.status ? 'fa-check' : 'fa-circle-o'"></i>
      </button>
    </template>

    <template slot="section-buttons">
      <section-button
        icon="fa-pencil"
        @click.native.prevent="$router.push({ name: 'task.edit', params: { id: task.id } })" />
      <section-button
        icon="fa-trash"
        @click.native.prevent="deleteTask" />
    </template>

    <div class="border-b px-4 py-4 text-sm text-grey-darkest markdown" v-html="content" v-if="task.description"></div>

    <div class="p-4 text-xs text-grey-dark">
      <p class="mb-1"><span class="font-bold ">Created </span> {{ task.created_at | fromNow }} </p>
      <p><span class="font-bold">Last update </span> {{ task.updated_at | fromNow }} </p>
    </div>
  </task-section>

  <task-not-found v-else-if="task === false" />
</template>

<script>
  import Marked from 'marked';
  import Moment from 'moment';
  import Service from 'services/task';
  import { wait } from 'core/helpers';
  import TaskSection from '@/Section.vue';
  import TaskNotFound from './NotFound.vue';
  import SectionButton from '@/SectionButton.vue';

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
      TaskNotFound,
      SectionButton,
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
        task: undefined,
      };
    },

    created () {
      Service.find(this.id)
        .then(({ data }) => {
          this.task = data;
        })
        .catch(() => {
          this.task = false;
        });
    },

    methods: {
      deleteTask () {
        const answer = window.confirm('Do you really want to delete this task?');

        if (! answer) {
          return;
        }

        Service.delete(this.id)
          .then(() => {
            this.$router.push({
              name: 'task.index',
            });
          });
      },

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

<style lang="scss">
  .markdown {
    blockquote, dl, dd, h1, h2, h3, h4, h5, h6, figure, p, pre {
      margin-bottom: 5px;
    }

    ul {
      padding-left: 2rem;
    }
  }
</style>
