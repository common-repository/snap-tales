<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Types;

use BeycanPress\SnapTales\Settings;

class Story
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var int
     */
    public int $userId;

    /**
     * @var int|null
     */
    public ?int $parentId;

    /**
     * @var string|null
     */
    public ?string $externalURL;

    /**
     * @var string
     */
    public string $mediaURL;

    /**
     * @var string
     */
    public string $mediaType;

    /**
     * @var int
     */
    public int $likes;

    /**
     * @var bool
     */
    public bool $status;

    /**
     * @var string|null
     */
    public ?string $showUntil;

    /**
     * @var string
     */
    public string $updatedAt;

    /**
     * @var string
     */
    public string $createdAt;

    /**
     * @var string
     */
    public string $createdTimeAgo;

    /**
     * @var array<string>
     */
    private array $videoTypes = [
        'mp4',
        'webm',
        'ogg'
    ];

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param int $userId
     * @return self
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @param int|null $parentId
     * @return self
     */
    public function setParentId(?int $parentId): self
    {
        $this->parentId = $parentId;
        return $this;
    }

    /**
     * @param string|null $externalURL
     * @return self
     */
    public function setExternalURL(?string $externalURL): self
    {
        $this->externalURL = $externalURL;
        return $this;
    }

    /**
     * @param string $mediaURL
     * @return self
     */
    public function setMediaURL(string $mediaURL): self
    {
        $this->mediaURL = $mediaURL;

        $mediaType = pathinfo($mediaURL, PATHINFO_EXTENSION);

        if (in_array($mediaType, $this->videoTypes)) {
            $this->mediaType = 'video';
        } else {
            $this->mediaType = 'image';
        }

        return $this;
    }

    /**
     * @param int $likes
     * @return self
     */
    public function setLikes(int $likes): self
    {
        $this->likes = $likes;
        return $this;
    }

    /**
     * @param bool $status
     * @return self
     */
    public function setStatus(bool $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string|null $showUntil
     * @return self
     */
    public function setShowUntil(?string $showUntil): self
    {
        $this->showUntil = $showUntil;
        return $this;
    }

    /**
     * @param string $updatedAt
     * @return self
     */
    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @param string $createdAt
     * @return self
     */
    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @param string $createdTimeAgo
     * @return self
     */
    public function setCreatedTimeAgo(string $createdTimeAgo): self
    {
        $this->createdTimeAgo = $createdTimeAgo;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    /**
     * @return string|null
     */
    public function getExternalURL(): ?string
    {
        return $this->externalURL;
    }

    /**
     * @return string
     */
    public function getMediaURL(): string
    {
        return $this->mediaURL;
    }

    /**
     * @return string
     */
    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getShowUntil(): ?string
    {
        return $this->showUntil;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getCreatedTimeAgo(): string
    {
        return $this->createdTimeAgo;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'userId' => $this->getUserId(),
            'parentId' => $this->getParentId(),
            'externalURL' => $this->getExternalURL(),
            'mediaURL' => $this->getMediaURL(),
            'mediaType' => $this->getMediaType(),
            'likes' => $this->getLikes(),
            'status' => $this->getStatus(),
            'showUntil' => $this->getShowUntil(),
            'updatedAt' => $this->getUpdatedAt(),
            'createdAt' => $this->getCreatedAt(),
            'createdTimeAgo' => $this->getCreatedTimeAgo()
        ];
    }

    /**
     * @param array<string,mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return (new self())
            ->setId((int) $data['id'])
            ->setUserId($data['userId'])
            ->setLikes($data['likes'] ?? 0)
            ->setMediaURL($data['mediaURL'])
            ->setUpdatedAt($data['updatedAt'])
            ->setCreatedAt($data['createdAt'])
            ->setParentId($data['parentId'] ?? null)
            ->setShowUntil($data['showUntil'] ?? null)
            ->setCreatedTimeAgo($data['createdTimeAgo'])
            ->setStatus(boolval($data['status'] ?? true))
            ->setExternalURL($data['externalURL'] ?? null);
    }
}
