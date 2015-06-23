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