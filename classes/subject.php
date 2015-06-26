<?php

/**
* Section management class file
*
* @since 0.1
*/
class WPEMS_Subject {

    public static $validate;
    /**
     * Load Autometically class file when initiate
     *
     * @since 0.1
     */
    function __construct() {
        add_action( 'admin_init', array( $this, 'handle_subject_submit' ), 10 );
    }

    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new WPEMS_Subject();
        }

        return $instance;
    }

    function handle_subject_submit() {
        global $wpdb;
        $table = $wpdb->prefix . "wpems_subject";

        if ( isset( $_POST['save_subject'] ) && wp_verify_nonce( $_POST['wpems_save_subject_nonce'], 'wpems_save_subject_action' ) ) {
            self::$validate = $this->validate();

            if ( !is_wp_error( self::$validate ) ) {

                $data = array(
                    'name' => sanitize_text_field( $_POST['name'] ),
                    'teacher_id' => sanitize_text_field( $_POST['teacher_id'] ),
                    'class_id' => sanitize_text_field( $_POST['class_id'] ),
                );

                if( isset( $_POST['subject_id'] ) && !empty( $_POST['subject_id'] ) ) {
                    $row_affected = $wpdb->update( $table, $data, array( 'id' => $_POST['subject_id'] ) );
                    wp_redirect( add_query_arg( array( 'wpems_message' => 'updated' ), wpems_subject_tab_url() ) );
                    exit();
                } else {
                    $row_affected = $wpdb->insert( $table, $data );
                    wp_redirect( add_query_arg( array( 'wpems_message' => 'success' ), wpems_subject_tab_url() ) );
                    exit();
                }
            }
        }


        if ( isset( $_GET['delete_action'] ) && $_GET['delete_action'] == 'wpems-delete-subject' ) {

            $subject_id = isset( $_GET['subject_id'] ) ? (int) $_GET['subject_id'] : 0;

            if ( !$subject_id ) {
                wp_redirect( add_query_arg( array( 'message' => 'error' ), wpems_subject_tab_url() ) );
                return;
            }

            if ( !wp_verify_nonce( $_GET['_wpnonce'], 'wpems-delete-subject' ) ) {
                wp_redirect( add_query_arg( array( 'message' => 'error' ), wpems_section_tab_url() ) );
                return;
            }

            $wpdb->delete( $table, array( 'id' => $subject_id ) );
            wp_redirect( add_query_arg( array( 'message' => 'success' ), wpems_subject_tab_url() ) );
            exit;
        }

    }

    function validate() {
        $error = new WP_Error();

        if ( empty( $_POST['name'] ) ) {
            $error->add( 'error', __('Subject name must be required', 'wp-ems' ) );
        }

        if ( empty( $_POST['teacher_id'] ) ) {
            $error->add( 'error', __('Teacher must be selected', 'wp-ems' ) );
        }

        if ( empty( $_POST['class_id'] ) ) {
            $error->add( 'error', __('Class Name Must Be Selectd', 'wp-ems' ) );
        }

        if ( $error->get_error_codes() ) {
            return $error;
        }

        return true;

    }

    function get_subject( $id = NULL, $no = NULL, $offset = NULL ) {
        global $wpdb;
        $table = $wpdb->prefix . "wpems_subject";
        $where = '';

        if( $id ) {
            $results = $wpdb->get_row( "SELECT * FROM $table WHERE `id`='$id'" );
        } else {
            $sql = "SELECT * FROM $table";

            if ( $no ) {
                $sql .= " LIMIT $no";
            }

            if ( $offset ) {
                $sql .= " OFFSET $offset";
            }

            $results = $wpdb->get_results( $sql );
        }

        if ( $results ) {
            return $results;
        }
        return false;
    }

    function get_subject_by( $class_id = NULL, $teacher_id = NULL, $no = NULL, $offset = NULL ) {
        global $wpdb;
        $table = $wpdb->prefix . "wpems_subject";

        $sql = "SELECT * FROM $table";

        if ( $class_id && $teacher_id ) {
            $sql .= " WHERE `class_id`='$class_id' AND `teacher_id`='$teacher_id'";
        } elseif ( $class_id && !$teacher_id ) {
            $sql .= " WHERE `class_id`='$class_id'";
        } elseif ( $teacher_id && !$class_id ) {
            $sql .= " WHERE `teacher_id`='$teacher_id'";
        }

        if ( $no ) {
            $sql .= " LIMIT $no";
        }

        if ( $offset ) {
            $sql .= " OFFSET $offset";
        }

        $results = $wpdb->get_results( $sql );

        if ( $results ) {
            return $results;
        }
        return false;
    }

    public function count_subject( $class_id = NULL, $teacher_id = NULL ) {
        global $wpdb;
        $table = $wpdb->prefix . "wpems_section";

        $sql = "SELECT * FROM $table";

        if ( $class_id && $teacher_id ) {
            $sql .= " WHERE `class_id`='$class_id' AND `teacher_id`='$teacher_id'";
        } elseif ( $class_id && !$teacher_id ) {
            $sql .= " WHERE `class_id`='$class_id'";
        } elseif ( $teacher_id && !$class_id ) {
            $sql .= " WHERE `teacher_id`='$teacher_id'";
        }

        $results = $wpdb->get_results( $sql );

        if ( $results ) {
            return count( $results );
        }
        return 0;
    }


}