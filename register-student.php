<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $name = $lastname = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = $error = "";
$isOrg = 0;
$indeks = null;
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
        $error = "Wprowadzono nieprawidłowe dane";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
        $error = "Wprowadzono nieprawidłowe dane";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM students WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                    $error = "Wprowadzono nieprawidłowe dane";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password."; 
        $error = "Wprowadzono nieprawidłowe dane";    
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
        $error = "Wprowadzono nieprawidłowe dane";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password."; 
        $error = "Wprowadzono nieprawidłowe dane";    
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
            $error = "Wprowadzono nieprawidłowe dane";
        }
    }
    $name = trim($_POST["name"]);
    $lastname = trim($_POST["lastname"]);
    $indeks = trim($_POST["indeks"]);
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO students (username, name, lastname, indeks, password, isOrg) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssisi", $param_username, $param_name, $param_lastname, $param_indeks, $param_password, $param_isOrg);
            
            // Set parameters
            $param_username = $username;
            $param_name = $name;
            $param_lastname = $lastname;
            $param_indeks = $indeks;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_isOrg = $isOrg;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="register.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <main class="container_login">
    <div class="login_table">
        <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <span class="invalid-feedback"><?php echo $error; ?></span>    
            <div class="column_wrapper">
                <div class="form-group">
                    <label>Imię</label>
                    <input type="text" name="name" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    </div>
                <div class="form-group">
                    <label>Nazwisko</label>
                    <input type="text" name="lastname" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    </div>
            </div>  
            <div class="form-group">
                <label>Nazwa użytkownika</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                </div>        
            <div class="form-group">
                <label>Numer indeksu</label>
                <input type="number" name="indeks" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                </div>
            <div class="form-group">
                <label>Hasło</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                </div>
            <div class="form-group">
                <label>Potwierdź hasło</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                </div>
            <div class="form-group sub">
                <input type="submit" class="btn btn-primary" value="Rejestracja">
            </div>
            </form>
        <section class="register">
        <p>Masz już konto? <a href="login.php">Zaloguj się tutaj</a>.</p>
        </section>
    </div>  
</main>  
</body>
</html>