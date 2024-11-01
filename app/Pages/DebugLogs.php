<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Pages;

// @phpcs:disable WordPress.Security.NonceVerification.Missing
// @phpcs:disable WordPress.Security.NonceVerification.Recommended

use BeycanPress\SnapTales\PluginHero\Page;
use BeycanPress\SnapTales\PluginHero\Helpers;

class DebugLogs extends Page
{
    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct([
            'priority' => 11,
            'parent' => 'snap-tales',
            'pageName' => esc_html__('Debug logs', 'snap-tales'),
        ]);
    }

    /**
     * @return void
     */
    public function page(): void
    {
        if ($_POST['delete'] ?? 0) {
            Helpers::deleteLogFile();
        }

        Helpers::viewEcho('pages/debug-logs', [
            'logs' => Helpers::getLogFile(),
            'pageUrl' => Helpers::getCurrentUrl()
        ]);
    }
}
