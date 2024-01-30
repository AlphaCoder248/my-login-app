<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
         .gradient-custom-3 {
          background: #84fab0;

          background: -webkit-linear-gradient(to right, rgba(132, 250, 176, 0.5), rgba(143, 211, 244, 0.5));

          background: linear-gradient(to right, rgba(132, 250, 176, 0.5), rgba(143, 211, 244, 0.5))
          }
          .gradient-custom-4 {
          background: #84fab0;

          background: -webkit-linear-gradient(to right, rgba(132, 250, 176, 1), rgba(143, 211, 244, 1));

          background: linear-gradient(to right, rgba(132, 250, 176, 1), rgba(143, 211, 244, 1))
          }

          .subtext {
            color: red;
            display: none;
          }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>

<section class="vh-100 bg-image"
            style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
            <div class="mask d-flex align-items-center h-100 gradient-custom-3">
              <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                  <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                      <div class="card-body p-5">
                        <h2 class="text-uppercase text-center mb-5">Login to account</h2>

                        <form id="loginForm">

                          <div class="form-outline mb-4">
                            <label class="form-label" for="email">Your Email</label>
                            <input type="email" id="email" name="email" onfocus="hideErrorMessage('mail')" class="form-control form-control-lg" />
                            <label class="subtext submail" id="error-mail">Email must be filled</label>
                          </div>

                          <div class="form-outline mb-4">
                            <label class="form-label" for="pass">Password</label>
                            <input type="password" id="pwd" name="pass" onfocus="hideErrorMessage('pass')" class="form-control form-control-lg" />
                            <label class="subtext subpass" id="error-pass">Password must be filled</label>
                          </div>

                          <div class="d-flex justify-content-center">
                            <button type="button" id="loginBtn" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Login</button>
                          </div>

                          <p class="text-center text-muted mt-5 mb-0">Click to create an account? <a href="register.php" class="fw-bold text-body"><u>Signup here</u></a></p>

                        </form>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <script>
          $(document).ready(function() {
            $('#loginBtn').click(function() {
              var email = $('#email').val();
              var password = $('#pwd').val();

              // Clear previous error messages
              $('.subtext').hide();

              // Validate form fields
              if (email.trim() === '') {
                $('#error-mail').show();
                return;
              }
              if (password.trim() === '') {
                $('#error-pass').show();
                return;
              }

              // Perform login via AJAX
              $.ajax({
                type: 'POST',
                url: 'login.php', 
                data: $('#loginForm').serialize(),
                success: function(response) {
                  // Handle successful login
                  console.log(response);
                },
                error: function(xhr, status, error) {
                  // Handle login failure
                  console.error(xhr.responseText);
                  alert('Login failed. Please try again.');
                }
              });
            });
          });

          function hideErrorMessage(fieldid){
            $('#error-'+fieldid).hide();
          }; 

          </script>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['pass'];

    // Validate form data (you might want to add more validation here)
    if (empty($email) || empty($password)) {
        // Handle empty fields
        http_response_code(400); // Bad Request
        echo "Email and password are required.";
        exit();
    }

    
    $servername = "localhost"; 
    $username = "newuser"; 
    $dbpassword = "admin123"; 
    $dbname = "login-form"; 

    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        http_response_code(500);
        echo "Connection failed: " . $conn->connect_error;
        exit();
    }

    // Prepare and execute SQL statement to fetch user data based on the provided email
    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    print_r($result) ;

    if ($result->num_rows === 1) {
        // User found, verify password
        $user = $result->fetch_assoc();
        print_r($user);
        $user1 = $user['password'];
        echo ".$password + .$user1";
        if ($password == $user['password']) {
            // Password is correct, login successful
            http_response_code(200); // OK
            echo "Login successful!";
        } else {
            // Password is incorrect
            http_response_code(401); // Unauthorized
            echo "Incorrect password.";
        }
    } else {
        // User not found
        http_response_code(404); // Not Found
        echo "User not found.";
    }

    // Close database connection
    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
}
?>

</body>
</html>
