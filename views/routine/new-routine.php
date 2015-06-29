<?php

$classes_obj = WPEMS_Class::init();
$classes = $classes_obj->get_class();

$action = isset( $_GET['action'] ) ? $_GET['action'] : '';
$routine_id = isset( $_GET['routine_id'] ) ? $_GET['routine_id'] : '';

$week_day = wpems_get_week();

if ( $action == 'edit' && $routine_id ) {
    $heading = __( 'Edit Routine Info', 'wp-ems' );
    $button_text = __( 'Update Routine', 'wp-ems' );
    $routine_info = WPEMS_Routine::init()->get_routine( $routine_id );
    var_dump( $routine_info );
    $class_id = isset( $routine_info->class_id ) ? $routine_info->class_id  : '';
    $subject_id = isset( $routine_info->subject_id ) ? $routine_info->subject_id  : '';
    $week = isset( $routine_info->day ) ? $routine_info->day  : '';
    $start_time = isset( $routine_info->start_time ) ? $routine_info->start_time  : '';
    $end_time = isset( $routine_info->end_time ) ? $routine_info->end_time  : '';
} else {
    $heading = __( 'Add New Routine', 'wp-ems' );
    $button_text = __( 'Create New Routine', 'wp-ems' );
    $subject_id = '';
    $class_id = '';
    $week = '';
    $start_time = '';
    $end_time = '';
}

?>

<h2><?php echo $heading; ?> </h2>

<?php if ( is_wp_error( WPEMS_Routine::$validate ) ): ?>
    <?php
        $messages = WPEMS_Routine::$validate->get_error_messages();
        foreach ( $messages as $message ) {
            ?>
            <div class="error settings-error notice is-dismissible">
                <p><strong><?php echo $message; ?></strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
            <?php
        }
    ?>
<?php endif ?>

<div id="wpems-teacher-wrapper" class="wpems-rotune-wrapper white-popup">
    <form action="" method="post" class="wpems-routine-form">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="class_id" class="control-label"><?php _e( 'Assign Class', 'wp-ems' ); ?></label>
                    <select name="class_id" id="class_id" class="form-control wpems_class_select" required>
                        <option value=""><?php _e( '--Select a class--', 'wp-ems' ); ?></option>
                        <?php foreach ( $classes as $class_key => $class ): ?>
                            <option value="<?php echo $class->id; ?>" <?php selected( $class_id, $class->id ); ?>><?php echo $class->class_name; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="subject_id" class="control-label"><?php _e( 'Subject', 'wp-ems' ); ?></label>
                    <select name="subject_id" id="subject_id" class="form-control wpems_subject_select" required data-subjects='<?php echo json_encode( wpems_class_subject_format() ) ?>' data-subject_selected = <?php echo $subject_id; ?>>
                        <option value=""><?php _e( 'Select a Class First', 'wp-ems' ); ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="start_time" class="control-label"><?php _e( 'Start Time', 'wp-ems' ); ?></label>
                    <input type="text" name="start_time" value="<?php echo $start_time; ?>" class="form-control wpems-timepicker">
                </div>


                <div class="form-group">
                    <label for="end_time" class="control-label"><?php _e( 'End Time', 'wp-ems' ); ?></label>
                    <input type="text" name="end_time" value="<?php echo $end_time; ?>" class="form-control wpems-timepicker">
                </div>

                <div class="form-group">
                    <label for="week_day" class="control-label"><?php _e( 'Day', 'wp-ems' ); ?></label>
                    <select name="week_day" id="week_day" class="form-control" required>
                        <?php foreach ( $week_day as $week_key => $week_name ): ?>
                            <option value="<?php echo $week_key ?>" <?php selected( $week, $week_key ); ?>><?php echo $week_name; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <?php if ( $action == 'edit' && $routine_id ): ?>
                        <input type="hidden" name="routine_id" value="<?php echo $routine_id; ?>">
                    <?php endif; ?>
                    <?php wp_nonce_field( 'wpems_save_routine_action', 'wpems_save_routine_nonce' ); ?>
                    <input type="submit" name="save_routine" class="button button-primary" value="<?php echo $button_text; ?>">
                </div>
            </div>
        </div>
    </form>
</div>