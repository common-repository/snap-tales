<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Integrations;

// @phpcs:disable WordPress.Security.NonceVerification.Missing
// @phpcs:disable WordPress.Security.NonceVerification.Recommended

use BeycanPress\SnapTales\Settings;
use BeycanPress\SnapTales\PluginHero\Helpers;

class CategoryImage
{
    /**
     * Class construct
     * @return void
     */
    public function __construct()
    {
        if (is_admin()) {
            add_action('edited_category', [$this, 'saveCategoryImage'], 10, 1);
            add_action('create_category', [$this, 'saveCategoryImage'], 10, 1);
            add_action('category_add_form_fields', [$this, 'addInputCategoryAddPage']);
            add_action('category_edit_form_fields', [$this, 'addInputCategoryEditPage'], 10, 1);
            // @phpstan-ignore-next-line
            add_action('manage_edit-category_columns', [$this, 'showImageInCategoryList'], 10, 1);
            // @phpstan-ignore-next-line
            add_action('manage_category_custom_column', [$this, 'showImageInCategoryListNext'], 10, 3);
        }
    }

    /**
     * Show in the add new category field
     * @return void
     */
    public function addInputCategoryAddPage(): void
    {
        wp_enqueue_media();
        Helpers::addScript('backend.min.js', ['wp-i18n']);
        Helpers::viewEcho('category-image/add-input');
    }

    /**
     * Show in the edit category field
     * @param object $term
     * @return void
     */
    public function addInputCategoryEditPage(object $term): void
    {
        wp_enqueue_media();
        Helpers::addScript('backend.min.js', ['wp-i18n']);
        $imageURL = get_option(
            "bp_taxonomy_" . $term->term_id . "_image",
            Settings::get('default_category_image', '')
        );
        Helpers::viewEcho('category-image/edit-input', ['imageURL' => $imageURL]);
    }

    /**
     * @param integer $termId
     * @return void
     */
    public function saveCategoryImage(int $termId): void
    {
        if (isset($_POST['snap-tales-category-image-url'])) {
            $imageURL = esc_url_raw($_POST['snap-tales-category-image-url']);
            update_option("bp_taxonomy_" . $termId . "_image", $imageURL);
        }
    }

    /**
     * add column for image
     * @param array<mixed> $defaults
     * @return array<mixed>
     */
    public function showImageInCategoryList(array $defaults): array
    {
        $cb = $defaults["cb"];
        array_shift($defaults);
        return array_merge(
            ["cb" => $cb, "snap_tales_category_image" => esc_html__('Image:', 'snap-tales')],
            $defaults
        );
    }

    /**
     * Add thumbnail image to the category list
     * @param string $par
     * @param string $col col name
     * @param integer $catId current category id
     * @return string
     */
    public function showImageInCategoryListNext(string $par, string $col, int $catId): string
    {
        if ("snap_tales_category_image" == $col) {
            $imageURL = get_option('bp_taxonomy_' . $catId . '_image');
            if ($imageURL) {
                return '<img src="' . esc_url($imageURL) . '" width="50" height="50" alt="' . esc_html__('Category image:', 'snap-tales') . '">'; // phpcs:ignore
            } else {
                return '<img src="' . esc_url(Settings::get('default_category_image', '')) . '" width="50" height="50" alt="' . esc_html__('Category image:', 'snap-tales') . '">'; // phpcs:ignore
            }
        }
        return $par;
    }
}
