<template>
  <task-section>
    <template slot="header">
      <h1 class="text-5xl font-normal mr-2" v-text="total"></h1>
      <div class="self-center">
        <p class="font-bold">Tasks</p>
        <p class="text-sm">/ {{ all.length }}</p>
      </div>
    </template>

    <template slot="header-buttons">
      <button @click.prevent="$router.push({ name: 'task.create' })" class="flex w-10 h-10 ml-2 text-white flex shadow-md rounded-full bg-indigo-dark">
        <i class="fa fa-plus m-auto"></i>
      </button>
    </template>

    <template slot="section-buttons">
      <section-button
        :icon="filter.icon"
        :class="{ 'border-indigo': filter.name == activeFilter }"
        :key="filter.name"
        @click.native.prevent="activeFilter = filter.name"
        v-for="filter in filters" />
    </template>

    <div v-if="tasks === false">
      Loading...
    </div>

    <div v-else-if="tasks.length">
      <task :task="task" :key="task.id" v-for="task in filtered" @toggle="toggleStatus(task)" />
    </div>

    <div v-else>
      You do not have tasks =(
    </div>
  </task-section>
</template>

<script>
  import Task from './Card.vue';
  import { wait } from 'core/helpers';
  import Service from 'services/task';
  import TaskSection from '@/Section.vue';
  import SectionButton from '@/SectionButton.vue';

  export default {
    components: {
      Task,
      TaskSection,
      SectionButton,
    },

    data () {
      return {
        activeFilter: 'All',
      };
    },

    created () {
      this.fetch();
    },

    computed: {
      tasks: {
        get () {
          return this.$root.tasks;
        },

        set (value) {
          this.$root.tasks = value;
        }
      },

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
          {
            name: 'All',
            icon: 'fa-list',
          },
          {
            name: 'Remain',
            icon: 'fa-circle-o',
          },
          {
            name: 'Done',
            icon: 'fa-check',
          }
        ];
      },
    },

    methods: {
      toggleStatus (task) {
        wait(task.id, () => {
          task.status = ! task.status;
          const index = this.tasks.findIndex(t => t.id == task.id);

          return Service.update(task.id, {
            status: task.status,
          })
          .then(({ data }) => {
            this.$set(this.tasks, index, data);
          })
          .catch(() => {
            task.status = ! task.status;
          });
        });
      },

      fetch () {
        const before = Date.now();

        Service.all()
          .then(({ data }) => {
            const time = 2000 + Date.now() - before;

            setTimeout(() => this.tasks = data, time);
          });
      },
    },
  };
</script>
