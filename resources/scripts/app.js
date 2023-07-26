import domReady from '@roots/sage/client/dom-ready';

/**
 * Application entrypoint
 */
domReady(async () => {
  // ...
});

/**
 * @see {@link https://webpack.js.org/api/hot-module-replacement/}
 */
import.meta.webpackHot?.accept(console.error);
import $ from "jquery";

import "./components/fixed-header.js"
import "./components/burger.js"
import "./components/about.js"
import "./components/contact-popup.js"
import "./components/products.js"
import "./components/google-map.js"
import "./slick/slick.js"
