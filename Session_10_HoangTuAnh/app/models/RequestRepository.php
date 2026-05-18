<?php
declare(strict_types=1);

require_once __DIR__ . '/Request.php';

class RequestRepository
{
    /** @var array<int, Request> */
    private array $requests;

    public function __construct()
    {
        $this->requests = [
            1 => new Request(
                1,
                'Fix login bug',
                'Users cannot login with Google OAuth on Safari.',
                'in_progress',
                '2026-04-10'
            ),
            2 => new Request(
                2,
                'Update portfolio section',
                'Add session 10 screenshots and final report link.',
                'open',
                '2026-04-14'
            ),
            3 => new Request(
                3,
                'Optimize home page',
                'Improve Lighthouse performance for first contentful paint.',
                'done',
                '2026-04-18'
            ),
        ];
    }

    /** @return Request[] */
    public function all(): array
    {
        return array_values($this->requests);
    }

    public function findById(int $id): ?Request
    {
        return $this->requests[$id] ?? null;
    }
}