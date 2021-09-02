<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/kunal1400/cra.git
 * @since      1.0.0
 *
 * @package    Cra
 * @subpackage Cra/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cra
 * @subpackage Cra/public
 * @author     Kunal Malviya <mark@bilmarctech.com>
 */
class Cra_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cra_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cra_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cra-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cra_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cra_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cra-public.js', array( 'jquery' ), $this->version, false );

	}

	public function show_listings_cb() {
		global $wpdb;
		$tableName = $wpdb->prefix."stores";
		$results = $wpdb->get_results("select * FROM $tableName LIMIT 10", ARRAY_A);

		$ret = '<table width="799" border="0" align="center" cellpadding="0" cellspacing="0" class="smallbold">';

			$count == 0;
			foreach ($results as $i => $ShowStores) {
					$Name = $ShowStores['Name'];
					$Address = $ShowStores['Address'];
					$Address2 = $ShowStores['Address2'];
					$City = $ShowStores['City'];
					$State = $ShowStores['State'];
					$ListingZip = $ShowStores['Zip'];
					$Phone = $ShowStores['Phone'];
					$Website = $ShowStores['Website'];
					$Discount = $ShowStores ['Discount'];
					$Category = $ShowStores['Category'];
					$Longitude = $ShowStores['Longitude'];
					$Latitude = $ShowStores['Latitude'];
					$Miles = $ShowStores['distance'];
					$Featured = $ShowStores['featured'];
					$PastFeatured = $ShowStores['pastfeatured'];
					$DirectionAddress = "$Address, $City, $State, $ListingZip";
					$DirectionAddress = urlencode($DirectionAddress);

					if ($Featured == "1") {
						$CatPic = "/images/sotm.gif";
					}
					elseif ($PastFeatured == "1") {
						$CatPic = "/images/sotm_past.gif";
					}
					elseif ($Category == "1") {
						$CatPic = "/images/platinum_icon.jpg";
					}
					elseif ($Category == "2") {
						$CatPic = "/images/gold_icon.jpg";
					}
					elseif ($Category == "3") {
						$CatPic = "/images/business_icon.jpg";
					}

					$ret .= "<tr>";
					$ret .= '<td width="266" height="90" align="left" valign="top" class="smalltextbold">
						<span class="storename"><?php echo $Name ?></span>
						<span class="smalltextbold"><br />';
						if ($Category != "2") {
							$ret .= "$Address <br />";
						}
						if ($Category != "2") {
							if ($Address2 != "") {
								$ret .= "$Address2 <br />";
							}
						}
						$ret .= $City.','.$State.'&nbsp;';
						if ($Category != "2") {
							$ret .= $ListingZip;
						}
						$ret .= "<br />";
						if ($Category != "2") {
							if ($Phone != "") {
								$ret .= $this->format_phone($Phone);
							}
							$ret .= "<br />";
							if ($Website != "") {
								$ret .= "<a href=http://$Website target=_blank class=listingslink>$Website</a> <br>";
							}
						}
						$ret .= "</span>";
						if ($Category != "2") {
							$ret .= '<a href="http://maps.google.com/maps?daddr='.$DirectionAddress.'"target="_blank" class="listingslink">Get Directions</a>';
						}
						$ret .= '<br />';
						if ($Category == "2") {
							$ret .= '<a href="https://www.cigarrights.org/join.php?Type=GACS&MemType=Renew&Ref=" class="listingslinkupgrade">Upgrade to Platinum to show full listing</a>';
						}
						$ret .= '<br /><br />Distance to shop: <font color="#00CC00">'.round($Miles).' miles</font><br><br>';
						$ret .= '<img src="'.$CatPic.'" /></td>';
					$ret .= '</tr>';
		}
		$ret .= '</table>';

		return $ret;
	}

	function format_phone($phone) {
		$phone = preg_replace("/[^0-9]/", "", $phone);
		if(strlen($phone) == 7)
			return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
		elseif(strlen($phone) == 10)
			return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
		else
			return $phone;
	}

}
