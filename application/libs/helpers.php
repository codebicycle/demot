<?php

function cached_value($label, $data=null, $default=null) {
    if (isset($_POST[$label]))
        e($_POST[$label]);
    else if (isset($data[$label]))
        e($data[$label]);
    else if (!is_null($default))
        e($default);
}

function cb_cache($label) {
    if (isset($_POST[$label]) && $_POST[$label] === '')
        echo 'checked';
}

function radio_cache($label, $input_value, $checked=null) {
    if (isset($_POST[$label])  && $_POST[$label] === $input_value)
        echo 'checked';
    else if(!isset($_POST[$label]) && $checked === "checked")
        echo 'checked';
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
