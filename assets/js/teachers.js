/**
 * Srtipts for teachers
 *
 * @since 0.1
 *
 * @type {Object}
 */
;(function($) {
    var profile_gravatar_frame;

    var WPEMS_Teachers = {

        init: function() {
            this.loadDatePicker();
            $('#wpems-teacher-wrapper').on('click', 'a.profile-image-btn', this.addImage );
            $('#wpems-teacher-wrapper').on('click', 'a.profile-image-remove-btn', this.removeImage );
            $('#wpems-teacher-wrapper').on('change', 'input#password_auto_generate', this.hidePasswordFiled );

        },

        loadDatePicker: function() {
            $('.wpems-datepicker').datepicker({ dateFormat: "dd/mm/yy", defaultDate: new Date(), changeMonth: true,changeYear: true, yearRange: "-100:+0" });
        },

        hidePasswordFiled: function() {
            var self = $(this);
            if ( self.is(':checked') ) {
                $('.hide_if_generate_auto').slideUp('fast');
                $('.hide_if_generate_auto').find( 'input#user_password').removeAttr('required' );
            } else {
                $('.hide_if_generate_auto').slideDown('fast');
                $('.hide_if_generate_auto').find( 'input#user_password').attr('required', true );
            }

        },

        addImage: function(e) {
            e.preventDefault();

            var self = $(this);

            if ( profile_gravatar_frame ) {
                profile_gravatar_frame.open();
                return;
            }

            profile_gravatar_frame = wp.media({
                // Set the title of the modal.
                title: 'Upload Profile image',
                button: {
                    text: 'Set Profile image',
                }
            });

            profile_gravatar_frame.on('select', function() {
                var selection = profile_gravatar_frame.state().get('selection');

                selection.map( function( attachment ) {
                    attachment = attachment.toJSON();

                    // set the image hidden id
                    self.siblings('input.profile-image-id').val(attachment.id);

                    // set the image
                    var instruction = self.closest('.instruction-inside');
                    var wrap = instruction.siblings('.image-wrap');

                    // wrap.find('img').attr('src', attachment.sizes.thumbnail.url);
                    wrap.find('img').attr('src', attachment.url);

                    instruction.addClass('wpems-hide');
                    wrap.removeClass('wpems-hide');
                });
            });

            profile_gravatar_frame.open();
        },

        removeImage: function(e) {
            e.preventDefault();

            var self = $(this);
            var wrap = self.closest('.image-wrap');
            var instruction = wrap.siblings('.instruction-inside');

            instruction.find('input.profile-image-id').val('0');
            wrap.addClass('wpems-hide');
            instruction.removeClass('wpems-hide');
        }


    };

    $(document).ready( function() {
        WPEMS_Teachers.init();
    });

})(jQuery);