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

		// Getting variables from query string and POST data
		if (array_key_exists('_submit_check', $_POST)) {
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

		// INSERT THE SEARCH FORM HERE

		// If this is a City Search continue
		if ( $City <> "" || $Zip <> "" ) {
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
			?>

			<table width="860" border="0" align="center" cellpadding="0" cellspacing="0" style="padding-left: 10px">
			  <tr>
			    <td>
						<table width="860" border="0" align="center" cellpadding="0" cellspacing="0">
						  <tr>
						    <td>
							    <table width="860" border="0" align="center" cellpadding="0" cellspacing="0" class="smallbold">
							      <tr>
							        <td width="860" height="46" valign="top">
								 				<!-- MAP PHP GOES HERE -->
												<?php
												if( count($findzip) != 0 ) {
													echo "<div class=smallbold align=center><br>We were unable to locate this City in our database.<br>Please verify the City is spelled correctly and you have the correct state.</div>";
								 				}
												else {
													if ($Cat <> "") {
														$GetStores = $wpdb->get_results( "SELECT Name, Address, Address2, City, State, Zip, Phone, Website, Discount, Category, Longitude, Latitude,  (3959*acos(cos(radians($ZipLat))*cos(radians(Latitude))*cos(radians(Longitude)-radians($ZipLong))+sin(radians($ZipLat))*sin(radians(Latitude)))) AS distance FROM $storeTableName WHERE Category = '$Cat' and (expiration >= '$todays_date' OR Status = 'Active') HAVING distance < $RadiusMiles ORDER BY distance", ARRAY_A );
													}
													else {
														$GetStores = $wpdb->get_results( "SELECT Name, Address, Address2, City, State, Zip, Phone, Website, Discount, Category, Longitude, Latitude,  (3959*acos(cos(radians($ZipLat))*cos(radians(Latitude))*cos(radians(Longitude)-radians($ZipLong))+sin(radians($ZipLat))*sin(radians(Latitude)))) AS distance FROM $storeTableName WHERE (expiration >= '$todays_date' OR Status = 'Active') HAVING distance < $RadiusMiles ORDER BY distance", ARRAY_A );
													}
													if( count($GetStores) == 0 ) {
														echo "<div class=smallbold align=center><br>We were unable to locate any Great American Cigar Shops&trade; with the criteria you specified.<br>Please expand your distance or select different options.</div>";
								 					}
												}
												?>
							 				</td>
							      </tr>
							    </table>
								</td>
						  </tr>
						</table>
					</td>
			  </tr>
			</table>

			<div style="padding-left: 40px">
				<table width="799" border="0" align="center" cellpadding="0" cellspacing="0" class="smallbold">

				<?php
				// echo "<pre>";
				// print_r($GetStores);
				// echo "</pre>";
				if( count($GetStores) == 0 ) {}
				else {
				  if ($Cat <> "") {
				    $sql = "SELECT Name, Address, Address2, City, State, Zip, Phone, Website, Discount, Category, Longitude, Latitude, featured, pastFeatured, (3959*acos(cos(radians($ZipLat))*cos(radians(Latitude))*cos(radians(Longitude)-radians($ZipLong))+sin(radians($ZipLat))*sin(radians(Latitude)))) AS distance FROM $storeTableName WHERE Category = '$Cat' and (expiration >= '$todays_date' OR Status = 'Active') HAVING distance < $RadiusMiles ORDER BY distance";
				    $GetStores = $wpdb->get_results($sql, ARRAY_A);
				  }
				  else {
				    $sql = "SELECT Name, Address, Address2, City, State, Zip, Phone, Website, Discount, Category, Latitude, Longitude, featured, pastFeatured, (3959*acos(cos(radians($ZipLat))*cos(radians(Latitude))*cos(radians(Longitude)-radians($ZipLong))+sin(radians($ZipLat))*sin(radians(Latitude)))) AS distance FROM $storeTableName WHERE (expiration >= '$todays_date' OR Status = 'Active') HAVING distance <= $RadiusMiles ORDER BY distance";
				    $GetStores = $wpdb->get_results($sql, ARRAY_A);
				  }

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
				      $PastFeatured = $ShowStores['pastfeatured'];
				      $DirectionAddress = "$Address, $City, $State, $ListingZip";
				      $DirectionAddress = urlencode($DirectionAddress);

				      if ($Featured == "1")
				      { $CatPic = "/images/sotm.gif"; }
				      elseif ($PastFeatured == "1")
				      { $CatPic = "/images/sotm_past.gif"; }
				      elseif ($Category == "1")
				      { $CatPic = "/images/platinum_icon.jpg"; }
				      elseif ($Category == "2")
				      { $CatPic = "/images/gold_icon.jpg"; }
				      elseif ($Category == "3")
				      { $CatPic = "/images/business_icon.jpg"; }

				      if ($count == 3) {
				        echo "</tr><tr><td height=10 valign=middle align=left><img src=/images/layout/hrule_200px.gif /></td><td height=15 valign=middle align=left><img src=/images/layout/hrule_200px.gif /></td><td height=15 valign=middle align=left><img src=/images/layout/hrule_200px.gif /></td></tr><tr>";
				        echo "<tr><td colspan=3 height=5>&nbsp;</td></tr><tr>";
				        $count = 0;
				      }
				      elseif ($count == 0) {
				        echo "<tr><td colspan=3 height=20>&nbsp;</td></tr><tr>";
				      }
				      ?>
							<td width="266" height="90" align="left" valign="top" class="smalltextbold">
							  <span class="storename"><?php echo $Name ?></span>
							  <span class="smalltextbold"><br />
							    <?php
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
							  </span>
							  <?php if ($Category <> "2") { ?>
							    <a href="http://maps.google.com/maps?daddr=<?php echo $DirectionAddress; ?>"target="_blank" class="listingslink">Get Directions</a><?php
							  } ?>
							  <br />
							  <?php if ($Category == "2") {
							    ?><a href="https://www.cigarrights.org/join.php?Type=GACS&MemType=Renew&Ref=" class="listingslinkupgrade">Upgrade to Platinum to show full listing</a><?php
							  } ?>
							  <br />
							  <br />Distance to shop:
							  <font color="#00CC00"><?php echo round($Miles) ?> miles</font><br><br>
							  <img src="<?php echo $CatPic ?>" />
							</td>
							<?php
				    }

				  }
				}
				// This is a State Only Search
				else {
					?>
					<table width="860" border="0" align="center" cellpadding="0" cellspacing="0" style="padding-left:10px;">
						<tr>
							<td>
								<table width="860" border="0" align="center" cellpadding="0" cellspacing="0">
									<tr>
										<td>
											<table width="860" border="0" align="center" cellpadding="0" cellspacing="0" class="smallbold">
												<td width="860" height="46" valign="top">
													<?php
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
												</td>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>

					<div style="padding-left: 40px"><table width="799" border="0" align="center" cellpadding="0" cellspacing="0" class="smallbold">
					 <?php
						if ($Cat <> "") {
							$GetStores = $wpdb->get_results("select * FROM $storeTableName WHERE State = '$State' and (expiration >= '$todays_date' OR Status = 'Active') and Category = '$Cat' ORDER BY NAME", ARRAY_A);
						}
						else{
							$GetStores = $wpdb->get_results("select * FROM $storeTableName WHERE State = '$State' and (expiration >= '$todays_date' OR Status = 'Active') ORDER BY NAME", ARRAY_A);
						}

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

								if ($Featured == "1")
								{ $CatPic = "/images/sotm.gif"; }
								elseif ($PastFeatured == "1")
								{ $CatPic = "/images/sotm_past.gif"; }
								elseif ($Category == "1")
								{ $CatPic = "/images/platinum_icon.jpg"; }
								elseif ($Category == "2")
								{ $CatPic = "/images/gold_icon.jpg"; }
								elseif ($Category == "3")
								{ $CatPic = "/images/business_icon.jpg"; }

								if ($count == 3) {
									echo "</tr><tr><td height=10 valign=middle align=left><img src=/images/layout/hrule_200px.gif /></td><td height=15 valign=middle align=left><img src=/images/layout/hrule_200px.gif /></td><td height=15 valign=middle align=left><img src=/images/layout/hrule_200px.gif /></td></tr><tr>";
									echo "<tr><td colspan=3 height=5>&nbsp;</td></tr><tr>";
								}
								elseif ($count == 0) {
									echo "<tr><td colspan=3 height=20>&nbsp;</td></tr><tr>";
								}
								?>
		            <td width="266" height="90" align="left" valign="top" class="smalltextbold">
									<span class="storename"><?php echo $Name ?></span>
									<span class="smalltextbold" style="color: #f00;"><br />
										<?php if ($Category <> "2") {
											echo "$Discount <br />";
										}
										?>
									</span>
									<span class="smalltextbold">
										<?php
										if ($Category <> "2") {
											echo "$Address <br />";
										}
										if ($Category <> "2") {
											if ($Address2 <> "") {
												echo "$Address2 <br />";
											}
										}
										?>
										<?php echo $City.",".$State."&nbsp;";
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
											echo "</span>";
											if ($Category <> "2") {
												echo '<a href="http://maps.google.com/maps?daddr=<? echo $DirectionAddress; ?>"target="_blank" class="listingslink">Get Directions</a>';
											}
											echo "<br />";
											if ($Category == "2") {
												echo '<a href="https://www.cigarrights.org/join.php?Type=GACS&MemType=Renew&Ref=" class="listingslinkupgrade">Upgrade to Platinum to show full listing</a>';
											}
										?><br /><br /><img src="<? echo $CatPic ?>" /></td>
									<?php
									}
									?>
							</tr>
						</table>
					</div>
					<?php
				}
				?>
				</tr>
				</table>
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
