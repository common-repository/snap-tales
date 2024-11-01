<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Shortcode;

use BeycanPress\SnapTales\RestAPI;
use BeycanPress\SnapTales\Settings;
use BeycanPress\SnapTales\Constants;
use BeycanPress\SnapTales\PluginHero\Hook;
use BeycanPress\SnapTales\PluginHero\Helpers;
use BeycanPress\SnapTales\Shortcode\Modes\Mode;

class Manager
{
    /**
     * @var array<Mode>
     */
    protected array $modes = [];

    /**
     * @var array<string>|null
     */
    private ?array $deps = null;

    /**
     * @var RestAPI
     */
    private RestAPI $restAPI;

    /**
     * @var string
     */
    private string $key;

    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('init', [$this, 'init']);
        add_action('wp_footer', [$this, 'wpFooter']);
    }

    /**
     * Initialize the shortcode
     *
     * @return void
     */
    public function init(): void
    {
        $this->key = md5(strval(wp_rand(0, 1000)));

        $this->modes = Hook::callFilter('register_modes', [
            new Modes\Admin(),
            new Modes\Post()
        ]);

        $this->restAPI = new RestAPI($this->modes);

        add_shortcode('snap-tales', [$this, 'shortcode']);
    }

    /**
     * Add the script to the footer
     *
     * @return void
     */
    public function wpFooter(): void
    {
        if (!is_null($this->deps)) {
            $params = Hook::callFilter('init_params', [
                'key' => $this->key,
                'lang' => Constants::lang(),
                'apiUrl' => $this->restAPI->getUrl()
            ]);
            $scriptKey = Helpers::addScript('app.min.js', $this->deps);
            wp_localize_script($scriptKey, 'SnapTales', $params);
        }
    }

    /**
     * Shortcode handler
     *
     * @param array<mixed> $atts
     * @return string
     */
    public function shortcode(array $atts): string
    {
        $atts = shortcode_atts([
            'mode' => 'admin'
        ], $atts);

        $mode = $atts['mode'];
        $id = 'snap-tales-' . $mode;

        $isModeExists = array_filter($this->modes, function (Mode $m) use ($mode) {
            return $m->id === $mode;
        });

        if (empty($isModeExists)) {
            return esc_html__('Invalid mode', 'snap-tales');
        }

        if (false === Hook::callFilter('is_enabled', true, $mode)) {
            return Hook::callFilter('disabled_message', '', $mode);
        }

        $args = Hook::callFilter('args', [], $mode);
        $deps = Hook::callFilter('deps', [], $mode);
        $args = Hook::callFilter('args_' . $mode, $args, $mode);
        $deps = Hook::callFilter('deps_' . $mode, $deps, $mode);

        $this->deps = array_merge($this->deps ?? [], $deps);

        $template = Hook::callFilter('template', Helpers::view('snap-tales', [
            'id' => $id,
            'mode' => $mode,
            'args' => $args,
            'key' => $this->key
        ]), $mode);

        return Hook::callFilter('template_' . $mode, $template, $mode);
    }
}
