<?php
    if ( ! defined( 'ABSPATH' ) ) exit;
    // @phpcs:disable WordPress.Security.NonceVerification.Missing
    // @phpcs:disable WordPress.Security.NonceVerification.Recommended
    use BeycanPress\SnapTales\Types\StoryBox;
    use BeycanPress\SnapTales\PluginHero\Helpers;
?>
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?php echo esc_html__('Edit story box', 'snap-tales'); ?>
    </h1>
    <hr class="wp-header-end">
    <form action="<?php echo esc_url(Helpers::getCurrentUrl()); ?>" method="post">
        <?php Helpers::createNewNonceField(); ?>
        <input type="hidden" name="edit" value="1">
        <input type="hidden" name="id" value="<?php echo esc_attr(sanitize_text_field($_GET['edit'])); ?>">
        <?php 
            /** @var StoryBox $storyBox */
            Helpers::viewEcho('pages/admin-story-box/form', [
                'title' => $storyBox->title,
                'thumbnail' => $storyBox->thumbnail,
                'status' => $storyBox->status
            ]);
        ?>
    </form><!-- form -->
</div>