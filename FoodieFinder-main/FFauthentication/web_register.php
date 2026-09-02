<?php
session_start();
include "connector.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["txtEmail"]);
    $password = trim($_POST["txtPw"]);
    $confirm_password = trim($_POST["txtConfirmPw"]);

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION["error"] = "Passwords do not match!";
        header("Location: web_register.php");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email is already registered
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $_SESSION["error"] = "Email already exists!";
        header("Location: web_register.php");
        exit();
    }

    // Insert new user into database
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    
    if ($stmt->execute([$email, $hashed_password])) {
        $_SESSION["success"] = "Registration successful. Please log in.";
        header("Location: web_login.php"); // Redirect to login page
        exit();
    } else {
        $_SESSION["error"] = "Registration failed. Try again.";
    }
}
?>

<!-- Registration Form (HTML) -->
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet"href="signup.css">
    <title>register</title>
</head>
<body>
    <header>
        <div class="nav">
            <div class="logo">
            <img src="logo.png" width="125px">
        </div>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a  href="about.html">About Us</a></li>
                <li><a href="support.html">Support</a></li>
            </ul>
            <div>
              <button class="login" onclick="window.location.href='newlogin.html';">Log in</button>
            <button class="signup" onclick="window.location.href='signup.html';">Sign up</button>
          </div>
            </div>
        </div>
    </header>

    <main>
        <div class="bg-image"></div>
        <div class="form-container">
            <form action="web_register.php" method="post">
                <h2>Sign up</h2>
                <?php if (isset($_SESSION["error"])) { ?>
                <p style="color:red;"><?php echo $_SESSION["error"]; ?></p>
                <?php unset($_SESSION["error"]); } ?>
    
                <?php if (isset($_SESSION["success"])) { ?>
                <p style="color:green;"><?php echo $_SESSION["success"]; ?></p>
                <?php unset($_SESSION["success"]); } ?>
                <p>Already have an account? <a href="web_login.php">Log in</a></p>
                
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <img src="email.png" alt="email">
                        <input type="email" id="email" name="txtEmail" maxlength="50" placeholder="Enter Email" required>
                    </div>
                </div>
    
                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <img src="lock.png" alt="password">
                        <input type="password" id="password" name="txtPw" maxlength="18" placeholder="Enter password" required>
                    </div>
                </div>
    
                <div class="input-group">
                    <label for="confirm-password">Confirm Password</label>
                    <div class="input-wrapper">
                        <img src="lock.png" alt="confirm password">
                        <input type="password" id="confirm-password" name="txtConfirmPw" placeholder="Enter password" required>
                    </div>
                </div>
                
                <button type="submit" class="signup-button" name="register" onclick="window.location.href='shopdetails.html'">Sign up</button>
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
                    <li><a href="support.html">Support</a></li> </br>
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