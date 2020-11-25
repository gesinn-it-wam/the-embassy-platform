// To be added with its script on top when adding this in a page
// Read more: https://github.com/bigbite/macy.js

(function (mw, $, window) {
// Code from CDN
// <script src="https://cdn.jsdelivr.net/npm/macy@2"></script>
	$(document).ready(function () {
		if (document.querySelector('#masonry-columns-container')) {
			// eslint-ignore-next-line no-unused-var
			var macyInstance = Macy({
				// for all available options: https://github.com/bigbite/macy.js
				container: '#masonry-columns-container',
				columns: 3,
				margin: {
					x: 30,
					y: 30,
				},
				breakAt: {
					600: {
						columns: 1,
					},
					960: {
						columns: 2,
					},
				},
			});
		}
	});
}(mediaWiki, jQuery, window));