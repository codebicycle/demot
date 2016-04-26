<?php
  require APP . 'libs/helpers.php';
  $validation_errors = $validation_errors ?? null;
?>

<div class="container">
  <h3>Add new inmate</h3>
  <form action="<?php echo URL; ?>inmates/create" method="POST" id="inmates-add-form" novalidate >
    <?php validation_hint($validation_errors, 'FirstName') ?>
    <label for="FirstName">First Name</label>
    <input type="text" name="FirstName" id="FirstName" pattern="^[- 'a-zA-Z]{2,50}$" value="<?php cached_value('FirstName') ?>" required />
    
    <?php validation_hint($validation_errors, 'LastName') ?>
    <label for="LastName">Last Name</label>
    <input type="text" name="LastName" id="LastName" pattern="^[- 'a-zA-Z]{2,50}$" value="<?php cached_value('LastName') ?>" required />
     
    <?php validation_hint($validation_errors, 'CNP')  ?>
    <label for="CNP">CNP</label>
    <input type="text" name="CNP" id="CNP" inputmode="numeric" pattern="\d{13}" value="<?php cached_value('CNP') ?>" required />
    
    <?php validation_hint($validation_errors, 'DOB') ?>
    <label for="DOB">Date Of Birth</label>
    <input type="date" name="DOB" id="DOB" placeholder="yyyy-mm-dd" pattern="\d{4}[/-]\d{1,2}[/-]\d{1,2}" value="<?php cached_value('DOB') ?>" required />
  

    <?php validation_hint($validation_errors, 'InstId') ?>
    <label for="InstId">Institution Id</label>
    <input type="text" name="InstId" id="InstId" inputmode="numeric" value="<?php cached_value('InstId') ?>" required />

    <?php validation_hint($validation_errors, 'Crime') ?>
    <label for="Crime">Crime</label>
    <input type="text" name="Crime" id="Crime" value="<?php cached_value('Crime') ?>" required />

    <?php validation_hint($validation_errors, 'Sentence') ?>
    <label for="Sentence">Sentence</label>
    <input type="text" name="Sentence" id="Sentence" inputmode="numeric" value="<?php cached_value('Sentence') ?>" required />

    <?php validation_hint($validation_errors, 'IncarcerationDate') ?>
    <label for="IncarcerationDate">Incarceration Date</label>
    <input type="date" name="IncarcerationDate" id="IncarcerationDate" placeholder="yyyy-mm-dd" pattern="\d{4}[/-]\d{1,2}[/-]\d{1,2}" value="<?php cached_value('IncarcerationDate') ?>" required />

    <?php validation_hint($validation_errors, 'ReleaseDate') ?>
    <label for="ReleaseDate">Release Date</label>
    <input type="date" name="ReleaseDate" id="ReleaseDate" placeholder="yyyy-mm-dd" pattern="\d{4}[/-]\d{1,2}[/-]\d{1,2}" value="<?php cached_value('ReleaseDate') ?>" required />
  

    <?php validation_hint($validation_errors, 'LawyerFirstName') ?>
    <label for="LawyerFirstName">Lawyer First Name</label>
    <input type="text" name="LawyerFirstName" id="LawyerFirstName" pattern="^[- 'a-zA-Z]{2,50}$" value="<?php cached_value('LawyerFirstName') ?>" />

    <?php validation_hint($validation_errors, 'LawyerLastName') ?>
    <label for="LawyerLastName">Lawyer Last Name</label>
    <input type="text" name="LawyerLastName" id="LawyerLastName" pattern="^[- 'a-zA-Z]{3,50}$" value="<?php cached_value('LawyerLastName') ?>" />

    <?php validation_hint($validation_errors, 'LawyerCNP') ?>
    <label for="LawyerCNP">Lawyer CNP</label>
    <input type="text" name="LawyerCNP" id="LawyerCNP" inputmode="numeric" pattern="\d{13}" value="<?php cached_value('LawyerCNP') ?>" />
    

    <label></label>
    <input type="submit" name="Create" value="Create" />
  </form>
</div>
