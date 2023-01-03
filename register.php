<?php

// getting all values from the HTML form
if (isset($_POST['submit'])) {
    $company_name = $_POST['company_name'];
    $pass = $_POST['password'];

    // database details
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "get_statements";

    // creating a connection
    $con = mysqli_connect($host, $username, $password, $dbname);
    $query = "SELECT * from company_details where company_name = '$company_name'";
    $result = mysqli_query($con, $query);

    // to ensure that the connection is made
    if (!$con) {
        die("Connection failed!" . mysqli_connect_error());
    } else if (empty($company_name) || empty($pass)) {
        echo '<script> alert("Please enter all values"); window.location.href="register.html";</script>';
    } else if (mysqli_num_rows($result) > 0) {
        echo '<script> alert("Company already exists!"); window.location.href="login.html";</script>';
    } else if (strlen($pass) < 8) {
        echo '<script> alert("Password must be 8 characters long"); window.location.href="register.html";</script>';
    } else {
        $sql = "INSERT INTO company_details (company_name, pass) VALUES ('$company_name', '$pass')";

        // send query to the database to add values and confirm if successful
        $rs = mysqli_query($con, $sql);
        if ($rs) {
            echo '<script> alert("Success"); window.location.href="login.html";</script>';
        }

        // close connection
        mysqli_close($con);
    }
}
