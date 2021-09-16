<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/kunal1400/cra.git
 * @since      1.0.0
 *
 * @package    Cra
 * @subpackage Cra/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cra
 * @subpackage Cra/includes
 * @author     Kunal Malviya <mark@bilmarctech.com>
 */
class Cra_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $table_prefix, $wpdb;
	    $storeTable = $table_prefix . "stores";

	    #Check to see if the table exists already, if not, then create it
	    if($wpdb->get_var( "show tables like '$storeTable'" ) != $storeTable) {
	        $sql = "CREATE TABLE `". $storeTable . "` ( ";
	        $sql .= "  `StoreID`  int(11)   NOT NULL auto_increment, ";
					$sql .= "  `Name` varchar(255) NOT NULL, ";
					$sql .= "  `Address` varchar(50) NOT NULL, ";
					$sql .= "  `Address2` varchar(50) NOT NULL, ";
					$sql .= "  `City` varchar(50) NOT NULL, ";
					$sql .= "  `State` varchar(50) NOT NULL, ";
					$sql .= "  `Zip` varchar(50) DEFAULT NULL, ";
					$sql .= "  `Phone` varchar(15) DEFAULT NULL, ";
	        $sql .= "  `Website` varchar(255) DEFAULT NULL, ";
					$sql .= "  `Discount` varchar(50) DEFAULT NULL, ";
					$sql .= "  `Category` varchar(50) NOT NULL, ";
					$sql .= "  `Status` varchar(50) DEFAULT NULL, ";
					$sql .= "  `Longitude` varchar(50) DEFAULT NULL, ";
					$sql .= "  `Latitude` varchar(50) DEFAULT NULL, ";
					$sql .= "  `featured` varchar(50) DEFAULT NULL, ";
					$sql .= "  `pastfeatured` varchar(50) NOT NULL, ";
					$sql .= "  `expiration` date NOT NULL, ";
					$sql .= "  `LastUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), ";
					$sql .= "  `LastUser` varchar(50) NOT NULL, ";
	        $sql .= "  PRIMARY KEY (`StoreID`) ";
	        $sql .= "); ";

	        // File required to create table
	        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
	        dbDelta($sql);
	    }
	}

}
