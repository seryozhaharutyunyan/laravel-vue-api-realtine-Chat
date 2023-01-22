import { createStore } from 'vuex'

export default createStore({
  state: {
      url: 'http://city.loc/api',
  },
  getters: {
      getUrl(state){
          return state.url;
      },

  },
  mutations: {
  },
  actions: {
  },
  modules: {
  }
})
