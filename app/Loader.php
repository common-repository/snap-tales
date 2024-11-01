<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales;

use BeycanPress\SnapTales\PluginHero\Helpers;

class Loader extends PluginHero\Plugin
{
    /**
     * @param string $pluginFile
     */
    public function __construct(string $pluginFile)
    {
        parent::__construct([
            'pluginFile' => $pluginFile,
            'textDomain' => 'snap-tales',
            'pluginKey' => 'snap-tales',
            'settingKey' => 'snap-tales-settings'
        ]);

        Helpers::feedback(true, 'snap-tales');

        add_action('plugins_loaded', function (): void {
            new Integrations\Register();
        });

        new Shortcode\Manager();

        add_filter(
            'plugin_action_links_' . plugin_basename(Helpers::getProp('pluginFile')),
            [$this, 'pluginActionLinks']
        );
    }

    /**
     * @param array<string,string> $links
     * @return array<string,string>
     */
    public function pluginActionLinks(array $links): array
    {
        // @phpcs:disable
        $links[] = '<a href="https://beycanpress.com/snap-tales/?utm_source=free_version&utm_medium=plugins_list" style="color: #389e38;font-weight: bold;" target="_blank">' . __('Buy Premium', 'snap-tales') . '</a>';
        $links[] = '<a href="' . admin_url('admin.php?page=snap-tales-settings') . '">' . __('Settings', 'snap-tales') . '</a>';
        $links[] = '<a href="https://beycanpress.gitbook.io/snap-tales-docs/" target="_blank">' . __('Documentation', 'snap-tales') . '</a>';
        // @phpcs:enable

        return $links;
    }

    /**
     * @return void
     */
    public function adminProcess(): void
    {
        new Pages\AdminStory();
        new Pages\AdminStoryBox();

        if (file_exists(Helpers::getProp('pluginDir') . '/debug.log')) {
            new Pages\DebugLogs();
        }

        add_action('init', function (): void {
            new Settings();
        }, 9);
    }

    /**
     * @return void
     */
    public static function uninstall(): void
    {
        if (Settings::get('dds')) {
            delete_option(Helpers::getProp('settingKey'));
        }
    }
}
