<?php
session_start();


if (isset($_SESSION['message'])):

?>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong></strong> <?= $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php
    unset($_SESSION['message']);
endif;
?>

<?php /*
if (isset($_SESSION['Login'])):

?>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong></strong> <?= $_SESSION['Login']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php
    unset($_SESSION['Login']);
endif;
*/ ?> 