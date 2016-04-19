<?php

function cached_value($label) {
  if (isset($_POST[$label])) echo htmlentities($_POST[$label]);
}

function validation_hint($hint) {
  if (isset($hint)) echo '<p class="validation_error">' . $hint . '</p>';
}

