<?php
    if ( ! defined( 'ABSPATH' ) ) exit;
    // @phpcs:disable WordPress.Security.NonceVerification.Missing
    // @phpcs:disable WordPress.Security.NonceVerification.Recommended
?>
<div id="poststuff">
    <div id="post-body" class="metabox-holder columns-2">
        <div id="post-body-content">
            <div id="titlediv">
                <div id="titlewrap">
                    <input type="text" name="title" placeholder="<?php echo esc_attr__('Title', 'snap-tales') ?>" size="30" id="title" spellcheck="true" autocomplete="off" value="<?php echo isset($title) ? esc_attr($title) : null; ?>" required>
                </div>
            </div>
        </div><!-- #post-body-content -->

        <div id="postbox-container-1" class="postbox-container">
            <div class="postbox">
                <div class="postbox-header">
                    <h2><?php echo isset($_GET['edit']) ? esc_html__('Edit story box', 'snap-tales') : esc_html__('Add story box', 'snap-tales'); ?></h2>
                </div>
                <div class="inside">
                    <div class="minor-publishing">

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
                                <?php echo isset($_GET['edit']) ? esc_html__('Edit story box', 'snap-tales') : esc_html__('Add story box', 'snap-tales'); ?>
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
                    <h2><?php echo esc_html__('Thumbnail', 'snap-tales'); ?></h2>
                </div>
                <div class="inside">
                    <div class="snap-tales-container" style="display: flex; align-items:center">
                        <img id="thumbnail_preview" style="border: 2px solid #525252;border-radius: 50%;margin-right: 10px;" width="66" height="66" 
                        <?php echo isset($thumbnail) ? 'src="'.esc_url($thumbnail).'"' : null; ?>>
                        <input type="hidden" name="thumbnail" id="thumbnail" value="<?php echo isset($thumbnail) ? esc_url($thumbnail) : null; ?>">
                        <button type="button" class="button snap-tales-select-thumbnail">
                            <?php echo esc_html__('Select thumbnail', 'snap-tales'); ?>
                        </button>
                    </div>
                </div><!-- .inside -->
            </div><!-- .postbox -->
        </div><!-- .postbox-container-2 -->

    </div><!-- #bost-body -->
    <div class="clear"></div>
</div><!-- #poststuff -->