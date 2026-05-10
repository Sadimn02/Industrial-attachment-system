<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Login | UITS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #003366;
            --accent: #FFC600;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            /* Elegant academic-themed gradient */
            background: linear-gradient(135deg, #00264d 0%, #004080 100%);
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
            padding: 45px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .header-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 198, 0, 0.15);
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            margin: 0 auto 20px auto;
            font-size: 2rem;
            border: 1px solid rgba(255, 198, 0, 0.3);
        }

        .login-card h2 {
            color: var(--white);
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .login-card p.subtitle {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
            margin-bottom: 30px;
        }

        /* Input Group Styling */
        .input-group {
            position: relative;
            margin-bottom: 25px;
            text-align: left;
        }

        .input-group label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.85rem;
            margin-bottom: 8px;
            margin-left: 5px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            bottom: 13px;
            color: var(--accent);
            opacity: 0.8;
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
            box-shadow: 0 0 15px rgba(255, 198, 0, 0.1);
        }

        /* Button Styling */
        .btn-lec {
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
            text-transform: uppercase;
            margin-top: 10px;
        }

        .btn-lec:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 198, 0, 0.3);
            background: #f2bc00;
        }

        /* Footer links */
        .footer-links {
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .footer-links a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .home-btn {
            display: inline-block;
            margin-top: 20px;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .home-btn:hover { color: var(--white); }

    </style>
</head>
<body>

    <div class="login-card">
        <div class="header-icon">
            <i class="fa fa-chalkboard-teacher"></i>
        </div>
        <h2>Lecturer Login</h2>
        <p class="subtitle">Faculty Supervision Portal</p>

        <form method="post" id="leclogin" action="login.php" onSubmit="return validateForm()">
            <div class="input-group">
                <label>Role ID / Staff ID</label>
                <i class="fa fa-id-badge"></i>
                <input type="text" id="role_id" name="role_id" placeholder="Enter your Role ID">
            </div>

            <div class="input-group">
                <label>Password</label>
                <i class="fa fa-shield-alt"></i>
                <input type="password" id="password" name="password" placeholder="••••••••">
            </div>

            <button type="submit" class="btn-lec" name="login_btn">Sign In</button>
            
            <p class="footer-links">
                Not yet a member? <a href="lecturerregistration.php">Sign up</a><br>
                <a href="../index.php" class="home-btn">
                    <i class="fa fa-chevron-left" style="font-size: 0.7rem;"></i> Back to Home
                </a>
            </p>
        </form>
    </div>

    <script>
        function validateForm() {
            // Validate Role ID
            const role_id = document.getElementById("role_id").value;
            if (role_id === "" || role_id.length < 4) {
                alert("Please enter a valid Role ID");
                document.getElementById("role_id").focus();
                return false;
            }
            
            // Validate Password
            const password = document.getElementById("password").value;
            if (password === "" || password.length < 8) {
                alert("Password should not be empty and must be at least 8 characters long");
                document.getElementById("password").focus();
                return false;
            }
            return true;
        }
    </script>

</body>
</html>