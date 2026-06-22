// resources/js/password-manager.js

document.addEventListener('DOMContentLoaded', () => {
    // Logica existente para ver/ocultar contrasenas
    document.addEventListener('click', (e) => {
        if (!e.target.classList.contains('pw-toggle')) return;
        
        const td = e.target.closest('td');
        const mask = td.querySelector('.pw-mask');
        const real = td.querySelector('.pw-real');
        const showing = !real.classList.contains('hidden');

        if (showing) {
            real.classList.add('hidden');
            mask.classList.remove('hidden');
            e.target.textContent = 'ver';
        } else {
            real.classList.remove('hidden');
            mask.classList.add('hidden');
            e.target.textContent = 'ocultar';
        }
    });
});

// Funciones globales para el Modal de Dar de Baja
window.triggerBajaModal = function(appName, actionUrl) {
    document.getElementById('bajaAppName').innerText = appName;
    document.getElementById('bajaForm').action = actionUrl;
    document.getElementById('bajaModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

window.closeBajaModal = function() {
    document.getElementById('bajaModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Funciones globales para el Modal de Eliminar Definitivamente
window.triggerDeleteModal = function(appName, actionUrl) {
    document.getElementById('deleteAppName').innerText = appName;
    document.getElementById('deleteForm').action = actionUrl;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

window.closeDeleteModal = function() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}