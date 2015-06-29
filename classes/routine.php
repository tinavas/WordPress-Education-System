<?php
/**
*  WPEMS Routine Class file
*
*  @since 2.4
*
*  @package wpems
*/
class WPEMS_Routine {

    public static $validate;
    /**
     * Load autometically when class initiate
     *
     * @since wpems
     */
    function __construct() {
        add_action( 'admin_init', array( $this, 'handle_routine_submit' ), 10 );
    }

    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new WPEMS_Routine();
        }

        return $instance;
    }

    function handle_routine_submit() {
        global $wpdb;
        $table = $wpdb->prefix . "wpems_routine";

        if ( isset( $_POST['save_routine'] ) && wp_verify_nonce( $_POST['wpems_save_routine_nonce'], 'wpems_save_routine_action' ) ) {
            self::$validate = $this->validate();

            if ( !is_wp_error( self::$validate ) ) {

                $data = array(
                    'class_id' => sanitize_text_field( $_POST['class_id'] ),
                    'subject_id' => sanitize_text_field( $_POST['subject_id'] ),
                    'start_time' => sanitize_text_field( $_POST['start_time'] ),
                    'end_time' => sanitize_text_field( $_POST['end_time'] ),
                    'day' => sanitize_text_field( $_POST['week_day'] ),
                );

                if( isset( $_POST['routine_id'] ) && !empty( $_POST['routine_id'] ) ) {
                    $row_affected = $wpdb->update( $table, $data, array( 'id' => $_POST['routine_id'] ) );
                    wp_redirect( add_query_arg( array( 'wpems_message' => 'updated' ), wpems_routine_tab_url() ) );
                    exit();
                } else {
                    $row_affected = $wpdb->insert( $table, $data );
                    wp_redirect( add_query_arg( array( 'wpems_message' => 'success' ), wpems_routine_tab_url() ) );
                    exit();
                }
            }
        }


        if ( isset( $_GET['delete_action'] ) && $_GET['delete_action'] == 'wpems-delete-routine' ) {

            $routine_id = isset( $_GET['routine_id'] ) ? (int) $_GET['routine_id'] : 0;

            if ( !$routine_id ) {
                wp_redirect( add_query_arg( array( 'message' => 'error' ), wpems_routine_tab_url() ) );
                return;
            }

            if ( !wp_verify_nonce( $_GET['_wpnonce'], 'wpems-delete-routine' ) ) {
                wp_redirect( add_query_arg( array( 'message' => 'error' ), wpems_routine_tab_url() ) );
                return;
            }

            $wpdb->delete( $table, array( 'id' => $routine_id ) );
            wp_redirect( add_query_arg( array( 'wpems_message' => 'deleted' ), wpems_routine_tab_url() ) );
            exit;
        }

    }


    function validate() {
        $error = new WP_Error();

        if ( empty( $_POST['class_id'] ) ) {
            $error->add( 'error', __('Class Name Must Be Selectd', 'wp-ems' ) );
        }

        if ( empty( $_POST['subject_id'] ) ) {
            $error->add( 'error', __('Subject name must be required', 'wp-ems' ) );
        }

        if ( empty( $_POST['start_time'] ) ) {
            $error->add( 'error', __('Class Starting time must me required', 'wp-ems' ) );
        }

        if ( empty( $_POST['end_time'] ) ) {
            $error->add( 'error', __('Class Ending time must me required', 'wp-ems' ) );
        }

        if ( $error->get_error_codes() ) {
            return $error;
        }

        return true;
    }

    function get_routine( $id = NULL ) {
        global $wpdb;
        $rt_table = $wpdb->prefix . "wpems_routine";
        $cl_table = $wpdb->prefix . "wpems_class";
        $sb_table = $wpdb->prefix . "wpems_subject";

        $sql = "SELECT `rt`.*,`cl`.`class_name`,`sb`.`name`
                FROM $rt_table AS `rt`
                LEFT JOIN $cl_table AS `cl` ON `cl`.`id` = `rt`.`class_id`
                LEFT JOIN $sb_table AS `sb` ON `sb`.`id` = `rt`.`subject_id`";

        if ( $id ) {
            $sql .= " WHERE `rt`.id = $id";
        }

        if ( $id ) {
            $results = $wpdb->get_row( $sql );
        } else {
            $results = $wpdb->get_results( $sql );
        }

        if ( $results ) {
            return $results;
        }

        return false;
    }


}