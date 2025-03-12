import './bootstrap';
import 'instant.page';
import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';
import ajax from '@imacrayon/alpine-ajax';
import intersect from '@alpinejs/intersect';

window.Alpine = Alpine;

Alpine.plugin(mask);
Alpine.plugin(ajax);
Alpine.plugin(intersect);

Alpine.start();
