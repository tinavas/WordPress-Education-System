<?php
/**
*  WP EMS Admin Class
*
*  @since 0.1
*
*  @author sabbir <sabbir.081070@gmail.com>
*/
class WPEMS_Admin {

    /**
     * Load automitically when class initiate
     *
     * @uses actions
     * @uses filters
     *
     * @since 0.1
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
    }

    /**
     * Initializes the WP_Education_Management() class
     *
     * Checks for an existing WP_Education_Management() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new WPEMS_Admin();
        }

        return $instance;
    }


    public function add_admin_menu() {
        $capability = apply_filters( 'wpems_admin_role', 'manage_options' );
        add_menu_page( __( 'WP School Mangement', 'wp-ems' ), __( 'School', 'wp-ems' ), $capability, 'wpems-admin-opt', array( $this, 'adming_page_handle' ), 'dashicons-awards', 55 );
        add_submenu_page( 'wpems-admin-opt', __( 'Students', 'wp-ems' ), __( 'Students', 'wp-ems' ), $capability, 'wpems-students', array( $this, 'load_students_views') );
        add_submenu_page( 'wpems-admin-opt', __( 'Teachers', 'wp-ems' ), __( 'Teachers', 'wp-ems' ), $capability, 'wpems-teachers', array( $this, 'load_teachers_views') );
        add_submenu_page( 'wpems-admin-opt', __( 'Class', 'wp-ems' ), __( 'Class', 'wp-ems' ), $capability, 'wpems-class', array( $this, 'load_class_views') );
        add_submenu_page( 'wpems-admin-opt', __( 'Subject', 'wp-ems' ), __( 'Subject', 'wp-ems' ), $capability, 'wpems-subject', array( $this, 'load_subject_views') );
        add_submenu_page( 'wpems-admin-opt', __( 'Routine', 'wp-ems' ), __( 'Routine', 'wp-ems' ), $capability, 'wpems-routine', array( $this, 'load_routine_views') );

    }

    public function adming_page_handle() {
        echo '<div class="wrap wpems-dashbaord">';
        require_once WP_EMS_VIEW_DIR . '/dashboard/main.php';
        echo '</div>';
    }

    public function load_students_views() {
        $actions = isset( $_GET['action'] ) ? $_GET['action'] : '';

        if ( $actions == 'new' || $actions == 'edit' ) {
            require_once WP_EMS_VIEW_DIR . '/students/new-student.php';
        } else {
            require_once WP_EMS_VIEW_DIR . '/students/main.php';
        }
    }

    public function load_teachers_views() {
        $actions = isset( $_GET['action'] ) ? $_GET['action'] : '';

        if ( $actions == 'new' || $actions == 'edit' ) {
            require_once WP_EMS_VIEW_DIR . '/teachers/new-teacher.php';
        } else {
            require_once WP_EMS_VIEW_DIR . '/teachers/main.php';
        }
    }

    public function load_class_views() {
        echo '<div class="wrap wpems-class">';
        echo '<h2 class="nav-tab-wrapper">';
        $class_tab = $this->class_tab();
        $current = isset( $_GET['tab'] ) ? strtolower( $_GET['tab'] ) : 'class';
        foreach( $class_tab as $tab => $url ){
            $class = ( strtolower( $tab ) == $current ) ? ' nav-tab-active' : '';
            echo "<a class='nav-tab$class' href='".$url."'>$tab</a>";
        }
        echo '</h2>';
        ?>
        <div class="wpems-tab-content">
            <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'class' ): ?>

                <?php if ( isset( $_GET['action'] ) && ( $_GET['action'] == 'new' || $_GET['action'] == 'edit' ) ) : ?>
                    <?php require_once WP_EMS_VIEW_DIR . '/class/new-class.php'; ?>
                <?php else: ?>
                    <?php require_once WP_EMS_VIEW_DIR . '/class/class.php'; ?>
                <?php endif ?>

            <?php elseif ( isset( $_GET['tab'] ) && $_GET['tab'] == 'sections' ): ?>

                <?php if ( isset( $_GET['action'] ) && ( $_GET['action'] == 'new' || $_GET['action'] == 'edit' ) ) : ?>
                    <?php require_once WP_EMS_VIEW_DIR . '/section/new-section.php'; ?>
                <?php else: ?>
                    <?php require_once WP_EMS_VIEW_DIR . '/section/section.php'; ?>
                <?php endif ?>

            <?php else: ?>

                <?php require_once WP_EMS_VIEW_DIR . '/class/class.php'; ?>

            <?php endif ?>

        </div>
        <?php
        echo '</div>';
    }

    public function class_tab() {
        $tabs = array(
            'Class' => wpems_class_tab_url(),
            'Sections' => wpems_section_tab_url(),
        );

        return apply_filters( 'wpems_class_tabs', $tabs );
    }

    public function load_subject_views() {
        $actions = isset( $_GET['action'] ) ? $_GET['action'] : '';

        if ( $actions == 'new' || $actions == 'edit' ) {
            require_once WP_EMS_VIEW_DIR . '/subject/new-subject.php';
        } else {
            require_once WP_EMS_VIEW_DIR . '/subject/subject.php';
        }
    }

    public function load_routine_views() {
        $actions = isset( $_GET['action'] ) ? $_GET['action'] : '';

        if ( $actions == 'new' || $actions == 'edit' ) {
            require_once WP_EMS_VIEW_DIR . '/routine/new-routine.php';
        } else {
            require_once WP_EMS_VIEW_DIR . '/routine/main.php';
        }
    }

}
