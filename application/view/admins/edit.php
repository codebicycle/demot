<?php 
    $validation_errors = $validation_errors ?? null;
    $cache = $cache ?? null;
?>

<div class="container">
  <h3>Edit Profile</h3>
    <form action="<?php echo URL . 'admins/update'; ?>" method="POST" id="demot-form" enctype="multipart/form-data" novalidate >

        <?php validation_hint($validation_errors, 'UserName');?>
        <label for="Username">User Name</label>
        <input type="text" name="UserName" id="UserName"  pattern="^[- a-zA-Z]{2,50}$" value="<?php cached_value('UserName', $cache) ?>" required />

        <?php validation_hint($validation_errors, 'OldPassword') ?>
        <label for="OldPassword">Old Password</label>
        <input type="password" name="OldPassword" id="OldPassword"  />

        <?php validation_hint($validation_errors, 'Password') ?>
        <label for="Password">New Password</label>
        <input type="password" name="Password" id="Password"  />

        <?php validation_hint($validation_errors, 'RepeatPassword') ?>
        <label for="RepeatPassword">Repeat Password</label>
        <input type="password" name="RepeatPassword" id="RepeatPassword"/>

        <input type="submit" name="Update" value="Update" />
    </form>
</div>
