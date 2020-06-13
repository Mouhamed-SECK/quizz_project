<?php require APPROOT . '/views/inc/header.php'; 

$view = explode(  '/', $_GET['url'])[1];


?>

<header class="bgSecondary">
    <div class="logo position-absolute" style="left: 10px; ">
        <img src="<?=URLROOT?>img/logo-QuizzSA.png" class="img-fluid" width="35px" height="35px" alt="">
    </div>
    <h1 class="text-center m-0">
        Le plaisir de jouer
    </h1>
</header>

<div id="main" class="d-flex justify-content-center align-items-center ">

    <section style="width:92vw ;">
        <div class="section-header bgPrimary position-relative ">
            <h3 class=" w-100 py-2 d-inline-block text-center">CREER ET PARAMETRER VOS QUIZZ</h3>
            <a class="deconnexion position-absolute btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                style="right: 10px; top: 10px;">Deconnexion</a>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Deconnexion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Voulez vous quitter le site ?
                    </div>
                    <div class="modal-footer d-flex">
                        <a href="<?=URLROOT?>users/logout" class="btn btn-success">Oui</a>

                        <button type="button" data-dismiss="modal" class="btn btn-danger">Non</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="section-body bgWhite px-5 ">

            <div class="row d-flex align-items-center h-100">
                <!-- Menu  Final-->


                <div class="col-md-4 pl-3">
                    <div class="menu " style="width: 95%;">
                        <div class="menu-header  py-2 d-flex align-items-center justify-content-between px-3">
                            <div class="avatar ">
                                <img class="img-fluid" src="<?=URLROOT. "uploads/" .$_SESSION['user_avatar'];?>" alt="">
                            </div>
                            <h5 class="text-white">
                                <?php echo strtoupper($_SESSION['user_prenom']) ." " . strtoupper($_SESSION['user_nom']);?>
                            </h5>
                        </div>

                        <nav class="nav flex-column pt-3 ">
                            <a class="nav-link  <?php if($view=="listQuestion") echo 'active' ; ?>"
                                href="<?=URLROOT?>questions/listQuestion">
                                <span class="d-block"> Lister Question</span>
                                <span class=" d-block  icon icon-list"> </span>
                            </a>
                            <a class="nav-link  <?php if($view=="register") echo 'active' ; ?>"
                                href="<?=URLROOT?>users/register">
                                <span class="d-block"> Creer Admin </span>
                                <span class=" d-block  icon icon-create"> </span>
                            </a>
                            <a class="nav-link <?php if($view=="listJoueur" || $view=="adminIndex" ) echo 'active' ; ?> "
                                href="<?=URLROOT?>users/listJoueur">
                                <span class="d-block"> Lister Joueur</span>
                                <span class=" d-block icon  icon-list"> </span>
                            </a>
                            <a class="nav-link <?php if($view=="createQuestion" || $view=="adminIndex" ) echo 'active' ; ?> "
                                href="<?=URLROOT?>questions/createQuestion">
                                <span class="d-block">Creer Question</span>
                                <span class=" d-block icon  icon-create"> </span>
                            </a>

                        </nav>
                    </div>
                </div>


                <!-- Form inscription Final-->

                <div class="col-md-8 width-full">
                    <?php echo $content_for_layout; ?>

                </div>

            </div>

        </div>
    </section>
</div>
<?php 
if($view=="createQuestion" ) {?>
<script src="<?php echo URLROOT; ?>/js/question.js?<? echo time(); ?>"></script>

<?php
} else {
    ?>
<script src="<?php echo URLROOT; ?>/js/listQuestion.js?<? echo time(); ?>"></script>
<?php }  ?>


<?php require APPROOT . '/views/inc/footer.php'; ?>