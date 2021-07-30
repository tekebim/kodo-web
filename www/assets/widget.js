import './styles/widget.scss';

window.addEventListener("DOMContentLoaded", () => {
  console.log('widget.js Kodo')
  const domainAllowed = window.domainAllowed;
  const domainCurrent = document.referrer;

  if (domainCurrent && !(domainCurrent.toString().includes('localhost'))) {
    if ((domainAllowed !== '') && (!domainCurrent.toString().includes(domainAllowed))) {
      const overlayError = document.getElementById('overlay-error');
      const widgetEl = document.getElementById('widget-wrapper');
      widgetEl.remove();
      overlayError.style.display = 'flex';
      console.error(`Vous n'êtes pas autorisé à utiliser notre widget sur cette page.`);
    }
  }
});

