<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Models;

// Classes
use BeycanPress\SnapTales\PluginHero\Model\AbstractModel;

abstract class AbstractStory extends AbstractModel
{
    /**
     * @var string
     */
    public string $version = '1.0.0';

    /**
     * @param string $tableName
     */
    public function __construct(string $tableName)
    {
        $this->tableName = 'snap_tales_story_' . $tableName;

        parent::__construct([
            'userId' => [
                'type' => 'bigint',
            ],
            'parentId' => [
                'type' => 'bigint',
                'nullable' => true,
            ],
            'externalURL' => [
                'type' => 'text',
                'nullable' => true,
            ],
            'mediaURL' => [
                'type' => 'text',
            ],
            'likes' => [
                'type' => 'bigint',
                'default' => 0,
            ],
            'status' => [
                'type' => 'smallint',
                'default' => 1,
            ],
            'showUntil' => [
                'type' => 'datetime',
                'nullable' => true,
                'default' => null,
            ],
            'updatedAt' => [
                'type' => 'datetime'
            ],
            'createdAt' => [
                'type' => 'timestamp',
                'default' => 'current_timestamp',
            ],
        ]);

        $this->createTable();
    }
}
