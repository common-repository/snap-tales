<?php

declare(strict_types=1);

// @phpcs:disable Generic.Files.LineLength 

namespace BeycanPress\SnapTales;

use BeycanPress\SnapTales\PluginHero\Hook;

class Settings extends PluginHero\Setting
{
    /**
     * @return void
     */
    public function __construct()
    {
        $parent = PluginHero\Helpers::getPage('AdminStory')->getSlug();
        parent::__construct(esc_html__('Settings', 'snap-tales'), $parent);

        // self::createSection([
        //     'id'     => 'generalSettings',
        //     'title'  => esc_html__('General settings', 'snap-tales'),
        //     'icon'   => 'fa fa-cog',
        //     'fields' => [
        //         [
        //             'id'      => 'dds',
        //             'title'   => esc_html__('Data deletion status', 'snap-tales'),
        //             'type'    => 'switcher',
        //             'default' => false,
        //             'help'    => esc_html__('This setting is passive come by default. You enable this setting. All data created by the plug-in will be deleted while removing the plug-in.', 'snap-tales')
        //         ],
        //         [
        //             'id'      => 'debugging',
        //             'title'   => esc_html__('Debugging', 'snap-tales'),
        //             'type'    => 'switcher',
        //             'default' => false,
        //             'desc'    => esc_html__('The Debug menu will appear when this setting is turned on and the log file is created.', 'snap-tales'),
        //             'help'    => esc_html__('This setting has been added for the developer team rather than the users. If you open a support ticket to us due to a bug, we will use this setting to check the plugin progress.', 'snap-tales')
        //         ],
        //     ]
        // ]);

        self::createSection([
            'id'     => 'default_options',
            'title'  => esc_html__('Default options', 'snap-tales'),
            'icon'   => 'fa fa-cogs',
            'fields' => [
                [
                    'id'      => 'default_category_image',
                    'title'   => esc_html__('Default category image', 'snap-tales'),
                    'type'    => 'upload',
                    'help'    => esc_html__('This will appear if there is no picture of the category when the posts are listed as stories.', 'snap-tales')
                ],
                [
                    'id'      => 'default_media_url',
                    'title'   => esc_html__('Default media', 'snap-tales'),
                    'type'    => 'upload',
                    'help'    => esc_html__('Appears if you haven\'t selected a featured image and story media when adding posts and products.', 'snap-tales')
                ],
                [
                    'id'      => 'story_limit',
                    'title'   => esc_html__('Story limit', 'snap-tales'),
                    'type'    => 'number',
                    'default' => 5,
                    'help'    => esc_html__('The maximum number of products and posts to appear as stories in a category.', 'snap-tales')
                ],
            ]
        ]);

        if (!defined('BP_SNAP_TALES_PRO_LOADED')) {
            self::createSection([
                'id'     => 'pro_benefits',
                'title'  => esc_html__('Pro benefits', 'snap-tales'),
                'icon'   => 'fa fa-star',
                'fields' => [
                    [
                        'id' => 'buy_pro',
                        'type' => 'content',
                        'content' => esc_html__('Unlock the following features by purchasing Snap Tales Pro.', 'snap-tales') . '<br><br>
                        <a href="https://beycanpress.com/snap-tales" target="_blank">' . esc_html__('Review and Buy Pro', 'snap-tales') . '</a>',
                        'title' => esc_html__('Buy Snap Tales Pro', 'snap-tales')
                    ],
                    [
                        'id'      => 'product_stories',
                        'title'   => esc_html__('Product stories', 'snap-tales'),
                        'type'    => 'content',
                        'content' => esc_html__('With Snap Tales pro, you can list your WooCommerce products as stories so that you can feature your products on your homepage.', 'snap-tales'),
                    ],
                    [
                        'id'      => 'user_stories',
                        'title'   => esc_html__('User stories', 'snap-tales'),
                        'type'    => 'content',
                        'content' => esc_html__('If you have a community website, which means you have users, you can access the feature that allows your users to create their own stories, so they can share stories on their own accounts.', 'snap-tales'),
                    ],
                    [
                        'id'      => 'integrated_with_other_plugins',
                        'title'   => esc_html__('Integrated with other plugins', 'snap-tales'),
                        'type'    => 'content',
                        'content' => sprintf(
                            /* translators: %1$s: <br><br>, %2$s: <br><br>, %3$s: <br><br>, %4$s: <b>BuddyPress</b>, <b>PeepSo</b>, <b>bbPress</b> */
                            esc_html__(
                                'The current free version already includes blocks for plugins like Elementor, Gutenberg, etc.
                                %1$s
                                However, if user stories are the feature you want, we have good news for you.
                                %2$s
                                Snap Tales Pro is integrated with all of the following plugins and in the settings you can enable users to see only their friends stories.
                                %3$s
                                %4$s
                                ',
                                'snap-tales'
                            ),
                            '<br><br>',
                            '<br><br>',
                            '<br><br>',
                            '<b>BuddyPress</b>, <b>PeepSo</b>, <b>bbPress</b>'
                        ),
                    ],
                ]
            ]);
        }

        Hook::callAction('register_settings');

        self::createSection([
            'id'     => 'backup',
            'title'  => esc_html__('Backup', 'snap-tales'),
            'icon'   => 'fas fa-shield-alt',
            'fields' => [
                [
                    'type'  => 'backup',
                    'title' => esc_html__('Backup', 'snap-tales')
                ],
            ]
        ]);
    }
}
