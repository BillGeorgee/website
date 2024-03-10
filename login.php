<?php
        if(isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $errors = array();
        if (empty($email) || empty($password)) {
            array_push($errors, "Email and password are required");
        } else {
            require_once "database.php";
            $sql = "SELECT * FROM user WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

            if($user) {
                if(password_verify($password, $user["password"])) {
                    $_SESSION["user"] = "yes";
                    header("Location: contact.html");
                    die();
                } else {
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Email not found</div>";
            }
        }

        // Display any validation errors
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://secure.exportkit.com/cdn/js/ek_googlefonts.js?v=6"></script>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
    body {
    background-image: url("background.gif");
    background-size: 100%;
    position: relative;
    overflow: hidden;
}

.container {
    max-width: 500px;
    margin: 0 auto;
    margin-top: 10px;
    padding:50px;
    background-color: #e1e1e1;
    opacity: 100%;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.7);
    display: block;
}

.form-group {
    margin-bottom:30px;
}

.btn-custom {
    background-color: gray;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.btn-custom:hover {
    background-color: #a9a9a9;
}
.custom-image {
            width: 180px; 
            height: auto; 
            border-radius: 20px; 
            margin-bottom: 20px; 
            margin-left: 650px;
            margin-top:30px;
            position: relative;
        }
.back-button {
    position: absolute;
    top: 20px;
    left: 20px;
    padding: 10px;
    font-size: 16px;
    background-color: gray;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.back-button i {
    vertical-align: middle;
}
.back-button:hover {
    background-color: #a9a9a9;
}
</style>
<body>
    <button class="back-button" onclick="goBack()"><i class="fas fa-arrow-left"></i></button>
    <div class="container">
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class= "form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class= "form-control" required>
            </div>

            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn-custom">
            </div>
        </form>
        <div><p>Not Registered Yet? <a href="register.php"> Register Here</a></div>
    </div>
    <script>
        function goBack() {
        window.location.href = "about.html";
    }
    </script>

</body>
</html>