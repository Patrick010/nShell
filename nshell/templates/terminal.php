<?php
/**
 * @var array $_
 */

// Add CSS for the terminal
\OCP\Util::addStyle('nshell', 'terminal'); // For terminal.css
\OCP\Util::addStyle('https://cdnjs.cloudflare.com/ajax/libs/xterm/5.5.0/xterm.min.css');

// Add JavaScript for the terminal
\OCP\Util::addScript('https://cdnjs.cloudflare.com/ajax/libs/xterm/5.5.0/xterm.min.js');
\OCP\Util::addScript('nshell', 'terminal'); // For terminal.js

// Pass the CSRF token to the frontend
\OCP\Util::addScript('core', 'OC', true);
\OCP\Util::addScript('core', 'core/js/oc-request-token.js', true);
?>

<div id="nshell-terminal" style="height: 100%; width: 100%;"></div>
