<?php 

extract($data);

$question = $listQuestion[0];

$responses = $question->responses;

// var_dump($response);
?>

<div id="jeu" class=" row py-4 px-3 bgWhite">

    <!-- Question -->
    <div class="question col-md-8 h-100 border py-3">
        <div class="question-head text-center bgLight py-3">
            <h3 class="title font-italic text-secondary">QUESTION <?php echo $currentPage . "/". $nbreOfPages; ?></h3>
            <p class="libelle lead  text-secondary">
                <?php echo $question->libelleQuestion ?>
            </p>
        </div>

        <!-- Points -->
        <div class="marks bgLight pt-2 mt-3"> <?php echo $question->nbrePoint ?> pts</div>


        <!-- Response -->
        <form
            action="<?php echo  ( $data['currentPage'] == $data['nbreOfPages'] )  ? URLROOT .'questions/jouer/5/fin'    : URLROOT .'questions/jouer/' .( $data['currentPage'] +1) ;?>"
            method="post" class="response pl-5 py-4">


            <?php 
               // verifie pour un choix texte
               if (!is_array($responses)) { ?>

            <div class="d-block">
                <input type="text" class="form-control   w-25 p-0" name="responseTexte-<?=$currentPage?>"
                    id="exampleInputEmail1" style="height: 24px;"
                    value="<?php echo isset( $_SESSION['remplis'][$currentPage])?  $_SESSION['remplis'][$currentPage]["responseTexte-$currentPage"]: ''; ?>"
                    aria-describedby="emailHelp">
            </div>

            <?php   
                } else {
                    $i=0;
                    foreach ($responses['response'] as $response) {   $i++;?>

            <div
                class="custom-control custom-<?php echo $question->typeReponses =="choixMultiple" ? 'checkbox' :  'radio'; ?>">
                <input type="<?php echo $question->typeReponses =="choixMultiple" ? 'checkbox' :  'radio'; ?>"
                    class="custom-control-input  p-2" value="isCorrect-<?=$i?>" id="response-<?=$i?>"
                    name="response-<?=$i?>"
                    <?php echo isset($_SESSION['cocher'][$currentPage]) ?  ( in_array('isCorrect-'.$i, $_SESSION['cocher'][$currentPage])  ? 'checked' : '' ) : '' ; ?>>
                <label class="custom-control-label" for="response-<?=$i?>"><?php echo $response ?>
                </label>
            </div>
            <?php  
                        }

                    }

                        ?>


            <div class="step-control  position-absolute d-flex justify-content-between"
                style="bottom: 11px; width: 87%;">

                <a type="submit" href="<?=URLROOT .'questions/jouer/' .( $data['currentPage'] - 1)?>"
                    class="btn btn-primary    <?php if ($data['currentPage'] == 1 ) { echo ' disabled'; } ?>">Precedent</a>


                <button type="submit" class="btn btn-primary "><?php   if ( $data['currentPage'] == $data['nbreOfPages'] ){  echo 'Terminer' ; } else {
                    echo 'Suivant';
                }
?></button>

            </div>

    </div>


    </form>





    <!-- Tabs -->
    <div class="scores col-md-4  px-5  ">
        <div class="scores-tabs">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                        aria-controls="nav-home" aria-selected="true">Top
                        Scores</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
                        aria-controls="nav-profile" aria-selected="false">Mon Meilleur Score</a>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active p-1" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                    <ul class="topScores">
                        <li>
                            <span class="name">Mouhamed Seck</span>
                            <span class="userScore">3542 pts</span>
                        </li>
                        <li>
                            <span class="name">Mouhamed Seck</span>
                            <span class="userScore">3542 pts</span>
                        </li>
                        <li>
                            <span class="name">Mouhamed Seck</span>
                            <span class="userScore">3542 pts</span>
                        </li>
                        <li>
                            <span class="name">Mouhamed Seck</span>
                            <span class="userScore">3542 pts</span>
                        </li>
                        <li>
                            <span class="name">Mouhamed Seck</span>
                            <span class="userScore">3542 pts</span>
                        </li>



                    </ul>

                </div>
                <div class="tab-pane fade p-2" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">Lorem
                    ipsum dolor sit amet consectetur adipisicing
                    elit. Assumenda nulla at praesentium harum odio placeat! Repudiandae id similique
                    odio quas ducimus repellat minus eius porro enim optio, quae dicta earum.Nulla
                    dolore corporis ducimus. Vero doloribus similique, dicta quasi tempore provident
                    facilis asperiores voluptatibus animi doloremque quibusdam sequi blanditiis sunt,
                    exercitationem, sapiente quia natus voluptates! Tempora qui unde itaque vel.</div>
            </div>
        </div>

    </div>
</div>