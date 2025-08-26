// JavaScript for nShell Terminal

document.addEventListener('DOMContentLoaded', function () {
    const term = new Terminal({
        cursorBlink: true
    });
    const terminalElement = document.getElementById('nshell-terminal');
    term.open(terminalElement);
    term.focus();

    let sessionId = null;
    let socket = null;

    term.write('Connecting to nShell...\r\n');

    // 1. Create a new session by calling the /start endpoint
    fetch(OC.generateUrl('/apps/nshell/start'), {
        method: 'POST',
        headers: {
            'requesttoken': OC.requestToken,
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to initialize session.');
        }
        return response.json();
    })
    .then(data => {
        if (data.sessionId) {
            sessionId = data.sessionId;
            term.write(`Session created: ${sessionId}\r\n`);
            connectWebSocket(sessionId);
        } else {
            term.write('Error: Could not retrieve session ID.\r\n');
        }
    })
    .catch(err => {
        term.write(`Initialization error: ${err.message}\r\n`);
    });

    function connectWebSocket(sessionId) {
        // NOTE: The WebSocket URL will need to be configurable in a real implementation.
        // We are hardcoding it here for development purposes.
        const wsUrl = `ws://127.0.0.1:8080/${sessionId}`;
        socket = new WebSocket(wsUrl);

        socket.onopen = function(e) {
            term.write('Connection established. Welcome to nShell!\r\n$ ');
        };

        socket.onmessage = function(event) {
            term.write(event.data);
        };

        socket.onclose = function(event) {
            if (event.wasClean) {
                term.write(`\r\nConnection closed cleanly, code=${event.code} reason=${event.reason}\r\n`);
            } else {
                term.write('\r\nConnection died\r\n');
            }
            socket = null;
        };

        socket.onerror = function(error) {
            term.write(`\r\n[WebSocket Error] ${error.message}\r\n`);
        };
    }

    // 2. Handle user input
    term.onData(e => {
        if (socket && socket.readyState === WebSocket.OPEN) {
            // Send input to the backend via WebSocket
            socket.send(e);
        }
    });

    // 3. Handle session cleanup on page unload
    window.addEventListener('beforeunload', () => {
        if (sessionId) {
            // Use sendBeacon as a more reliable way to send a request on page unload
            const url = OC.generateUrl(`/apps/nshell/stop/${sessionId}`);
            const headers = { type: 'application/x-www-form-urlencoded' };
            const blob = new Blob([`requesttoken=${OC.requestToken}`], headers);
            navigator.sendBeacon(url, blob);
        }
        if (socket) {
            socket.close();
        }
    });
});
