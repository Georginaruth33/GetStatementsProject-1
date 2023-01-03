<?php
if (isset($_POST['submit'])) {

    //start session
    session_start();

    $company_name = $_POST['company_name'];
    $pass = $_POST['password'];

    // database details
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "get_statements";

    // creating a connection
    $con = mysqli_connect($host, $username, $password, $dbname);
    $sql = "SELECT * from company_details where company_name = '$company_name' and pass = '$pass'";
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_array($result)) {
        $company_id = $row['id'];
        $_SESSION['company_id'] = $company_id;
    }

    if (mysqli_num_rows($result)) {
        echo '<script> alert("Success"); window.location.href="businessForm.html";</script>';
    } else if (empty($company_name) || empty($pass)) {
        echo '<script> alert("Please enter all values"); window.location.href="login.html";</script>';
    } else {
        echo '<script> alert("Invalid username or password"); window.location.href="login.html";</script>';
    }
}
