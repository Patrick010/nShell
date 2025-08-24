// JavaScript for nShell Admin Panel

document.addEventListener('DOMContentLoaded', function () {
    const adminForm = document.querySelector('#nshell-admin form');

    if (adminForm) {
        adminForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(adminForm);
            const settings = Object.fromEntries(formData.entries());

            // This is a placeholder for a real URL generation function
            const url = '/apps/nshell/settings';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'requesttoken': OC.requestToken // Important for Nextcloud CSRF protection
                },
                body: JSON.stringify(settings)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Settings saved successfully!');
                } else {
                    alert('Error saving settings: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred while saving settings.');
            });
        });
    }
});
