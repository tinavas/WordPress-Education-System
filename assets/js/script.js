;(function($) {

    WPEMS_Admin = {

        init: function() {
            this.loadTimePicker();
            $('.wpems-class-routine-wrap').on( 'click', 'a.wpems-action-toggle', this.toggleRoutineMetabox );
            $('form.wpems-routine-form').on('change', 'select.wpems_class_select', this.selectSubjectByClass )
        },

        loadTimePicker: function() {
            $('.wpems-timepicker').timepicker({
                showPeriod: true,
                minutes: {
                    starts: 0,                // First displayed minute
                    ends: 59,                 // Last displayed minute
                    interval: 1,              // Interval of displayed minutes
                },
            });
        },

        toggleRoutineMetabox: function(e) {
            e.preventDefault();
            $(this).closest('.wpems-routine-metabox').find('.inside').slideToggle('fast');
        },

        selectSubjectByClass: function(e) {
            e.preventDefault();
            var self = $(this),
                $subjectField = $('select.wpems_subject_select'),
                $options = '',
                classVal = self.val(),
                subjectArr = $subjectField.data('subjects'),
                selectedSub = $subjectField.data('subject_selected')

            if ( typeof subjectArr[classVal] != 'undefined' && subjectArr[classVal].length ) {
                $.each( subjectArr[classVal], function( i, el ) {
                    $select = ( selectedSub && selectedSub == el.id ) ? 'selected' : '';

                    $options += '<option value="'+el.id+'" '+ $select +'>'+el.name+'</option>';
                } );
            } else {
                $options += '<option value="">--No Subject Found--</option>';
            }

            $subjectField.html( $options );
        }
    };

    $(document).ready( function() {
        WPEMS_Admin.init();
        $('select.wpems_class_select').trigger('change');
    })

})(jQuery);

