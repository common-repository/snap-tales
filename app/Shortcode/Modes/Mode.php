<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Shortcode\Modes;

use BeycanPress\SnapTales\Types\StoryBox;

abstract class Mode
{
    /**
     * Shortcode ID
     *
     * @var string
     */
    public string $id;

    /**
     * Get story boxes
     *
     * @return array<StoryBox>
     */
    abstract protected function prepareStruct(): array;

    /**
     * Get story boxes
     *
     * @return array<StoryBox>
     */
    public function get(): array
    {
        $storyBoxes = $this->prepareStruct();

        /** @var array<StoryBox> $storyBoxes */
        usort($storyBoxes, function (StoryBox $a, StoryBox $b) {
            $result = $a->lastStoryCreatedTimestamp < $b->lastStoryCreatedTimestamp;
            return $result ? 1 : -1;
        });

        return $storyBoxes;
    }

    /**
     * Get story boxes as array
     *
     * @return array<mixed>
     */
    public function getArray(): array
    {
        return array_map(function ($box) {
            return $box->toArray();
        }, $this->get());
    }
}
