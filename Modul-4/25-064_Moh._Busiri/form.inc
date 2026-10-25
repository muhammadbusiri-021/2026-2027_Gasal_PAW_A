<fieldset>
  <legend>Person Details</legend>
  <form name="myForm" action="processData_form.php" method="POST">
    
    <div class="field">
      <label for="surname">Surname</label>
      <input type="text" name="surname" size="31" value="<?php if (isset($_POST['surname'])) echo htmlspecialchars($_POST['surname']); ?>" />
      <?php if (isset($errors['surname'])) echo " " . $errors['surname']; ?>
    </div>

    <div class="field">
      <label for="email">Email address</label>
      <input type="text" name="email" size="31" value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>" />
      <?php if (isset($errors['email'])) echo " " . $errors['email']; ?>
    </div>

    <div class="field">
      <label for="passwd">Password</label>
      <input type="password" name="passwd" size="31" value="<?php if (isset($_POST['passwd'])) echo htmlspecialchars($_POST['passwd']); ?>" />
      <?php if (isset($errors['passwd'])) echo " " . $errors['passwd']; ?>
    </div>

    <div class="field">
      <label for="address">Street Address</label>
      <textarea name="address" rows="3" cols="22"><?php if (isset($_POST['address'])) echo htmlspecialchars($_POST['address']); ?></textarea>
      <?php if (isset($errors['address'])) echo " " . $errors['address']; ?>
    </div>

    <div class="field">
      <label for="state">State</label>
      <select name="state">
        <option value="-1" <?php if (!isset($_POST['state']) || $_POST['state'] == "-1") echo 'selected'; ?>>[choose your state]</option>
        <option value="1" <?php if (isset($_POST['state']) && $_POST['state'] == "1") echo 'selected'; ?>>Australian Capital Territory</option>
        <option value="2" <?php if (isset($_POST['state']) && $_POST['state'] == "2") echo 'selected'; ?>>Queensland</option>
        <option value="3" <?php if (isset($_POST['state']) && $_POST['state'] == "3") echo 'selected'; ?>>Victoria</option>
        <option value="4" <?php if (isset($_POST['state']) && $_POST['state'] == "4") echo 'selected'; ?>>New South Wales</option>
        <option value="5" <?php if (isset($_POST['state']) && $_POST['state'] == "5") echo 'selected'; ?>>Tasmania</option>
        <option value="6" <?php if (isset($_POST['state']) && $_POST['state'] == "6") echo 'selected'; ?>>South Australia</option>
        <option value="7" <?php if (isset($_POST['state']) && $_POST['state'] == "7") echo 'selected'; ?>>Western Australia</option>
        <option value="8" <?php if (isset($_POST['state']) && $_POST['state'] == "8") echo 'selected'; ?>>Northern Territory</option>
      </select>
      <?php if (isset($errors['state'])) echo " " . $errors['state']; ?>
    </div>

    <div class="field">
      <input type="hidden" name="country" value="Australia" />
    </div>

    <div class="field">
      <label for="sex">Gender</label>
      <input type="radio" name="sex" value="male" <?php if (isset($_POST['sex']) && $_POST['sex'] == "male") echo 'checked'; ?> />Male
      <input type="radio" name="sex" value="female" <?php if (isset($_POST['sex']) && $_POST['sex'] == "female") echo 'checked'; ?> />Female
      <?php if (isset($errors['sex'])) echo " " . $errors['sex']; ?>
    </div>

    <div class="field">
      <label for="vegetarian">Vegetarian?</label>
      <input type="checkbox" name="vegetarian" <?php if (isset($_POST['vegetarian'])) echo 'checked'; ?> />
    </div>

    <div class="field">
      <label>&nbsp;</label>
      <input type="submit" value="submit" name="submit" />
      <input type="reset" value="reset" name="reset" />
    </div>
  </form>
</fieldset>
