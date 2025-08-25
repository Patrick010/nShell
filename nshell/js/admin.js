// JavaScript for nShell Admin Panel

document.addEventListener('DOMContentLoaded', function () {
    const adminForm = document.getElementById('nshell-admin-form');

    if (adminForm) {
        adminForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(adminForm);
            const url = '/apps/nshell/admin/settings';

            // Nextcloud expects form data, not JSON, for this type of request.
            const searchParams = new URLSearchParams();
            for (const pair of formData) {
                searchParams.append(pair[0], pair[1]);
            }
            // Manually add the request token to the body for form submissions
            searchParams.append('requesttoken', OC.requestToken);

            fetch(url, {
                method: 'POST',
                // The Content-Type header is not strictly necessary as the browser
                // will set it automatically for URLSearchParams, but we can be explicit.
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: searchParams,
            })
            .then(response => {
                if (!response.ok) {
                    // Throw an error to be caught by the catch block
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    // A less intrusive notification would be better in a real app
                    alert('Settings saved successfully!');
                } else {
                    alert('Error saving settings: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred while saving settings. Check the browser console for details.');
            });
        });
    }
});
