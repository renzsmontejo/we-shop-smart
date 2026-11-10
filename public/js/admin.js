(() => {
  'use strict';

  const shell = document.getElementById('adminShell');
  const menu = document.getElementById('menuToggle');
  const sidebar = document.getElementById('adminSidebar');
  const search = document.getElementById('navSearch');
  const links = [...document.querySelectorAll('[data-nav-label]')];
  const noResults = document.getElementById('navEmpty');
  const panelPairs = [
    [document.getElementById('notificationToggle'), document.getElementById('notificationsPanel')],
    [document.getElementById('accountToggle'), document.getElementById('accountPanel')],
  ];

  function setSidebar(open) {
    shell.classList.toggle('sidebar-open', open);
    menu?.setAttribute('aria-expanded', String(open));
    if (sidebar && window.matchMedia('(max-width: 950px)').matches) {
      sidebar.inert = !open;
    }
    if (open) sidebar?.querySelector('.nav-link')?.focus();
    else if (document.activeElement?.closest('#adminSidebar')) menu?.focus();
  }

  menu?.addEventListener('click', () => setSidebar(!shell.classList.contains('sidebar-open')));
  document.querySelectorAll('[data-close-sidebar]').forEach(el => {
    el.addEventListener('click', () => setSidebar(false));
  });
  const smallScreen = window.matchMedia('(max-width: 950px)');
  const syncSidebar = () => { if (!smallScreen.matches) { sidebar.inert = false; setSidebar(false); } else { sidebar.inert = !shell.classList.contains('sidebar-open'); } };
  smallScreen.addEventListener('change', syncSidebar);
  syncSidebar();

  search?.addEventListener('input', () => {
    const term = search.value.trim().toLowerCase();
    let shown = 0;
    links.forEach(link => {
      const match = link.dataset.navLabel.includes(term);
      link.hidden = !match;
      if (match) shown++;
    });
    noResults.hidden = shown !== 0;
  });
  search?.addEventListener('keydown', event => {
    if (event.key === 'Enter') {
      const first = links.find(link => !link.hidden);
      if (first) { event.preventDefault(); window.location.assign(first.href); }
    }
    if (event.key === 'Escape' && search.value) { search.value = ''; search.dispatchEvent(new Event('input')); }
  });

  const closePanels = (except = null) => {
    panelPairs.forEach(([trigger, panel]) => {
      if (!trigger || !panel || panel === except) return;
      panel.hidden = true;
      trigger.setAttribute('aria-expanded', 'false');
    });
  };
  panelPairs.forEach(([trigger, panel]) => {
    trigger?.addEventListener('click', event => {
      event.stopPropagation();
      const shouldOpen = panel.hidden;
      closePanels();
      panel.hidden = !shouldOpen;
      trigger.setAttribute('aria-expanded', String(shouldOpen));
    });
    panel?.addEventListener('click', event => event.stopPropagation());
  });
  document.addEventListener('click', () => closePanels());
  document.addEventListener('keydown', event => {
    if (event.key === 'Escape') { closePanels(); if (shell.classList.contains('sidebar-open')) setSidebar(false); }
    if (event.key === '/' && !event.altKey && !event.ctrlKey && !event.metaKey && !/^(INPUT|TEXTAREA|SELECT)$/.test(document.activeElement?.tagName || '') && !document.activeElement?.isContentEditable) {
      if (search && window.getComputedStyle(search).display !== 'none') { event.preventDefault(); search.focus(); }
    }
  });
})();
