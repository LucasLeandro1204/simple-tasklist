<template>
  <task-section v-if="fetching" :back="{ name: 'task.index' }">
    <vue-content-loading slot="header" style="height: 18px" :width="180" :height="18">
      <rect x="0" y="0" width="180" height="18"></rect>
    </vue-content-loading>

    <vue-content-loading slot="section-buttons" style="height: 46px" :width="80" :height="46">
      <rect x="0" y="16" width="180" height="14"></rect>
    </vue-content-loading>

    <vue-content-loading style="height: 74px" :width="320" :height="74">
      <rect x="16" y="16" width="288" height="12"></rect>
      <rect x="16" y="34" width="240" height="12"></rect>
      <rect x="16" y="52" width="266" height="12"></rect>
    </vue-content-loading>
  </task-section>

  <task-section v-else-if="fetched" :back="{ name: 'task.index' }">
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

  <task-not-found v-else />
</template>

<script>
  import Marked from 'marked';
  import Moment from 'moment';
  import TaskSection from '@/Section.vue';
  import TaskNotFound from './NotFound.vue';
  import SectionButton from '@/SectionButton.vue';
  import VueContentLoading from 'vue-content-loading';
  import { mapGetters, mapState, mapActions } from 'vuex';

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
      VueContentLoading,
    },

    created () {
      setTimeout(this.fetch.bind(null, this.id), 1000);
    },

    filters: {
      fromNow (date) {
        return Moment(date).fromNow();
      },
    },

    computed: {
      ...mapState('task', [
        'task',
      ]),

      ...mapGetters('task', [
        'fetched',
        'fetching',
      ]),

      content () {
        return Marked(this.task.description, {
          sanitize: true,
        });
      },
    },

    methods: {
      ...mapActions('task', [
        'fetch',
      ]),

      ...mapActions('tasks', [
        'updateStatus',
      ]),
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
