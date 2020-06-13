<div id="question-list" class="w-100 bg-white container text-secondary py-2">

    <!-- Nombre de question form -->
    <div class=" ml-auto " style="width: 35%;">
        <form id="question-number-form" class="form-inline" action="<?=URLROOT;?>questions/fixQuestions" method="post">
            <div class="form-group mb-2">
                <label class="d-inline-block mr-2" for="nbreQuestion">Nbre de
                    question/jeu</label>
                <input style="width: 40px;" value=" <?php echo $data['nbreQuestionForGame']->NbreQuestion; ?>"
                    type="text" id="nbreQuestion" class=" form-control d-inline-block" name="nbreQuestion">
                <small id="error" class="form-text text-danger position-absolute " style="top: 30px;">

                </small>


            </div>
            <button type="submit" class="btn btn-primary ml-2 mb-2">OK</button>

        </form>

    </div>

    <!-- Question List -->
    <div class="question-list-body border" style="font-size: 13px;">
        <ol>

            <?php foreach($data['listQuestion'] as $questions) :?>
            <!-- lIgne de question -->
            <li class="p-2">
                <span class="font-weight-bold">
                    <!-- Libelle du question -->
                    <?php echo $questions->libelleQuestion ?></span>
                <div>
                    <?php 
                    
                    // verifie pour un choix texte
                    if (is_string($questions->responses)) {
                        ?>
                    <div class="d-block">
                        <input type="text" disabled value="<?php echo $questions->responses?>"
                            class="form-control  w-25 p-0" id="exampleInputEmail1" style="height: 24px;"
                            aria-describedby="emailHelp">
                    </div>
                    <?php   
                    } else {
                        $i=0;
                 
                        foreach($questions->responses['response'] as  $response) :
                            $i++;
                        ?>

                    <div
                        class="custom-control custom-<?php echo $questions->typeReponses =="choixMultiple" ? 'checkbox' :  'radio'; ?>">
                        <input disabled
                            type="<?php echo $questions->typeReponses =="choixMultiple" ? 'checkbox' :  'radio'; ?>"
                            class="custom-control-input" id="response-1"
                            <?php echo (array_key_exists('isCorrect-'.$i, $questions->responses['correct'])) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="response-1"> <?php echo $response ?>
                        </label>
                    </div>
                    <?php endforeach ;

                    }?>
                </div>
            </li>
            <?php  endforeach ?>

        </ol>
    </div>

    <div class="step-control  position-absolute d-flex justify-content-between" style="bottom: 11px; width: 87%;">

        <a href="<?=URLROOT .'questions/listQuestion/' .( $data['currentPage'] - 1)?>"
            class="btn btn-primary    <?php if ($data['currentPage'] == 1 ) { echo ' disabled'; } ?>">Precedent</a>


        <a href="<?=URLROOT .'questions/listQuestion/' .( $data['currentPage'] +1)?>" class="btn btn-primary 
<?php   if ( $data['currentPage'] == $data['nbreOfPages'] ){  echo 'disabled' ; }
  ?>">Suivant</a>

    </div>


</div>