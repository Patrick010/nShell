// JavaScript for nShell Terminal

document.addEventListener('DOMContentLoaded', function () {
    const term = new Terminal();
    const terminalElement = document.getElementById('nshell-terminal');
    term.open(terminalElement);
    term.focus();

    let sessionId = null;

    // Function to generate a base URL for the app
    const generateUrl = (url) => {
        // In a real Nextcloud environment, this would be more robust.
        // For now, assuming a standard URL structure.
        return '/apps/nshell' + url;
    };

    // 1. Create a new session
    fetch(generateUrl('/session'), {
        method: 'POST',
    })
    .then(response => response.json())
    .then(data => {
        if (data.sessionId) {
            sessionId = data.sessionId;
            term.write('Welcome to nShell! Session ID: ' + sessionId + '\r\n$ ');
        } else {
            term.write('Error creating session: ' + (data.message || 'Unknown error') + '\r\n');
        }
    })
    .catch(err => {
        term.write('Fatal error creating session: ' + err.message + '\r\n');
    });

    // 2. Handle user input
    term.onData(e => {
        if (sessionId) {
            // Send input to the backend
            fetch(generateUrl('/session/' + sessionId + '/io'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // Nextcloud requires a CSRF token for POST requests
                    'requesttoken': OC.requestToken,
                },
                body: JSON.stringify({ input: e }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.output) {
                    // Replace newlines with carriage return + newline for proper terminal display
                    const formattedOutput = data.output.replace(/\n/g, '\r\n');
                    term.write(formattedOutput);
                }
                 // Add a prompt after output for better UX
                if (!data.output.endsWith('\n')) {
                    term.write('\r\n$ ');
                } else {
                    term.write('$ ');
                }
            })
            .catch(err => {
                term.write('\r\nError communicating with server: ' + err.message + '\r\n');
            });
        }
    });
});
