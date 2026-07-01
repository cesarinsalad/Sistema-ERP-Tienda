document.addEventListener('DOMContentLoaded', function () {
    // Intercept all form submissions at the document level
    document.addEventListener('submit', function (e) {
        const form = e.target;

        // Only intercept POST methods (which include PUT, PATCH, DELETE via _method)
        // GET requests (searches, filters) are ignored.
        if (form.method.toUpperCase() !== 'POST') {
            return;
        }

        // Exclusions: IDs that shouldn't be intercepted
        const excludedIds = ['logout-form', 'login-form', 'fetch-tasa-form'];
        if (form.id && excludedIds.includes(form.id)) {
            return;
        }

        // Exclusions: action URLs that shouldn't be intercepted
        const actionUrl = form.action.toLowerCase();
        if (actionUrl.includes('/login') || actionUrl.includes('/logout') || actionUrl.includes('metrics/query')) {
            return;
        }

        // Check if there is a _method field to determine if it's a DELETE operation
        const methodInput = form.querySelector('input[name="_method"]');
        const isDelete = methodInput && methodInput.value.toUpperCase() === 'DELETE';

        // Prevent default submission
        e.preventDefault();

        // Configure SweetAlert text based on the action type
        const title = isDelete ? '¿Desactivar o Activar registro?' : '¿Estás seguro?';
        const text = isDelete
            ? 'Esta acción inhabilitará la opción o al usuario del sistema.'
            : '¿Deseas continuar con esta operación y guardar los cambios?';
        const confirmButtonText = isDelete ? 'Sí, continuar' : 'Sí, continuar';
        const confirmButtonColor = isDelete ? '#d33' : '#3085d6';

        // Trigger SweetAlert2 Modal
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: confirmButtonColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmButtonText,
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form programmatically bypassing the event listener
                form.submit();
            }
        });
    });
});
