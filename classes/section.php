<?php

/**
* Section management class file
*
* @since 0.1
*/
class WPEMS_Section {

    public static $validate;
    /**
     * Load Autometically class file when initiate
     *
     * @since 0.1
     */
    function __construct() {
        add_action( 'admin_init', array( $this, 'handle_sections_submit' ), 10 );
    }

    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new WPEMS_Section();
        }

        return $instance;
    }

    function handle_sections_submit() {
        global $wpdb;
        $table = $wpdb->prefix . "wpems_section";

        if ( isset( $_POST['save_section'] ) && wp_verify_nonce( $_POST['wpems_save_section_nonce'], 'wpems_save_section_action' ) ) {
            self::$validate = $this->validate();

            if ( !is_wp_error( self::$validate ) ) {

                $data = array(
                    'section_name' => sanitize_text_field( $_POST['section_name'] ),
                    'section_nick_name' => sanitize_text_field( $_POST['section_nick_name'] ),
                    'teacher_id' => sanitize_text_field( $_POST['teacher_id'] ),
                    'class_id' => sanitize_text_field( $_POST['class_id'] ),
                );

                if( isset( $_POST['section_id'] ) && !empty( $_POST['section_id'] ) ) {
                    $row_affected = $wpdb->update( $table, $data, array( 'id' => $_POST['section_id'] ) );
                    wp_redirect( add_query_arg( array( 'wpems_message' => 'updated' ), wpems_section_tab_url() ) );
                    exit();
                } else {
                    $row_affected = $wpdb->insert( $table, $data );
                    wp_redirect( add_query_arg( array( 'wpems_message' => 'success' ), wpems_section_tab_url() ) );
                    exit();
                }
            }
        }


        if ( isset( $_GET['delete_action'] ) && $_GET['delete_action'] == 'wpems-delete-section' ) {

            $section_id = isset( $_GET['section_id'] ) ? (int) $_GET['section_id'] : 0;

            if ( !$section_id ) {
                wp_redirect( add_query_arg( array( 'message' => 'error' ), wpems_section_tab_url() ) );
                return;
            }

            if ( !wp_verify_nonce( $_GET['_wpnonce'], 'wpems-delete-section' ) ) {
                wp_redirect( add_query_arg( array( 'message' => 'error' ), wpems_section_tab_url() ) );
                return;
            }

            $wpdb->delete( $table, array( 'id' => $section_id ) );
            wp_redirect( add_query_arg( array( 'message' => 'success' ), wpems_section_tab_url() ) );
            exit;
        }

    }

    function validate() {
        $error = new WP_Error();

        if ( empty( $_POST['section_name'] ) ) {
            $error->add( 'error', __('Section Name Must Be Required', 'wp-ems' ) );
        }


        if ( empty( $_POST['section_nick_name'] ) ) {
            $error->add( 'error', __('Section Nick Name Name Must Be Required', 'wp-ems' ) );
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

    function get_section( $id = NULL, $no = NULL, $offset = NULL ) {
        global $wpdb;
        $table = $wpdb->prefix . "wpems_section";
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

    function get_section_by_class( $class_id = NULL, $no = NULL, $offset = NULL ) {
        global $wpdb;
        $table = $wpdb->prefix . "wpems_section";

        $sql = "SELECT * FROM $table WHERE `class_id`='$class_id'";

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

    public function count_section( $class_id = NULL ) {
        global $wpdb;
        $table = $wpdb->prefix . "wpems_section";

        $sql = "SELECT * FROM $table";

        if ( $class_id ) {
           $sql .= " WHERE `class_id`='$class_id'";
        }

        $results = $wpdb->get_results( $sql );

        if ( $results ) {
            return count( $results );
        }
        return 0;
    }


}