<div id="inscription-form" class=" bg-white container w-50 text-secondary py-2">
    <div class=" inscription-form-header">
        <h1 class="h5 m-0">S'INSCRIRE</h1>
        <p class="m-0 ">Pour proposer un quizz</p>
        <hr class="w-50 m-0">
    </div>

    <div class="inscription-form-body row">
        <div class="col-md-7">
            <form class="w-75" action="<?=URLROOT;?>users/register" method="post" enctype="multipart/form-data">
                <div class="form-group mb-1">
                    <label class="m-0 " for="prenom">Prenom</label>
                    <input name="prenom" type="text"
                        class="form-control <?php echo (!empty($data['prenom_err'])) ? 'is-invalid' : ''; ?> "
                        value="<?php echo $data['prenom']; ?>" id="prenom">
                    <small class="form-text text-danger invalid-feedback  ">
                        <?php echo $data['prenom_err']; ?></small>

                </div>

                <div class="form-group mb-1">
                    <label class="m-0 " for="nom">Nom</label>
                    <input name="nom" type="text"
                        class="form-control <?php echo (!empty($data['nom_err'])) ? 'is-invalid' : ''; ?>   value="
                        <?php echo $data['nom']; ?> id=" nom">
                    <small id="error" class="form-text text-danger  "> <?php echo $data['nom_err']; ?></small>
                </div>

                <div class="form-group  mb-1">
                    <label class="m-0 " for="login">Login</label>
                    <input name="login" type="text"
                        class="form-control <?php echo (!empty($data['login_err'])) ? 'is-invalid' : ''; ?> " id="login"
                        value="<?php echo $data['login']; ?>">
                    <small id="error" class="form-text text-danger  "> <?php echo $data['login_err']; ?></small>

                </div>

                <div class="form-group mb-1">
                    <label class="m-0 " for="password1">Password</label>
                    <input name="password1" type="password"
                        class="form-control <?php echo (!empty($data['password1_err'])) ? 'is-invalid' : ''; ?> "
                        id="password" value="<?php echo $data['password1']; ?>">
                    <small id="error" class="form-text text-danger  "><?php echo $data['password1_err']; ?></small>

                </div>

                <div class="form-group mb-1">
                    <label class="m-0 " for="password2">Confirmer Password</label>
                    <input name="password2" type="password"
                        class="form-control  <?php echo (!empty($data['password2_err'])) ? 'is-invalid' : ''; ?>"
                        id="password2" value="<?php echo $data['password2']; ?>">
                    <small id="error" class="form-text text-danger  "><?php echo $data['password2_err']; ?></small>

                </div>

                <div class="form-group d-flex justify-content-between">
                    <label class="m-0 ">Avatar</label>
                    <label for="file" class="btn btn-primary">Choisir une image</label>
                    <input id="file" name="avatar"
                        class="d-none  <?php echo (!empty($data['avatar'])) ? 'is-invalid' : ''; ?>" type="file">
                    <small class="form-text text-danger  "><?php echo $data['avatar_err']; ?></small>
                </div>


                <button type="submit" class="btn btn-primary">Creer compte</button>

        </div>
        <div class="col-md-4">
            <div class="avatar  ">
                <img class="img-fluid" id="avatar" src="" alt="">
            </div>
            <h4 class="ml-5 mt-2" id="avatar-name">Avatar</h4>

            <?php  flash('register_success'); ?>
        </div>
    </div>


</div>