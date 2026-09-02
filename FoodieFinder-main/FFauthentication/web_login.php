<?php
session_start();
include "connector.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Checker for existing email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password
    if ($user && password_verify($password, $user["password"])) {
        // Set session variables
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];

        $_SESSION["success"] = "Login successful!";
         // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION["error"] = "Invalid email or password!";
        header("Location: web_login.php");
        exit();
    }
}
?>

<!-- Login Form (HTML) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FoodieFinder</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <div class="nav">
            <div class="logo">
            <img src="logo.png" width="125px">
        </div>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="support.html">Support</a></li>
            </ul>
            <div>
              <button class="login" onclick="window.location.href='login.html';">Log in</button>
            <button class="signup" onclick="window.location.href='signup.html';">Sign up</button>
          </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Background Image -->
        <div class="bg-image"></div>
        <div class="login-container">
            <form action="web_login.php" method="post">
                <h2>Log in</h2>
                <?php if (isset($_SESSION["error"])) { ?>
                <p style="color:red;"><?php echo $_SESSION["error"]; ?></p>
                <?php unset($_SESSION["error"]); } ?>
    
                <?php if (isset($_SESSION["success"])) { ?>
                <p style="color:green;"><?php echo $_SESSION["success"]; ?></p>
                <?php unset($_SESSION["success"]); } ?>

                <p>Don’t have an account? <a href="web_register.php">Create an account</a></p>
    
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <img src="email.png" alt="Email Icon">
                        <input type="email" id="email" name="email" maxlength="50" placeholder="Enter Email" required>
                    </div>
                </div>
    
                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <img src="lock.png" alt="Lock Icon">
                        <input type="password" id="password" name="password" maxlength="18" placeholder="Enter password" required>
                    </div>
                </div>
    
                <button type="submit" class="login-button"name="login" onclick="window.location.href='main.html'">Login</button>
    
                <div class="extras">
                    <label><input type="checkbox"> Remember me</label>
                    <a href="forgotpass.html">Forgot Password?</a>
                </div>
            </form>
        </div>
    </main>
    

    <footer>
        <div class="footer-container">
            <div class="sec sci">
                <div class="logo">
                    <img src="logo.png" width="250px">
                    <p>&copy; 2025 FoodieFinder. All rights reserved</p>
                    <ul class="icn">
                        <li><img src="twt.png" width="30px"></li>
                        <li><img src="fb.png" width="30px"></li>
                        <li><img src="yt.png" width="30px"></li>
                        <li><img src="link.png" width="30px"></li>
                    </ul>
                </div>
            </div>
            <div class="sec navigation">
                <h2>Navigation</h2>
                <ul class="navg">
                    <li><a href="index.html">Home</a></li> </br>
                    <li><a href="about.html">About Us</a></li> </br>
                    <li><a href="#">Contact Us</a></li> </br>
                    <li><a href="active">Support</a></li> </br>
                </ul>
            </div>
            <div class="sec help">
                <h2>Helpful Links</h2>
                <ul class="navg">
                    <li><a href="#">Privacy Policy</a></li> </br>
                    <li><a href="#">Terms and Conditions</a></li> </br>
                    <li><a href="#">FAQs</a></li> </br>
                </ul>
            </div>
        </div>
      </footer>
  </body>
</html>
