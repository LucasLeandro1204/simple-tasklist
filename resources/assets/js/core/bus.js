import Vue from 'vue';

class Bus {
  constructor (vue) {
    this.vue = vue;
    this.map = new Map();
  }

  on (event, callback) {
    this.vue.$on(event, callback);

    if (this.map.has(event)) {
      callback(this.map.get(event));
    }
  }

  emit (event, data = null, cache = false) {
    this.vue.$emit(event, data);

    if (cache) {
      this.map.set(event, data);
    }
  }
};

const bus = new Bus(new Vue);

Vue.use({
  install (vue) {
    vue.prototype.$bus = (event, data = null) => bus.emit(event, data);
  },
});

export default bus;
