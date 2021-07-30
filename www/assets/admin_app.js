import './styles/admin/app.scss';
import 'prismjs/prism'
import 'prismjs/themes/prism-tomorrow.css'

const $ = require('jquery');
global.$ = global.jQuery = $;

window.addEventListener("DOMContentLoaded", () => {
  console.log('admin_app');
  $('#btn-add-subdomain').tooltip();
  $('#btn-add-widget').tooltip();

  let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })

  const widgetsPanel = document.getElementById('widgets-panel');

  if (typeof (widgetsPanel) != 'undefined' && widgetsPanel != null) {
  }
});
