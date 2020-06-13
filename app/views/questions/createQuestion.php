<div id="question-parameter" class="w-100 bg-white container px-5   text-secondary py-2">
    <h4 class="text-center">Parametrer votre Question</h4>
    <div class="question-parameter-body border px-3 pt-3">
        <form class="w-75" id="question-create" action="<?=URLROOT;?>questions/createQuestion" method="post">
            <div class="form-group row">
                <label for="libelleQuestion" style="line-height: 70px ;"
                    class="col-sm-2 col-form-labe  font-weight-bold">Question</label>
                <div class="col-sm-10">

                    <textarea name="libelleQuestion" class="form-control " id="libelleQuestion" rows="3"></textarea>
                </div>
                <small class="text-danger pl-5 ml-5"></small>
            </div>

            <div class="form-group row">
                <label for="nbrePoint" class="col-sm-2 col-form-label font-weight-bold">Points</label>
                <div class="col-sm-2">
                    <input type="text" name="nbrePoint" class="form-control" id="nbrePoint">
                </div>
                <small class="text-danger"></small>

            </div>
            <div class="form-group row">
                <label for="typeReponse" class="col-sm-3 col-form-label font-weight-bold">Type
                    Reponses</label>
                <div class="col-sm-8">
                    <select id="typeReponse" name="typeReponses" class="form-control">
                        <option value="choixSimple">Choix simple</option>
                        <option value="choixMultiple" selected>Choix multiple</option>
                        <option value="choixText">Choix Texte</option>
                    </select>
                </div>
                <div class="d-inline-block" id="addResponse"><img style="cursor: pointer;"
                        src="<?=URLROOT?>img/ic-ajout-réponse.png" alt=""></div>
            </div>


            <div id="response-container">
                <small id="common-error" class="text-bold text-center text-danger w-100">

                </small>


            </div>
            <div class="  position-absolute" style="bottom: 15px ; right: 38px;">
                <button type="submit" class="btn btn-primary  d-block ml-auto">Enregistrer</button>
            </div>
        </form>
    </div>
</div>