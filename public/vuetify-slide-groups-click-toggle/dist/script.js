new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  data: () => ({
    model: null }),

  methods: {
    onCardClick(n) {
      this.model = n - 1;
    } } });