<?php
class Note
{
    private ?int   $id;
    private int    $userId;
    private string $title;
    private string $content;
    private bool   $favorite;
    private array  $tags;         
    private ?string $createdAt;

    public function __construct(
        ?int $id,
        int $userId,
        string $title,
        string $content = '',
        array $tags = [],
        bool $favorite = false,
        ?string $createdAt = null
    ) {
        $this->id        = $id;
        $this->userId    = $userId;
        $this->title     = $title;
        $this->content   = $content;
        $this->tags      = $tags;
        $this->favorite  = $favorite;
        $this->createdAt = $createdAt;
    }

    public function getId()        { return $this->id; }
    public function getUserId()    { return $this->userId; }
    public function getTitle()     { return $this->title; }
    public function getContent()   { return $this->content; }
    public function getTags()      { return $this->tags; }
    public function isFavorite()   { return $this->favorite; }
    public function getCreatedAt() { return $this->createdAt; }
}
