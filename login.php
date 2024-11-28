<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass =$_POST['password'];
$action = $_POST['action'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "jazzify";

    // Establish connection
    $conn = mysqli_connect($servername, $username, $password, $db);
    if (!$conn) {
        die("Connection error: " . mysqli_connect_error());
    } 
     if ($action == "signup") {
        $name = $_POST['name'];
        $sql1 = "SELECT * FROM sign WHERE email = '$email'";
        $result=mysqli_query($conn,$sql1);
        $num=mysqli_num_rows($result);
        if ($num > 0) {
            echo "<script>alert('Email already registered'); window.location.href='login.php';</script>";
            exit();
        } else {
            $query = "INSERT INTO sign (name, email, password) VALUES ('$name','$email','$pass')";

           mysqli_query($conn,$query);
            header("Location: main.html");
            exit();
        }
    }
 elseif ($action == "login") {
        $sql2 = "SELECT * FROM sign WHERE email = '$email' AND password='$pass';";
       $resu=mysqli_query($conn,$sql2);
$num=mysqli_num_rows($resu);
if($num==1){
  header("Location: main.html");
            exit();
}
else{
  echo "<script>alert('Email or password wrong'); window.location.href='login.php';</script>";

}

       
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <title>Login</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                font-family: 'Poppins', sans-serif;
            }
            .container {
                width: 90%;
                height: 100vh;
                background-image: url("posters/logoo.jpg");
                background-size: cover;
                background-position: center;
                display: flex;
                align-items: center;
                justify-content: flex-start;
                padding: 0 5%;
                overflow: hidden; /* Prevents horizontal scrollbar */
            }
            .form-box {
                width: 45%;
                max-width: 320px;
                background: rgba(17, 24, 39, 0.9); /* Semi-transparent dark background */
                text-align: center;
                padding: 50px 60px 70px;
                box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.6);
                border-radius: 10px;
            }
            .form-box h1 {
                text-align: center;
                margin-bottom: 60px;
                font-size: 30px;
                color: #a3b5d3;
                position: relative;
            }
            .form-box h1::after {
                content: '';
                width: 40px;
                height: 4px;
                border-radius: 3px;
                background: #a3b5d3;
                position: absolute;
                bottom: -12px;
                left: 50%;
                transform: translateX(-50%);
            }
            .input-field {
                background: #1f2937;
                margin: 15px 0;
                border-radius: 5px;
                display: flex;
                align-items: center;
                justify-content: center;
                max-height: 65px;
                transition: max-height 0.5s;
                overflow: hidden;
                border: 1px solid #3b4556;
            }
            input {
                width: 100%;
                background: transparent;
                border: none;
                outline: 0;
                padding: 18px;
                color: #d1d5db;
            }
            .input-field i {
                padding-left: 1rem;
                color: #6b7280;
            }
            form p {
                text-align: left;
                font-size: 16px;
                color: #a3b5d3;
            }
            form p a {
                text-decoration: none;
                color: #7f8ea6;
                font-weight: 500;
            }
            .btn-field {
                width: 100%;
                display: flex;
                justify-content: space-between;
                margin-top: 20px;
            }
            .btn-field button {
                flex-basis: 48%;
                background: #2563eb;
                color: white;
                height: 40px;
                border-radius: 20px;
                border: 0;
                outline: 0;
                cursor: pointer;
                transition: background 0.3s;
            }
            .btn-field button:hover {
                background: #1d4ed8;
            }
            .input-group {
                height: 280px;
            }
            .btn-field button.disable {
                background: #3b4556;
                color: #9ca3af;
                cursor: hand;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="form-box">
                <h1 id="title">Sign Up</h1>
                <form id="loginForm" method="POST" action="login.php">
<input type="hidden" name="action" id="formAction" value="signup">
                    <div class="input-group">
                        <div class="input-field" id="nameField">
                            <i class="fas fa-user"></i>
                            <input type="text" id="nameInput" name="name" placeholder="Name">
                        </div>
                        <div class="input-field">
                            <i class="fas fa-envelope"></i>
                            <input type="text" id="emailInput" name="email" placeholder="Email">
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="passwordInput" name="password" placeholder="Password">
                        </div>
                        
                    </div>
                    <div class="btn-field">
                        <button type="submit" id="signupBtn">Sign Up</button>
                        <button type="submit" id="signinBtn" >Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </body>    
    <script>
        // Get references to the elements
let signupBtn = document.getElementById("signupBtn");
let signinBtn = document.getElementById("signinBtn");
let nameField = document.getElementById("nameField");
let title = document.getElementById("title");
let formAction = document.getElementById("formAction");


// Toggle between Sign Up and Sign In
signinBtn.onclick = function() {
    nameField.style.maxHeight = "0";
    nameField.style.opacity = "0";

    title.innerHTML = "Sign In";
    signupBtn.classList.add("disable");
    signinBtn.classList.remove("disable");
        formAction.value = "login"; 
};

signupBtn.onclick = function() {
    nameField.style.maxHeight = "65px";
    nameField.style.opacity = "1";

    title.innerHTML = "Sign Up";
    signupBtn.classList.remove("disable");
    signinBtn.classList.add("disable");
        formAction.value = "signup"; 
};

// Adding basic validation
document.getElementById("loginForm").onsubmit = function(event) {
    event.preventDefault();
    let name = document.getElementById("nameInput").value;

    let email = document.getElementById("emailInput").value;
    let password = document.getElementById("passwordInput").value;


if(formAction.value=="signup"){if(name==""){alert("Enter Name"); return;}}

    if (!email.includes("@")) {
        alert("Please enter a valid email address.");
        return;
    }

    if (password.length < 6) {
        alert("Password should be at least 6 characters.");
        return;
    }

document.getElementById("loginForm").submit();
};
    </script>
</html>