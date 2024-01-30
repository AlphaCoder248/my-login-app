<?php
// Function to check if a user with the given email already exists in the database
function userExists($email) {
    $servername = "localhost";
    $username = "newuser";
    $password = "admin123";
    $dbname = "login-form";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if user exists
    $sql = "SELECT * FROM userprofile WHERE email='$email'";
    $result = $conn->query($sql);

    $conn->close();

    return $result->num_rows > 0;
}

// Function to insert user details into the database
function insertOrUpdateUserDetails($email, $firstName, $lastName, $age, $gender, $address) {
    $servername = "localhost";
    $username = "newuser";
    $password = "admin123";
    $dbname = "login-form";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if user exists
    if (userExists($email)) {
        // User exists, update details
        $sql = "UPDATE userprofile SET firstName='$firstName', lastName='$lastName', age=$age, gender='$gender', address='$address' WHERE email='$email'";
    } else {
        // User doesn't exist, insert new user
        $sql = "INSERT INTO userprofile (email, firstName, lastName, age, gender, address)
                VALUES ('$email', '$firstName', '$lastName', $age, '$gender', '$address')";
    }

    if ($conn->query($sql) === TRUE) {
        return true; // Insert or update successful
    } else {
        return false; // Insert or update failed
    }

    $conn->close();
}

// Assume the data is retrieved from the request
$email = $_POST['email'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$address = $_POST['address'];

// Insert or update user details
if (insertOrUpdateUserDetails($email, $firstName, $lastName, $age, $gender, $address)) {
    echo "Details saved successfully!";
} else {
    echo "Error saving details. Please try again.";
}
?>
