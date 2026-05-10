<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login | UITS</title>
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
            background: linear-gradient(135deg, var(--primary) 0%, #001a33 100%);
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
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.2);
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
            margin-bottom: 30px;
            text-transform: uppercase;
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
            box-shadow: 0 0 10px rgba(255, 198, 0, 0.2);
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
            background: #e6b300;
        }

        /* Footer Links */
        .footer-text {
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .footer-text a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        .home-link {
            display: inline-block;
            margin-top: 15px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

    </style>
</head>
<body>

    <div class="login-card">
        <div class="header-box">
            <i class="fa fa-user-circle"></i>
        </div>
        <h2>Student Login</h2>

        <form method="post" id="studentlogin" action="login.php" onSubmit="return validateForm()">
            <div class="input-group">
                <label>Admission Number</label>
                <i class="fa fa-id-card"></i>
                <input type="text" name="admissionnumber" id="admissionnumber" placeholder="Enter Admission No.">
            </div>

            <div class="input-group">
                <label>Password</label>
                <i class="fa fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="••••••••">
            </div>

            <button type="submit" class="btn" id="login_btn" name="login_btn">Login Now</button>
            
            <p class="footer-text">
                Not yet a member? <a href="studentregistration.php">Sign up</a><br>
                <a href="../index.php" class="home-link"><i class="fa fa-arrow-left" style="font-size: 0.7rem;"></i> Back to Home</a>
            </p>
        </form>
    </div>

    <script>
        function validateForm() {
            // Validate admission number
            const admissionnumber = document.getElementById("admissionnumber").value;
            if (admissionnumber == "" || isNaN(admissionnumber) || admissionnumber.length < 5) {
                alert("Please enter a valid admission number (at least 5 digits)");
                document.getElementById("admissionnumber").focus();
                return false;
            }
            
            // Validating password
            const password = document.getElementById("password").value;
            if (password == "" || password.length < 8) {
                alert("Password must be at least 8 characters long");
                document.getElementById("password").focus();
                return false;
            }
            return true;
        }
    </script>
</body>
</html>