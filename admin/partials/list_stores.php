<table class="widefat fixed">
  <thead>
    <th width="10%">Store ID</th>
    <th width="20%">Name</th>
    <th width="30%">Address</th>
    <th width="15%">Expiration</th>
    <th width="15%">Last Update</th>
    <th width="10%">Action</th>
  </thead>
  <tbody>
    <?php
      foreach ($results as $count => $store) {
        $storeUrl = admin_url().'admin.php?page=add_cra_listings&storeId='.$store['StoreID'];
        if( $count % 2 == 0 ) {
          $className = "alternate";
        }
        else {
          $className = "";
        }
        echo '<tr class="'.$className.'">
          <td>'.$store['StoreID'].'</td>
          <td><a href="'.$storeUrl.'" >'.$store['Name'].'</a></td>
          <td>'.$store['Address'].'</td>
          <td>'.$store['expiration'].'</td>
          <td>'.$store['LastUpdate'].'</td>
          <td>
            <a class="button button-info" href="'.$storeUrl.'">Edit</a>
            <a class="button button-danger" href="'.admin_url().'admin.php?page=cra_settings&deleteStoreId='.$store['StoreID'].'">Delete</a>
          </td>
        </tr>';
      }
    ?>
  </tbody>
</table>
