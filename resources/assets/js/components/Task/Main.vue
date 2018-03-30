<template>
  <section class="rounded-sm text-black">
    <header class="flex px-8 py-6 bg-indigo-lighter text-white rounded-tl rounded-tr relative">
      <h1 class="text-5xl font-normal mr-2">10</h1>
      <div class="self-center">
        <p class="font-bold">Tasks</p>
        <p class="text-sm">/ 15</p>
      </div>
      <button class="flex w-10 h-10 text-white flex shadow-md rounded-full bg-indigo-dark absolute pin-r pin-b -mb-5 mr-8">
        <i class="fa fa-plus m-auto"></i>
      </button>
    </header>
    <div class="border-b px-4">
      <button :class="['py-4 px-2 -mb-px text-grey-darkest font-bold text-xs border-b no-outline focus:border-indigo-lighter hover:border-indigo-lighter', { 'border-indigo': filter.name == activeFilter }]"
        :key="filter.name"
        v-text="filter.name"
        @click.prevent="activeFilter = filter.name"
        v-for="filter in filters">
      </button>
    </div>
    <div v-if="tasks === false">
      Loading...
    </div>
    <div v-else-if="tasks.length">
      Show
    </div>
    <div v-else>
      You do not have tasks =(
    </div>
  </section>
</template>

<script>
  import TaskService from 'services/task';

  export default {
    data () {
      return {
        tasks: false,
        activeFilter: 'All',
      };
    },

    created () {
      this.fetch();
    },

    computed: {
      filters () {
        return [
          {
            name: 'All',
            callback (tasks) {
              return tasks;
            },
          },
          {
            name: 'Done',
            callback (tasks) {
              return tasks.filter(task => task.status);
            },
          },
          {
            name: 'Remain',
            callback (tasks) {
              return tasks.filter(task => ! task.status);
            },
          },
        ];
      },
    },

    methods: {
      fetch () {
        const before = Date.now();

        TaskService.all()
          .then(({ data }) => {
            const time = 2000 + Date.now() - before;

            setTimeout(() => this.tasks = data, time);
          });
      },
    },
  };
</script>

<style scoped>
  .fa-plus {
    font-size: 14px;
  }
</style>
