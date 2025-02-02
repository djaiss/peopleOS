import './bootstrap';
import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';
import ajax from '@imacrayon/alpine-ajax';

window.Alpine = Alpine;

Alpine.plugin(mask);
Alpine.plugin(ajax);

// import Alpine from 'alpinejs';
// import htmx from 'htmx.org';

// window.Alpine = Alpine;
// window.htmx = htmx;

Alpine.start();
