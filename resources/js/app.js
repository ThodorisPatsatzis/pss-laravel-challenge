import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

import persist from '@alpinejs/persist'

Alpine.plugin(persist)

Alpine.start();
