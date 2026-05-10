<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Registration | UITS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #003366;
            --accent: #FFC600;
            --white: #ffffff;
            --glass-bg: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            /* Industrial themed professional gradient */
            background: linear-gradient(135deg, #001a33 0%, #004080 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        /* Glassmorphism Card */
        .reg-card {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 40px;
            width: 100%;
            max-width: 700px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        .header-box {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-box i {
            font-size: 3rem;
            color: var(--accent);
            margin-bottom: 10px;
        }

        .header-box h2 {
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 1.5rem;
        }

        .header-box p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
            margin-top: 5px;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .inputform {
            margin-bottom: 5px;
            text-align: left;
        }

        .full-width {
            grid-column: span 2;
        }

        .inputform label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.85rem;
            margin-bottom: 8px;
            padding-left: 5px;
        }

        .inputform input {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: var(--white);
            outline: none;
            transition: 0.3s;
            font-size: 0.9rem;
        }

        .inputform input:focus {
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.1);
        }

        /* Button Styling */
        .btn-container {
            grid-column: span 2;
            text-align: center;
            margin-top: 15px;
        }

        .btn {
            width: 100%;
            max-width: 300px;
            padding: 14px;
            background: var(--accent);
            color: var(--primary);
            border: none;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            font-size: 1rem;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 198, 0, 0.3);
            background: #f2bc00;
        }

        .footer-text {
            grid-column: span 2;
            text-align: center;
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .footer-text a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-width, .btn-container, .footer-text { grid-column: span 1; }
        }
    </style>
</head>
<body>

    <div class="reg-card">
        <div class="header-box">
            <i class="fa fa-user-tie"></i>
            <h2>Trainer Registration</h2>
            <p>Industry Attachment Management Portal</p>
        </div>

        <form method="post" id="trainerreg" action="./includes/server.php" onSubmit="return validateForm()">
            <div class="form-grid">
                <div class="inputform full-width">
                    <label>Trainer Full Name</label>
                    <input type="text" id="trainername" name="trainername" placeholder="Enter your official name">
                </div>

                <div class="inputform">
                    <label>Email Address</label>
                    <input type="email" id="email" name="email" placeholder="corporate@email.com">
                </div>

                <div class="inputform">
                    <label>Phone Number</label>
                    <input type="text" id="mobile" name="mobile" placeholder="e.g. 01700000000">
                </div>

                <div class="inputform full-width">
                    <label>Title / Job Position</label>
                    <input type="text" id="title" name="title" placeholder="e.g. Senior Software Engineer">
                </div>

                <div class="inputform">
                    <label>Password</label>
                    <input type="password" id="password_1" name="password_1" placeholder="Min. 8 characters">
                </div>

                <div class="inputform">
                    <label>Confirm Password</label>
                    <input type="password" id="password_2" name="password_2" placeholder="Repeat password">
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn" name="register_btn">Register as Trainer</button>
                </div>

                <p class="footer-text">
                    Already a member? <a href="trainerlogin.php">Sign in here</a>
                </p>
            </div>
        </form>
    </div>

    <script>
        function validateForm() {
            // Fullname check
            let trainername = document.getElementById("trainername").value;
            if (trainername == "" || trainername.length < 4) {
                alert("Please enter your full name");
                document.getElementById("trainername").focus();
                return false;
            }
            
            // Email check
            let email = document.getElementById("email").value;
            if (email.length == 0 || email.indexOf("@") == -1 || email.indexOf(".") == -1) {
                alert("You must enter a valid email address");
                document.getElementById("email").focus();
                return false;
            }
            
            // Phone check
            let mobile = document.getElementById("mobile").value;
            if (mobile == "" || isNaN(mobile) || mobile.length < 8) {
                alert("Please enter a valid phone number");
                document.getElementById("mobile").focus();
                return false;
            }
            
            // Title check
            let title = document.getElementById("title").value;
            if (title == "") {
                alert("Please enter your professional title");
                document.getElementById("title").focus();
                return false;
            }
            
            // Password checks
            let password_1 = document.getElementById("password_1").value;
            if (password_1 == "" || password_1.length < 8) {
                alert("Password should be at least 8 characters long");
                document.getElementById("password_1").focus();
                return false;
            }
            
            let password_2 = document.getElementById("password_2").value;
            if (password_2 == "" || password_2 != password_1) {
                alert("Passwords do not match. Please try again.");
                document.getElementById("password_2").focus();
                return false;
            }
            return true;
        }
    </script>
</body>
</html>