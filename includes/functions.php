<?php

function wpems_get_gender() {
    return apply_filters( 'wpems_get_gender', array(
        'male' => __( 'Male', 'wp-ems' ),
        'female' => __( 'Female', 'wp-ems' )
    ) );
}

function wpems_paginations( $total_user, $paged, $no, $base_url = NULL ) {
    $total_pages=ceil($total_user/$no);
    if ( $base_url ) {
        $base = $base_url;
    } else {
        $base = get_pagenum_link(1);
    }
    echo "<div class='wpems_pagination'>";
    echo paginate_links(array(
        'base' => $base . '%_%',
        'format' => '&paged=%#%',
        'current' => $paged,
        'total' => $total_pages,
        'type'=> 'list',
    ));
    echo "</div>";
}

function wpems_get_profile_avatar( $user_id ) {
    $default_placeholder = WP_EMS_PLUGIN_URI . '/assets/images/placeholder.png';
    $avatar_id  = get_user_meta( $user_id, 'avatar', true );
    $gravatar   = isset( $avatar_id ) ? absint( $avatar_id ) : 0;
    $gravatar_url = $gravatar ? wp_get_attachment_url( $gravatar ) : $default_placeholder;

    return $gravatar_url;
}

function wpems_get_week( $key = NULL ) {
    return array(
        'sat'  => __( 'Saturday', 'wp-ems' ),
        'sun'  => __( 'Sunday', 'wp-ems' ),
        'mon'  => __( 'Monday', 'wp-ems' ),
        'tues' => __( 'Tuesday', 'wp-ems' ),
        'wed'  => __( 'Wednesday', 'wp-ems' ),
        'thur' => __( 'Thursday', 'wp-ems' ),
        'fri'  => __( 'Friday', 'wp-ems' ),
    );
}

function wpems_class_subject_format() {
    $class_arr = array();
    $subjects_obj = WPEMS_Subject::init()->get_subject();

    foreach($subjects_obj as $key => $value ) {
       $class_arr[ $value->class_id ][] = array(
          'id' => $value->id,
           'name' => $value->name,
           'teacher_id' => $value->teacher_id
       );
    }

    return $class_arr;
}

function wpems_class_routine_format() {
    $class_arr = array();
    $routines = WPEMS_Routine::init()->get_routine();

    if ( $routines ) {
        foreach( $routines as $routine_key => $routine_value ) {
            $class_arr[$routine_value->class_name][] = $routine_value;
        }
    }

    return $class_arr;
}













