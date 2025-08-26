// JavaScript for nShell Terminal

document.addEventListener('DOMContentLoaded', function () {
    const term = new Terminal();
    const terminalElement = document.getElementById('nshell-terminal');
    term.open(terminalElement);
    term.focus();

    let sessionId = null;

    // 1. Create a new session
    fetch(OC.generateUrl('/apps/nshell/session'), {
        method: 'POST',
        headers: {
            'requesttoken': OC.requestToken,
        },
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
            fetch(OC.generateUrl('/apps/nshell/session/' + sessionId + '/io'), {
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
                if (data && typeof data.output === 'string') {
                    term.write(data.output);
                } else {
                    term.write(`\r\nError: invalid server response\r\n`);
                }
            })
            .catch(err => {
                term.write(`\r\nError communicating with server: ${err}\r\n`);
            });
        }
    });
});
