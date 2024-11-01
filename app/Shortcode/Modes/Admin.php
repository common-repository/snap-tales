<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Shortcode\Modes;

use BeycanPress\SnapTales\Types\StoryBox;
use BeycanPress\SnapTales\PluginHero\Helpers;
use BeycanPress\SnapTales\Models\AdminStoryBox;

class Admin extends Mode
{
    /**
     * @var string
     */
    public string $id = 'admin';

    /**
     * @var AdminStoryBox
     */
    public AdminStoryBox $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->model = new AdminStoryBox();
    }

    /**
     * Get story boxes
     *
     * @return array<StoryBox>
     */
    protected function prepareStruct(): array
    {
        return array_map(function ($box) {
            if (isset($box['stories'])) {
                $box['stories'] = json_decode($box['stories'], true);
            } else {
                $box['stories'] = [];
            }

            $box['stories'] = array_map(function ($story) {
                return array_merge($story, [
                    'createdTimeAgo' => Helpers::dateToTimeAgo($story['createdAt'])
                ]);
            }, $box['stories']);

            $lastStory = end($box['stories']);
            $box['lastStoryCreatedTimeAgo'] = $lastStory['createdTimeAgo'];
            $box['lastStoryCreatedTimestamp'] = strtotime($lastStory['createdAt']);

            return StoryBox::fromArray($box);
        }, $this->model->getWithStories());
    }
}
