<?php

/**
*  Students Class
*  Database manupulation class for School Students
*/
class WPEMS_Users {

    /**
     * Initializes the WP_Education_Management() class
     *
     * Checks for an existing WP_Education_Management() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new WPEMS_Users();
        }

        return $instance;
    }

    public function get_users_list( $no = NULL, $offset=NULL, $role ) {

    	if( $no ) {
    		$args['number'] = $no;
    	}

    	if( $offset ) {
    		$args['offset'] = $offset;
    	}

		$args['role'] = $role;
		$user_query = new WP_User_Query( $args );
		if ( !empty( $user_query->results ) ) {
			return $user_query->get_results();
		}

		return false;
    }

   	public function count_user( $no, $offset, $role ) {
   		$args = array( 'number' => $no, 'offset' => $offset, 'role' => $role );
		$user_query = new WP_User_Query( $args );

		return $user_query->total_users;
   	}

    public function get_class_list() {
        global $wpdb;
        $table = $wpdb->prefix . "wpsm_class";
        $results = $wpdb->get_results( "SELECT * FROM $table" );
        return $results;

    }

}