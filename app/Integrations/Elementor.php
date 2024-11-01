<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Integrations;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use BeycanPress\SnapTales\PluginHero\Hook;

// @phpcs:disable PSR2.Methods.MethodDeclaration.Underscore
// @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

/**
 * Elementor short code selector
 */
class Elementor extends Widget_Base
{
    /**
     * Retrieve the widget name.
     *
     * @since 2.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name(): string
    {
        return 'snap-tales';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 2.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title(): string
    {
        return esc_html__('Snap Tales', 'snap-tales');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 2.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon(): string
    {
        return 'eicon-image-bold';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 2.0.0
     *
     * @access public
     *
     * @return array<string> Widget categories.
     */
    public function get_categories(): array
    {
        return ['general'];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 2.0.0
     *
     * @access protected
     * @return void
     */
    protected function _register_controls(): void
    {
        /** @disregard */
        // @phpstan-ignore-next-line
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Select stories shortcode', 'snap-tales'),
            ]
        );

        /** @disregard */
        // @phpstan-ignore-next-line
        $this->add_control(
            'storiesShortcode',
            [
                'label'       => esc_html__('Title', 'snap-tales'),
                // @phpstan-ignore-next-line
                'type'        => Controls_Manager::SELECT,
                'default'     => "[snap-tales mode='admin']",
                'options'     => Hook::callFilter('elementor_shortcodes', [
                    "[snap-tales mode='admin']"   => esc_html__('Admin stories', 'snap-tales'),
                    "[snap-tales mode='post']"    => esc_html__('Post stories', 'snap-tales')
                ]),
            ]
        );

        /** @disregard */
        // @phpstan-ignore-next-line
        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 2.0.0
     *
     * @access protected
     * @return void
     */
    protected function render(): void
    {
        /** @disregard */
        // @phpstan-ignore-next-line
        echo wp_kses_post($this->get_settings_for_display('stories') ?? '');
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.0.0
     *
     * @access protected
     * @return void
     */
    protected function _content_template(): void
    {
        ?> {{{ settings.storiesShortcode }}} <?php // phpcs:ignore
    }
}
