<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Integrations;

// @phpcs:disable WordPress.Security.NonceVerification.Missing
// @phpcs:disable WordPress.Security.NonceVerification.Recommended

use BeycanPress\SnapTales\PluginHero\Helpers;

class MetaBoxes
{
    /**
     * Class construct
     * @return void
     */
    public function __construct()
    {
        // @phpstan-ignore-next-line
        add_action('post_updated', [$this, 'saveStoryVisibility'], 10, 3);

        add_action('add_meta_boxes', function (): void {
            // Post and product post type
            $postTypes = ['post'];

            if (defined('BP_SNAP_TALES_PRO_LOADED')) {
                $postTypes[] = 'product';
            }

            add_meta_box(
                'snap_tales_post_and_product_story_visibility',
                esc_html__('Story settings', 'snap-tales'),
                [$this, 'postAndProductStoryVisibility'],
                $postTypes,
                'side',
                'high'
            );
        });
    }

    /**
     * Post type story setting
     * @param object $post
     * @return void
     */
    public function postAndProductStoryVisibility(object $post): void
    {
        Helpers::createNewNonceField();
        $mediaURL = get_post_meta($post->ID, 'snap_tales_media_url', true);
        $storyVisibility = get_post_meta($post->ID, 'snap_tales_story_visibility', true);

        wp_enqueue_media();
        Helpers::addScript('backend.min.js', ['wp-i18n']);

        Helpers::viewEcho('meta-box', [
            'storyVisibility' => $storyVisibility,
            'mediaURL' => $mediaURL
        ]);
    }

    /**
     * Story creator save
     * @param integer $postId current post
     * @param object $postAfter post saved after data
     * @return int
     */
    public function saveStoryVisibility(int $postId, object $postAfter): int
    {
        // Permission control
        $postType = get_post_type_object($postAfter->post_type);
        if (!current_user_can($postType->cap->edit_post, $postId)) {
            return $postId;
        }

        // Post type control
        if ('post' !== $postAfter->post_type && 'product' !== $postAfter->post_type) {
            return $postId;
        }

        // Nonce control
        if (!Helpers::checkNonceField()) {
            return $postId;
        }

        // Autosave control
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $postId;
        }

        if (isset($_POST['snap_tales'])) {
            $storyVisibility = isset($_POST['snap_tales']['story_visibility']) ? sanitize_text_field($_POST['snap_tales']['story_visibility']) : null; // phpcs:ignore
            $mediaURL = isset($_POST['snap_tales']['media_url']) ? esc_url_raw($_POST['snap_tales']['media_url']) : null; // phpcs:ignore

            update_post_meta($postId, 'snap_tales_media_url', $mediaURL);
            update_post_meta($postId, 'snap_tales_story_visibility', $storyVisibility);
        }

        return $postId;
    }
}
