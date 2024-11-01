<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div
    id="<?php echo esc_attr($id); ?>"
    data-mode="<?php echo esc_attr($mode); ?>"
    class="snap-tales-<?php echo esc_attr($key) ?>"
    data-args="<?php echo esc_attr(wp_json_encode($args)) ?>"
>
</div>