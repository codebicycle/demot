<div class="container">
  <a href="<?php echo URL; ?>inmates/new">New Inmate</a>
  <h3>Inmates List</h3>
  <table>
    <thead style="background-color: #ddd; font-weight: bold;">
      <tr>
        <td>Id</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>CNP</td>
        <td>Date Of Birth</td>
        <td>Institution Id</td>
        <td>Crime</td>
        <td>Sentence</td>
        <td>Incarceration Date</td>
        <td>Release Date</td>
        <td>Lawyer</td>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($inmates as $inmate) { ?>
      <tr>
        <td>
          <?php if (isset($inmate->Id)) 
          echo htmlspecialchars($inmate->Id, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($inmate->FirstName)) 
          echo htmlspecialchars($inmate->FirstName, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($inmate->LastName)) 
          echo htmlspecialchars($inmate->LastName, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($inmate->CNP)) 
          echo htmlspecialchars($inmate->CNP, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($inmate->DOB)) 
          echo htmlspecialchars($inmate->DOB, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($inmate->InstId)) 
          echo htmlspecialchars($inmate->InstId, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($inmate->Crime)) 
          echo htmlspecialchars($inmate->Crime, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($inmate->Sentence)) 
          echo htmlspecialchars($inmate->Sentence, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($inmate->IncarcerationDate)) 
          echo htmlspecialchars($inmate->IncarcerationDate, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($inmate->ReleaseDate)) 
          echo htmlspecialchars($inmate->ReleaseDate, ENT_QUOTES, 'UTF-8'); ?>
        </td>
        <td>
          <?php if (isset($inmate->Lawyer)) 
          echo htmlspecialchars($inmate->Lawyer, ENT_QUOTES, 'UTF-8'); ?>
        </td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
