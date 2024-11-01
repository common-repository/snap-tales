;(() => {
    const { __ } = window.wp.i18n;

    const wpMediaSelector = (callback) => {
        let mediaFrame;
        if (mediaFrame) {
            mediaFrame.open();
            return;
        }

        // Define image_frame as wp.media object
        mediaFrame = wp.media({
            title: __('Select Media', 'snap-tales'),
            multiple : false,
            library : {
                type : [
                    'image',
                    'video'
                ]
            }
        });
        mediaFrame.on('select', function() {
            var attachment = mediaFrame.state().get('selection').first().toJSON();
            callback(attachment);
        });
        mediaFrame.open();
    }

    let selectStoryBoxImage = document.querySelector('.snap-tales-select-thumbnail');
    if (selectStoryBoxImage) {
        selectStoryBoxImage.addEventListener('click', () => {
            wpMediaSelector((attachment) => {
                document.getElementById('thumbnail').value = attachment.url;
                document.getElementById('thumbnail_preview').src = attachment.url;
            });
        });
    }

    let selectMedia = document.querySelector('.snap-tales-select-media');
    if (selectMedia) {
        selectMedia.addEventListener('click', () => {
            wpMediaSelector((attachment) => {
                document.querySelector('.snap-tales-media-url').value = attachment.url;
                const mediaPreview = document.querySelector('.snap-tales-media-preview');
                if (mediaPreview) {
                    mediaPreview.src = attachment.url;
                }
            });
        });
    }

})();