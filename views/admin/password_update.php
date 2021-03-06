<?php
use App\Classe\Data\DataHelper;
use App\Classe\User\User;

session_start();
$data = new DataHelper;
if (!empty($_POST)) {
    if (isset($_POST['password_check'])){
        if (User::passwordVerify($_POST['password_check'], $_SESSION['password'])) {
            $_SESSION['password_checked'] = 1;
        }
    }
    if (isset($_POST['password'])) {
        $_SESSION['password_checked'] = 1;
        $prepare = "UPDATE user SET password = :password WHERE username = :username";
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $execute =
        [
            'username' => $_SESSION['username'],
            'password' => $password
        ];
        $new_password = $data->dataAction($prepare, $execute);
        $_SESSION['password'] = $password;
        header('Location: ' . $router->generate('account'));
    }
}
?>
<div class="row align-items-center p-3" style="height: auto;">
  <div class="icon-site col-md-1 col-2" style="background-color: #42A1B4;"></div>
  <h5 class="col-md-2 col-6 text-white my-auto">FESTIVAL INTERNATIONAL DU FILM <span class="font-weight-lighter">DE NIORT</span></h5>
</div>

<div class="row justify-content-center align-items-center mt-5" style="height: auto;">
  <h3 class="text-white text-uppercase font-weight-light"><?php if(!isset($_SESSION['password_checked'])) : ?><i class="fa fa-lock" aria-hidden="true"></i><?php else : ?><i class="fa fa-unlock-alt" aria-hidden="true"></i><? endif ?> Modifier mon pot de passe</h3>
</div>

<div class="d-flex justify-content-center w-100 px-5">
    <form action="" method="POST" class="w-100 mt-3 mx-5 d-flex flex-column align-items-center justify-content-center">
        <?php if(!isset($_SESSION['password_checked'])) : ?>
        <div class="form-group w-50 p-3">
            <label class="text-white" for="password_check">Saisissez votre mot de passe actuel : </label>
            <input type="password" class="form-control rounded-0" name="password_check" value="" >
        </div>
        <?php endif ?>
        <?php if(isset($_SESSION['password_checked'])) : ?>
            <div class="form-group w-50 p-3">
                <label class="text-white" for="password">Saisissez votre nouveau mot de passe : </label>
                <input type="password" class="form-control rounded-0" name="password" value="">
            </div>
        <?php endif ?>
        <div class="d-flex justify-content-center m-3">
            <a href="<?= $router->generate('account') ?>" class="btn btn-light border font-weight-lighter rounded-0 mt-auto mx-1" >Annuler</a>
            <button type="submit" class="btn btn-dark font-weight-lighter rounded-0 mt-auto mx-1" style="background-color: #EF6962;">Valider</button>    
        </div>
    </form>
</div>
