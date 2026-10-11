(function () {
  function normalizeForSearch(value) {
    return value.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLocaleLowerCase();
  }

  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.admin-topbar-search input');
    if (!searchInput) return;

    const searchableGroups = [
      ...document.querySelectorAll('.dash-table tbody'),
      ...document.querySelectorAll('[data-search-list]'),
    ];

    searchableGroups.forEach(function (group) {
      const isTableBody = group instanceof HTMLTableSectionElement;
      const items = Array.from(group.querySelectorAll(
        isTableBody ? 'tr:not([data-search-empty])' : '[data-search-item]'
      ));
      let emptyMessage;

      function updateResults() {
        const query = normalizeForSearch(searchInput.value.trim());
        let visibleCount = 0;

        items.forEach(function (item) {
          const searchableContent = item.cloneNode(true);
          searchableContent.querySelectorAll('a, button, form').forEach(function (control) {
            control.remove();
          });
          const matches = normalizeForSearch(searchableContent.textContent).includes(query);
          item.hidden = !matches;
          if (matches) visibleCount += 1;
        });

        if (!query || visibleCount > 0) {
          emptyMessage?.remove();
          emptyMessage = undefined;
          return;
        }

        if (!emptyMessage) {
          if (isTableBody) {
            emptyMessage = document.createElement('tr');
            const cell = document.createElement('td');
            cell.colSpan = group.closest('table').querySelectorAll('thead th').length || 1;
            cell.className = 'text-center text-muted py-4';
            emptyMessage.appendChild(cell);
          } else {
            emptyMessage = document.createElement('div');
            emptyMessage.className = 'col-12 text-center text-muted py-4';
          }

          emptyMessage.dataset.searchEmpty = '';
          emptyMessage.setAttribute('role', 'status');
          emptyMessage.textContent = 'No se encontraron coincidencias.';
          group.appendChild(emptyMessage);
        }
      }

      searchInput.addEventListener('input', updateResults);
    });
  });
})();