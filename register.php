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
            <!-- <a href="Login.php">Log in</a> -->
            <!-- <a href="Register.php">Register</a> -->
        </div>
    </div>
    <div>
    <?php

$errors = [];
function validate_input($input)
{
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    return $input;
}

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($con ,validate_input($_POST['name']));
    $email = mysqli_real_escape_string($con ,validate_input($_POST['email']));
    $password =mysqli_real_escape_string($con , validate_input($_POST['password'])); 
    $phone = mysqli_real_escape_string($con , validate_input($_POST['phone']));

    if (empty($name)) {
        $errors['name'] = " Name is required";
    } elseif (!ctype_alpha(str_replace(" ", "", $name))) {
        $errors['name'] = "Only letters and White space are allowed";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = "Enter a valid Email";
    }

    if (empty($_POST['password'])) {   // we have to check the emptiness of the field by checking the field itself not the hashed 
        $errors['password'] = "Password is required";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{3,}$/', $password)) {
        $errors['password'] = "Password must include at least one uppercase letter, one lowercase letter, one number, and one special character";
    }

    if (empty($phone)) {
        $errors['phone'] = "Phone is required";
    } elseif (!preg_match('/^[0-9]{11}$/', $phone)) {
        $errors['phone'] = "Enter a valid 10-digit phone number";
    }


    if (empty($errors)) {

        $qy = "SELECT COUNT(*) AS count FROM users WHERE email = '$email'";
        $checkPhone = "SELECT COUNT(*) AS count FROM users WHERE phone = '$phone'";
        $rt = mysqli_query($con, $qy);
        $rt2 = mysqli_query($con , $checkPhone);
        $row = mysqli_fetch_assoc($rt);
        $row2 = mysqli_fetch_assoc($rt2);
        $emailCount = $row['count'];
        $phoneCount = $row2['count'];

        if ($emailCount > 0) {
        echo '<script language="javascript">';
        echo 'alert("This email already exists!")';
        echo '</script>';
      } elseif($phoneCount > 0){
        echo '<script language="javascript">';
        echo 'alert("This Phone Number already exists!")';
        echo '</script>';
      }  else {

        $hashed_password = password_hash($password , PASSWORD_DEFAULT);

        $query = "INSERT INTO `users`(`name`, `email`, `password`, `phone`)
         VALUES('$name' ,'$email' , '$hashed_password' , '$phone')";

         if (mysqli_query($con , $query)) {
            echo "<script>alert('Your account created successfully!')</script>";
            echo "<script>window.location.href='login.php';</script>";
            exit();  
         } else {
            echo "<script> alert('An Error Occured!') </script>";
         }

    } 
}
}






?>

        <form class="form" action="" method="post">
            
            <h3>Register Here</h3>
            <input placeholder="Enter Name" class="input" type="text" name="name" id=""value="">
            <span style="color: red;"> <?php echo isset($errors['name']) ? $errors['name'] : null ?> </span>
            <input placeholder="Enter Email" class="input" type="email" name="email" id=""value="">
            <span style="color: red;"> <?php echo isset($errors['email']) ? $errors['email'] : null ?> </span>
            <input class="input" placeholder="Enter Password" type="password" name="password" id="">
            <span style="color: red;"> <?php echo isset($errors['password']) ? $errors['password'] : null ?> </span>
            <input class="input" placeholder="Enter your phone " type="text" name="phone" id="">
            <span style="color: red;"> <?php echo isset($errors['phone']) ? $errors['phone'] : null ?> </span>
            <button type="submit" name="submit">Register</button>
        </form>
    </div>
</body>

</html>