<div id="connexion-form" class="w-25">
    <div class="connexion-form-header">
        <h3 class="bgPrimary h5 p-3 m-0">Login form</h3>
    </div>

    <div class="connexion-form-body bgWhite p-3">
        <form class="py-2" action="<?=URLROOT;?>users/login" method="post">
            <div class="form-group ">
                <input type="text" placeholder="Login" id="login" name="login" value="<?php echo $data['login']; ?>"
                    class="form-control <?php echo (!empty($data['login'])) ? 'is-invalid' : ''; ?>" id="email">
                <small class="form-text text-danger  "><?php echo $data['login_err']; ?></small>

            </div>

            <div class="form-group py-2">
                <input type="password" placeholder="Password" id="password" name="password"
                    value="<?php echo $data['password']; ?>"
                    class="form-control <?php echo (!empty($data['password'])) ? 'is-invalid' : ''; ?>">
                <small class="form-text text-danger  "><?php echo $data['password_err']; ?></small>

            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
            <!-- <?php  if (!isset($_SESSION['user_id'])) { ?> -->
            <a href="<?=URLROOT?>users/register" class="text-secondary pl-5">S'inscrire pour jouer</a>
            <!-- <?php } ?>s -->
        </form>
    </div>
</div>