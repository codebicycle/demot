<?php

function cached_value($label) {
  if (isset($_POST[$label]))
    echo htmlentities($_POST[$label]);
}

function validation_hint($errors, $label) {
  $hint = $errors[$label] ?? null;
  if ($hint)
    echo '<p class="validation_error">' . $hint . '</p>';
}
