class App extends React.Component {
constructor(props) {
	super(props);

	this.state = {
		movieName: "",
		movies: [],
		apiKey: `1b62ccff88d2cd537027e1d82920197b` };


	this.handleChange = this.handleChange.bind(this);
}

api(url) {
	fetch(url).
	then(response => response.json()).
	then(data => this.setState({ movies: data.results }));
}

handleChange() {
this.setState({ movieName: this.refs.keyword.value.toLowerCase() });

setTimeout(() => {
	this.api(`https://consolo.is.cc/list.php?api_key=${this.state.apiKey}&query=${this.state.movieName}`);
		}, 1000);

}

componentDidMount() {
	this.api(`https://consolo.is.cc/list.php?api_key=${this.state.apiKey}&sort_by=popularity.desc`);
	}

	render() {
		let movies = this.state.movies;

		return (
		React.createElement("div", null,
			React.createElement("div", null,
				React.createElement("input", {
					type: "text",
					value: this.state.movieName,
					ref: "keyword",
					placeholder: "Search for a movie \u2192",
					onChange: this.handleChange }),


				React.createElement("ul", null,
					movies.map(movie => {
						return (
							React.createElement("li", null,
								React.createElement("img", { src: movie.poster_path ? `https://image.tmdb.org/t/p/w342/${movie.poster_path}` : `https://www.societaetstheater.de/media/thumbnails/229/3b9e6b88f1adc1a78594de4e39819229/7adcc363/placeholder_portrait.png` }),

									React.createElement("div", { className: "flex" },
										React.createElement("h2", null, movie.title),
										React.createElement("p", { className: "star" },
											React.createElement("span", null, "\u2B50\uFE0F"),
											Math.round(movie.vote_average)),

										React.createElement("p", { className: "desc" },
											movie.overview))));




		})))));





}}


ReactDOM.render(React.createElement(App, null), document.querySelector('#app'));