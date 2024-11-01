<?php
    if ( ! defined( 'ABSPATH' ) ) exit;
    // @phpcs:disable WordPress.Security.NonceVerification.Missing
    // @phpcs:disable WordPress.Security.NonceVerification.Recommended
    use BeycanPress\SnapTales\Types\Story;
    use BeycanPress\SnapTales\PluginHero\Helpers;
?>
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?php echo esc_html__('Story edit', 'snap-tales'); ?>
    </h1>
    <hr class="wp-header-end">
    <form action="<?php echo esc_url(Helpers::getCurrentUrl()); ?>" method="post">
        <?php Helpers::createNewNonceField(); ?>
        <input type="hidden" name="edit" value="1">
        <input type="hidden" name="story_id" value="<?php echo esc_attr(sanitize_text_field($_GET['edit'])); ?>">
        <?php 
            /** @var Story $story */
            Helpers::viewEcho('pages/admin-story/form', [
                'storyBoxId' => $story->parentId,
                'mediaURL' => $story->mediaURL,
                'externalURL' => $story->externalURL,
                'showUntil' => $story->showUntil,
                'status' => $story->status
            ]);
        ?>
    </form><!-- form -->
</div>