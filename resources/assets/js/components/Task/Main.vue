<template>
  <section class="rounded-sm text-black">
    <header class="flex px-8 py-6 bg-indigo-lighter text-white rounded-tl rounded-tr relative">
      <h1 class="text-5xl font-normal mr-2" v-text="total"></h1>
      <div class="self-center">
        <p class="font-bold">Tasks</p>
        <p class="text-sm">/ {{ all.length }}</p>
      </div>
      <button class="flex w-10 h-10 text-white flex shadow-md rounded-full bg-indigo-dark absolute pin-r pin-b -mb-5 mr-8">
        <i class="fa fa-plus m-auto"></i>
      </button>
    </header>
    <div class="border-b px-4">
      <button
        class="py-4 px-2 -mb-px text-grey-darkest font-bold text-xs border-b no-outline focus:border-indigo hover:border-indigo"
        :class="{ 'border-indigo': filter == activeFilter }"
        :key="filter"
        v-text="filter"
        @click.prevent="activeFilter = filter"
        v-for="filter in filters">
      </button>
    </div>
    <div v-if="tasks === false">
      Loading...
    </div>
    <div v-else-if="tasks.length">
      <div class="flex border-b pl-4 text-grey-darkest text-sm" :class="{ 'text-grey': task.status }" :key="task.id" v-for="task in filtered">
        <i class="fa mr-2 text-indigo my-auto" :class="task.status ? 'fa-check-circle-o text-indigo-lighter' : 'fa-circle-o'"></i>
        <p class="py-4" :class="{ 'line-through': task.status }" v-text="task.title"></p>
        <button class="ml-auto px-4" @click.prevent>
          <i class="fa fa-angle-right my-auto"></i>
        </button>
      </div>
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
      done () {
        return this.tasks ? this.tasks.filter(task => task.status) : [];
      },

      remain () {
        return this.tasks ? this.tasks.filter(task => ! task.status) : [];
      },

      all () {
        return this.tasks || [];
      },

      total () {
        const all = this.all.length;

        if (! all) {
          return 0;
        }

        if (this.activeFilter == 'Remain') {
          return all - this.done.length;
        }

        return all - this.remain.length;
      },

      filtered () {
        if (this.activeFilter == 'Done') {
          return this.done;
        }

        if (this.activeFilter == 'Remain') {
          return this.remain;
        }

        return this.all;
      },

      filters () {
        return [
          'All', 'Remain', 'Done',
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
