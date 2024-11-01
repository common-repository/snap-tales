const { __ } = window.wp.i18n;
const { applyFilters } = window.wp.hooks;

wp.blocks.registerBlockType('beycanpress/snap-tales', {
    title: 'Snap Tales',
    icon: 'dashicons dashicons-format-gallery',
    category: 'widgets',
    attributes: {
        content: {type: 'string'},
        color: {type: 'string'}
    },
    /* This configures how the content and color fields will work, and sets up the necessary elements */
    edit: function(props) {
        function updateContent(event) {
            props.setAttributes({content: event.target.value})
        }
        return React.createElement(
            "select", 
            { value: props.attributes.content, onChange: updateContent },
            ...applyFilters('beycanpress_snap_tales_gutenberg_short_codes', [
                React.createElement("option", {value: __('Choose a Mode', 'snap-tales')}, __('Choose a Mode', 'snap-tales')),
                React.createElement("option", {value: "[snap-tales mode='admin']"}, __('Admin Stories', 'snap-tales')),
                React.createElement("option", {value: "[snap-tales mode='post']"}, __('Post Stories', 'snap-tales'))
            ], React)
        );
    },
    save: function(props) {
        return wp.element.createElement(
            "div",
            {},
            props.attributes.content
        );
    }
});