<?php

function cached_value($label) {
  if (isset($_POST[$label])) echo htmlentities($_POST[$label]);
}

function validation_hint($validation_errors, $label) {
  if ( isset($validation_errors[$label])) {
    echo '<p class="validation_error">' . $validation_errors[$label] . '</p>';
  }
}

