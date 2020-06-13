<?php require APPROOT . '/views/inc/header.php'; ?>
<header class="bgSecondary">
    <h1 class="text-center m-0">
        Le plaisir de jouer
    </h1>
</header>

<div id="main" class="d-flex justify-content-center align-items-center">

    <section style="width:92vw ;">
        <div class="section-header bgPrimary position-relative ">
            <h3 class=" w-100 py-2 d-inline-block text-center">CREER ET PARAMETRER VOS QUIZZ</h3>
            <a class="deconnexion position-absolute btn btn-primary" style="right: 10px; top: 10px;"
                href="<?=URLROOT?>users/logout">Deconnexion</a>
        </div>


        <div class="section-body bgGray px-5 py-3 " style="height: 75vh;">
            <?php echo $content_for_layout; ?>
        </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>