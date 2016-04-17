<div class="container">
  <h3>Add new inmate</h3>
  <form action="<?php echo URL; ?>inmates/create" method="POST" id="inmates-new-form">
    <label for="FirstName">First Name</label>
    <input type="text" name="FirstName" id="FirstName" required autofocus />
    <label for="LastName">Last Name</label>
    <input type="text" name="LastName" id="LastName" required />
    <label for="CNP">CNP</label>
    <input type="text" name="CNP" id="CNP" required />
    <label for=name="DOB">Date Of Birth</label>
    <input type="date" name="DOB" id=name="DOB" required />
    <label for="InstId">Institution Id</label>
    <input type="text" name="InstId" id="InstId" required />
    <label for="Crime">Crime</label>
    <input type="text" name="Crime" id="Crime" required />
    <label for="Sentence">Sentence</label>
    <input type="text" name="Sentence" id="Sentence" required />
    <label for="IncarcerationDate">Incarceration Date</label>
    <input type="date" name="IncarcerationDate" id="IncarcerationDate" required />
    <label for="ReleaseDate">Release Date</label>
    <input type="date" name="ReleaseDate" id="ReleaseDate" required />
    <label for="Lawyer">Lawyer</label>
    <input type="text" name="Lawyer" id="Lawyer" />
    <label></label>
    <input type="submit" name="Create" value="Create" />
  </form>
</div>
