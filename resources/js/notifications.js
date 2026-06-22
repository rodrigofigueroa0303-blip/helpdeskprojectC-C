document.addEventListener('DOMContentLoaded', () => {
  const bell = document.getElementById('notifBell');

  // Si no existe la campana en la página (porque no es admin), detenemos el script por completo
  if (!bell) {
    return;
  }

  // Evento al hacer clic en la campana
  bell.addEventListener('click', () => {
    Swal.fire({
      title: 'Notificaciones',
      html: `
        <ul style="text-align:left; list-style:none; padding:0;">
          ${bell.querySelector('span') 
            ? '<li>Hay tickets nuevos</li>' 
            : '<li>No hay notificaciones nuevas</li>'}
          <li>Recuerda revisar tus tickets pendientes</li>
        </ul>
      `,
      icon: 'info',
      confirmButtonText: 'Cerrar'
    });
  });

  // Polling cada 30 segundos (solo se ejecutará para admins gracias al return de arriba)
  setInterval(() => {
    fetch('/api/check-new-tickets')
      .then(res => res.json())
      .then(data => {
        let badge = bell.querySelector('span');

        if (data.has_new) {
          if (!badge) {
            badge = document.createElement('span');
            badge.className = 'absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white ring-2 ring-white animate-pulse';
            bell.appendChild(badge);
          }
          badge.textContent = data.count;

          Swal.fire({
            title: '¡Nuevo ticket!',
            text: `Se han registrado ${data.count} ticket(s). Último: ${data.ticket}`,
            icon: 'info',
            confirmButtonText: 'Ok'
          });
        } else {
          if (badge) {
            badge.remove();
          }
        }
      })
      .catch(err => console.error('Error consultando tickets:', err));
  }, 30000); 
});