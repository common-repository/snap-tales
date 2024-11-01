<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<label>
    <input 
        type="checkbox" 
        name="snap_tales[story_visibility]" 
        value="on" 
        <?php echo isset($storyVisibility) && 'on' === $storyVisibility ? 'checked' : null; ?> 
    />
        <?php echo esc_html__('Story visibility', 'snap-tales'); ?>
</label>
<br>
<p class="post-attributes-label-wrapper page-template-label-wrapper">
    <label class="post-attributes-label">
        <?php echo esc_html__('Media URL: (If not selected, the featured image is used.)', 'snap-tales'); ?>
    </label>
</p>
<input type="url" class="widefat snap-tales-media-url" name="snap_tales[media_url]" value="<?php echo isset($mediaURL) ? esc_url($mediaURL) : null; ?>">
<button type="button" class="button snap-tales-select-media" style="margin-top: 10px">
    <?php echo esc_html__('Select story media', 'snap-tales'); ?>
</button>