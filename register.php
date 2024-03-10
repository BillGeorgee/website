<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Comfortaa:wght@300..700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<style>
    body {
    background-image: url("background.gif");
    background-size: 100%;
    position: relative;
    background-repeat: no-repeat;

}
.container {
    max-width: 600px;
    margin: 0 auto;
    padding:50px;
    background-color: #e1e1e1;
    opacity: 90%;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.7);
    position: relative;
}

.form-group {
    margin-bottom:30px;
}

.btn-custom {
    background-color: gray;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.btn-custom:hover {
    background-color: #a9a9a9;
}
.back-button {
    position: absolute;
    top: 20px;
    left: 20px;
    padding: 10px;
    font-size: 16px;
    background-color: gray;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
    
.back-button i {
     vertical-align: middle;
}
.back-button:hover {
     background-color: #a9a9a9;
}
</style>
<body>
<button class="back-button" onclick="goBack()"><i class="fas fa-arrow-left"></i></button>
<div class="container">

    <?php
    if(isset($_POST["Submit"])) {
        $LastName = $_POST["LastName"];
        $FirstName = $_POST["FirstName"];
        $Email = $_POST["Email"];
        $password = $_POST["password"];
        $RepeatPassword = $_POST["repeat_password"];
        $country = $_POST["country"];
        $state = $_POST["state"];
        $city = $_POST["city"];
        $barangay = $_POST["barangay"];
        $contactNumber = $_POST["contactNumber"];

       
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $errors = array();
        if (empty($LastName) || empty($FirstName) || empty($Email) || empty($password) || empty($RepeatPassword) || empty($country) || empty($state) || empty($city) || empty($barangay) || empty($contactNumber)) {
            array_push($errors, "All fields are required");
        }
 
        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Email is not valid");
        }
 
        if(strlen($password) < 8) {
            array_push($errors, "Password must be at least 8 characters long");
        }
 
        if($password != $RepeatPassword){
            array_push($errors, "Password does not match");
        }
 
        require_once "database.php";
        $sql = "SELECT * FROM user WHERE email = '$Email'";
        $result = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($result);
        if($rowCount > 0){
            array_push($errors,"Email Already Exists.");
        }
 
        if (count($errors) > 0){
            foreach($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            require_once("database.php");
            $sql = "INSERT INTO user (last_name, first_name, email, password, country, state, city, barangay, contactNumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $preparestmt = mysqli_stmt_prepare($stmt, $sql);
            if ($preparestmt) {
                mysqli_stmt_bind_param($stmt, "sssssssss", $LastName, $FirstName, $Email, $passwordHash, $country, $state, $city, $barangay, $contactNumber);
                mysqli_stmt_execute($stmt);
                echo "<div class = 'alert alert-sucess'> You are Registered Successfully! </div>";
        }   else {
                die("Something went wrong");
            }
        }
    }
    ?>
    <form action="register.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="LastName" placeholder="Last Name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="FirstName" placeholder="First Name">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="Email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Input Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
            </div>
            <div class="form-group">
                <label for="country">Country</label>
                <select class="form-control" id="country" name="country" required>
                    <option selected>Choose...</option>
                </select>
            </div>
            <div class="form-group">
                <label for="state">State/Province</label>
                <select class="form-control" id="state" name="state" required>
                    <option selected>Choose...</option>
                </select>
                </div>
            <div class="form-group">
                <label for="city">City/Municipality</label>
                <select class="form-control" id="city" name="city" required>
                    <option selected>Choose...</option>
            </select>
            </div>
            <div class = "form-group">
                <label for="barangay">Barangay</label>
                <input type = "text" class = "form-control" name = "barangay" placeholder="ex. Brgy. 121">
            </div>
            <div class="form-group">
                <label for="contactNumber">Contact Number</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="phoneCode" readonly>
                    <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="9***********">
                </div>
            </div>
            <div class="form-group">
                <input type="submit" value="Register" name="Submit" class="btn-custom"  >
            </div>
    </form>
    <div><p>Already registered? <a href="login.php"> Login Here</a></div>
</div>

<script>
        function goBack() {
        window.location.href = "about.html";
    }
        let data = [];

                document.addEventListener('DOMContentLoaded', function() {
                    fetch('https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/countries%2Bstates%2Bcities.json')
                        .then(response => response.json())
                        .then(jsonData => {
                            data = jsonData;
                            const countries = data.map(country => country.name);
                            populateDropdown('country', countries);
                        })
                        .catch(error => console.error('Error fetching countries:', error));
                });

                function populateDropdown(dropdownId, data) {
                    const dropdown = document.getElementById(dropdownId);
                    dropdown.innerHTML = '';
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item;
                        option.text = item;
                        dropdown.add(option);
                    });
                }

                document.getElementById('country').addEventListener('change', function() {
                    const selectedCountry = this.value;
                    const countryData = data.find(country => country.name === selectedCountry);
                    if (countryData && countryData.states) {
                        const states = countryData.states.map(state => state.name);
                        populateDropdown('state', states);
                    }
                    const phoneCode = countryData ? countryData.phone_code : '';
                    document.getElementById('phoneCode').value = phoneCode;
                });

                document.getElementById('state').addEventListener('change', function() {
                    const selectedState = this.value;
                    const countryData = data.find(country => country.name === document.getElementById('country').value);
                    if (countryData) {
                        const stateData = countryData.states.find(state => state.name === selectedState);
                        if (stateData && stateData.cities) {
                            const cities = stateData.cities.map(city => city.name);
                            populateDropdown('city', cities);
                        } else {
                            console.log('No cities found for state:', selectedState);
                        }
                    } else {
                        console.log('Country data not found for state:', selectedState);
                    }
                });
</script>
</body>
</html>