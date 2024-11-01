<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="form-field">
    <label for="snap-tales-category-image-url">
        <?php echo esc_html__('Category image URL:', 'snap-tales'); ?>
    </label>
    <img width="60px" height="60px" class="snap-tales-media-preview">
    <br><br>
    <input type="text" name="snap-tales-category-image-url" id="snap-tales-category-image-url" class="snap-tales-media-url" placeholder="<?php echo esc_html__('Image URL', 'snap-tales'); ?>">
    <br><br>
    <button type="button" class="snap-tales-select-media button">
        <?php echo esc_html__('Select image', 'snap-tales'); ?>
    </button>
</div>