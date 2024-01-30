<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <section class="vh-100 bg-image" style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Update Account Details</h2>
                                <div class="form-message"></div>
                                <form id="registrationForm">
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" id="email" name="email" class="form-control form-control-lg" disabled/>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="firstName">First Name</label>
                                        <input type="text" id="firstName" name="firstName" class="form-control form-control-lg" />
                                    </div>
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="lastName">Last Name</label>
                                        <input type="text" id="lastName" name="lastName" class="form-control form-control-lg" />
                                    </div>
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="age">Age</label>
                                        <input type="number" id="age" name="age" class="form-control form-control-lg" />
                                    </div>
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="gender">Gender</label>
                                        <select id="gender" name="gender" class="form-select form-select-lg">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="address">Address</label>
                                        <textarea id="address" name="address" class="form-control form-control-lg"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" id="saveDetails" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Save Details</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function(){
            // Function to get user details
            function getUserDetails() {
                var email = "new@gmail.com"; 
                
                $.ajax({
                    type: 'GET',
                    url: 'getUserDetails.php', 
                    data: { email: email },
                    success: function(response) {
                        var userDetails = JSON.parse(response);
                        $('#email').val(userDetails.email);
                        $('#firstName').val(userDetails.firstName);
                        $('#lastName').val(userDetails.lastName);
                        $('#age').val(userDetails.age);
                        $('#gender').val(userDetails.gender);
                        $('#address').val(userDetails.address);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Failed to fetch user details.');
                    }
                });
            }
            
            // Call function to get user details when page loads
            getUserDetails();

            // Function to save user details
            $('#saveDetails').click(function(){
                var firstName = $('#firstName').val();
                var lastName = $('#lastName').val();
                var age = $('#age').val();
                var gender = $('#gender').val();
                var address = $('#address').val();
                
                $.ajax({
                    type: 'POST',
                    url: 'insertOrUpdateUserDetails.php', 
                    data: {
                        email: $('#email').val(),
                        firstName: firstName,
                        lastName: lastName,
                        age: age,
                        gender: gender,
                        address: address
                    },
                    success: function(response) {
                        console.log(response);
                        alert('Details updated successfully!');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Failed to update details. Please try again.');
                    }
                });
            });
        });
    </script>
</body>
</html>
