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
		// http://localhost/toysandgames/cra-listings/?State=FL&City=Orlando&Zip=32819&RadiusMiles=10&Category=1
		global $wpdb;
		$storeTableName = $wpdb->prefix."stores";
		$todays_date = date("Y-m-d");
		$allState = array('FL','MN','NY','NC','PA','TX','VA','NV','SC','AZ','NH','CA','MA','IL','KS','IN','CO','TN','MD','AL','GA','CT','LA','WA','NJ','IA','SD','MO','MI','OH','HI','DC','WY','KY','WI','NM','RI','OR','MS','OK','AK','AR','DE','ME','NE','UT','WV','ND','MT','ID','VT');

		$State = "FL";
		$City = "";
		$Zip = "";
		$RadiusMiles = 10;
		$Cat = 1;

		// Getting variables from query string and POST data
		if ( array_key_exists('_submit_check', $_POST) ) {
			$State = $_POST['State'];
			$City = $_POST['City'];
			$Zip = $_POST['Zip'];
			$RadiusMiles = $_POST['RadiusMiles'];
			$Cat = $_POST['Category'];
		}
		else {
			if (isset($_GET['State'])) {
				$State = $_GET['State'];
			}
			if (isset($_GET['City'])) {
				$City = $_GET['City'];
			}
			if (isset($_GET['Zip'])) {
				$Zip = $_GET['Zip'];
			}
			if (isset($_GET['RadiusMiles'])) {
				$RadiusMiles = $_GET['RadiusMiles'];
			}
			if (isset($_GET['Category'])) {
				$Cat = $_GET['Category'];
			}
		}
		?>
		<table style="border:1px; border-color: #888888; border-style:solid;" cellpadding="0" cellspacing="0" id="searchbg">
			<tr>
					<td width="80%" align="center" valign="top">
						<table width="100%" border="0" cellspacing="3" cellpadding="3">
							<form name="thisForm" method="get" action="">
								<input type="hidden" name="_submit_check" value="1"/>
								<tr>
									<td width="181" align="left" class="smallwhitebold">City:<br />
										<input class="smalltext" type="text" size="23" maxlength="250" name="City" value="<?php echo $City ?>" />
									</td>
									<td width="97" align="left" class="smallwhitebold">State: <br />
										<select name="State" class="smalltext">
											<?php foreach ($allState as $key => $state): ?>
												<option value="<?php echo $state ?>" <?php echo ($State == $state ? 'selected' : '') ?>><?php echo $state ?></option>
											<?php endforeach; ?>
										</select>
									</td>
									<td width="84" align="left" class="smallwhitebold">OR</td>
									<td colspan="2" align="left" class="smallwhitebold">Zip Code:<br />
										<input class="smalltext" type="text" size="23" maxlength="250" name="Zip" value="<?php echo $Zip ?>" />
									</td>
								 </tr>
								<tr>
									<td align="left" class="smallwhitebold">Within: <br />
										<select name="RadiusMiles" id="RadiusMiles" class="smalltext">
											<option value="10" <?php if ($RadiusMiles=="10"){?> selected <?php } ?>>10 Miles</option>
											<option value="25" <?php if ($RadiusMiles=="25"){?> selected <?php } ?>>25 Miles</option>
											<option value="50" <?php if ($RadiusMiles=="50"){?> selected <?php } ?>>50 Miles</option>
											<option value="100" <?php if ($RadiusMiles=="100"){?> selected <?php } ?>>100 Miles</option>
										</select>
									</td>
									<td colspan="2" align="left" class="smallwhitebold">Category:<br />
										<select name="Category" class="smalltext">
											<option value="">&lt;All Types&gt;</option>
											<option value="1" <?php if ($Cat=="1"){?> selected <?php } ?>>1</option>
											<option value="2" <?php if ($Cat=="2"){?> selected <?php } ?>>2</option>
											<option value="3" <?php if ($Cat=="3"){?> selected <?php } ?>>3</option>
										</select>
									</td>
									<td width="64"><input type="submit" value="Search"></td>
									<td width="140">&nbsp;</td>
								</tr>
							</form>
						</table>
					</td>
					<td width="20%" align="center" valign="top"><img src="/images/poweredbyCF.jpg" border="0"/></td>
				</tr>
		</table>

		<?php
		// If this is a City Search continue
		if ( $City != "" || $Zip != "" ) {
			echo "<h1>This is a City Only Search</h1>";

			/*** Open our recordset - THIS DB NOT GIVEN BY CLIENT
			if ($City <> "") {
				$findzip = mysql_query("select * FROM zipcodes WHERE City = '$City' and State = '$State' LIMIT 1") or die(mysql_error());
				while($Newzip = mysql_fetch_array($findzip)) {
			  	$searchzip = $Newzip['ZIP'];
		      $ZipLat = $Newzip['Lat'];
			  	$ZipLong = $Newzip['Long'];
				}
			}
			else {
				$findzip = mysql_query("select * FROM zipcodes WHERE zip = '$Zip' LIMIT 1") or die(mysql_error());
				while($Newzip = mysql_fetch_array($findzip)) {
			  	$searchzip = $Newzip['ZIP'];
			  	$ZipLat = $Newzip['Lat'];
			  	$ZipLong = $Newzip['Long'];
				}
			}
			//BUILD MAP
			**/
			$findzip = array();
			$searchzip = 32819;
			$ZipLat = 28.4498672;
			$ZipLong = -81.4880601;

			if( count($findzip) != 0 ) {
				echo "<div class=smallbold align=center><br>We were unable to locate this City in our database.<br>Please verify the City is spelled correctly and you have the correct state.</div>";
			}
			if ($Cat != "") {
				$sql = "SELECT Name, Address, Address2, City, State, Zip, Phone, Website, Discount, Category, Longitude, Latitude, featured, pastFeatured, (3959*acos(cos(radians($ZipLat))*cos(radians(Latitude))*cos(radians(Longitude)-radians($ZipLong))+sin(radians($ZipLat))*sin(radians(Latitude)))) AS distance FROM $storeTableName WHERE Category = '$Cat' and (expiration >= '$todays_date' OR Status = 'Active') HAVING distance < $RadiusMiles ORDER BY distance";
				$GetStores = $wpdb->get_results($sql, ARRAY_A);
			}
			else {
				$sql = "SELECT Name, Address, Address2, City, State, Zip, Phone, Website, Discount, Category, Latitude, Longitude, featured, pastFeatured, (3959*acos(cos(radians($ZipLat))*cos(radians(Latitude))*cos(radians(Longitude)-radians($ZipLong))+sin(radians($ZipLat))*sin(radians(Latitude)))) AS distance FROM $storeTableName WHERE (expiration >= '$todays_date' OR Status = 'Active') HAVING distance <= $RadiusMiles ORDER BY distance";
				$GetStores = $wpdb->get_results($sql, ARRAY_A);
			}
			?>
			<div class="searchContainer">
				<div class="searchContainerRow">
				<?php
				  foreach ($GetStores as $count => $ShowStores) {
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
				      $PastFeatured = $ShowStores['pastFeatured'];
				      $DirectionAddress = "$Address, $City, $State, $ListingZip";
				      $DirectionAddress = urlencode($DirectionAddress);

				      if ($Featured == "1"){
								$CatPic = "/images/sotm.gif";
							}
				      elseif ($PastFeatured == "1"){
								$CatPic = "/images/sotm_past.gif";
							}
				      elseif ($Category == "1"){
								$CatPic = "/images/platinum_icon.jpg";
							}
				      elseif ($Category == "2"){
								$CatPic = "/images/gold_icon.jpg";
							}
				      elseif ($Category == "3"){
								$CatPic = "/images/business_icon.jpg";
							}
				      ?>
							<div class="searchContainerCol">
							  <p><b><?php echo $Name ?></b></p>
							  <p><?php
							    if ($Category <> "2") {
							      echo "$Address <br />";
							    }
							    if ($Category <> "2") {
							      if ($Address2 <> "") {
							        echo "$Address2 <br />";
							      }
							    }
							    echo $City.",".$State."&nbsp";
							    if ($Category <> "2") {
							      echo $ListingZip;
							    }
							    echo "<br />";
							    if ($Category <> "2") {
							      if ($Phone <> "") {
							        echo $this->format_phone($Phone);
							      }
							      echo "<br/>";
							      if ($Website <> "") {
							        echo "<a href=http://$Website target=_blank class=listingslink>$Website</a> <br>";
							      }
							    }
							    ?>
							  </p>
							  <?php if ($Category <> "2") { ?>
							  	<p><a href="http://maps.google.com/maps?daddr=<?php echo $DirectionAddress; ?>"target="_blank" class="listingslink">Get Directions</a></p>
								<?php } ?>
							  <?php if ($Category == "2") { ?>
									<p><a href="https://www.cigarrights.org/join.php?Type=GACS&MemType=Renew&Ref=" class="listingslinkupgrade">Upgrade to Platinum to show full listing</a></p>
								<?php } ?>
							  <p>Distance to shop: <font color="#00CC00"><?php echo round($Miles) ?> miles</font></p>
							  <p><img src="<?php echo $CatPic ?>" /></p>
								<br/>
							</div>
							<?php
				    }
						?>
					</div>
				</div>
				<?php
				}
				// This is a State Only Search
				else {
					echo "<h1>This is a State Only Search</h1>";
					if ($Cat <> "") {
						$GetStores = $wpdb->get_results("select * FROM $storeTableName WHERE State = '$State' and (expiration >= '$todays_date' OR Status = 'Active') and Category='$Cat' ORDER BY NAME", ARRAY_A);
					}
					else {
						$GetStores = $wpdb->get_results("select * FROM $storeTableName WHERE State = '$State' and (expiration >= '$todays_date' OR Status = 'Active') ORDER BY NAME", ARRAY_A);
					}
					if( count($GetStores) == 0 ) {
						echo "<div class=smallbold align=center><br>There are currently no Great American Cigar Shops&trade; in this state.<br /><a href=http://www.cigarrights.org/membership_GACS.php>Join now and be the first!</a></div>";
					}
					else {}
					?>
					<div class="searchContainer">
						<div class="searchContainerRow">
					 <?php
						foreach ($GetStores as $count => $ShowStores) {
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
								?>
		            <div class="searchContainerCol">
									<p><b><?php echo $Name ?></b></p>
									<p><?php
										if ($Category <> "2") {
											echo "$Discount";
										}
										?>
									</p>
									<p><?php
										if ($Category <> "2") {
											echo "$Address <br />";
										}
										if ($Category <> "2") {
											if ($Address2 <> "") {
												echo "$Address2 <br />";
											}
										}
										echo $City.",".$State."&nbsp;";
										if ($Category <> "2") {
											echo $ListingZip;
										}
										echo "<br />";
										if ($Category <> "2") {
											if ($Phone <> "") {
												echo $this->format_phone($Phone);
											}
											echo "<br />";
											if ($Website <> "") {
												echo "<a href=http://$Website target=_blank class=listingslink>$Website</a> <br>";
											}
										}
										?>
									</p>
										<?php if ($Category <> "2") {
											echo '<p><a href="http://maps.google.com/maps?daddr='.$DirectionAddress.'"target="_blank" class="listingslink">Get Directions</a></p>';
										}
										if ($Category == "2") {
											echo '<p><a href="https://www.cigarrights.org/join.php?Type=GACS&MemType=Renew&Ref=" class="listingslinkupgrade">Upgrade to Platinum to show full listing</a></p>';
										}
									?>
									<p><img src="<?php echo $CatPic ?>" /></p>
									<br/>
								</div>
							<?php
							}
							?>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		<?php
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
