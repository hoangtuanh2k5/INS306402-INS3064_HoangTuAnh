<?php
declare(strict_types=1);

class Request
{
    public int $id;
    public string $title;
    public string $description;
    public string $status;
    public string $createdAt;

    public function __construct(
        int $id,
        string $title,
        string $description,
        string $status,
        string $createdAt
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }
}