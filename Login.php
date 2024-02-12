<?php
require_once "inc/connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
        }
        .nav .links a:hover , button:hover{
            background-color:#8000ff ;
        }
        body {
            display: flex;
            flex-direction: column;
            align-content: center;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            height: 100px;
            padding: 20px;
            background-color: #607d8b4a;
        }

        .nav {
            display: flex;
            flex-direction: row;
            align-content: center;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            height: 100px;
            padding: 10px;
            margin: 0;
        }

        .nav .links {
            width: 15%;
            display: flex;
            justify-content: space-around;
        }

        .nav .links a {
            color: white;
            padding: 4px 10px;
            background-color: #03a9f47a;
            text-decoration: none;
            border-radius: 4px;
            transition: all 1s;
        }

        .input {
            outline: none;
            border: none;
            width: 300px;
            height: 45px;
            border-radius: 10px;
            padding: 10px;
        }

        .form {
            width: 430px;
            height: 425px;
            display: flex;
            flex-direction: column;
            align-items: center;
            align-content: center;
            justify-content: space-between;
            background-color: rgba(255, 255, 255, 0.423);
            backdrop-filter: blur(30px);
            padding: 30px;
            -webkit-filter-blur: 10%;
            border-radius: 30px;
        }

        form button {
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            color: white;
            background-color: #03a9f47a;
            transition: all 1s;
        }

        form span a {
            text-decoration: none;
            color: black;
            font-weight: bold;
        }

        .remember {
            width: 135px;
            height: 32px;
            display: flex;
            flex-direction: row;
            align-content: center;
            justify-content: space-around;
            align-items: center;
        }
        .wrong{
            color: red;
        }
    </style>
</head>

<body>
    <div class="nav">
        <div class="links">
            <a href="Login.php">Log in</a>
            <!-- <a href="Register.php">Register</a> -->
        </div>
    </div>
    <div>
    <?php
    function validate_input($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
    
    if (isset($_POST['submit'])) {
      
      $email = mysqli_real_escape_string($con, validate_input($_POST['email']));
      $password = mysqli_real_escape_string($con, validate_input($_POST['password']));
    
      if (empty($email)) {
          $errors['email'] = "Email is required";
      }
    
      if (empty($password)) {
          $errors['password'] = "Password is required";
      }
    
      if (empty($errors)) {
        $user_query = "SELECT * FROM `users` WHERE `email`='$email'";
        $user_result = mysqli_query($con, $user_query);
    
        if (mysqli_num_rows($user_result) == 1) {
            $user_data = mysqli_fetch_assoc($user_result);
    
            if ($user_data && password_verify($password, $user_data['password'])) {
                    $_SESSION['email'] = $email;
                    $t = "SELECT `id` FROM `users` WHERE `email` = '{$_SESSION['email']}'";
                    $h = mysqli_query($con, $t);
    
                    if ($row = mysqli_fetch_assoc($h)) {
                        $user_id = $row['id'];
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['loggedin'] = true;
                        session_regenerate_id();
                        header("location:index.php");
                        exit();
                    } else {
                        echo "<script>alert('An Error occurred!');</script>";
                    }
                }else{
                    echo "<script>alert('Invalid Credentials!!');</script>";
                }
            } else {
                echo "<script>alert('Email does not exist!');</script>";
            }   
    }
}

?>

        <form class="form" action="" method="post">
            
            <h3>Login Here</h3>
            <input placeholder="Enter Email" class="input" type="email" name="email" id=""value="">
            <span style="color: red;"> <?php echo isset($errors['email']) ? $errors['email'] : null ?> </span>
            <input class="input" placeholder="Enter Password" type="password" name="password" id="">
            <span style="color: red;"> <?php echo isset($errors['password']) ? $errors['password'] : null ?> </span>
            <button type="submit" name="submit">Login</button>
           
            

        </form>
    </div>
</body>

</html>