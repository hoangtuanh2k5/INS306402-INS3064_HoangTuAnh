<?php
declare(strict_types=1);

require_once __DIR__ . '/../Services/RequestService.php';

class RequestController
{
    private RequestService $service;

    public function __construct(?RequestService $service = null)
    {
        $this->service = $service ?? new RequestService();
    }

    public function index(): void
    {
        $requests = $this->service->getAllRequests();
        require __DIR__ . '/../viewa/requests/index.php';
    }

    public function show(int $id): void
    {
        $request = $this->service->getRequestById($id);
        if ($request === null) {
            http_response_code(404);
            echo 'Request not found.';
            return;
        }

        require __DIR__ . '/../viewa/requests/show.php';
    }
}