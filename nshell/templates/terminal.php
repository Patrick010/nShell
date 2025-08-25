<?php
/**
 * @var array $_
 */

// Add CSS for the terminal
\OCP\Util::addStyle('nshell', 'xterm.min');
\OCP\Util::addStyle('nshell', 'terminal');

// Add JavaScript for the terminal
\OCP\Util::addScript('nshell', 'xterm');
\OCP\Util::addScript('nshell', 'terminal');

// Pass the CSRF token to the frontend
\OCP\Util::addScript('core', 'OC', true);
\OCP\Util::addScript('core', 'core/js/oc-request-token.js', true);
?>

<div id="nshell-terminal" style="height: 100%; width: 100%;"></div>
