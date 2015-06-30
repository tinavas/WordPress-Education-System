<h2><?php _e( 'Dashboard', 'wp-ems' ); ?></h2> <br>

<?php

$count_teachers = WPEMS_Users::init()->count_user( NULL, NULL, 'teacher' );
$count_students = WPEMS_Users::init()->count_user( NULL, NULL, 'student' );

?>

<div class="wpems-dashbaord-event-schedule">
    <div class="postbox wpems-dashboard-metabox">
        <div id="dashboard-widgets" class="metabox-holder">
            <h3 class="hndle"><?php _e( 'Event Schedule: ', 'wp-ems ') ?></h3>

            <div class="wpems-dashboard-content inside">
                <div id='wpems-event-calendar'></div>

            </div>
        </div>
    </div>
</div>
<div class="wpes-dashboard-sidebar">
    <div class="postbox wpems-dashboard-metabox">
        <div id="dashboard-widgets" class="metabox-holder">
            <h3 class="hndle"><?php _e( 'Total Students', 'wp-ems ') ?></h3>

            <div class="wpems-dashboard-content inside">

                <div class="wpems-dashboard-counter">
                    <span class="counter"><?php echo $count_students; ?></span>
                </div>
                <div class="wpems-dashboard-counter-label">
                    <?php _e( 'Students', 'wp-ems' ); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="postbox wpems-dashboard-metabox">
        <div id="dashboard-widgets" class="metabox-holder">
            <h3 class="hndle"><?php _e( 'Total Teachers', 'wp-ems ') ?></h3>

            <div class="wpems-dashboard-content inside">

                <div class="wpems-dashboard-counter">
                    <span class="counter"><?php echo $count_teachers; ?></span>
                </div>
                <div class="wpems-dashboard-counter-label">
                    <?php _e( 'Teachers', 'wp-ems' ); ?>
                </div>
            </div>
        </div>
    </div>


</div>

<script>

(function($){

    $(document).ready(function() {

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        $('#wpems-event-calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            defaultDate: date,
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                {
                    title: 'All Day Event',
                    start: '2015-02-01'
                },
                {
                    title: 'Long Event',
                    start: '2015-02-07',
                    end: '2015-02-10'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2015-02-09T16:00:00'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: '2015-02-16T16:00:00'
                },
                {
                    title: 'Conference',
                    start: '2015-02-11',
                    end: '2015-02-13'
                },
                {
                    title: 'Meeting',
                    start: '2015-02-12T10:30:00',
                    end: '2015-02-12T12:30:00'
                },
                {
                    title: 'Lunch',
                    start: '2015-02-12T12:00:00'
                },
                {
                    title: 'Meeting',
                    start: '2015-02-12T14:30:00'
                },
                {
                    title: 'Happy Hour',
                    start: '2015-02-12T17:30:00'
                },
                {
                    title: 'Dinner',
                    start: '2015-02-12T20:00:00'
                },
                {
                    title: 'Birthday Party',
                    start: '2015-02-13T07:00:00'
                },
                {
                    title: 'Click for Google',
                    url: 'http://google.com/',
                    start: '2015-02-28'
                }
            ]
        });

        $('.counter').counterUp({
            delay: 5,
            time: 1000
        });

    });

})(jQuery);

</script>