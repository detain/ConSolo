new Vue({
	el: "#app",
	data: {
		items: [],
		image: 'https://image.tmdb.org/t/p/w342',
		loaded: true },

	created: function () {
		this.fetchData();
	},
	methods: {
		fetchData: function () {
			this.$http.get('https://consolo.is.cc/list.php?api_key=' + 'bc7aff7c3e4cd31438852dcac726059e' + '&sort_by=popularity.desc').then(response => {
				this.items = response.body;
				this.loaded = false;
			});
} } });