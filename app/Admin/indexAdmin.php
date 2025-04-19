
<!DOCTYPE html>
<html lang="pt-ao">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Acesso</title>
    <?php require("../Views/Links.php") ?>
</head>
<body class="bg-light">
    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
        <form method="post">
            <h4 class="bg-dark text-white py-3">Painel de Acesso Administrativo</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input name="Admin_login" required type="text" class="form-control shadow-none text-center" placeholder="Nome Administrativo">
                </div>
                <div class="mb-4">
                    <input name="Admin_pass" required type="password" class="form-control shadow-none text-center" placeholder="Password">
                </div>
                <button name="login" type="submit" class="btn text-white custom-bg shadow-none" >Logar</button>
            </div>
        </form>
    </div>

    <?php 
        require("../Controllers/Admin_login.php")
    ?>
    <?php require("../Views/scripts.php") ?>
</body>
</html>