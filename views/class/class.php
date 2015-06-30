    <h2><?php _e( 'Manage Class', 'wp-ems' ); ?> <a href="<?php echo wpems_add_new_class_url(); ?>" id="wpems-new-teacher" class="add-new-h2"><?php _e( 'Add New', 'wp-ems' ); ?></a></h2>

    <?php if ( isset( $_GET['wpems_message'] ) ): ?>

        <?php if ( $_GET['wpems_message'] == 'success' ): ?>
            <div class="updated settings-updated notice is-dismissible">
                <p><strong><?php _e( 'Successfully added a new Class', 'wp-ems') ?></strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
        <?php elseif ( $_GET['wpems_message'] == 'updated' ): ?>
            <div class="updated settings-updated notice is-dismissible">
                <p><strong><?php _e( 'Successfully Updated Class info', 'wp-ems') ?></strong></p>
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
    $class      = WPEMS_Class::init();
    $no         = 10;
    $paged      = ( isset( $_GET['paged'] ) ) ? $_GET['paged'] : 1;
    $offset     = ( $paged == 1 ) ? 0 : ( ( $paged-1)*$no );
    $total_class = $class->count_class();
    $classes   = $class->get_class( null, $no, $offset );

    ?>
    <table class="wp-list-table widefat fixed teachers-list-table">
        <thead>
            <tr>
                <th scope="col" id="cb" class="manage-column column-cb check-column" style="">
                    <input id="cb-select-all-1" type="checkbox">
                </th>
                <th class="col-"><?php _e( 'Class Name', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Class Numeric name', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Assign Teacher', 'wp-ems' ); ?></th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th scope="col" id="cb" class="manage-column column-cb check-column" style="">
                    <input id="cb-select-all-1" type="checkbox">
                </th>
                <th class="col-"><?php _e( 'Class Name', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Class Numeric name', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Assign Teacher', 'wp-ems' ); ?></th>

            </tr>
        </tfoot>

        <tbody id="the-list">
            <?php if ( $classes ): ?>
                <?php foreach ( $classes as $key => $class ): ?>
                    <tr class="alternate" id="wp-ems-teacher-<?php echo $class->id; ?>">
                        <th scope="row" class="check-column">
                            <input id="cb-select-1" type="checkbox" name="class_id[]" value="<?php echo $class->id; ?>">
                        </th>
                        <td class="col- column-username">
                            <strong><a href="<?php echo add_query_arg( array( 'class_id' => $class->id ), wpems_edit_class_url() ); ?>"><?php echo $class->class_name; ?></a></strong>
                            <div class="row-actions">
                                <span class="edit"><a href="<?php echo add_query_arg( array( 'class_id' => $class->id ), wpems_edit_class_url() ); ?>" data-id="<?php echo $class->id; ?>" title="Edit this item"><?php _e( 'Edit', 'wp-ems' ); ?></a> | </span>
                                <span class="trash"><a onclick="return confirm('Are you sure?');" class="submitdelete" data-id="<?php echo $class->id; ?>" title="Delete this item" href="<?php echo wp_nonce_url( add_query_arg( array( 'delete_action' => 'wpems-delete-class', 'class_id' => $class->id ), wpems_edit_class_url() ), 'wpems-delete-class' ); ?>"><?php _e( 'Delete', 'wp-ems' ); ?></a></span>
                            </div>
                        </td>
                        <td class="col-"><?php echo $class->class_numeric_name; ?></td>
                        <td class="col-"><?php echo wpems_display_user_fullname( $class->teacher_id ); ?></td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr classe="even">
                    <td colspan="3"><?php _e( 'No Class founds.', 'wp-ems' ); ?></td>
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
        <?php if ( $total_class > $no ): ?>
            <div class="tablenav-pages">
                <?php echo wpems_paginations( $total_class, $paged, $no, wpems_class_tab_url() ); ?>
            </div>
        <?php endif ?>
    </div>