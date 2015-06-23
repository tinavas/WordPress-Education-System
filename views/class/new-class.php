<?php
$users = WPEMS_Users::init();
$teachers = $users->get_users_list( NULL, NULL, 'teacher' );

$action = isset( $_GET['action'] ) ? $_GET['action'] : '';
$class_id = isset( $_GET['class_id'] ) ? $_GET['class_id'] : '';

if ( $action == 'edit' && $class_id ) {
    $heading = __( 'Edit Class Info', 'wp-ems' );
    $button_text = __( 'Update Class', 'wp-ems' );
    $class_info = WPEMS_Class::init()->get_class( $class_id );

    $class_name = isset( $class_info->class_name ) ? $class_info->class_name  : '';
    $class_numeric_name = isset( $class_info->class_numeric_name ) ? $class_info->class_numeric_name  : '';
    $teacher_id = isset( $class_info->teacher_id ) ? $class_info->teacher_id  : '';
} else {
    $heading = __( 'Add New Class', 'wp-ems' );
    $button_text = __( 'Create New Class', 'wp-ems' );
    $class_name = '';
    $class_numeric_name = '';
    $teacher_id = '';
}

?>

<h2><?php echo $heading; ?> </h2>

<?php if ( is_wp_error( WPEMS_Class::$validate ) ): ?>
    <?php
        $messages = WPEMS_Class::$validate->get_error_messages();
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


<div id="wpems-teacher-wrapper" class="white-popup">
    <form action="" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="class_name" class="control-label"><?php _e( 'Class Name', 'wp-ems' ); ?></label>
                    <input type="text" required name="class_name" class="form-control" value="<?php echo $class_name; ?>">
                </div>

                <div class="form-group">
                    <label for="class_numeric_name" class="control-label"><?php _e( 'Class Numeric Name', 'wp-ems' ); ?></label>
                    <input type="text" required  name="class_numeric_name" class="form-control" value="<?php echo $class_numeric_name; ?>">
                </div>

                <div class="form-group">
                    <label for="teacher_id" class="control-label"><?php _e( 'Assign Teacher', 'wp-ems' ); ?></label>
                    <select name="teacher_id" id="teacher_id" class="form-control" required>
                        <option value=""><?php _e( '--Select a teacher--', 'wp-ems' ); ?></option>
                        <?php foreach ( $teachers as $key => $teacher ): ?>
                            <option value="<?php echo $teacher->ID; ?>" <?php selected( $teacher_id, $teacher->ID ); ?>><?php echo $teacher->display_name; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <?php if ( $action == 'edit' && $class_id ): ?>
                        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                    <?php endif; ?>
                    <?php wp_nonce_field( 'wpems_save_class_action', 'wpems_save_class_nonce' ); ?>
                    <input type="submit" name="save_class" class="button button-primary" value="<?php echo $button_text; ?>">
                </div>

            </div>
        </div>
    </form>
</div>