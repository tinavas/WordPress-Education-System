<div class="wrap wpems-teacher-wrap">

    <h2><?php _e( 'Teachers', 'wp-ems' ); ?> <a href="<?php echo wpems_add_new_teacher_url(); ?>" id="wpems-new-teacher" class="add-new-h2"><?php _e( 'Add New', 'wp-ems' ); ?></a></h2>

    <?php if ( isset( $_GET['wpems_message'] ) ): ?>

        <?php if ( $_GET['wpems_message'] == 'success' ): ?>
            <div class="updated settings-updated notice is-dismissible">
                <p><strong><?php _e( 'Successfully added a new teacher', 'wp-ems') ?></strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
        <?php elseif ( $_GET['wpems_message'] == 'updated' ): ?>
            <div class="updated settings-updated notice is-dismissible">
                <p><strong><?php _e( 'Successfully Updated teacher info', 'wp-ems') ?></strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
        <?php endif ?>

    <?php endif ?>



    <div class="tablenav top">
        <div class="alignleft actions bulkactions">
            <label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label>
            <select name="action" id="bulk-action-selector-top">
                <option value="-1" selected="selected">Bulk Actions</option>
                <option value="trash">Move to Trash</option>
            </select>
            <input type="submit" name="" id="doaction" class="button action" value="Apply">
        </div>
    </div>
    <?php
    $users      = WPEMS_Users::init();
    $no         = 2;
    $paged      = ( isset( $_GET['paged'] ) ) ? $_GET['paged'] : 1;
    $offset     = ( $paged == 1 ) ? 0 : ( ( $paged-1)*$no );
    $total_user = $users->count_user( $no, $offset, 'teacher' );
    $teachers   = $users->get_users_list( $no, $offset, 'teacher' );
    ?>
    <table class="wp-list-table widefat fixed teachers-list-table">
        <thead>
            <tr>
                <th scope="col" id="cb" class="manage-column column-cb check-column" style="">
                    <input id="cb-select-all-1" type="checkbox">
                </th>
                <th class="col-"><?php _e( 'Username', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Full Name', 'wp-ems' ); ?></th>
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
                <th class="col-"><?php _e( 'Email', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Phone', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Gender', 'wp-ems' ); ?></th>
            </tr>
        </tfoot>

        <tbody id="the-list">

            <?php foreach ( $teachers as $key => $teacher ): ?>
                <tr class="alternate" id="wp-ems-teacher-<?php echo 2; ?>">
                    <th scope="row" class="check-column">
                        <input id="cb-select-1" type="checkbox" name="teacher_id[]" value="<?php echo $teacher->ID; ?>">
                    </th>
                    <td class="col- column-username">
                        <img alt="" src="<?php echo wpems_get_profile_avatar( $teacher->ID ); ?>" class="avatar avatar-32 photo" height="32" width="32">
                        <strong><a href="<?php echo add_query_arg( array( 'teacher_id' => $teacher->ID ), wpems_edit_teacher_url() ); ?>"><?php echo $teacher->user_login; ?></a></strong>

                        <div class="row-actions">
                            <span class="edit"><a href="<?php echo add_query_arg( array( 'teacher_id' => $teacher->ID ), wpems_edit_teacher_url() ); ?>" data-id="<?php echo $teacher->ID; ?>" title="Edit this item"><?php _e( 'Edit', 'wp-ems' ); ?></a> | </span>
                            <span class="trash"><a class="submitdelete" data-id="<?php echo $teacher->ID; ?>" title="Delete this item" href=""><?php _e( 'Delete', 'wp-ems' ); ?></a></span>
                        </div>
                    </td>
                    <td class="col-"><?php echo $teacher->display_name; ?></td>
                    <td class="col-"><?php echo $teacher->user_email; ?></td>
                    <td class="col-"><?php echo get_user_meta( $teacher->ID, 'phone', true ); ?></td>
                    <td class="col-"><?php echo ucfirst( get_user_meta( $teacher->ID, 'gender', true ) ); ?></td>
                </tr>
            <?php endforeach ?>
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
                <?php echo wpems_paginations( $total_user, $paged, $no ); ?>
            </div>
        <?php endif ?>
    </div>
</div>












