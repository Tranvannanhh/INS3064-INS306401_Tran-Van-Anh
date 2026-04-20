<?php

class Request
{
    public int $id;
    public string $title;
    public string $description;
    public string $status;

    public function __construct(int $id, string $title, string $description, string $status = 'Pending')
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
    }
}
