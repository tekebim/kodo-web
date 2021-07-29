import './styles/admin/app.scss';

const $ = require('jquery');
global.$ = global.jQuery = $;

window.addEventListener("DOMContentLoaded", () => {
  console.log('admin_app');
  $('#btn-add-subdomain').tooltip()
});
