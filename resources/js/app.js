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

function refreshCsrfToken() {
  fetch('/refresh-csrf')
    .then((response) => response.json())
    .then((data) => {
      document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrfToken);
    });
}

// Refresh CSRF token every 10 minutes (600,000 milliseconds)
setInterval(refreshCsrfToken, 600000);
