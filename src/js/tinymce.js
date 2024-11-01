const { __ } = window.wp.i18n;
const { applyFilters } = window.wp.hooks;

;(function() {
    tinymce.PluginManager.add('snap-tales', function( editor, url ) {
        editor.addButton('snap-tales', {
            text: 'Snap Tales',
            icon: false,
            type: 'menubutton',
            menu: applyFilters('beycanpress_snap_tales_tinymce_short_codes', [
                {
                    text: __('Admin Stories', 'snap-tales'),
                    onclick: function() {
                        editor.insertContent("[snap-tales mode='admin']");
                    }
                },
                {
                    text: __('Post Stories', 'snap-tales'),
                    onclick: function() {
                        editor.insertContent("[snap-tales mode='post']");
                    }
                }
            ], editor)
        });
    });
})();