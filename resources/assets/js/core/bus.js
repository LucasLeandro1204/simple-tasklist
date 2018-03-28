import Vue from 'vue';

class Bus {
  constructor (vue) {
    this.vue = vue;
    this.map = new Map();
    this.queue = new Map();
  }

  on (event, callback) {
    this.vue.$on(event, callback);

    if (this.map.has(event)) {
      callback(this.map.get(event));
    }
  }

  wait (event, promise, identifier) {
    this.on(event, (...args) => {
      if (this.queue.get(event + '-' + identifier)) {
        return;
      }

      this.queue.set(event + '-' + identifier, true);

      promise(...args)
        .then(() => this.queue.set(event + '-' + identifier, false));
    });
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
