<?php

/**
*  Teachers Class file
*
*  load all necessary action for teachers
*/
class WPEMS_Student  {

    public static $validate;
    /**
     * Load autometically when class initiate
     *
     * @since 0.1
     */
    function __construct() {
        add_action( 'admin_init', array( $this, 'save_students_data' ) );
        add_action( 'admin_init', array( $this, 'delete_student' ) );
    }

    /**
     * Initializes the WP_Education_Management() class
     *
     * Checks for an existing WP_Education_Management() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new WPEMS_Student();
        }

        return $instance;
    }

    function save_students_data() {

        if( isset( $_POST['save_student'] ) && wp_verify_nonce( $_POST['wpems_student_save_action_nonce'], 'wpems_student_save_action' ) ) {

            self::$validate = $this->validate();

            if ( !is_wp_error( self::$validate ) ) {

                if( !isset( $_POST[ 'student_id'] ) && empty( $_POST[ 'student_id'] ) ) {

                    if ( isset( $_POST['password_auto_generate'] ) && $_POST['password_auto_generate'] == 'yes' ) {
                        $password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
                    } else {
                        $password = $_POST['user_password'];
                    }

                    $first_name = sanitize_text_field( $_POST['first_name'] );
                    $last_name  = sanitize_text_field( $_POST['last_name'] );
                    $birthday   = sanitize_text_field( $_POST['birtday'] );
                    $roll       = sanitize_text_field( $_POST['roll'] );
                    $class_id   = sanitize_text_field( $_POST['class_id'] );
                    $gender     = sanitize_text_field( $_POST['gender'] );
                    $avatar     = sanitize_text_field( $_POST['profile_image'] );
                    $phone      = sanitize_text_field( $_POST['phone'] );

                    $userdata = array(
                        'user_login'   => $_POST['user_username'],
                        'user_pass'    => $password,
                        'user_email'   => $_POST['email'],
                        'display_name' => $first_name .' '. $last_name,
                        'role'         => 'student'
                    );

                    $user_id = wp_insert_user( $userdata );

                    if( $user_id ) {
                        update_user_meta( $user_id, 'first_name', $first_name );
                        update_user_meta( $user_id, 'last_name', $last_name );
                        update_user_meta( $user_id, 'birthday', $birthday );
                        update_user_meta( $user_id, 'roll', $roll );
                        update_user_meta( $user_id, 'class_id', $class_id );
                        update_user_meta( $user_id, 'gender', $gender );
                        update_user_meta( $user_id, 'avatar', $avatar );
                        update_user_meta( $user_id, 'phone', $phone );

                        //wp_new_user_notification( $user_id, $password );

                        wp_redirect( add_query_arg( array( 'wpems_message' => 'success' ), wpems_student_tab_url() ) );
                        exit();
                    }

                } else {
                    $first_name = sanitize_text_field( $_POST['first_name'] );
                    $last_name  = sanitize_text_field( $_POST['last_name'] );
                    $birthday   = sanitize_text_field( $_POST['birtday'] );
                    $roll       = sanitize_text_field( $_POST['roll'] );
                    $class_id   = sanitize_text_field( $_POST['class_id'] );
                    $gender     = sanitize_text_field( $_POST['gender'] );
                    $avatar     = sanitize_text_field( $_POST['profile_image'] );
                    $phone      = sanitize_text_field( $_POST['phone'] );

                    $userdata = array(
                        'ID'           => $_POST['student_id'],
                        'user_email'   => $_POST['email'],
                        'display_name' => $first_name .' '. $last_name,
                        'role'         => 'student'
                    );

                    $user_id = wp_update_user( $userdata );

                    if( $user_id ) {
                        update_user_meta( $user_id, 'first_name', $first_name );
                        update_user_meta( $user_id, 'last_name', $last_name );
                        update_user_meta( $user_id, 'birthday', $birthday );
                        update_user_meta( $user_id, 'roll', $roll );
                        update_user_meta( $user_id, 'class_id', $class_id );
                        update_user_meta( $user_id, 'gender', $gender );
                        update_user_meta( $user_id, 'avatar', $avatar );
                        update_user_meta( $user_id, 'phone', $phone );

                        wp_redirect( add_query_arg( array( 'wpems_message' => 'updated' ), wpems_student_tab_url() ) );
                        exit();

                    }
                }
            }
        }
    }

    public function delete_student() {

        if ( isset( $_GET['delete_action'] ) && $_GET['delete_action'] == 'wpems-delete-student' ) {

            $student_id = isset( $_GET['student_id'] ) ? (int) $_GET['student_id'] : 0;

            if ( !$student_id ) {
                wp_redirect( add_query_arg( array( 'message' => 'error' ), wpems_student_tab_url() ) );
                return;
            }

            if ( !wp_verify_nonce( $_GET['_wpnonce'], 'wpems-delete-student' ) ) {
                wp_redirect( add_query_arg( array( 'message' => 'error' ), wpems_student_tab_url() ) );
                return;
            }

            $result = wp_delete_user( $student_id );

            if ( $result ) {
                wp_redirect( add_query_arg( array( 'message' => 'success' ), wpems_student_tab_url() ) );
                exit();
            } else {
                wp_redirect( add_query_arg( array( 'message' => 'error' ), wpems_student_tab_url() ) );
                return;
            }
        }

    }

    public function validate() {
        $error = new WP_Error();

        if ( ! is_email( $_POST['email'] ) ) {
            $error->add( 'error', __('Invalid email', 'wpsm' ) );
        }

        if( !isset( $_POST[ 'student_id'] ) && empty( $_POST[ 'student_id'] ) ){
            if( username_exists( $_POST['user_username'] ) ) {
                $error->add( 'error', __('Username already exist', 'wpsm' ) );
            }
        }

        if( !isset( $_POST[ 'student_id'] ) && empty( $_POST[ 'student_id'] ) ){
            if( email_exists( $_POST['email']) ) {
                $error->add( 'error', __('Email already exist', 'wpsm' ) );
            }
        }

        if ( $error->get_error_codes() ) {
            return $error;
        }

        return true;

    }
}