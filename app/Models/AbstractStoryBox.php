<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Models;

// Classes
use BeycanPress\SnapTales\PluginHero\Model\AbstractModel;

abstract class AbstractStoryBox extends AbstractModel
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
        $this->tableName = 'snap_tales_story_box_' . $tableName;

        parent::__construct([
            'title' => [
                'type' => 'text',
                'length' => 50,
                'index' => [
                    'type' => 'unique'
                ]
            ],
            'thumbnail' => [
                'type' => 'text',
            ],
            'status' => [
                'type' => 'smallint'
            ],
            'updatedAt' => [
                'type' => 'timestamp'
            ],
            'createdAt' => [
                'type' => 'timestamp',
                'default' => 'current_timestamp',
            ]
        ]);

        $this->createTable();
    }
}
