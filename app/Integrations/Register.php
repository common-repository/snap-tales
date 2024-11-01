<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Integrations;

use Elementor\Plugin;
use BeycanPress\SnapTales\PluginHero\Hook;
use BeycanPress\SnapTales\PluginHero\Helpers;

class Register
{
    /**
     * class construct
     */
    public function __construct()
    {
        new MetaBoxes();
        new CategoryImage();

        Hook::callAction('register_integrations');

        // Register Gutenberg block
        add_action('enqueue_block_editor_assets', function (): void {
            global $pagenow;
            if ('widgets.php' === $pagenow) {
                $deps = ['wp-edit-widgets'];
            } elseif ('post.php' === $pagenow || 'post-new.php' === $pagenow) {
                $deps = ['wp-editor'];
            }
            Helpers::addScript('gutenberg.min.js', array_merge([
                'wp-blocks',
                'wp-i18n',
                'wp-hooks',
                'jquery'
            ], $deps ?? []));
        });

        // Register Elementor integration
        if (defined('ELEMENTOR_VERSION')) {
            add_action('elementor/widgets/widgets_registered', function (): void {
                // @phpstan-ignore-next-line
                Plugin::instance()->widgets_manager->register_widget_type(new Elementor());
            });
        }

        // Register TinyMCE button
        add_action('admin_head', function (): void {
            add_filter('mce_external_plugins', function ($pluginArray) {
                $url = Helpers::getProp('pluginUrl');
                $pluginArray['snap-tales'] = $url . 'assets/js/tinymce.min.js';
                return $pluginArray;
            });
            add_filter('mce_buttons', function ($buttons) {
                array_push($buttons, 'snap-tales');
                return $buttons;
            });
        });
    }
}
