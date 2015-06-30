<?php
$action = isset( $_GET['action'] ) ? $_GET['action'] : '';
$student_id = isset( $_GET['student_id'] ) ? $_GET['student_id'] : '';
$genders = wpems_get_gender();

$classes_obj = WPEMS_Class::init();
$classes = $classes_obj->get_class();


if ( $action == 'edit' && $student_id ) {
    $readonly = "readonly";
    $button_text = "Update Student info";
    $student = get_userdata( $student_id );
    $first_name = get_user_meta( $student_id, 'first_name', true );
    $last_name = get_user_meta( $student_id, 'last_name', true );
    $username = $student->user_login;
    $email = $student->user_email;
    $phone = get_user_meta( $student_id, 'phone', true );
    $roll = get_user_meta( $student_id, 'roll', true );
    $birthday = get_user_meta( $student_id, 'birthday', true );
    $class_id = get_user_meta( $student_id, 'class_id', true );
    $gender = get_user_meta( $student_id, 'gender', true );
    $avatar = get_user_meta( $student_id, 'avatar', true );

    if ( $avatar ) {
        $wrap_class        = '';
        $instruction_class = ' wpems-hide';
        $profile_image_id  = $avatar;
    } else {
        $wrap_class        = ' wpems-hide';
        $instruction_class = '';
        $profile_image_id     = 0;
    }

} else {
    $readonly = "";
    $button_text = "Create New Student";
    $first_name = '';
    $last_name = '';
    $username = '';
    $email = '';
    $phone = '';
    $roll = '';
    $birthday = '';
    $class_id = '';
    $gender = '';
    $avatar = '';
    $wrap_class        = ' wpems-hide';
    $instruction_class = '';
    $profile_image_id     = 0;
}
?>

<div class="wrap wpems-teacher-wrap">

    <?php if ( $action == 'edit' && $student_id ): ?>
        <h2><?php _e( 'Edit Student', 'wp-ems' ); ?> </h2>
    <?php else: ?>
        <h2><?php _e( 'Add New Student', 'wp-ems' ); ?> </h2>
    <?php endif ?>

    <hr>

    <?php if ( is_wp_error( WPEMS_Student::$validate ) ): ?>
        <?php
            $messages = WPEMS_Student::$validate->get_error_messages();
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
            <div class="col-md-6 pull-left">
                <div class="form-group">
                    <label for="first_name" class="control-label"><?php _e( 'First Name', 'wp-ems' ); ?></label>
                    <input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>">
                </div>

                <div class="form-group">
                    <label for="last_name" class="control-label"><?php _e( 'Last Name', 'wp-ems' ); ?></label>
                    <input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>">
                </div>

                <div class="form-group">
                    <label for="username" class="control-label"><?php _e( 'Username', 'wp-ems' ); ?></label>
                    <input type="text" required name="user_username" <?php echo $readonly; ?> class="form-control" autocomplete="off" value="<?php echo $username; ?>">
                </div>

                <div class="form-group">
                    <label for="email" class="control-label"><?php _e( 'Email', 'wp-ems' ); ?></label>
                    <input type="email" required name="email" class="form-control" value="<?php echo $email; ?>">
                </div>

                <div class="form-group">
                    <label for="roll" class="control-label"><?php _e( 'Roll', 'wp-ems' ); ?></label>
                    <input type="roll" required name="roll" class="form-control" value="<?php echo $roll; ?>">
                </div>

                <div class="form-group">
                    <label for="class_id" class="control-label"><?php _e( 'Assign a Class', 'wp-ems' ); ?></label>
                    <select name="class_id" id="class_id" class="form-control" required>
                        <option value=""><?php _e( '--Select a class--', 'wp-ems' ); ?></option>
                        <?php foreach ( $classes as $class_key => $class ): ?>
                            <option value="<?php echo $class->id; ?>" <?php selected( $class_id, $class->id ); ?>><?php echo $class->class_name; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="email" class="control-label"><?php _e( 'Phone', 'wp-ems' ); ?></label>
                    <input type="number" name="phone" class="form-control" value="<?php echo $phone; ?>">
                </div>

                <div class="form-group">
                    <label for="birtday" class="control-label"><?php _e( 'Birthday', 'wp-ems' ); ?></label>
                    <input type="text" name="birtday" class="wpems-datepicker form-control" autocomplete="off" value="<?php echo $birthday; ?>">
                </div>

                <div class="form-group">
                    <label for="gender" class="control-label"><?php _e( 'Gender', 'wp-ems' ); ?></label>
                    <select name="gender" id="gender" class="form-control">
                        <?php foreach ( $genders as $key => $value ): ?>
                            <option value="<?php echo $key; ?>" <?php selected( $gender, $key ); ?>><?php echo $value; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <?php if ( $action == 'new' && empty( $student_id )  ): ?>
                    <div class="form-group hide_if_generate_auto">
                        <label for="user_password" class="control-label"><?php _e( 'Password', 'wp-ems' ); ?></label>
                        <input type="password" required name="user_password" id="user_password" class="form-control" autocomplete="off">
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="yes" id="password_auto_generate" name="password_auto_generate">
                            <?php _e( 'Autometic generate password and send to this user in mail', 'wp-ems' ) ?>
                      </label>
                    </div>
                <?php endif ?>

                <div class="form-group">
                    <?php if ( $action == 'edit' && $student_id ): ?>
                        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                    <?php endif; ?>
                    <?php wp_nonce_field( 'wpems_student_save_action', 'wpems_student_save_action_nonce' ); ?>
                    <input type="submit" name="save_student" value="<?php echo $button_text ?>" class="button button-primary">
                </div>
            </div>
            <div class="col-md-4 pull-right">
                <div class="wpems-profile-image-upload">
                    <div class="instruction-inside<?php echo $instruction_class; ?>">
                        <input type="hidden" name="profile_image" class="profile-image-id" value="<?php echo $profile_image_id; ?>">
                        <i class="fa fa-cloud-upload"></i>
                        <a href="#" class="profile-image-btn button button-primary"><?php _e( 'Upload Picture', 'wp-ems' ); ?></a>
                    </div>

                    <div class="image-wrap<?php echo $wrap_class; ?>">
                        <a class="close profile-image-remove-btn">&times;</a>
                        <?php if ( $profile_image_id ): ?>
                            <img src="<?php echo wpems_get_profile_avatar( $student_id ); ?>" alt="" width="200px" height="200px">
                        <?php else: ?>
                            <img src="" alt="" width="200px" height="200px">
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

        </form>
    </div>

</div>
