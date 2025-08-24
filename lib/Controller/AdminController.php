<?php

namespace nShell\Controller;

use nShell\Logger;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;

class AdminController extends Controller {

    private Logger $logger;

    public function __construct(
        string $appName,
        IRequest $request,
        Logger $logger
    ) {
        parent::__construct($appName, $request);
        $this->logger = $logger;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function saveSettings(string $sessionTimeout = null, string $shell = null): JSONResponse {
        $message = "Admin settings received. Session Timeout: $sessionTimeout, Shell: $shell";
        $this->logger->log($message);

        return new JSONResponse([
            'status' => 'success',
            'message' => 'Settings received',
            'data' => $this->request->getParams()
        ]);
    }
}
