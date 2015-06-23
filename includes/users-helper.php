<?php

function wpems_display_user_fullname( $user_id ) {
    $user = get_user_by( 'id', $user_id );
    return ( isset( $user->display_name ) && !empty( $user->display_name ) ) ? $user->display_name : '-';
}