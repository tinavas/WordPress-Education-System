<?php
/**
 * Nessary Urls routing for Wp EMS
 *
 * @since 0.1
 *
 * @package WP EMS
 */


function wpems_teacher_listing_url() {
    return apply_filters( 'wpems_teacher_listing_url',  sprintf( '%s?page=wpems-teachers', admin_url( 'admin.php' ) ) );
}

function wpems_add_new_teacher_url() {
    return apply_filters( 'wpems_add_new_teacher_url',  sprintf( '%s?page=wpems-teachers&action=new', admin_url( 'admin.php' ) ) );
}

function wpems_edit_teacher_url() {
    return apply_filters( 'wpems_edit_teacher_url',  sprintf( '%s?page=wpems-teachers&action=edit', admin_url( 'admin.php' ) ) );
}

function wpems_class_tab_url() {
    return apply_filters( 'wpems_class_tab_url',  sprintf( '%s?page=wpems-class&tab=class', admin_url( 'admin.php' ) ) );
}

function wpems_section_tab_url() {
    return apply_filters( 'wpems_section_tab_url',  sprintf( '%s?page=wpems-class&tab=sections', admin_url( 'admin.php' ) ) );
}

function wpems_add_new_class_url() {
    return apply_filters( 'wpems_add_new_class_url',  sprintf( '%s?page=wpems-class&tab=class&action=new', admin_url( 'admin.php' ) ) );
}

function wpems_edit_class_url() {
    return apply_filters( 'wpems_edit_class_url',  sprintf( '%s?page=wpems-class&tab=class&action=edit', admin_url( 'admin.php' ) ) );
}

function wpems_add_new_section_url() {
    return apply_filters( 'wpems_add_new_class_url',  sprintf( '%s?page=wpems-class&tab=sections&action=new', admin_url( 'admin.php' ) ) );
}

function wpems_edit_section_url() {
    return apply_filters( 'wpems_add_new_class_url',  sprintf( '%s?page=wpems-class&tab=sections&action=edit', admin_url( 'admin.php' ) ) );
}

function wpems_subject_tab_url() {
    return apply_filters( 'wpems_subject_tab_url',  sprintf( '%s?page=wpems-subject', admin_url( 'admin.php' ) ) );
}

function wpems_add_new_subject_url() {
    return apply_filters( 'wpems_add_new_subject_url',  sprintf( '%s?page=wpems-subject&action=new', admin_url( 'admin.php' ) ) );
}

function wpems_edit_subject_url() {
    return apply_filters( 'wpems_edit_subject_url',  sprintf( '%s?page=wpems-subject&action=edit', admin_url( 'admin.php' ) ) );
}


