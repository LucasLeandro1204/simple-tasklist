const waitCache = new Map();

const wait = (id, callback) => {
  if (waitCache.get(id) === true) {
    return;
  }

  waitCache.set(id, true);

  return callback()
    .then(() => waitCache.set(id, false));
};

export {
  wait,
};
