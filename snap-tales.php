<?php

declare(strict_types=1);

defined('ABSPATH') || exit;

// @phpcs:disable PSR1.Files.SideEffects
// @phpcs:disable Generic.Files.LineLength 

/**
 * Plugin Name: Snap Tales
 * Version:     1.0.0
 * Plugin URI:  https://beycanpress.com/snap-tales/
 * Description: Instagram Style Stories
 * Author:      BeycanPress LLC
 * Author URI:  https://beycanpress.com/
 * License:     GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: snap-tales
 * Domain Path: /languages
 * Tags:        Instagram, Stories, Instagram Stories, Instagram Style Stories, Instagram Stories for WordPress, Instagram Style Stories for WordPress
 * Requires at least: 5.0
 * Tested up to: 6.6
 * Requires PHP: 8.1
*/

require __DIR__ . '/vendor/autoload.php';
use BeycanPress\SnapTales\PluginHero\Helpers;

$args = [
    'phpVersions' => [8.1, 8.2],
    'extensions' => [
        'curl',
        'file_get_contents',
    ]
];

// Check requirements and load the plugin
if (Helpers::createRequirementRules($args, __FILE__)) {
    define('BP_SNAP_TALES_LOADED', true);
    new \BeycanPress\SnapTales\Loader(__FILE__);
}
