<?php
    $validation_errors = $validation_errors ?? null;
    $cache = $cache ?? null;
?>

<div class="container">
    <h3>Edit Inmate Visiting Rights</h3>
    <form>
        <span class="title">Inmate</span>
        <dl>
            <dt>FirstName</dt>
            <dd><?php e($inmate->FirstName); ?></dd>
            <dt>LastName</dt>
            <dd><?php e($inmate->LastName); ?></dd>
            <dt>Date of Birth</dt>
            <dd><?php e($inmate->DOB); ?></dd>

            <dt>Visits Left</dt>
            <dd>20</dd>

            <dt>Banned until</dt>
            <dd>2-10-201</dd>
            <dd>
                <button formaction="<?php e(URL . 'inmates/lift_ban/' . $inmate->Id) ?>">Lift Ban</button>
            </dd>

            <dt>Ban</dt>
            <dd>
                <button formaction="<?php e(URL . 'inmates/ban/' . $inmate->Id . '/1week') ?>">1 Week</button>
                <button formaction="<?php e(URL . 'inmates/ban/' . $inmate->Id . '/1month') ?>">1 Month</button>
                <button formaction="<?php e(URL . 'inmates/ban/' . $inmate->Id . '/3months') ?>">3 Months</button>
            </dd>

            <dt>Visits</dt>
            <dd>
                <button formaction="<?php e(URL . 'inmates/increment/' . $inmate->Id) ?>">+ 1</button>
                <button formaction="<?php e(URL . 'inmates/decrement/' . $inmate->Id) ?>">- 1</button>
            </dd>
        </dl>
    </form>
</div>
