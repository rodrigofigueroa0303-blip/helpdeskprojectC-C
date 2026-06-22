// resources/js/admin-users.js

window.openEditModal = function(user, actionUrl) {
    document.getElementById('editUserForm').action = actionUrl;
    
    document.getElementById('edit_name').value = user.name;
    document.getElementById('edit_email').value = user.email;
    document.getElementById('edit_role').value = user.role;
    
    document.getElementById('editUserModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

window.closeEditModal = function() {
    document.getElementById('editUserModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

window.openDeleteUserModal = function(username, actionUrl) {
    console.log('Abriendo modal de eliminar');
    console.log('Usuario:', username);
    console.log('URL:', actionUrl);
    
    const form = document.getElementById('deleteUserForm');
    form.action = actionUrl;
    
    console.log('Form action configurado a:', form.action);
    
    document.getElementById('delete_username').textContent = username;
    document.getElementById('deleteUserModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    
    // Agregar listener para ver si el formulario se envía
    form.onsubmit = function() {
        console.log('Formulario enviándose a:', this.action);
    }
}

window.closeDeleteUserModal = function() {
    document.getElementById('deleteUserModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}