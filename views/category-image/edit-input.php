<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<tr class="form-field">
    <th scope="row" valign="top">
    <label for="snap-tales-category-image-url">
            <?php echo esc_html__('Category image URL:', 'snap-tales'); ?>
        </label>
    </th>
    <td>
        <?php if (isset($imageURL)) : ?>
            <img src="<?php echo esc_url($imageURL) ?>" width="60px" height="60px" class="snap-tales-media-preview">
            <br><br>
        <?php endif; ?>
        <input type="text" name="snap-tales-category-image-url" id="snap-tales-category-image-url" class="snap-tales-media-url" value="<?php echo isset($imageURL) ? esc_attr($imageURL) : null; ?>" placeholder="<?php echo esc_html__('Image URL', 'snap-tales'); ?>">
        <br><br>
        <button type="button" class="snap-tales-select-media button">
            <?php echo esc_html__('Select image', 'snap-tales'); ?>
        </button>
    </td>
</tr>
