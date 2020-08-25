new Vue({
  el: '#app',
  data() {
    return {
      items: [
      {
        action: 'local_activity',
        title: 'Attractions',
        active: false,
        items: [
        { title: 'List Item' }] },


      {
        action: 'restaurant',
        title: 'Dining',
        active: true,
        items: [
        { title: 'Breakfast & brunch' },
        { title: 'New American' },
        { title: 'Sushi' }] },


      {
        action: 'school',
        title: 'Education',
        active: false,
        items: [
        { title: 'List Item' }] },


      {
        action: 'directions_run',
        title: 'Family',
        active: false,
        items: [
        { title: 'List Item' }] },


      {
        action: 'healing',
        title: 'Health',
        active: false,
        items: [
        { title: 'List Item' }] },


      {
        action: 'content_cut',
        title: 'Office',
        active: false,
        items: [
        { title: 'List Item' }] },


      {
        action: 'local_offer',
        title: 'Promotions',
        active: false,
        items: [
        { title: 'List Item' }] }] };




  },
  methods: {
    close() {
      this.items.forEach(item => {
        if (item.active) {
          _.delay(function () {
            item.active = false;
          }, 300);
          return false;
        }
      });
    } } });