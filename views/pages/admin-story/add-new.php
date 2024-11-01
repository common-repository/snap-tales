<?php
    if ( ! defined( 'ABSPATH' ) ) exit;
    use BeycanPress\SnapTales\PluginHero\Helpers;
?>
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?php echo esc_html__('Add new story', 'snap-tales'); ?>
    </h1>
    <hr class="wp-header-end">
    <form action="<?php echo esc_url(Helpers::getCurrentUrl()); ?>" method="post">
        <?php Helpers::createNewNonceField(); ?>
        <input type="hidden" name="add-new" value="1">
        <?php Helpers::viewEcho('pages/admin-story/form', [
            'storyBoxes' => $storyBoxes
        ]); ?>
    </form>
</div>
