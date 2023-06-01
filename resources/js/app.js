import './bootstrap';

import '../sass/app.scss';

const modules = import.meta.glob([
    '../assets/img/todopic/**',
],{
    query: { w: '150', h: '150', format: 'webp' }
});
