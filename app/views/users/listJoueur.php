<div id="joueur-list" class="w-100 bg-white container px-5   text-secondary py-2">
    <h3 class=" h6 text-center font-italic text-secondary">LISTE DES JOUEURS PAR SCORE</h3>

    <div class="joueur-list-body border ">
        <!-- Indicator -->
        <div class="joueur d-flex justify-content-between px-5">
            <span class="h6  w-25  text-center d-block font-italic ">Nom</span>
            <span class="h6 w-25  text-center  d-block font-italic ">Prenom</span>
            <span class="h6  w-25 text-center  d-block font-italic ">Score</span>
        </div>

        <?php  foreach($data['listJoueur'] as $joueur) : ?>

        <div class="joueur d-flex justify-content-between px-5">
            <span class="d-block w-25 text-center "><?php echo $joueur->nom ?> </span>
            <span class="d-block w-25  text-center"><?php echo $joueur->prenom ?></span>
            <span class="d-block  w-25 text-center "><?php echo $joueur->score ?> Pts</span>
        </div>
        <?php endforeach ?>

    </div>
    <div class="step-control  position-absolute d-flex justify-content-between" style="bottom: 11px; width: 87%;">

        <a href="<?=URLROOT .'users/listJoueur/' .( $data['currentPage'] - 1)?>"
            class="btn btn-primary    <?php if ($data['currentPage'] == 1 ) { echo ' disabled'; } ?>">Precedent</a>


        <a href="<?=URLROOT .'users/listJoueur/' .( $data['currentPage'] +1)?>" class="btn btn-primary 
        <?php   if ( $data['currentPage'] == $data['nbreOfPages'] ){  echo 'disabled' ; }
          ?>">Suivant</a>

    </div>

</div>