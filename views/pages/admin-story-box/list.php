<?php
    if ( ! defined( 'ABSPATH' ) ) exit;
    use BeycanPress\SnapTales\PluginHero\Table;
    use BeycanPress\SnapTales\PluginHero\Helpers;
?>
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?php echo esc_html__('Story boxes', 'snap-tales'); ?>
    </h1>
    <a href="<?php echo esc_url(Helpers::getCurrentUrl() . '&add-new=1'); ?>" class="page-title-action">
        <?php echo esc_html__('Add New', 'snap-tales'); ?>
    </a>
    <hr class="wp-header-end">
    <br>
    <?php
        /** @var Table $table */
        Helpers::ksesEcho($table->renderWpTable());
    ?>
</div>