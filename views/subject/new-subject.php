<?php
$users = WPEMS_Users::init();
$teachers = $users->get_users_list( NULL, NULL, 'teacher' );

$classes_obj = WPEMS_Class::init();
$classes = $classes_obj->get_class();

$action = isset( $_GET['action'] ) ? $_GET['action'] : '';
$subject_id = isset( $_GET['subject_id'] ) ? $_GET['subject_id'] : '';

if ( $action == 'edit' && $subject_id ) {
    $heading = __( 'Edit Subject Info', 'wp-ems' );
    $button_text = __( 'Update Subject', 'wp-ems' );
    $subject_info = WPEMS_Subject::init()->get_subject( $subject_id );

    $name = isset( $subject_info->name ) ? $subject_info->name  : '';
    $teacher_id = isset( $subject_info->teacher_id ) ? $subject_info->teacher_id  : '';
    $class_id = isset( $subject_info->class_id ) ? $subject_info->class_id  : '';
} else {
    $heading = __( 'Add New Subject', 'wp-ems' );
    $button_text = __( 'Create New Subject', 'wp-ems' );
    $name = '';
    $teacher_id = '';
    $class_id = '';
}

?>

<h2><?php echo $heading; ?> </h2>

<?php if ( is_wp_error( WPEMS_Subject::$validate ) ): ?>
    <?php
        $messages = WPEMS_Subject::$validate->get_error_messages();
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
                    <label for="name" class="control-label"><?php _e( 'Subject Name', 'wp-ems' ); ?></label>
                    <input type="text" required name="name" class="form-control" value="<?php echo $name; ?>">
                </div>

                <div class="form-group">
                    <label for="teacher_id" class="control-label"><?php _e( 'Assign Teacher', 'wp-ems' ); ?></label>
                    <select name="teacher_id" id="teacher_id" class="form-control" required>
                        <option value=""><?php _e( '--Select a teacher--', 'wp-ems' ); ?></option>
                        <?php foreach ( $teachers as $teacher_key => $teacher ): ?>
                            <option value="<?php echo $teacher->ID; ?>" <?php selected( $teacher_id, $teacher->ID ); ?>><?php echo $teacher->display_name; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="class_id" class="control-label"><?php _e( 'Assign Class', 'wp-ems' ); ?></label>
                    <select name="class_id" id="class_id" class="form-control" required>
                        <option value=""><?php _e( '--Select a class--', 'wp-ems' ); ?></option>
                        <?php foreach ( $classes as $class_key => $class ): ?>
                            <option value="<?php echo $class->id; ?>" <?php selected( $class_id, $class->id ); ?>><?php echo $class->class_name; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <?php if ( $action == 'edit' && $subject_id ): ?>
                        <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
                    <?php endif; ?>
                    <?php wp_nonce_field( 'wpems_save_subject_action', 'wpems_save_subject_nonce' ); ?>
                    <input type="submit" name="save_subject" class="button button-primary" value="<?php echo $button_text; ?>">
                </div>
            </div>
        </div>
    </form>
</div>