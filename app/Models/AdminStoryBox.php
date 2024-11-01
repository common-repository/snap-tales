<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Models;

final class AdminStoryBox extends AbstractStoryBox
{
    /**
     * @var AdminStory
     */
    public AdminStory $storyModel;

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct('admin');
        $this->storyModel = new AdminStory();
    }

    /**
     * @return array<mixed>
     */
    public function getWithStories(): array
    {
        $query = "SELECT 
            sb.*,
            JSON_ARRAYAGG(
                JSON_OBJECT(
                    'id', s.id,
                    'userId', s.userId,
                    'parentId', s.parentId,
                    'externalURL', s.externalURL,
                    'mediaURL', s.mediaURL,
                    'likes', s.likes,
                    'status', s.status,
                    'showUntil', s.showUntil,
                    'updatedAt', s.updatedAt,
                    'createdAt', s.createdAt
                )
            ) AS stories
        FROM 
            {$this->tableName} sb
        LEFT JOIN 
            {$this->storyModel->tableName} s ON sb.id = s.parentId
        WHERE sb.status = 1 AND s.status = 1 
        AND (s.showUntil IS NULL OR s.showUntil >= NOW())
        GROUP BY sb.id
        ORDER BY s.createdAt ASC;";

        return $this->getResults($query, ARRAY_A);
    }
}
