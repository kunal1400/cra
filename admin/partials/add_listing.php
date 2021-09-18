<form action="" method="post">
  <table class="form-table">
    <tr>
      <th>
        <label>Store Name</label>
      </th>
      <td>
        <input type="text" name="store[Name]" class="regular-text" value="<?php echo $Name ?>" required />
      </td>
    </tr>
    <tr>
      <th>
        <label>Address</label>
      </th>
      <td>
        <input type="text" name="store[Address]" class="regular-text" value="<?php echo $Address ?>" required />
      </td>
    </tr>
    <tr>
      <th>
        <label>Address2</label>
      </th>
      <td>
        <input type="text" name="store[Address2]" class="regular-text" value="<?php echo $Address2 ?>" />
      </td>
    </tr>
    <tr>
      <th>
        <label>City</label>
      </th>
      <td>
        <input type="text" name="store[City]" class="regular-text" value="<?php echo $City ?>" required />
      </td>
    </tr>
    <tr>
      <th>
        <label>State</label>
      </th>
      <td>
        <input type="text" name="store[State]" class="regular-text" value="<?php echo $State ?>" required />
      </td>
    </tr>
    <tr>
      <th>
        <label>Zip</label>
      </th>
      <td>
        <input type="text" name="store[Zip]" class="regular-text" value="<?php echo $Zip ?>" required />
      </td>
    </tr>
    <tr>
      <th>
        <label>Phone</label>
      </th>
      <td>
        <input type="text" name="store[Phone]" class="regular-text" value="<?php echo $Phone ?>" />
      </td>
    </tr>
    <tr>
      <th>
        <label>Website</label>
      </th>
      <td>
        <input type="text" name="store[Website]" class="regular-text" value="<?php echo $Website ?>" />
      </td>
    </tr>
    <tr>
      <th>
        <label>Category</label>
      </th>
      <td>
        <select name="store[Category]" class="regular-text">
          <option <?php echo ($Category == "" ? 'selected' : '') ?> value="">-None-</option>
          <option <?php echo ($Category == "1" ? 'selected' : '') ?> value="1">1</option>
          <option <?php echo ($Category == "2" ? 'selected' : '') ?> value="2">2</option>
          <option <?php echo ($Category == "3" ? 'selected' : '') ?> value="3">3</option>
        </select>
      </td>
    </tr>
    <tr>
      <th>
        <label>Status</label>
      </th>
      <td>
        <select name="store[Status]" class="regular-text">
          <option <?php echo ($Status == "" ? 'selected' : '') ?> value="">-None-</option>
          <option <?php echo ($Status == "1" ? 'selected' : '') ?> value="1">1</option>
          <option <?php echo ($Status == "Active" ? 'selected' : '') ?> value="Active">Active</option>
        </select>
      </td>
    </tr>
    <tr>
      <th>
        <label>Longitude</label>
      </th>
      <td>
        <input type="text" name="store[Longitude]" class="regular-text" value="<?php echo $Longitude ?>" required />
      </td>
    </tr>
    <tr>
      <th>
        <label>Latitude</label>
      </th>
      <td>
        <input type="text" name="store[Latitude]" class="regular-text" value="<?php echo $Latitude ?>" required />
      </td>
    </tr>
    <tr>
      <th>
        <label>featured</label>
      </th>
      <td>
        <select name="store[featured]" class="regular-text">
          <option <?php echo ($featured == "" ? 'selected' : '') ?> value="">-None-</option>
          <option <?php echo ($featured == "1" ? 'selected' : '') ?> value="1">1</option>
        </select>
      </td>
    </tr>
    <tr>
      <th>
        <label>pastfeatured</label>
      </th>
      <td>
        <select name="store[pastfeatured]" class="regular-text">
          <option <?php echo ($pastfeatured == "" ? 'selected' : '') ?> value="">-None-</option>
          <option <?php echo ($pastfeatured == "1" ? 'selected' : '') ?> value="1">1</option>
        </select>
      </td>
    </tr>
    <tr>
      <th>
        <label>expiration</label>
      </th>
      <td>
        <input type="text" name="store[expiration]" class="regular-text datePickerClass" value="<?php echo $expiration ?>" required />
      </td>
    </tr>
    <tr>
      <th>
        <label>Last User</label>
      </th>
      <td>
        <select name="store[LastUser]" class="regular-text">
          <option value=''>-None-</option>
          <?php
            $users = get_users();
            foreach ($users as $i => $user) {
              echo "<option value='".$user->data->user_login."'>".$user->data->display_name."</option>";
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="hidden" name="store_id_to_update" value="<?php echo $StoreID ?>" />
        <input type="submit" name="store_listing_form_submitted" class="button button-primary" value="Submit"/>
      </td>
    </tr>
  </table>
</form>
