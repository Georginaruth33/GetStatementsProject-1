<?php
// getting all values from the HTML form
if (isset($_POST['submit'])) {
    $company_name = $_POST['company_name'];
    $beginning_acc = $_POST['beginning_acc'];
    $end_acc = $_POST['end_acc'];
    $currency = $_POST['currency'];
}

// database details
$host = "localhost";
$username = "root";
$password = "";
$dbname = "get_statements";

// creating a connection
$con = mysqli_connect($host, $username, $password, $dbname);

$query = "SELECT * FROM company_details where company_name = '$company_name'";
$result = mysqli_query($con, $query);
// to ensure that the connection is made
if (!$con) {
    die("Connection failed!" . mysqli_connect_error());
}

if (empty($company_name) || empty($beginning_acc) || empty($end_acc)) {
    echo '<script> alert("Please enter all values"); window.location.href="companyDetails.html";</script>';
}
//checking of the company name already exists in the database
elseif (mysqli_num_rows($result) > 0) {
    echo '<script> alert("Company already exists!"); window.location.href="companyDetails.html";</script>';
} else {
    // using sql to create a data entry query
    $sql = "INSERT INTO company_details (company_name, beginning_acc, end_acc, currency) VALUES ('$company_name', '$beginning_acc', '$end_acc', '$currency')";

    // send query to the database to add values and confirm if successful
    $rs = mysqli_query($con, $sql);
    if ($rs) {
        echo '<script> alert("Successful data entry"); window.location.href="businessForm.html";</script>';
    }

    // close connection
    mysqli_close($con);
}
