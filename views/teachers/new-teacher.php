<?php
$action = isset( $_GET['action'] ) ? $_GET['action'] : '';
$teacher_id = isset( $_GET['teacher_id'] ) ? $_GET['teacher_id'] : '';
$genders = wpems_get_gender();
if ( $action == 'edit' && $teacher_id ) {
    $readonly = "readonly";
    $teacher = get_userdata( $teacher_id );
    $first_name = get_user_meta( $teacher_id, 'first_name', true );
    $last_name = get_user_meta( $teacher_id, 'last_name', true );
    $username = $teacher->user_login;
    $email = $teacher->user_email;
    $phone = get_user_meta( $teacher_id, 'phone', true );
    $birthday = get_user_meta( $teacher_id, 'birthday', true );
    $gender = get_user_meta( $teacher_id, 'gender', true );
    $avatar = get_user_meta( $teacher_id, 'avatar', true );

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
    $first_name = '';
    $last_name = '';
    $username = '';
    $email = '';
    $phone = '';
    $birtday = '';
    $gender = '';
    $avatar = '';
    $wrap_class        = ' wpems-hide';
    $instruction_class = '';
    $profile_image_id     = 0;
}
?>

<div class="wrap wpems-teacher-wrap">

    <?php if ( $action == 'edit' && $teacher_id ): ?>
        <h2><?php _e( 'Edit Teacher', 'wp-ems' ); ?> </h2>
    <?php else: ?>
        <h2><?php _e( 'Add New Teacher', 'wp-ems' ); ?> </h2>
    <?php endif ?>

    <hr>

    <?php if ( is_wp_error( WPEMS_Teachers::$validate ) ): ?>
        <?php
            $messages = WPEMS_Teachers::$validate->get_error_messages();
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

                <?php if ( $action == 'new' && empty( $teacher_id )  ): ?>
                    <div class="form-group hide_if_generate_auto">
                        <label for="user_password" class="control-label"><?php _e( 'Password', 'wp-ems' ); ?></label>
                        <input type="password" required name="user_password" id="user_password" class="form-control" autocomplete="off">
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="yes" id="password_auto_generate" name="password_auto_generate">
                            Autometic generate password and send to this user in mail
                      </label>
                    </div>
                <?php endif ?>

                <div class="form-group">
                    <?php if ( $action == 'edit' && $teacher_id ): ?>
                        <input type="hidden" name="teacher_id" value="<?php echo $teacher_id; ?>">
                    <?php endif; ?>
                    <?php wp_nonce_field( 'wpems_teacher_save_action', 'wpems_teacher_save_action_nonce' ); ?>
                    <input type="submit" name="save_teacher" value="Create New Teacher" class="button button-primary">
                </div>
            </div>
            <div class="col-md-4 pull-right">
                <div class="wpems-profile-image-upload">
                    <div class="instruction-inside<?php echo $instruction_class; ?>">
                        <input type="hidden" name="profile_image" class="profile-image-id" value="0">
                        <i class="fa fa-cloud-upload"></i>
                        <a href="#" class="profile-image-btn button button-primary"><?php _e( 'Upload Picture', 'wp-ems' ); ?></a>
                    </div>

                    <div class="image-wrap<?php echo $wrap_class; ?>">
                        <a class="close profile-image-remove-btn">&times;</a>
                        <?php if ( $profile_image_id ): ?>
                            <img src="<?php echo wpems_get_profile_avatar( $teacher_id ); ?>" alt="" width="200px" height="200px">
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
