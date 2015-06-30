    <h2><?php _e( 'Manage Sections', 'wp-ems' ); ?> <a href="<?php echo wpems_add_new_section_url(); ?>" id="wpems-new-teacher" class="add-new-h2"><?php _e( 'Add New', 'wp-ems' ); ?></a></h2>

    <?php if ( isset( $_GET['wpems_message'] ) ): ?>

        <?php if ( $_GET['wpems_message'] == 'success' ): ?>
            <div class="updated settings-updated notice is-dismissible">
                <p><strong><?php _e( 'Successfully added a new section', 'wp-ems') ?></strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
        <?php elseif ( $_GET['wpems_message'] == 'updated' ): ?>
            <div class="updated settings-updated notice is-dismissible">
                <p><strong><?php _e( 'Successfully Updated section info', 'wp-ems') ?></strong></p>
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
    $filter_class = ( isset( $_GET['filter_class'] ) && !empty( $_GET['f ilter_class'] ) ) ? $_GET['filter_class'] : '';
    ?>

    <div class="tablenav top">
        <div class="alignleft actions bulkactions">
            <label for="bulk-action-selector-top" class="screen-reader-text">Select Bulk Action</label>
            <select name="action" id="bulk-action-selector-top">
                <option value="-1" selected="selected">Bulk Actions</option>
                <option value="trash">Move to Trash</option>
            </select>
            <input type="submit" name="" id="doaction" class="button action" value="Apply">
        </div>
        <div class="alignleft actions bulkactions">
            <form action="" method="get">
                <input type="hidden" name="page" value="wpems-class">
                <input type="hidden" name="tab" value="sections">
                <label for="bulk-action-selector-top" class="screen-reader-text">Filter by a Class</label>
                <select name="filter_class" id="bulk-action-selector-top">
                    <option value="" selected="selected">Filter By Class</option>
                    <?php foreach ( $classes as $class_key => $class ): ?>
                        <option value="<?php echo $class->id ?>" <?php selected( $filter_class, $class->id ); ?>><?php echo $class->class_name; ?></option>
                    <?php endforeach ?>
                </select>
                <input type="submit" name="" id="doaction" class="button action" value="Apply">
            </form>
        </div>
    </div>
    <?php
    $section    = WPEMS_Section::init();
    $no         = 10;
    $paged      = ( isset( $_GET['paged'] ) ) ? $_GET['paged'] : 1;
    $offset     = ( $paged == 1 ) ? 0 : ( ( $paged-1)*$no );
    if ( $filter_class ) {
        $total_section = $section->count_section( $_GET['filter_class'] );
        $sections   = $section->get_section_by_class( $_GET['filter_class'], $no, $offset );
    } else {
        $total_section = $section->count_section();
        $sections   = $section->get_section( null, $no, $offset );
    }

    ?>
    <table class="wp-list-table widefat fixed teachers-list-table">
        <thead>
            <tr>
                <th scope="col" id="cb" class="manage-column column-cb check-column" style="">
                    <input id="cb-select-all-1" type="checkbox">
                </th>
                <th class="col-"><?php _e( 'Section Name', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Nick name', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Assign Teacher', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Class', 'wp-ems' ); ?></th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th scope="col" id="cb" class="manage-column column-cb check-column" style="">
                    <input id="cb-select-all-1" type="checkbox">
                </th>
                <th class="col-"><?php _e( 'Section Name', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Nick name', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Assign Teacher', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Class', 'wp-ems' ); ?></th>
            </tr>
        </tfoot>

        <tbody id="the-list">
            <?php if ( $sections ): ?>

                <?php foreach ( $sections as $section_key => $section ): ?>
                    <tr class="alternate" id="wp-ems-teacher-<?php echo $section->id; ?>">
                        <th scope="row" class="check-column">
                            <input id="cb-select-1" type="checkbox" name="section_id[]" value="<?php echo $section->id; ?>">
                        </th>
                        <td class="col- column-username">
                            <strong><a href="<?php echo add_query_arg( array( 'section_id' => $section->id ), wpems_edit_section_url() ); ?>"><?php echo $section->section_name; ?></a></strong>
                            <div class="row-actions">
                                <span class="edit"><a href="<?php echo add_query_arg( array( 'section_id' => $section->id ), wpems_edit_section_url() ); ?>" data-id="<?php echo $section->id; ?>" title="Edit this item"><?php _e( 'Edit', 'wp-ems' ); ?></a> | </span>
                                <span class="trash"><a onclick="return confirm('Are you sure?');" class="submitdelete" data-id="<?php echo $section->id; ?>" title="Delete this item" href="<?php echo wp_nonce_url( add_query_arg( array( 'delete_action' => 'wpems-delete-section', 'section_id' => $section->id ), wpems_edit_section_url() ), 'wpems-delete-section' ); ?>"><?php _e( 'Delete', 'wp-ems' ); ?></a></span>
                            </div>
                        </td>
                        <td class="col-"><?php echo $section->section_nick_name; ?></td>
                        <td class="col-"><?php echo wpems_display_user_fullname( $section->teacher_id ); ?></td>
                        <td class="col-"><?php echo $class_name_arr[$section->class_id]; ?></td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr class="alternate">
                    <td colspan="5">No Sections Found</td>
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
        <?php if ( $total_section > $no ): ?>
            <div class="tablenav-pages">
                <?php echo wpems_paginations( $total_section, $paged, $no, wpems_section_tab_url() ); ?>
            </div>
        <?php endif ?>
    </div>