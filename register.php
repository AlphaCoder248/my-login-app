<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

          .passmatch {
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
              <div class="container h-60">
                <div class="row d-flex justify-content-center align-items-center h-100">
                  <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                      <div class="card-body p-5">
                        <h2 class="text-uppercase text-center mb-4">Create an account</h2>
                        <div class="form-message"></div>

                        <form id="registrationForm">

                          <div class="form-outline mb-3">
                          <label class="form-label" for="name">Your Name</label>
                            <input type="text" id="name" name="name" onfocus="hideErrorMessage('name')" class="form-control form-control-lg" />
                            <label class="subtext subname" id="error-name">Name field must be filled</label>
                          </div>

                          <div class="form-outline mb-3">
                          <label class="form-label" for="email">Your Email</label>
                            <input type="email" id="email" name="email" onfocus="hideErrorMessage('mail')" class="form-control form-control-lg" />
                            <label class="subtext submail" id="error-mail">Email must be filled</label>
                          </div>

                          <div class="form-outline mb-3">
                          <label class="form-label" for="pass">Password</label>
                           <input type="password" id="pwd" name="pass" onfocus="hideErrorMessage('pass')" class="form-control form-control-lg" />
                            <label class="subtext subpass" id="error-pass">Password must be filled</label>
                          </div>

                          <div class="form-outline mb-3">
                          <label class="form-label" for="pass1">Repeat your password</label>
                            <input type="password" id="pwd1" name="pass1" onfocus="hideErrorMessage('pass1')" class="form-control form-control-lg" />
                            <label class="subtext subpass1" id="error-pass1">Confirm password can't be empty</label>
                            <label class="passmatch" id="error-match">Passwords doesn't match</label>
                          </div>

                          <div class="d-flex justify-content-center">
                            <button type="button" id="register" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                          </div>

                          <p class="text-center text-muted mt-3 mb-0">Have already an account? <a href="login.php"
                              class="fw-bold text-body"><u>Login here</u></a></p>

                        </form>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <script>

          $(document).ready(function(){
            $('#register').click(function(){
              var name = $('#name').val();
              var email = $('#email').val();
              var password = $('#pwd').val();
              var password1 = $('#pwd1').val();

              // Perform client-side validation
              if (name == '') {
                $(".subname").show();
                return;
              }
              if (email == '') {
                $(".submail").show();
                return;
              }
              if (password == '') {
                $(".subpass").show();
                return;
              }
              if (password1 == '') {
                $(".subpass1").show();
                return;
              }
              if (password != password1) {
                $(".passmatch").show();
                return;
              }

              // If validation passes, send data via AJAX
              $.ajax({
                type: 'POST',
                url: 'register.php',
                data: $('#registrationForm').serialize(),
                success: function(response) {
                  console.log(response);
                  alert('Registration successful!');
                },
                error: function(xhr, status, error) {
                  console.error(xhr.responseText);
                  alert('Registration failed. Please try again.');
                }
              });
            });
          });

          function hideErrorMessage(fieldid){
            $('#error-'+fieldid).hide();
            $("#error-match").hide();
          };

          </script>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password1 = $_POST['pass'];
    
    if (empty($name) || empty($email) || empty($password1)) {
        http_response_code(400); // Bad Request
        echo "All fields are required.";
        exit();
    }

    // Hash the password
    //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Connect to MySQL database
    $servername = "localhost"; 
    $username = "newuser"; 
    $password = "admin123"; 
    $dbname = "login-form"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        http_response_code(500); 
        echo "Connection failed: " . $conn->connect_error;
        exit();
    }

    // Prepare and execute SQL statement to insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password1);

    if ($stmt->execute()) {
        // Registration successful
        http_response_code(200); // OK
        echo "Registration successful!";
    } else {
        // Registration failed
        http_response_code(500); // Internal Server Error
        echo "Error: " . $stmt->error;
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
