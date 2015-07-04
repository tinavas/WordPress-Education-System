<?php
$routines = wpems_class_routine_format();
$weeks_day = wpems_get_week();
?>
<div class="wrap wpems-class-routine-wrap">

    <h2><?php _e( 'Manage Class Schedule', 'wp-ems' ); ?>
        <?php if ( !current_user_can('student') ): ?>
            <a href="<?php echo wpems_add_new_routine_url(); ?>" id="wpems-new-teacher" class="add-new-h2"><?php _e( 'Add New', 'wp-ems' ); ?></a></h2>
        <?php endif ?>

    <?php if ( isset( $_GET['wpems_message'] ) ): ?>

        <?php if ( $_GET['wpems_message'] == 'success' ): ?>
            <div class="updated settings-updated notice is-dismissible">
                <p><strong><?php _e( 'Successfully added a new Routine', 'wp-ems') ?></strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
        <?php elseif ( $_GET['wpems_message'] == 'updated' ): ?>
            <div class="updated settings-updated notice is-dismissible">
                <p><strong><?php _e( 'Successfully Updated Routine info', 'wp-ems') ?></strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
        <?php elseif ( $_GET['wpems_message'] == 'deleted' ): ?>
            <div class="updated settings-updated notice is-dismissible">
                <p><strong><?php _e( 'Successfully deleted Routine info', 'wp-ems') ?></strong></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
        <?php endif ?>

    <?php endif ?>

    <?php if ( $routines ): ?>

        <?php foreach ( $routines as $class_name => $routine_value ): ?>

            <div class="postbox wpems-routine-metabox">
                <div id="dashboard-widgets" class="metabox-holder">
                    <h3 class="hndle"><span><?php _e( 'Class: ', 'wp-ems ') ?><?php echo $class_name ?></span></h3>
                    <div class="wpems-routine-action">
                        <a href="#" class="wpems-action-toggle">Toggle</a>
                    </div>
                    <div class="wpems-routine-content inside">
                        <table class="wpems-class-routine">
                            <thead>
                                <th>Day</th>
                                <th>Class Schedule</th>
                            </thead>
                            <tbody>
                                <?php foreach ( $weeks_day as $week_key => $week_val ): ?>

                                    <tr>
                                        <td><?php echo $week_val; ?></td>
                                        <td>
                                        <?php foreach ( $routine_value as $routine ): ?>

                                            <?php if ( isset( $routine->day ) && $week_key == $routine->day ): ?>
                                                <div class="wpems-routine-item">
                                                    <?php echo $routine->name . ' ( '. $routine->start_time. ' - ' . $routine->end_time . ' )'; ?>
                                                    <?php if ( !current_user_can('student') ): ?>
                                                        <span class="routine-action">
                                                            <a href="<?php echo add_query_arg( array( 'routine_id' => $routine->id ), wpems_edit_routine_url() ) ?>"><i class="fa fa-pencil"></i></a>
                                                            <a href="<?php echo wp_nonce_url( add_query_arg( array( 'delete_action' => 'wpems-delete-routine', 'routine_id' => $routine->id ), wpems_edit_routine_url() ), 'wpems-delete-routine' ); ?>" onclick="return confirm('Are you sure?');" ><i class="fa fa-times"></i></a>
                                                        </span>
                                                    <?php endif ?>
                                                </div>
                                            <?php endif ?>

                                        <?php endforeach ?>
                                        </td>
                                    </tr>

                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php endforeach ?>

    <?php else: ?>
        <div class="updated settings-updated notice is-dismissible">
            <p><strong><?php _e( 'No Routine Found', 'wp-ems') ?></strong></p>
        </div>
    <?php endif ?>

</div>