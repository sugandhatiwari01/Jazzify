<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $action = $_POST['action'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "imp";

    // Establish connection
    $conn = mysqli_connect($servername, $username, $password, $db, 3307);
    if (!$conn) {
        die("Connection error: " . mysqli_connect_error());
    }

    if ($action == "signup") {
        // Check if email already exists
        $sql1 = "SELECT * FROM sign WHERE email = '$email'";
        $result = mysqli_query($conn, $sql1);
        $num = mysqli_num_rows($result);

        if ($num > 0) {
            echo "<script>alert('Email already registered'); window.location.href='login.php';</script>";
            exit();
        } else {
            $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
            // Insert user into database
            $query = "INSERT INTO sign (name, email, password) VALUES ('$name', '$email', '$hashed_pass')";
            $check = mail($email, "Welcome User", "HELLO! " . $name . "🎶🎶Welcome to Jazzify🎷.Hope you enjoy streaming music without any interruptions whenever you want and wherever you please.", "From: sugandhaproject25@gmail.com");
     
           if( mysqli_query($conn, $query)){
            header("Location: main.html");
            exit();}
            else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } elseif ($action == "login") {
        // Check credentials for login
        $sql2 = "SELECT * FROM sign WHERE email = '$email'";
        $resu = mysqli_query($conn, $sql2);
        $user = mysqli_fetch_assoc($resu);

        if ($user && password_verify($pass, $user['password'])) {
            header("Location: main.html");
            exit();
        } else {
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
            overflow: hidden;
        }
        .form-box {
            width: 45%;
            max-width: 320px;
            background: rgba(17, 24, 39, 0.9);
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
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
        }
        #imgg {
            border-radius: 50px;
            border: 2px solid grey;
            width: 200px;
            transition: all 0.3s ease;
        }
        #imgg:hover {
            width: 207px;
            height: 48px;
            margin-left: -2px;
        }
        .sso {
            height: 45px;
            width: 300px;
            margin: 30px 0 0 10px;
        }
        .toggle {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .toggle button {
            flex-grow: 1;
            background: #2563eb;
            color: white;
            height: 45px;
            border-radius: 30px;
            border: 0;
            outline: 0;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
            padding: 0 20px;
        }
        .toggle button:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .toggle button:active {
            transform: translateY(1px);
            box-shadow: none;
        }
        .toggle button.disable {
            background: #3b4556;
            color: #9ca3af;
            cursor: hand;
            opacity: 0.6;
        }
        .sub {
            display: flex;
            justify-content: center;
        }
        .sub button {
            width: 100%;
            max-width: 300px;
            background: #4CAF50;
            color: white;
            height: 45px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.3s ease-in-out;
            cursor: pointer;
        }
        .sub button:hover {
            background: #45a049;
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
        .btn-field button.disable {
            background: #3b4556;
            color: #9ca3af;
            cursor: hand;
        }
        .error-message {
            font-size: 10px;
            margin-top: 4px;
            color: red;
        }
        input:-webkit-autofill {
            background-color: #1f2937 !important;
            color: white !important;
            box-shadow: 0 0 0 30px #1f2937 inset !important;
            transition: color 5000s ease-in-out 0s;
        }
        input:focus, input:active, input:-webkit-autofill:focus {
            background-color: #1f2937 !important;
            color: white !important;
            border: 1px solid #3b4556 !important;
        }

        /* Media Query for Mobile */
        @media only screen and (max-width: 768px) {
            .container {
                justify-content: center;
            }
            .form-box {
                width: 90%;
                padding: 30px;
            }
            .input-field {
                margin: 10px 0;
            }
            .sso {
                width: 50%;
                margin-left: 80px;
            }
            #imgg {
                width: 100%;
                height: auto;
                border-radius: 50%;
            }
            .toggle {
                flex-direction: column;
            }
            .toggle button {
                width: 100%;
                margin-bottom: 10px;
            }
        }

        </style>
    </head>
    <body>
   
        <div class="container">
            <div class="form-box">
                <h1 id="title">Sign Up</h1>

                <div class="btn-field">
                       <div class="toggle"><button type="button" id="signupBtn">Sign Up</button>
                        <button type="button" id="signinBtn" >Sign In</button>
                        </div> 

                    </div>

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
                      
                       <div class="sub"> <button type="submit" id="submitBtn" >Submit</button></div>

                    </div>
                    <div class="sso">                     
                    <a href='google.php' class="glink"> <img src="google.png" id="imgg" width="300px"></a>

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
    event.preventDefault(); // Prevent form submission

    // Clear any previous error messages
    clearErrorMessages();

    let name = document.getElementById("nameInput").value;
    let email = document.getElementById("emailInput").value;
    let password = document.getElementById("passwordInput").value;
    let valid = true;

    // Validation for Sign Up form
    if (formAction.value == "signup") {
        if (name == "") {
            showError("nameInput", "Please enter your name.");
            valid = false;
        }
        if (name.length > 50 ) {
            showError("nameInput", "Name should be atmost 50 characters ");
            valid = false;
        }
    }

    // Validation for email
    let emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (email == "" || !emailRegex.test(email)) {
        showError("emailInput", "Please enter a valid email address.");
        valid = false;
    }

    // Validation for password
    if (password.length < 6 ) {
        showError("passwordInput", "Password should be at least 6 characters.");
        valid = false;
    }
    if (password.length > 50 ) {
        showError("passwordInput", "Password should be at most 50 characters.");
        valid = false;
    }

    // If validation passes, submit the form
    if (valid) {
        document.getElementById("loginForm").submit();
    }
};

// Function to show error message below the input field
function showError(inputId, message) {
    let inputField = document.getElementById(inputId);
    let errorMessage = document.createElement("div");
    errorMessage.classList.add("error-message");
    errorMessage.style.color = "red";
    
    errorMessage.innerText = message;

    // Check if error message already exists, if not, add it
    if (!inputField.nextElementSibling || !inputField.nextElementSibling.classList.contains("error-message")) {
        inputField.parentNode.appendChild(errorMessage);
    }
}

// Function to clear error messages
function clearErrorMessages() {
    let errorMessages = document.querySelectorAll(".error-message");
    errorMessages.forEach(function(message) {
        message.remove();
    });
}

    </script>
</html>

