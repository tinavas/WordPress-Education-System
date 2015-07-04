<div class="wrap wpems-teacher-wrap">

    <h2><?php _e( 'Manage Subjects', 'wp-ems' ); ?>
        <?php if ( !current_user_can('student') ): ?>
            <a href="<?php echo wpems_add_new_subject_url(); ?>" id="wpems-new-teacher" class="add-new-h2"><?php _e( 'Add New', 'wp-ems' ); ?></a></h2>
        <?php endif ?>

    <?php if ( isset( $_GET['wpems_message'] ) ): ?>

        <?php if ( $_GET['wpems_message'] == 'success' ): ?>
            <div class="updated settings-updated notice is-dismissible">
                <p><strong><?php _e( 'Successfully added a new subject', 'wp-ems') ?></strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
        <?php elseif ( $_GET['wpems_message'] == 'updated' ): ?>
            <div class="updated settings-updated notice is-dismissible">
                <p><strong><?php _e( 'Successfully Updated subject info', 'wp-ems') ?></strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
        <?php endif ?>

    <?php endif ?>

    <?php
    $class = WPEMS_Class::init();
    $teachers = WPEMS_Users::init()->get_users_list( NULL, NULL, 'teacher' );
    $classes = $class->get_class();

    if ( $classes ) {
        $class_name_arr = wp_list_pluck( $classes, 'class_name', 'id' );
    } else {
        $class_name_arr = array();
    }

    if ( $teachers ) {
        $teacher_name_arr = wp_list_pluck( $teachers, 'display_name', 'ID' );
    } else {
        $teacher_name_arr = array();
    }

    $filter_class = ( isset( $_GET['filter_class'] ) && !empty( $_GET['filter_class'] ) ) ? $_GET['filter_class'] : NULL;
    $filter_teacher = ( isset( $_GET['filter_teacher'] ) && !empty( $_GET['filter_teacher'] ) ) ? $_GET['filter_teacher'] : NULL;
    ?>

    <div class="tablenav top">
        <?php if ( !current_user_can('student') ): ?>
            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-top" class="screen-reader-text">Select Bulk Action</label>
                <select name="action" id="bulk-action-selector-top">
                    <option value="-1" selected="selected">Bulk Actions</option>
                    <option value="trash">Move to Trash</option>
                </select>
                <input type="submit" name="" id="doaction" class="button action" value="Apply">
            </div>
        <?php endif ?>
        <div class="alignleft actions bulkactions">
            <form action="" method="get">
                <input type="hidden" name="page" value="wpems-subject">
                <?php if ( $filter_teacher ): ?>
                    <input type="hidden" name="filter_teacher" value="<?php echo $filter_teacher; ?>">
                <?php endif ?>
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

        <div class="alignleft actions bulkactions">
            <form action="" method="get">
                <input type="hidden" name="page" value="wpems-subject">
                <?php if ( $filter_class ): ?>
                    <input type="hidden" name="filter_class" value="<?php echo $filter_class; ?>">
                <?php endif ?>
                <label for="bulk-action-selector-top" class="screen-reader-text">Filter by a Class</label>
                <select name="filter_teacher" id="bulk-action-selector-top">
                    <option value="" selected="selected">Filter By Teacher</option>
                    <?php foreach ($teachers as $teacher_key => $teacher ): ?>
                        <option value="<?php echo $teacher->ID ?>" <?php selected( $filter_teacher, $teacher->ID ); ?>><?php echo $teacher->display_name; ?></option>
                    <?php endforeach ?>
                </select>
                <input type="submit" name="" id="doaction" class="button action" value="Apply">
            </form>
        </div>

    </div>
    <?php
    $subject    = WPEMS_Subject::init();
    $no         = 10;
    $paged      = ( isset( $_GET['paged'] ) ) ? $_GET['paged'] : 1;
    $offset     = ( $paged == 1 ) ? 0 : ( ( $paged-1)*$no );
    if ( $filter_class || $filter_teacher ) {
        $total_subject = $subject->count_subject( $filter_class, $filter_teacher );
        $subjects   = $subject->get_subject_by( $filter_class, $filter_teacher, $no, $offset );
    } else {
        $total_subject = $subject->count_subject();
        $subjects   = $subject->get_subject( null, $no, $offset );
    }

    ?>
    <table class="wp-list-table widefat fixed teachers-list-table">
        <thead>
            <tr>
                <?php if ( !current_user_can('student' ) ): ?>

                <th scope="col" id="cb" class="manage-column column-cb check-column" style="">
                    <input id="cb-select-all-1" type="checkbox">
                </th>
                <?php endif ?>
                <th class="col-"><?php _e( 'Subject Name', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Assing Teacher', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Class', 'wp-ems' ); ?></th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <?php if ( !current_user_can('student' ) ): ?>
                    <th scope="col" id="cb" class="manage-column column-cb check-column" style="">
                        <input id="cb-select-all-1" type="checkbox">
                    </th>
                <?php endif; ?>
                <th class="col-"><?php _e( 'Subject Name', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Assing Teacher', 'wp-ems' ); ?></th>
                <th class="col-"><?php _e( 'Class', 'wp-ems' ); ?></th>
            </tr>
        </tfoot>

        <tbody id="the-list">
            <?php if ( $subjects ): ?>

                <?php foreach ( $subjects as $subject_key => $subject ): ?>
                    <tr class="alternate" id="wp-ems-teacher-<?php echo $subject->id; ?>">
                        <?php if ( !current_user_can('student') ): ?>
                            <th scope="row" class="check-column">
                                <input id="cb-select-1" type="checkbox" name="section_id[]" value="<?php echo $subject->id; ?>">
                            </th>
                        <?php endif ?>
                        <td class="col- column-username">
                            <strong>
                                <?php if ( !current_user_can('student' ) ): ?>
                                    <a href="<?php echo add_query_arg( array( 'subject_id' => $subject->id ), wpems_edit_subject_url() ); ?>"><?php echo $subject->name; ?></a>
                                <?php else: ?>
                                    <?php echo $subject->name; ?>
                                <?php endif; ?>
                            </strong>
                            <?php if ( !current_user_can('student' ) ): ?>
                                <div class="row-actions">
                                    <span class="edit"><a href="<?php echo add_query_arg( array( 'subject_id' => $subject->id ), wpems_edit_subject_url() ); ?>" data-id="<?php echo $subject->id; ?>" title="Edit this item"><?php _e( 'Edit', 'wp-ems' ); ?></a> | </span>
                                    <span class="trash"><a onclick="return confirm('Are you sure?');" class="submitdelete" data-id="<?php echo $subject->id; ?>" title="Delete this item" href="<?php echo wp_nonce_url( add_query_arg( array( 'delete_action' => 'wpems-delete-subject', 'subject_id' => $subject->id ), wpems_edit_subject_url() ), 'wpems-delete-subject' ); ?>"><?php _e( 'Delete', 'wp-ems' ); ?></a></span>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="col-"><?php echo isset( $teacher_name_arr[$subject->teacher_id ] ) ? $teacher_name_arr[$subject->teacher_id ] : ''; ?></td>
                        <td class="col-"><?php echo isset( $class_name_arr[$subject->class_id] ) ? $class_name_arr[$subject->class_id] : ''; ?></td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr class="alternate">
                    <td colspan="5">No Subjects Found</td>
                </tr>
            <?php endif ?>

        </tbody>
    </table>

    <div class="tablenav bottom">
        <?php if ( !current_user_can('student') ): ?>
            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label>
                <select name="action" id="bulk-action-selector-top">
                    <option value="-1" selected="selected">Bulk Actions</option>
                    <option value="trash">Move to Trash</option>
                </select>
                <input type="submit" name="" id="doaction" class="button action" value="Apply">
            </div>
        <?php endif ?>
        <?php if ( $total_subject > $no ): ?>
            <div class="tablenav-pages">
                <?php echo wpems_paginations( $total_subject, $paged, $no, wpems_subject_tab_url() ); ?>
            </div>
        <?php endif ?>
    </div>
</div>