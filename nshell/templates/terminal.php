<?php
/**
 * @var array $_
 */


// Pass the CSRF token to the frontend
\OCP\Util::addScript('core', 'OC', true);
\OCP\Util::addScript('core', 'core/js/oc-request-token.js', true);
?>

<div id="nshell-terminal" style="height: 100%; width: 100%;"></div>
