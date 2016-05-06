<?php require APP . 'libs/helpers.php'; ?>

<div class="navigation">

    <?php
    if(!isset($_SESSION))
    {
        session_start();
    }

    if (isset($_SESSION['user_id']))
    {
        ?>
        <a href="<?php echo URL ?>">home</a>
        <a href="<?php echo URL . 'appointments/index' ?>">appointments</a>
        <a href="<?php echo URL . 'visits/index' ?>">visits</a>
        <a href="<?php echo URL . 'visitors/editaccount' ?>">profile </a>
        <a href="<?php echo URL . 'visitors/logout' ?>">logout</a>

        <?php
    }
    else if(isset($_SESSION['admin_id']) && $_SESSION['rank'] == 0)
    {
        ?>
        <a href="<?php echo URL ?>">home</a>
        <a href="<?php echo URL . 'inmates/index' ?>">inmates</a>
        <a href="<?php echo URL . 'appointments/index' ?>">appointments</a>
        <a href="<?php echo URL . 'visits/index' ?>">visits</a>
        <a href="<?php echo URL . 'admins/index' ?>">admins</a>
        <a href="<?php echo URL . 'statistics/index' ?>">stats</a>
        <a href="<?php echo URL . 'admins/logout' ?>">logout</a>
        <?php
    }
    else if(isset($_SESSION['admin_id']) && $_SESSION['rank'] == 1)
    {
        ?>
        <a href="<?php echo URL ?>">home</a>
        <a href="<?php echo URL . 'inmates/index' ?>">inmates</a>
        <a href="<?php echo URL . 'appointments/index' ?>">appointments</a>
        <a href="<?php echo URL . 'visits/index' ?>">visits</a>
        <a href="<?php echo URL . 'admins/index' ?>">admins</a>
        <a href="<?php echo URL . 'statistics/index' ?>">stats</a>
        <a href="<?php echo URL . 'admins/logout' ?>">logout</a>
        <?php
    }
    else if(isset($_SESSION['admin_id']) && $_SESSION['rank'] == 2)
    {
        ?>
        <a href="<?php echo URL ?>">home</a>
        <a href="<?php echo URL . 'appointments/index' ?>">appointments</a>
        <a href="<?php echo URL . 'admins/logout' ?>">logout</a>
        <?php
    }
        ?>

    <span><?php e($_SESSION['username'] ?? null); ?></span>
    <?php
        $rank = $_SESSION['rank'] ?? null;
        if (!is_null($rank)) {
            $ranks = ['super admin', 'admin', 'guard'];
            ?>
            <span>(<?php echo $ranks[$rank]; ?>)</span>
            <?php
        }
    ?>
</div>
