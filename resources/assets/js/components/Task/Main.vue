<template>
  <section class="rounded-sm text-black">
    <header class="flex px-8 py-6 bg-indigo-lighter text-white rounded-tl rounded-tr">
      <h1 class="text-5xl font-normal mr-2">10</h1>
      <div class="self-center">
        <p class="font-bold">Tasks</p>
        <p class="text-sm">/ 15</p>
      </div>
    </header>
    <div class="border-b px-4">
      <button :class="['py-4 px-2 -mb-px text-grey-darkest font-bold text-xs border-b no-outline focus:border-indigo-lighter hover:border-indigo-lighter', { 'border-indigo': filter.name == activeFilter }]"
        :key="filter.name"
        v-text="filter.name"
        @click.prevent="activeFilter = filter.name"
        v-for="filter in filters">
      </button>
    </div>
  </section>
</template>
{
<script>
  export default {
    data () {
      return {
        activeFilter: 'All',
      };
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
  };
</script>

<style lang="scss" scoped>

</style>
