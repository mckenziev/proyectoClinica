<?php
    session_start();

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: principal.php");
        exit;
    }

    include "config.php";

    $pdo = pdo_connect_mysql();
    $consulta = "SELECT usuario, contra FROM login WHERE usuario = :current_page";

    $f = true;
    $username = $password = "";
    $username_err = $password_err = $login_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty(trim($_POST["username"]))){
            $username_err = "Debe ingresar un usuario para continuar.";
            $f = false;
        } else{
            $username = trim($_POST["username"]);
        }
        
        //se verifica si el campo de contraseña esta vacio
        if(empty(trim($_POST["password"]))){
            $password_err = "Debe ingresar una contraseña para continuar.";
            $f = false;
        } else{
            $password = trim($_POST["password"]);
        }
        if($f){
            if($stmt = $pdo->prepare($consulta)){   
                $stmt->bindValue(':current_page', trim($_POST["username"]), PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch();
                    if($stmt->rowCount() == 1){                    
                        if($password == $row['contra']){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["usuario"] = $username;                        
                            
                            header("location: index.php");
                        } else{
                            $login_err = "Contraseña incorrecta, vuelva a intentarlo.";
                        }
                    } else{
                        // Username doesn't exist, display a generic error message
                        $login_err = "Usuario incorrecto, vuelva a intentarlo.";
                    }
            }else{
                $login_err = "No se obtuvo una respuesta valida del servidor.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inicio de Sesion</title>
</head>
    <body class="body-login">
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
        <div class="login">
            <div class="login-triangle"></div>
            
            <h2 class="login-header">Inicio de sesion</h2>

            <form class="login-container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <p><input type="username" name="username" placeholder="Usuario" <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>"></p>
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div>
                    <p><input type="password" name="password" placeholder="Contraseña" <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"></p>
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <p><input type="submit" value="Log in"></p>
                </div>
                
            </form>
        </div>

        
    </body>
</html>