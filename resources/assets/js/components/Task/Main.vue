<template>
  <task-section>
    <template slot="header">
      <h1 class="text-5xl font-normal mr-2" v-text="filtered.length"></h1>
      <div class="self-center">
        <p class="font-bold">Tasks</p>
        <p class="text-sm">/ {{ count }}</p>
      </div>
    </template>

    <template slot="header-buttons">
      <button @click.prevent="$router.push({ name: 'task.create' })" class="flex w-10 h-10 ml-2 text-white flex shadow-md rounded-full bg-indigo-dark">
        <i class="fa fa-plus m-auto"></i>
      </button>
    </template>

    <template slot="section-buttons">
      <section-button
        :icon="icon"
        :class="{ 'border-indigo': filter.name == name }"
        :key="name"
        @click.native.prevent="SET_FILTER(name)"
        v-for="({ icon, name }) in filters" />
    </template>

    <div v-if="fetching">
      <div :key="i" class="p-4 border-b" v-for="i in 10">
        <vue-content-loading :width="300" :height="14">
          <circle cx="7" cy="7" r="7"></circle>
          <rect x="21" y="1" width="150" height="11"></rect>
          <circle cx="293" cy="7" r="7"></circle>
        </vue-content-loading>
      </div>
    </div>

    <div v-else-if="fetched">
      <task :task="task" :key="task.id" v-for="task in filtered" @toggle="toggleStatus(task)" />

      <icon-announcement :icon="filter.empty.icon" v-if="! filtered.length">
        <h4 class="mb-1" v-text="filter.empty.title"></h4>
        <p v-text="filter.empty.subtitle"></p>
      </icon-announcement>
    </div>

    <icon-announcement icon="fa-warning" v-else>
      <h4 class="mb-1">Some error occurred when fetching your tasks</h4>
      <p>Please reload the page =/</p>
    </icon-announcement>
  </task-section>
</template>

<script>
  import Task from './Card.vue';
  import TaskSection from '@/Section.vue';
  import SectionButton from '@/SectionButton.vue';
  import VueContentLoading from 'vue-content-loading';
  import IconAnnouncement from '@/IconAnnouncement.vue';
  import { mapGetters, mapActions, mapMutations, mapState } from 'vuex';

  export default {
    components: {
      Task,
      TaskSection,
      SectionButton,
      IconAnnouncement,
      VueContentLoading,
    },

    created () {
      this.fetch();
    },

    computed: {
      ...mapState('tasks', [
        'filters',
        'filtered',
      ]),

      ...mapGetters('tasks', [
        'count',
        'filter',
        'fetched',
        'fetching',
        'filtered',
      ]),
    },

    methods: {
      ...mapMutations('tasks', [
        'SET_FILTER',
      ]),

      ...mapActions('tasks', [
        'fetch',
      ]),
    },
  };
</script>
