<?php require APPROOT . '/views/inc/header.php'; ?>
<header class="bgSecondary">
    <div class="logo position-absolute" style="left: 10px; ">
        <img src="<?=URLROOT?>img/logo-QuizzSA.png" class="img-fluid" width="35px" height="35px" alt="">
    </div>
    <h1 class="text-center m-0">
        Le plaisir de jouer
    </h1>
</header>

<div id="main" class="d-flex justify-content-center align-items-center">
    <?php echo $content_for_layout; ?>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>