<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales;

class Constants
{
    /**
     * @return array<string>
     */
    public static function lang(): array
    {
        return [
            'now' => __('now', 'snap-tales'),
            'story' => __('Story', 'snap-tales'),
            'close' => __('Close', 'snap-tales'),
            'cancel' => __('Cancel', 'snap-tales'),
            'delete' => __('Delete', 'snap-tales'),
            'confirm' => __('Confirm', 'snap-tales'),
            'publish' => __('Publish', 'snap-tales'),
            'seeMore' => __('See More', 'snap-tales'),
            'enterURL' => __('Enter URL', 'snap-tales'),
            'pleaseWait' => __('Please wait...', 'snap-tales'),
            'noFileSelected' => __('No file selected', 'snap-tales'),
            'addExternalURL' => __('Add External URL', 'snap-tales'),
            'selectNewMedia' => __('Select New Media', 'snap-tales'),
            'somethingWentWrong' => __('Something went wrong!', 'snap-tales'),
            'youWantDeleteStory' => __('Are you sure you want to delete this story?', 'snap-tales'),
            'invalidURL' => __('You entered an invalid URL, please enter a correct URL!', 'snap-tales')
        ];
    }
}
