<?php

/**
* Class management class file
*
* @since 0.1
*/
class WPEMS_Class {

    public static $validate;
    /**
     * Load Autometically class file when initiate
     *
     * @since 0.1
     */
    function __construct() {
        add_action( 'admin_init', array( $this, 'handle_class_submit' ), 10 );
    }

    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new WPEMS_Class();
        }

        return $instance;
    }

    function handle_class_submit() {
        global $wpdb;
        $table = $wpdb->prefix . "wpems_class";

        if ( isset( $_POST['save_class'] ) && wp_verify_nonce( $_POST['wpems_save_class_nonce'], 'wpems_save_class_action' ) ) {
            self::$validate = $this->validate();

            if ( !is_wp_error( self::$validate ) ) {

                $data = array(
                    'class_name' => sanitize_text_field( $_POST['class_name'] ),
                    'class_numeric_name' => sanitize_text_field( $_POST['class_numeric_name'] ),
                    'teacher_id' => sanitize_text_field( $_POST['teacher_id'] ),
                );

                if( isset( $_POST['class_id'] ) && !empty( $_POST['class_id'] ) ) {
                    $row_affected = $wpdb->update( $table, $data, array( 'id' => $_POST['class_id'] ) );
                    wp_redirect( add_query_arg( array( 'wpems_message' => 'updated' ), wpems_class_tab_url() ) );
                    exit();
                } else {
                    $row_affected = $wpdb->insert( $table, $data );
                    wp_redirect( add_query_arg( array( 'wpems_message' => 'success' ), wpems_class_tab_url() ) );
                    exit();
                }
            }
        }


        if ( isset( $_GET['delete_action'] ) && $_GET['delete_action'] == 'wpems-delete-class' ) {

            $class_id = isset( $_GET['class_id'] ) ? (int) $_GET['class_id'] : 0;

            if ( !$class_id ) {
                wp_redirect( add_query_arg( array( 'message' => 'error' ), wpems_class_tab_url() ) );
                return;
            }

            if ( !wp_verify_nonce( $_GET['_wpnonce'], 'wpems-delete-class' ) ) {
                wp_redirect( add_query_arg( array( 'message' => 'error' ), wpems_class_tab_url() ) );
                return;
            }

            $wpdb->delete( $table, array( 'id' => $class_id ) );
            wp_redirect( add_query_arg( array( 'message' => 'success' ), wpems_class_tab_url() ) );
            exit;
        }

    }

    function validate() {
        $error = new WP_Error();

        if ( !is_numeric( $_POST['class_numeric_name'] ) ) {
            $error->add( 'error', __('Class Numeric Name Must be numeric', 'wp-ems' ) );
        }

        if ( $error->get_error_codes() ) {
            return $error;
        }

        return true;

    }

    function get_class( $id = NULL, $no = NULL, $offset = NULL ) {
        global $wpdb;
        $table = $wpdb->prefix . "wpems_class";
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

    public function count_class() {
        global $wpdb;
        $table = $wpdb->prefix . "wpems_class";
        $where = '';

        $results = $wpdb->get_results( "SELECT * FROM $table" );

        if ( $results ) {
            return count( $results );
        }
        return 0;
    }


}