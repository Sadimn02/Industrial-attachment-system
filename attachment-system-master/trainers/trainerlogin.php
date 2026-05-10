<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Login | UITS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #003366;
            --accent: #FFC600;
            --white: #ffffff;
            --error: #ff4d4d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            /* Distinct subtle gradient for Trainer portal */
            background: linear-gradient(135deg, #001a33 0%, #004080 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Glassmorphism Card */
        .login-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .header-box i {
            font-size: 3.5rem;
            color: var(--accent);
            margin-bottom: 15px;
        }

        .login-card h2 {
            color: var(--white);
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .login-card p.subtitle {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
            margin-bottom: 30px;
        }

        /* Input Styling */
        .input-group {
            position: relative;
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            margin-bottom: 8px;
            margin-left: 5px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            bottom: 13px;
            color: rgba(255, 255, 255, 0.5);
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: var(--white);
            outline: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .input-group input:focus {
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.1);
        }

        /* Error Div */
        #errors {
            color: var(--error);
            font-size: 0.8rem;
            margin-bottom: 10px;
        }

        /* Button Styling */
        .btn {
            width: 100%;
            padding: 14px;
            background: var(--accent);
            color: var(--primary);
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            text-transform: uppercase;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 198, 0, 0.3);
            background: #f2bc00;
        }

        hr {
            margin: 25px 0;
            border: 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Footer Links */
        .footer-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .footer-text a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        .home-link {
            display: inline-block;
            margin-top: 15px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
            transition: 0.3s;
        }
        
        .home-link:hover { opacity: 1; color: var(--white); }

    </style>
</head>
<body>

    <div class="login-card">
        <div class="header-box">
            <i class="fa fa-user-tie"></i>
        </div>
        <h2>Trainer Login</h2>
        <p class="subtitle">Industrial Supervisor Access</p>

        <form method="post" id="trainlogin" action="login.php" onSubmit="return validateForm()">
            <div class="input-group">
                <label>Email Address</label>
                <i class="fa fa-envelope"></i>
                <input type="text" name="email" id="email" placeholder="name@company.com">
            </div>

            <div class="input-group">
                <label>Password</label>
                <i class="fa fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="••••••••">
            </div>

            <div id="errors"></div>

            <button type="submit" class="btn" name="login_btn">Sign In</button>
            
            <hr>
            
            <p class="footer-text">
                Not yet a member? <a href="trainerregistration.php">Sign up</a><br>
                <a href="../index.php" class="home-link"><i class="fa fa-chevron-left" style="font-size: 0.7rem;"></i> Back to Home</a>
            </p>
        </form>
    </div>

    <script>
        function validateForm() {
            // Validate email
            const email = document.getElementById("email").value;
            if (email.length == 0 || email.indexOf("@") == -1 || email.indexOf(".") == -1) {
                alert("You must enter a valid email address");
                document.getElementById("email").focus();
                return false;
            }
            
            // Validating password
            const password = document.getElementById("password").value;
            if (password == "" || password.length < 8) {
                alert("Password should not be empty and must be at least 8 characters");
                document.getElementById("password").focus();
                return false;
            }
            return true;
        }
    </script>
</body>
</html>