<div class="container">
  <h3>Add new inmate</h3>
  <form action="<?php echo URL; ?>inmates/create" method="POST">
    <label>First Name</label>
    <input type="text" name="FirstName" value="" required autofocus />
    <label>Last Name</label>
    <input type="text" name="LastName" value="" required />
    <label>CNP</label>
    <input type="text" name="CNP" value="" required />
    <label>Institution Id</label>
    <input type="text" name="InstId" value="" required />
    <label>Lawyer</label>
    <input type="text" name="Lawyer" value="" />
    <label>Date Of Birth</label>
    <input type="date" name="DOB" value="" required />
    <label>Sentence</label>
    <input type="text" name="Sentence" value="" required />
    <label>Crime</label>
    <input type="text" name="Crime" value="" required />
    <label>Incarceration Date</label>
    <input type="date" name="IncarcerationDate" value="" required />
    <label>Release Date</label>
    <input type="date" name="ReleaseDate" value="" required />

    <input type="submit" name="Create" value="Create" />
  </form>
</div>