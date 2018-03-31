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
      <div class="p-4 border-b" v-for="i in 10">
        <vue-content-loading :width="300" :height="14">
          <circle cx="7" cy="7" r="7"></circle>
          <rect x="21" y="1" width="150" height="11"></rect>
          <circle cx="293" cy="7" r="7"></circle>
        </vue-content-loading>
      </div>
    </div>

    <div v-else-if="tasks.length">
      <task :task="task" :key="task.id" v-for="task in filtered" @toggle="toggleStatus(task)" />

      <template v-if="! filtered.length">
        <icon-announcement icon="fa-sign-language" v-if="activeFilter == 'Remain'">
          <h4 class="mb-1">You completed all your tasks</h4>
          <p>Create more, you can't stop xD</p>
        </icon-announcement>

        <icon-announcement icon="fa-meh-o" v-if="activeFilter == 'Done'">
          <h4 class="mb-1">Whaaattt???</h4>
          <p>GO FINISH YOUR TASKS!!!!</p>
        </icon-announcement>
      </template>
    </div>

    <icon-announcement icon="fa-file-o" v-else>
      <h4 class="mb-1">You don't have any tasks</h4>
      <p>Try to create some =D</p>
    </icon-announcement>

  </task-section>
</template>

<script>
  import Task from './Card.vue';
  import { wait } from 'core/helpers';
  import Service from 'services/task';
  import TaskSection from '@/Section.vue';
  import SectionButton from '@/SectionButton.vue';
  import IconAnnouncement from '@/IconAnnouncement.vue';
  import VueContentLoading from 'vue-content-loading';

  export default {
    components: {
      Task,
      TaskSection,
      SectionButton,
      IconAnnouncement,
      VueContentLoading,
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
