<?php
//start session
session_start();
// getting all values from the HTML form
if (isset($_POST['submit'])) {
    $beginning_acc = $_POST['beginning_acc'];
    $end_acc = $_POST['end_acc'];
    $currency = $_POST['currency'];
    $overheads = $_POST['overheads'];
    $sales = $_POST['sales'];
    $cost_of_goods = $_POST['cost_of_goods'];
    $cash = $_POST['cash'];
    $debtors = $_POST['debtors'];
    $others = $_POST['others'];
    $furniture_and_fixtures = $_POST['furniture_and_fixtures'];
    $machinery_and_equipment = $_POST['machinery_and_equipment'];
    $land_and_buildings = $_POST['land_and_buildings'];
    $software = $_POST['software'];
    $creditors = $_POST['creditors'];
    $other_payables = $_POST['other_payables'];
    $long_term_loans = $_POST['long_term_loans'];
    $owners_funds = $_POST['owners_funds'];
}

// database details
$host = "localhost";
$username = "root";
$password = "";
$dbname = "get_statements";

// creating a connection
$con = mysqli_connect($host, $username, $password, $dbname);

// to ensure that the connection is made
if (!$con) {
    die("Connection failed!" . mysqli_connect_error());
} else if (empty($beginning_acc) || empty($end_acc)) {
    echo '<script> alert("Please enter all values"); window.location.href="businessForm.html";</script>';
} else {
    $company_id = $_SESSION['company_id'];
    $sql = "INSERT INTO financial_figures (beginning_acc, end_acc, currency, overheads, total_sales, cost_of_goods, cash, debtors, creditors, others, machinery_and_equipment, land_and_buildings, furniture_and_fixtures, software, other_payables, long_term_loans, owners_funds, company_id) VALUES ('$beginning_acc', '$end_acc', '$currency', '$overheads', '$sales', '$cost_of_goods', '$cash', '$debtors', '$creditors', '$others', '$machinery_and_equipment', '$land_and_buildings','$furniture_and_fixtures', '$software', '$other_payables', '$long_term_loans', '$owners_funds', '$company_id')";

    // send query to the database to add values and confirm if successful
    $rs = mysqli_query($con, $sql);
    if ($rs) {
        echo '<script> alert("Successful data entry"); window.location.href="downloadForms.php";</script> ';
    }

    // close connection
    mysqli_close($con);
}
