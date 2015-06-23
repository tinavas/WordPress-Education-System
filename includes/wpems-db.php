<?php

global $wpdb;
$table_name1 = $wpdb->prefix . 'wpems_class';

$sql1 = "CREATE TABLE IF NOT EXISTS {$table_name1} (
           `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
           `class_name` varchar(255) DEFAULT NULL,
           `class_numeric_name` int(11) DEFAULT NULL,
           `teacher_id` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

require_once ABSPATH . 'wp-admin/includes/upgrade.php';
dbDelta( $sql1 );

?>
