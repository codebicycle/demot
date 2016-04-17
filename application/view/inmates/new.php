<div class="container">
  <h3>Add new inmate</h3>
  <form action="<?php echo URL; ?>inmates/create" method="POST" id="inmates-new-form">
    <label for="FirstName">First Name</label>
    <input type="text" name="FirstName" id="FirstName" pattern="^[- a-zA-Z]{2,50}$" required autofocus />

    <label for="LastName">Last Name</label>
    <input type="text" name="LastName" id="LastName" pattern="^[- a-zA-Z]{3,50}$" required />

    <label for="CNP">CNP</label>
    <input type="text" name="CNP" id="CNP" inputmode="numeric" pattern="\d{13}" required />

    <label for="DOB">Date Of Birth</label>
    <input type="date" name="DOB" id="DOB" placeholder="yyyy-mm-dd" pattern="\d{4}[/-]\d{1,2}[/-]\d{1,2}" required />

    <label for="InstId">Institution Id</label>
    <input type="text" name="InstId" id="InstId" inputmode="numeric" required />

    <label for="Crime">Crime</label>
    <input type="text" name="Crime" id="Crime" required />

    <label for="Sentence">Sentence</label>
    <input type="text" name="Sentence" id="Sentence" inputmode="numeric" required />

    <label for="IncarcerationDate">Incarceration Date</label>
    <input type="date" name="IncarcerationDate" id="IncarcerationDate" placeholder="yyyy-mm-dd" pattern="\d{4}[/-]\d{1,2}[/-]\d{1,2}" required />

    <label for="ReleaseDate">Release Date</label>
    <input type="date" name="ReleaseDate" id="ReleaseDate" placeholder="yyyy-mm-dd" pattern="\d{4}[/-]\d{1,2}[/-]\d{1,2}" required />

    <label for="Lawyer">Lawyer</label>
    <input type="text" name="Lawyer" id="Lawyer" />

    <label></label>
    <input type="submit" name="Create" value="Create" />
  </form>
</div>
