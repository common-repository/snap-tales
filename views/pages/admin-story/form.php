<?php
    if ( ! defined( 'ABSPATH' ) ) exit;
    // @phpcs:disable WordPress.Security.NonceVerification.Missing
    // @phpcs:disable WordPress.Security.NonceVerification.Recommended
?>
<div id="poststuff">
    <div id="post-body" class="metabox-holder columns-2">

        <div id="postbox-container-1" class="postbox-container">
            <div class="postbox">
                <div class="postbox-header">
                    <h2><?php echo isset($_GET['edit']) ? esc_html__('Edit story', 'snap-tales') : esc_html__('Add story', 'snap-tales'); ?></h2>
                </div>
                <div class="inside">
                    <div class="minor-publishing">

                    
                        <p class="post-attributes-label-wrapper page-template-label-wrapper">
                            <label class="post-attributes-label">
                                <?php echo esc_html__('Story box', 'snap-tales'); ?>
                            </label>
                        </p>
                        <?php 
                            use BeycanPress\SnapTales\Models\AdminStoryBox as StoryBoxModel;
                            if (!isset($storyBoxes)) {
                                $storyBoxes = (new StoryBoxModel())->findAll();
                            }
                        ?>
                        <select name="story_box_id" class="widefat">
                            <?php foreach ($storyBoxes as $key => $value) { ?>
                                <option value="<?php echo esc_attr($value->id); ?>" <?php echo isset($storyBoxId) && $storyBoxId == $value->id ? 'selected' : null ?>>
                                    <?php echo esc_html($value->title); ?>
                                </option>
                            <?php } ?>
                        </select>

                        <?php if (isset($_GET['edit'])) { ?>
                            <p class="post-attributes-label-wrapper page-template-label-wrapper">
                                <label class="post-attributes-label">
                                    <?php echo esc_html__('Status', 'snap-tales'); ?>
                                </label>
                            </p>
                            <select name="status" class="widefat">
                                <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : null ?>>
                                    <?php echo esc_html__('Active', 'snap-tales'); ?>
                                </option>
                                <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : null ?>>
                                    <?php echo esc_html__('Passive', 'snap-tales'); ?>
                                </option>
                            </select>
                        <?php } ?>

                        <div class="minor-publishing-actions" style="padding:10px 0 0 0">
                            <button type="submit" class="button button-primary">
                                <?php echo isset($_GET['edit']) ? esc_html__('Edit story', 'snap-tales') : esc_html__('Add story', 'snap-tales'); ?>
                            </button>
                            <div class="clear"></div>
                        </div><!-- .minor-publishing-actions -->

                    </div><!-- .minor-publishing -->
                </div><!-- .inside -->
            </div><!-- .postbox -->
        </div><!-- #postbox-container-1 -->

        <div id="postbox-container-2" class="postbox-container">
            <div class="postbox">
                <div class="postbox-header">
                    <h2><?php echo esc_html__('Story properties', 'snap-tales'); ?></h2>
                </div>
                <div class="inside">
                    <p class="post-attributes-label-wrapper page-template-label-wrapper">
                        <label class="post-attributes-label">
                            <?php echo esc_html__('Show until date: (If you leave it blank it will always appear.)', 'snap-tales'); ?>
                        </label>
                    </p>
                    <input type="datetime-local" class="widefat" name="show_until" value="<?php echo isset($showUntil) ? esc_attr($showUntil) : null; ?>">

                    <p class="post-attributes-label-wrapper page-template-label-wrapper">
                        <label class="post-attributes-label">
                            <?php echo esc_html__('External URL: (optional)', 'snap-tales'); ?>
                        </label>
                    </p>
                    <input type="url" class="widefat" name="external_url" value="<?php echo isset($externalURL) ? esc_url($externalURL) : null; ?>">
                    
                    <p class="post-attributes-label-wrapper page-template-label-wrapper">
                        <label class="post-attributes-label">
                            <?php echo esc_html__('Media URL: (required)', 'snap-tales'); ?>
                        </label>
                    </p>
                    <input type="url" class="widefat snap-tales-media-url" name="media_url" value="<?php echo isset($mediaURL) ? esc_url($mediaURL) : null; ?>" required>
                    <button type="button" class="button snap-tales-select-media" style="margin-top: 10px">
                        <?php echo esc_html__('Select story media', 'snap-tales'); ?>
                    </button>
                </div><!-- .inside -->
            </div><!-- .postbox -->
        </div><!-- .postbox-container-2 -->

    </div><!-- #bost-body -->
    <div class="clear"></div>
</div><!-- #poststuff -->