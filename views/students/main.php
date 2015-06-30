<div class="wrap wpems-student-wrap">

    <h2><?php _e( 'Students Mangement', 'wp-ems' ); ?> <a href="<?php echo wpems_add_new_student_url(); ?>" id="wpems-new-student" class="add-new-h2"><?php _e( 'Add New', 'wp-ems' ); ?></a></h2>

    <?php if ( isset( $_GET['wpems_message'] ) ): ?>

        <?php if ( $_GET['wpems_message'] == 'success' ): ?>
            <div class="updated settings-updated notice is-dismissible">
                <p><strong><?php _e( 'Successfully added a new Student', 'wp-ems') ?></strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
        <?php elseif ( $_GET['wpems_message'] == 'updated' ): ?>
            <div class="updated settings-updated notice is-dismissible">
                <p><strong><?php _e( 'Successfully Updated student info', 'wp-ems') ?></strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
        <?php endif ?>

    <?php endif ?>

    <?php
    $class = WPEMS_Class::init();
    $classes = $class->get_class();
    if ( $classes ) {
        $class_name_arr = wp_list_pluck( $classes, 'class_name', 'id' );
    } else {
        $class_name_arr = array();
    }

    $filter_class = ( isset( $_GET['filter_class'] ) && !empty( $_GET['filter_class'] ) ) ? $_GET['filter_class'] : '';
    ?>

    <div class="tablenav top">
        <div class="alignleft actions bulkactions">
            <label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label>
            <select name="action" id="bulk-action-selector-top">
                <option value="-1" selected="selected">Bulk Actions</option>
                <option value="trash">Move to Trash</option>
            </select>
            <input type="submit" name="" id="doaction" class="button action" value="Apply">
        </div>
        <div class="alignleft actions bulkactions">
            <form action="" method="get">
                <input type="hidden" name="page" value="wpems-students">
                <label for="bulk-action-selector-top" class="screen-reader-text">Filter by a Class</label>
                <select name="filter_class" id="bulk-action-selector-top">
                    <option value="" selected="selected">Filter By Class</option>
                    <?php foreach ($classes as $class_key => $class ): ?>
                        <option value="<?php echo $class->id ?>" <?php selected( $filter_class, $class->id ); ?>><?php echo $class->class_name; ?></option>
                    <?php endforeach ?>
                </select>
                <input type="submit" name="" id="doaction" class="button action" value="Apply">
            </form>
        </div>

    </div>
    <?php
    $users      = WPEMS_Users::init();
    $no         = 20;
    $paged      = ( isset( $_GET['paged'] ) ) ? $_GET['paged'] : 1;
    $offset     = ( $paged == 1 ) ? 0 : ( ( $paged-1)*$no );
    if ( $filter_class ) {
        $total_user = $users->count_user_by( $no, $offset, 'student', $filter_class );
        $students   = $users->get_users_list_by( $no, $offset, 'student', $filter_class );
    } else {
        $total_user = $users->count_user( $no, $offset, 'student' );
        $students   = $users->get_users_list( $no, $offset, 'student' );
    }
    ?>
    <table class="wp-list-table widefat fixed teachers-list-table">
        <thead>
            <tr>
                <th scope="col" id="cb" class="manage-column column-cb check-column" style="">
                    <input id="cb-select-all-1" type="checkbox">
                </th>
                <th class="col-"><?php _e( 'Username', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Full Name', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Roll', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Class', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Email', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Phone', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Gender', 'wp-ems' ); ?></th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th scope="col" id="cb" class="manage-column column-cb check-column" style="">
                    <input id="cb-select-all-1" type="checkbox">
                </th>
                <th class="col-"><?php _e( 'Username', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Full Name', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Roll', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Class', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Email', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Phone', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Gender', 'wp-ems' ); ?></th>
            </tr>
        </tfoot>

        <tbody id="the-list">
            <?php if ( $students ): ?>
                <?php foreach ( $students as $key => $student ): ?>
                    <tr class="alternate" id="wp-ems-teacher-<?php echo 2; ?>">
                        <th scope="row" class="check-column">
                            <input id="cb-select-1" type="checkbox" name="student_id[]" value="<?php echo $student->ID; ?>">
                        </th>
                        <td class="col- column-username">
                            <img alt="" src="<?php echo wpems_get_profile_avatar( $student->ID ); ?>" class="avatar avatar-32 photo" height="32" width="32">
                            <strong><a href="<?php echo add_query_arg( array( 'student_id' => $student->ID ), wpems_edit_student_url() ); ?>"><?php echo $student->user_login; ?></a></strong>

                            <div class="row-actions">
                                <span class="edit"><a href="<?php echo add_query_arg( array( 'student_id' => $student->ID ), wpems_edit_student_url() ); ?>" data-id="<?php echo $student->ID; ?>" title="Edit this item"><?php _e( 'Edit', 'wp-ems' ); ?></a> | </span>
                                <span class="trash"><a class="submitdelete" data-id="<?php echo $student->ID; ?>" title="Delete this item" onclick="return confirm('Are you sure?');" class="submitdelete" title="Delete this item" href="<?php echo wp_nonce_url( add_query_arg( array( 'delete_action' => 'wpems-delete-student', 'student_id' => $student->ID ), wpems_edit_student_url() ), 'wpems-delete-student' ); ?>"><?php _e( 'Delete', 'wp-ems' ); ?></a></span>
                            </div>
                        </td>
                        <td class="col-"><?php echo $student->display_name; ?></td>
                        <td class="col-"><?php echo get_user_meta( $student->ID, 'roll', true ); ?></td>
                        <td class="col-">
                            <?php
                                $class_name_id = get_user_meta( $student->ID, 'class_id', true );
                                if ( $class_name_id ) {
                                    echo isset( $class_name_arr[$class_name_id] ) ? $class_name_arr[$class_name_id] : '';
                                }
                            ?>
                        </td>
                        <td class="col-"><?php echo $student->user_email; ?></td>
                        <td class="col-"><?php echo get_user_meta( $student->ID, 'phone', true ); ?></td>
                        <td class="col-"><?php echo ucfirst( get_user_meta( $student->ID, 'gender', true ) ); ?></td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr class="even">
                    <td colspan="4"><?php _e( 'No Students Found', 'wp-ems' ); ?></td>
                </tr>
            <?php endif ?>

        </tbody>
    </table>

    <div class="tablenav bottom">
        <div class="alignleft actions bulkactions">
            <label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label>
            <select name="action" id="bulk-action-selector-top">
                <option value="-1" selected="selected">Bulk Actions</option>
                <option value="trash">Move to Trash</option>
            </select>
            <input type="submit" name="" id="doaction" class="button action" value="Apply">
        </div>
        <?php if ( $total_user > $no ): ?>
            <div class="tablenav-pages">
                <?php echo wpems_paginations( $total_user, $paged, $no, wpems_student_tab_url() ); ?>
            </div>
        <?php endif ?>
    </div>
</div>












