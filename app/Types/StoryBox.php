<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Types;

class StoryBox
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $thumbnail;

    /**
     * @var array<Story>
     */
    public array $stories;

    /**
     * @var bool
     */
    public bool $status;

    /**
     * @var string
     */
    public string $updatedAt;

    /**
     * @var string
     */
    public string $createdAt;

    /**
     * @var string|null
     */
    public ?string $redirectURL = null;

    /**
     * @var string
     */
    public string $lastStoryCreatedTimeAgo;

    /**
     * @var int
     */
    public int $lastStoryCreatedTimestamp;

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
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $thumbnail
     * @return self
     */
    public function setThumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    /**
     * @param array<Story> $stories
     * @return self
     */
    public function setStories(array $stories): self
    {
        $this->stories = $stories;
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
     * @param Story $story
     * @return self
     */
    public function addStory(Story $story): self
    {
        $this->stories[] = $story;
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
     * @param string|null $redirectURL
     * @return self
     */
    public function setRedirectURL(?string $redirectURL): self
    {
        $this->redirectURL = $redirectURL;
        return $this;
    }

    /**
     * @param string $lastStoryCreatedTimeAgo
     * @return self
     */
    public function setLastStoryCreatedTimeAgo(string $lastStoryCreatedTimeAgo): self
    {
        $this->lastStoryCreatedTimeAgo = $lastStoryCreatedTimeAgo;
        return $this;
    }

    /**
     * @param int $lastStoryCreatedTimestamp
     * @return self
     */
    public function setLastStoryCreatedTimestamp(int $lastStoryCreatedTimestamp): self
    {
        $this->lastStoryCreatedTimestamp = $lastStoryCreatedTimestamp;
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * @return array<Story>
     */
    public function getStories(): array
    {
        return $this->stories;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
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
     * @return string|null
     */
    public function getRedirectURL(): ?string
    {
        return $this->redirectURL;
    }

    /**
     * @return string
     */
    public function getLastStoryCreatedTimeAgo(): string
    {
        return $this->lastStoryCreatedTimeAgo;
    }

    /**
     * @return int
     */
    public function getLastStoryCreatedTimestamp(): int
    {
        return $this->lastStoryCreatedTimestamp;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'status' => $this->getStatus(),
            'thumbnail' => $this->getThumbnail(),
            'updatedAt' => $this->getUpdatedAt(),
            'createdAt' => $this->getCreatedAt(),
            'redirectURL' => $this->getRedirectURL(),
            'lastStoryCreatedTimeAgo' => $this->getLastStoryCreatedTimeAgo(),
            'lastStoryCreatedTimestamp' => $this->getLastStoryCreatedTimestamp(),
            'stories' => array_map(fn (Story $story) => $story->toArray(), $this->getStories())
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
            ->setTitle($data['title'])
            ->setThumbnail($data['thumbnail'])
            ->setUpdatedAt($data['updatedAt'])
            ->setCreatedAt($data['createdAt'])
            ->setStatus(boolval($data['status'] ?? true))
            ->setRedirectURL($data['redirectURL'] ?? null)
            ->setLastStoryCreatedTimeAgo($data['lastStoryCreatedTimeAgo'])
            ->setLastStoryCreatedTimestamp($data['lastStoryCreatedTimestamp'])
            ->setStories(array_map(fn (array $story) => Story::fromArray($story), $data['stories']));
    }
}
