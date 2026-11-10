(() => {
  'use strict';
  const body = document.body;
  const openButton = document.querySelector('[data-open-sidebar]');
  const closeButton = document.querySelector('[data-close-sidebar]');
  const sidebar = document.getElementById('storefront-sidebar');

  function closeSidebar() {
    body.classList.remove('sidebar-is-open');
    openButton?.setAttribute('aria-expanded', 'false');
  }
  function toggleSidebar() {
    const open = body.classList.toggle('sidebar-is-open');
    openButton?.setAttribute('aria-expanded', String(open));
    if (open) sidebar?.querySelector('a')?.focus();
  }

  openButton?.addEventListener('click', toggleSidebar);
  closeButton?.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeSidebar();
  });
  document.querySelectorAll('.wss-sidebar a').forEach(link => {
    link.addEventListener('click', closeSidebar);
  });
  document.querySelectorAll('[data-auto-submit]').forEach(control => {
    control.addEventListener('change', () => control.form?.requestSubmit());
  });
  document.querySelectorAll('[data-dismiss-flash]').forEach(button => {
    button.addEventListener('click', () => button.closest('.flash')?.remove());
  });
})();
