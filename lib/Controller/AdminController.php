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
    public function saveSettings(): JSONResponse {
        $settings = $this->request->getParams();
        $this->logger->log("Saving settings: " . json_encode($settings));

        try {
            $configPath = __DIR__ . '/../../config/nshell_settings.json';
            file_put_contents($configPath, json_encode($settings, JSON_PRETTY_PRINT));

            return new JSONResponse([
                'status' => 'success',
                'message' => 'Settings saved successfully.'
            ]);
        } catch (\Exception $e) {
            $this->logger->log("Error saving settings: " . $e->getMessage());
            return new JSONResponse([
                'status' => 'error',
                'message' => 'Could not save settings: ' . $e->getMessage()
            ], 500);
        }
    }
}
