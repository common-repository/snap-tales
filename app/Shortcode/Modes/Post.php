<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Shortcode\Modes;

use BeycanPress\SnapTales\Settings;
use BeycanPress\SnapTales\Types\Story;
use BeycanPress\SnapTales\Types\StoryBox;
use BeycanPress\SnapTales\PluginHero\Helpers;

class Post extends Mode
{
    /**
     * @var string
     */
    public string $id = 'post';

    /**
     * @return array<StoryBox>
     */
    protected function prepareStruct(): array
    {
        $storyBoxes = [];
        $categories = get_terms(['taxonomy' => 'category']);

        foreach ($categories as $category) {
            $stories = [];
            if (0 !== $category->count && 0 === $category->parent) {
                // @phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_query
                $args = [
                    'paged'          => 1,
                    'order'          => 'ASC',
                    'post_type'      => 'post',
                    'post_status'    => 'publish',
                    'cat'            => $category->term_id,
                    'posts_per_page' => Settings::get('story_limit', 5),
                    'meta_query'     => [
                        [
                            'value' => 'on',
                            'key' => 'snap_tales_story_visibility',
                        ]
                    ]
                ];

                $postList = new \WP_Query($args);

                if ($postList->have_posts()) {
                    foreach ($postList->posts as $post) {
                        $mediaURL = get_post_meta($post->ID, 'snap_tales_media_url', true);

                        if (empty($mediaURL)) {
                            $mediaURL = get_the_post_thumbnail_url($post->ID);
                            if (empty($mediaURL)) {
                                $mediaURL = Settings::get('default_media_url');
                            }
                        }

                        $stories[] = [
                            'id' => $post->ID,
                            'mediaURL' => $mediaURL,
                            'parentId' => $category->term_id,
                            'createdAt' => $post->post_date,
                            'updatedAt' => $post->post_modified,
                            'userId' => absint($post->post_author),
                            'externalURL' => get_the_permalink($post->ID),
                            'createdTimeAgo' => Helpers::dateToTimeAgo($post->post_date)
                        ];
                    }

                    $storyBoxImage = get_option(
                        "taxonomy_" . $category->term_id . "_image",
                        Settings::get('default_category_image')
                    );

                    /** @var Story $lastStory */
                    $lastStory = end($stories);
                    $storyBoxes[] = StoryBox::fromArray([
                        'stories' => $stories,
                        'id' => $category->term_id,
                        'title' => $category->slug,
                        'thumbnail' => $storyBoxImage,
                        'updatedAt' => $lastStory['updatedAt'],
                        'createdAt' => $lastStory['createdAt'],
                        'redirectURL' => get_category_link($category->term_id),
                        'lastStoryCreatedTimeAgo' => $lastStory['createdTimeAgo'],
                        'lastStoryCreatedTimestamp' => strtotime($lastStory['createdAt'])
                    ]);
                }
            }
        }

        return $storyBoxes;
    }
}
