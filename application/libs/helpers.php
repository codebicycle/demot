<?php

function cached_value($label, $data=null) {
    if (isset($_POST[$label]))
        echo htmlentities($_POST[$label]);
    else if (isset($data[$label]))
        echo htmlentities($data[$label]);
}

function validation_hint($errors, $label) {
    $hint = $errors[$label] ?? null;
    if ($hint)
        echo '<p class="validation_error">' . $hint . '</p>';
}


//  Escape given input for the use in HTML.
function e($input)
{
    // Use htmlspecialchars with ENT_QUOTES to escape '.
    echo htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}
