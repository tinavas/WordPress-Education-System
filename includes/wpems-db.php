<?php

global $wpdb;
$table_name1 = $wpdb->prefix . 'wpems_class';
$table_name2 = $wpdb->prefix . 'wpems_subject';
$table_name3 = $wpdb->prefix . 'wpems_section';
$table_name4 = $wpdb->prefix . 'wpems_routine';

$sql1 = "CREATE TABLE IF NOT EXISTS {$table_name1} (
           `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
           `class_name` varchar(255) DEFAULT NULL,
           `class_numeric_name` int(11) DEFAULT NULL,
           `teacher_id` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

$sql2 = "CREATE TABLE IF NOT EXISTS {$table_name2} (
           `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
           `name` varchar(255) DEFAULT NULL,
           `class_id` int(11) DEFAULT NULL,
           `teacher_id` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";


$sql3 = "CREATE TABLE IF NOT EXISTS {$table_name3} (
           `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
           `section_name` varchar(255) DEFAULT NULL,
           `section_nick_name` varchar(255) DEFAULT NULL,
           `teacher_id` int(11) DEFAULT NULL,
           `class_id` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";


$sql4 = "CREATE TABLE IF NOT EXISTS {$table_name4} (
           `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
           `class_id` int(11) DEFAULT NULL,
           `subject_id` int(11) DEFAULT NULL,
           `start_time` varchar(20) DEFAULT NULL,
           `end_time` varchar(20) DEFAULT NULL,
           `day` varchar(20) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

require_once ABSPATH . 'wp-admin/includes/upgrade.php';
dbDelta( $sql1 );
dbDelta( $sql2 );
dbDelta( $sql3 );
dbDelta( $sql4 );

?>
