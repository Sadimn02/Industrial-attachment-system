<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration | UITS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #003366;
            --accent: #FFC600;
            --white: #ffffff;
            --glass: rgba(255, 255, 255, 0.1);
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
            padding: 40px 20px;
        }

        .reg-card {
            background: var(--glass);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 40px;
            width: 100%;
            max-width: 850px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header i {
            font-size: 3rem;
            color: var(--accent);
            margin-bottom: 10px;
        }

        .header h2 {
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        /* Form Layout */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .section-title {
            grid-column: span 2;
            color: var(--accent);
            font-size: 0.9rem;
            text-transform: uppercase;
            border-bottom: 1px solid rgba(255, 198, 0, 0.3);
            padding-bottom: 5px;
            margin-top: 10px;
            letter-spacing: 1px;
        }

        .inputform {
            display: flex;
            flex-direction: column;
        }

        .inputform label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            margin-bottom: 8px;
            margin-left: 5px;
        }

        .inputform input, .inputform select {
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: var(--white);
            outline: none;
            transition: 0.3s;
            font-size: 0.9rem;
        }

        .inputform input:focus, .inputform select:focus {
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.1);
        }

        .inputform select option {
            background: var(--primary);
            color: white;
        }

        /* Date Input specific fix */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }

        .btn-container {
            grid-column: span 2;
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            width: 100%;
            max-width: 350px;
            padding: 15px;
            background: var(--accent);
            color: var(--primary);
            border: none;
            border-radius: 12px;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 198, 0, 0.3);
        }

        .footer-link {
            grid-column: span 2;
            text-align: center;
            margin-top: 15px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }

        .footer-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .form-grid { grid-template-columns: 1fr; }
            .section-title, .btn-container, .footer-link { grid-column: span 1; }
        }
    </style>
</head>
<body>

<div class="reg-card">
    <div class="header">
        <i class="fa fa-user-graduate"></i>
        <h2>Student Registration</h2>
    </div>

    <form id="studentreg" method="post" action="./includes/server.php" onSubmit="return validateForm()">
        <div class="form-grid">
            
            <h3 class="section-title">Personal Information</h3>
            
            <div class="inputform">
                <label>Full Name</label>
                <input type="text" id="fullname" name="fullname" placeholder="John Doe">
            </div>

            <div class="inputform">
                <label>Admission Number</label>
                <input type="text" id="admissionnumber" name="admissionnumber" placeholder="12345">
            </div>

            <div class="inputform">
                <label>Email Address</label>
                <input type="text" id="email" name="email" placeholder="student@uits.edu">
            </div>

            <div class="inputform">
                <label>Phone Number</label>
                <input type="text" id="phonenumber" name="phonenumber" placeholder="017XXXXXXXX">
            </div>

            <div class="inputform">
                <label>Department</label>
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
                <label>Starting Date</label>
                <input type="date" id="startingdate" name="startingdate">
            </div>

            <h3 class="section-title">Placement / Company Details</h3>

            <div class="inputform">
                <label>Company Name</label>
                <input type="text" id="companyname" name="companyname">
            </div>

            <div class="inputform">
                <label>Company Contact</label>
                <input type="text" id="companycontact" name="companycontact">
            </div>

            <div class="inputform">
                <label>Company Email</label>
                <input type="text" id="companyemail" name="companyemail">
            </div>

            <div class="inputform">
                <label>Company Address</label>
                <input type="text" id="companyaddress" name="companyaddress">
            </div>

            <h3 class="section-title">Account Security</h3>

            <div class="inputform">
                <label>Password</label>
                <input type="password" id="password_1" name="password_1" placeholder="Min. 8 characters">
            </div>

            <div class="inputform">
                <label>Confirm Password</label>
                <input type="password" id="password_2" name="password_2">
            </div>

            <div class="btn-container">
                <button type="submit" class="btn" id="register_btn" name="register_btn">Create Account</button>
            </div>

            <p class="footer-link">
                Already a member? <a href="studentlogin.php">Sign in</a>
            </p>
        </div>
    </form>
</div>

<script>
    function validateForm() {
        // Validation logic kept identical to original
        let fullname = document.getElementById("fullname").value;
        if (fullname == "" || fullname.length < 4) {
            alert("Please enter your full name");
            document.getElementById("fullname").focus();
            return false;
        }

        let admissionnumber = document.getElementById("admissionnumber").value;
        if (admissionnumber == "" || isNaN(admissionnumber) || admissionnumber.length < 5) {
            alert("Please enter valid admission number");
            document.getElementById("admissionnumber").focus();
            return false;
        }

        let email = document.getElementById("email").value;
        if (email.length == 0 || email.indexOf("@") == -1 || email.indexOf(".") == -1) {
            alert("You must enter a valid email");
            document.getElementById("email").focus();
            return false;
        }

        let phonenumber = document.getElementById("phonenumber").value;
        if (phonenumber == "" || isNaN(phonenumber) || phonenumber.length < 6) {
            alert("Please enter valid phone number");
            document.getElementById("phonenumber").focus();
            return false;
        }

        let department = document.getElementById("department").value;
        if (department == "") {
            alert("Please select a department");
            document.getElementById("department").focus();
            return false;
        }

        let companyname = document.getElementById("companyname").value;
        if (companyname == "" || companyname.length < 4) {
            alert("Please enter company name");
            document.getElementById("companyname").focus();
            return false;
        }

        let companycontact = document.getElementById("companycontact").value;
        if (companycontact == "" || isNaN(companycontact) || companycontact.length < 8) {
            alert("Please enter valid company contact");
            document.getElementById("companycontact").focus();
            return false;
        }

        let companyaddress = document.getElementById("companyaddress").value;
        if (companyaddress == "" || companyaddress.length < 4) {
            alert("Please enter your company address");
            document.getElementById("companyaddress").focus();
            return false;
        }

        let companyemail = document.getElementById("companyemail").value;
        if (companyemail.length == 0 || companyemail.indexOf("@") == -1 || companyemail.indexOf(".") == -1) {
            alert("You must enter a valid company email");
            document.getElementById("companyemail").focus();
            return false;
        }

        let startingdate = document.getElementById("startingdate").value;
        if (startingdate == "" || startingdate.indexOf("-") == -1) {
            alert("Starting date must be entered");
            document.getElementById("startingdate").focus();
            return false;
        }

        let password_1 = document.getElementById("password_1").value;
        let password_2 = document.getElementById("password_2").value;
        
        if (password_1 == "" || password_1.length < 8) {
            alert("Password should be at least 8 characters");
            document.getElementById("password_1").focus();
            return false;
        }

        if (password_1 != password_2) {
            alert("The two passwords should match. Try Again");
            document.getElementById("password_1").focus();
            return false;
        }
        
        return true;
    }
</script>

</body>
</html>