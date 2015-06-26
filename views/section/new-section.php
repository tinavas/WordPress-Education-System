<?php
$users = WPEMS_Users::init();
$teachers = $users->get_users_list( NULL, NULL, 'teacher' );

$classes_obj = WPEMS_Class::init();
$classes = $classes_obj->get_class();

$action = isset( $_GET['action'] ) ? $_GET['action'] : '';
$section_id = isset( $_GET['section_id'] ) ? $_GET['section_id'] : '';

if ( $action == 'edit' && $section_id ) {
    $heading = __( 'Edit Section Info', 'wp-ems' );
    $button_text = __( 'Update Section', 'wp-ems' );
    $section_info = WPEMS_Section::init()->get_section( $section_id );

    $section_name = isset( $section_info->section_name ) ? $section_info->section_name  : '';
    $section_nick_name = isset( $section_info->section_nick_name ) ? $section_info->section_nick_name  : '';
    $teacher_id = isset( $section_info->teacher_id ) ? $section_info->teacher_id  : '';
    $class_id = isset( $section_info->class_id ) ? $section_info->class_id  : '';
} else {
    $heading = __( 'Add New Section', 'wp-ems' );
    $button_text = __( 'Create New Section', 'wp-ems' );
    $section_name = '';
    $section_nick_name = '';
    $teacher_id = '';
    $class_id = '';
}

?>

<h2><?php echo $heading; ?> </h2>

<?php if ( is_wp_error( WPEMS_Section::$validate ) ): ?>
    <?php
        $messages = WPEMS_Section::$validate->get_error_messages();
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
                    <label for="section_name" class="control-label"><?php _e( 'Section Name', 'wp-ems' ); ?></label>
                    <input type="text" required name="section_name" class="form-control" value="<?php echo $section_name; ?>">
                </div>

                <div class="form-group">
                    <label for="section_nick_name" class="control-label"><?php _e( 'Section Nick Name', 'wp-ems' ); ?></label>
                    <input type="text" required  name="section_nick_name" class="form-control" value="<?php echo $section_nick_name; ?>">
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
                    <?php if ( $action == 'edit' && $section_id ): ?>
                        <input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
                    <?php endif; ?>
                    <?php wp_nonce_field( 'wpems_save_section_action', 'wpems_save_section_nonce' ); ?>
                    <input type="submit" name="save_section" class="button button-primary" value="<?php echo $button_text; ?>">
                </div>

            </div>
        </div>
    </form>
</div>