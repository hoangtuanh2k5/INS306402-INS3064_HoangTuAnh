<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/RequestRepository.php';

class RequestService
{
    private RequestRepository $repository;

    public function __construct(?RequestRepository $repository = null)
    {
        $this->repository = $repository ?? new RequestRepository();
    }

    /** @return Request[] */
    public function getAllRequests(): array
    {
        return $this->repository->all();
    }

    public function getRequestById(int $id): ?Request
    {
        if ($id <= 0) {
            return null;
        }

        return $this->repository->findById($id);
    }
}