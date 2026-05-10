<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Registration | UITS</title>
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
            background: linear-gradient(135deg, #00264d 0%, #004080 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        /* Glassmorphism Registration Card */
        .reg-card {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 40px;
            width: 100%;
            max-width: 700px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.2);
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
            font-size: 1.6rem;
        }

        /* Grid Layout for Form */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .inputform {
            margin-bottom: 15px;
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

        .inputform input, .inputform select {
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

        .inputform select option {
            background: var(--primary);
            color: white;
        }

        .inputform input:focus, .inputform select:focus {
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.1);
        }

        /* Button Styling */
        .btn-container {
            grid-column: span 2;
            text-align: center;
            margin-top: 10px;
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
            margin-top: 20px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .footer-text a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-width, .btn-container { grid-column: span 1; }
        }
    </style>
</head>
<body>

    <div class="reg-card">
        <div class="header-box">
            <i class="fa fa-user-plus"></i>
            <h2>Lecturer Registration</h2>
        </div>

        <form method="post" id="lecreg" action="./includes/server.php" onSubmit="return validateForm()">
            <div class="form-grid">
                <div class="inputform full-width">
                    <label>Full Name</label>
                    <input type="text" id="lecname" name="lecname" placeholder="Enter your full name">
                </div>

                <div class="inputform">
                    <label>Role ID</label>
                    <input type="text" id="role_id" name="role_id" placeholder="ID Number">
                </div>

                <div class="inputform">
                    <label>Email Address</label>
                    <input type="email" id="email" name="email" placeholder="example@uits.edu.bd">
                </div>

                <div class="inputform">
                    <label>Phone Number</label>
                    <input type="text" name="phonenumber" id="phonenumber" placeholder="e.g. 01700000000">
                </div>

                <div class="inputform">
                    <label for="department">Department</label>
                    <select name="department" id="department">
                        <option value="" disabled selected>Select Department</option>
                        <option value="Mathematics and Actuarial Science">Mathematics and Actuarial Science</option>
                        <option value="Computer and Information Science">Computer and Information Science</option>
                        <option value="Community Health and Development">Community Health and Development</option>
                        <option value="Natural Sciences">Natural Sciences</option>
                        <option value="Nursing">Nursing</option>
                    </select>
                </div>

                <div class="inputform">
                    <label>Password</label>
                    <input type="password" id="password_1" name="password_1" placeholder="At least 8 characters">
                </div>

                <div class="inputform">
                    <label>Confirm Password</label>
                    <input type="password" id="password_2" name="password_2" placeholder="Repeat password">
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn" name="register_btn">Register Account</button>
                </div>

                <p class="footer-text">
                    Already a member? <a href="lecturerlogin.php">Sign in</a>
                </p>
            </div>
        </form>
    </div>

    <script>
        function validateForm() {
            // Fullname check
            let lecname = document.getElementById("lecname").value;
            if (lecname == "" || lecname.length < 4) {
                alert("Please enter your full name");
                document.getElementById("lecname").focus();
                return false;
            }

            // Role ID check
            let role_id = document.getElementById("role_id").value;
            if (role_id == "" || role_id.length < 4) {
                alert("Please enter your Role ID");
                document.getElementById("role_id").focus();
                return false;
            }

            // Email check
            let email = document.getElementById("email").value;
            if (email.length == 0 || email.indexOf("@") == -1 || email.indexOf(".") == -1) {
                alert("You must enter a valid email");
                document.getElementById("email").focus();
                return false;
            }

            // Phone check
            let phonenumber = document.getElementById("phonenumber").value;
            if (phonenumber == "" || isNaN(phonenumber) || phonenumber.length < 8) {
                alert("Please enter valid phone number");
                document.getElementById("phonenumber").focus();
                return false;
            }

            // Department check
            let department = document.getElementById("department").value;
            if (department == "") {
                alert("Please enter department");
                document.getElementById("department").focus(); // FIXED: Removed extra 'd'
                return false;
            }

            // Password 1 check
            let password_1 = document.getElementById("password_1").value;
            if (password_1 == "" || password_1.length < 8) {
                alert("Password should not be empty and it should have more than 8 characters");
                document.getElementById("password_1").focus();
                return false;
            }

            // Password 2 check
            let password_2 = document.getElementById("password_2").value;
            if (password_2 == "" || password_2.length < 8) {
                alert("Confirm Password should not be empty");
                document.getElementById("password_2").focus();
                return false;
            }

            // Final check: Passwords must match
            if (password_1 !== password_2) {
                alert("Passwords do not match!");
                document.getElementById("password_2").focus();
                return false;
            }

            // SUCCESS: Allow form submission
            return true; 
        }
    </script>

</body>
</html>