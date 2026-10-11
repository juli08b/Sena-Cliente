// ajax-forms.js
// Generic AJAX form handler for forms with data-ajax="true".
// Usage (in a Blade view):
// <form data-ajax="true" data-target="#areas-tbody" data-template="<tr data-area-id='{id}'><td>{id}</td><td>{name}</td><td>...</td></tr>" data-insert="prepend" action="/area/store" method="POST"> ... </form>
// - data-target: CSS selector for the table tbody where the new row will be inserted
// - data-template: HTML template string with placeholders like {id}, {name}
// - data-insert: 'prepend' (default) or 'append'

(function () {
  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function showAlertNear(form, type, message) {
    let alertBox = form.querySelector('.ajax-alert');
    if (!alertBox) {
      alertBox = document.createElement('div');
      alertBox.className = 'ajax-alert mt-3';
      form.appendChild(alertBox);
    }
    alertBox.innerHTML = `<div class="alert alert-${type}">${escapeHtml(message)}</div>`;
    setTimeout(() => { if (alertBox) alertBox.innerHTML = ''; }, 3500);
  }

    document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form[data-ajax="true"]');
    forms.forEach(form => {
      form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const targetSelector = form.dataset.target;
        const templateSelector = form.dataset.templateSelector || form.dataset.template || '';
        let template = '';
        if (templateSelector && templateSelector.startsWith('#')) {
          const tplEl = document.querySelector(templateSelector);
          if (tplEl) template = tplEl.innerHTML.trim();
        } else {
          template = form.dataset.template || '';
        }
        const insert = (form.dataset.insert || 'prepend').toLowerCase();
        let target = document.querySelector(targetSelector);
        const submitBtn = form.querySelector('[type="submit"]');
        if (!target) {
          // Intentar localizar un tbody cercano como reserva (por si la plantilla está estructurada distinto)
          const fallback = form.closest('.card')?.querySelector('tbody') || document.querySelector('tbody');
          if (fallback) {
            console.warn('AJAX form target not found, using fallback tbody');
            target = fallback;
          } else {
            console.error('AJAX form target not found:', targetSelector);
            showAlertNear(form, 'danger', 'Configuración incorrecta del formulario (target no encontrado). Se enviará de forma tradicional.');
            // Remover atributo AJAX y enviar el formulario tradicionalmente para no bloquear al usuario
            form.removeAttribute('data-ajax');
            form.submit();
            return;
          }
        }

        if (submitBtn) submitBtn.disabled = true;

        try {
          const res = await fetch(form.action, {
            method: (form.method || 'POST').toUpperCase(),
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: new FormData(form),
          });

          if (!res.ok) {
            let text = await res.text();
            console.error('AJAX form error', res.status, text);
            showAlertNear(form, 'danger', 'Error al guardar. Revisa la consola.');
            return;
          }

          const data = await res.json();

          // Replace placeholders in template like {id} with escaped values from data
          const html = template.replace(/\{(\w+)\}/g, function (m, key) {
            return escapeHtml(data[key] ?? '');
          });

          // Convert HTML string to DOM node(s)
          const container = document.createElement('tbody');
          container.innerHTML = html;
          const newNode = container.firstElementChild;
          if (!newNode) {
            console.error('Template produced no nodes.');
            showAlertNear(form, 'warning', 'La plantilla no generó contenido.');
            return;
          }

          if (insert === 'prepend') target.prepend(newNode);
          else target.append(newNode);

          newNode.setAttribute('data-record-id', data.id ?? '');
          form.reset();
          showAlertNear(form, 'success', 'Guardado correctamente.');
        } catch (err) {
          console.error('AJAX form exception', err);
          showAlertNear(form, 'danger', 'Error de red al guardar.');
        } finally {
          if (submitBtn) submitBtn.disabled = false;
        }
      });
    });
    
    // Manejador delegado para formularios de eliminación vía AJAX
    document.addEventListener('submit', async function (e) {
      const form = e.target;
      if (!(form instanceof HTMLFormElement)) return;
      if (!form.dataset.ajaxDelete) return;
      e.preventDefault();
      if (!confirm('¿Seguro que deseas eliminar este registro?')) return;

      try {
        const row = form.closest('tr');
        let action = form.getAttribute('action') || '';
        if (action.includes('{id}')) {
          const rid = (row && (row.dataset.recordId || row.dataset.id)) || '';
          action = action.replace(/\{id\}/g, rid);
        }
        const res = await fetch(action, {
          method: 'DELETE',
          headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': form.querySelector('input[name="_token"]')?.value || '' },
        });

        if (!res.ok) {
          console.error('AJAX delete error', res.status);
          alert('Error al eliminar. Revisa la consola.');
          return;
        }

        // Al borrar con éxito, eliminar la fila del DOM
        const row = form.closest('tr');
        if (row) row.remove();

      } catch (err) {
        console.error('AJAX delete exception', err);
        alert('Error de red al eliminar.');
      }
    });
  });
})();
