<?php

namespace Dompdf;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    session_start();
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "get_statements";

    $company_id = $_SESSION["company_id"];

    // creating a connection
    $con = mysqli_connect($host, $username, $password, $dbname);

    $query = "SELECT company_name from company_details WHERE id = '$company_id'";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result)) {
        $company_name = $row[0];
    }

    $statement = "SELECT * from financial_figures WHERE company_id = '$company_id' and id = '$id'";
    $rs = mysqli_query($con, $statement);
    $row = mysqli_fetch_array($rs);

    $profit_before_tax = ($row['total_sales'] - $row['cost_of_goods']) - $row['overheads'];
}

?>
<?php
$html = '
    <style>
    @import url(\'https://fonts.googleapis.com/css?family=Nunito:400,900|Montserrat|Roboto\');
    
    html {
        box-sizing: border-box;
    }
    
    body {
        font-family: \'Roboto\', sans-serif;
        color: #0a0a23;
        background: linear-gradient(to right, #3FB6A8, #7ED386);
    }
    
    h1 {
        max-width: 37.25rem;
        margin: 0 auto;
        padding: 1.5rem 1.25rem 1.5rem;
        font-family: \'Montserrat\', sans-serif;
        color: black;
        font-size: 2em;
    }
    
    h1 .flex {
        display: flex;
        flex-direction: column-reverse;
        gap: 1rem;
        font-size: 0.7em;
    }
    th.description{
        font-weight: normal;
        font-style: italic;
        display: block;
        padding: 1rem 0 0.75rem;
        margin-right: -13.5rem;
    }
    
    section {
        max-width: 40rem;
        margin: 0 auto;
        border: 1px solid black;
    }
    
    .table-wrap {
        padding: 0 0.75rem 1.5rem 0.75rem;
    }
    
    table {
        border-collapse: collapse;
        border: 0;
        width: 100%;
        position: relative;
    }
    
    tbody td {
        width: 100vw;
        min-width: 4rem;
        max-width: 4rem;
    }
    
    tbody th {
        width: cal(100% - 12rem);
    }
    tr.total{
        color:black
    }
    
    tr.total,tr.data-total {
        border-bottom: 4px double #0a0a23;
        font-weight: bold;
    }
    tr.total,tr.data-total th {
        text-align: left;
        padding: 0.5rem 0 0.25rem 0.5rem;
    }
    
    tr.total td,tr.data-total td {
        text-align: right;
        padding: 0 0.25rem;
    }
    
    tr.total td:last-of-type,tr.data-total td:last-of-type {
        padding-right: 0.5rem;
    }
    
    tr.total:hover{
        background-color: #99c9ff;
    }
    
    td.current {
        font-style: italic;
    }
    
    tr th.name {
        color: #000 !important;
        font-size: 1em !important;
        font-weight: bold !important;
    }
    
    tr.data th {
        text-align: left;
        padding-left: 0.5rem;
    }
    
    tr.data th .description {
        display: block;
        font-weight: normal;
        font-style: italic;
        padding: 1rem 0 0.75rem;
        margin-right: -13.5rem;
    }
    
    tr.data td {
        vertical-align: top;
        padding: 0.3rem 0.25rem 0;
        text-align: right;
    }
    
    tr.data td:last-of-type {
        padding-right: 0.5rem;
    }
    }
    </style>
<body>
    <main>
        <section>
            <h1>
                <span class="flex">
                <!-- This seems like a more natural order for screen readers and we can use flex to reverse them in the layout -->   
                <span>' . $company_name . '</span><br>
                <span>Profit and Loss Statement</span><br>
                <span>For period ending ' . $row['end_acc'] . '</span><br>
                <span>' . $row['currency'] . '</span>
                </span>
            </h1>
            <div class="table-wrap">
                <table>
                    <tbody>
                        <tr class="data">
                            <th>Income</th>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Sales
                            </th>
                            <td class="current">' . $row['total_sales'] . '</td>
                        </tr>
                        <tr class="total">
                            <th>Total Sales</th>
                            <td class="current">' . $row['total_sales'] . '</td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr class="data">
                            <th>Cost of Goods Sold</th>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Cost of Goods
                            </th>
                            <td class="current">' . $row['cost_of_goods'] . '</td>
                        </tr>
                        <tr class="total">
                            <th>Total Cost of Goods</th>
                            <td class="current">' . $row['cost_of_goods'] . '</td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr class="data">
                            <th class="description">
                                Gross Profit
                            </th>
                            <td class="current">' . $row['total_sales'] - $row['cost_of_goods'] . '</td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr class="data">
                            <th>Admin Costs</th>
                        </tr>
                        <tr class="data">
                            <th class="description">
                                Overheads
                            </th>
                            <td class="current">' . $row['overheads'] . '</td>
                        </tr>
                        <tr class="total">
                            <th>Total Admin Costs</th>
                            <td class="current">' . $row['overheads'] . '</td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tbody>
                        <tr class="data">
                            <th class="description">Profit before tax</th>
                            <td class="current">' . $profit_before_tax . '</td>
                        </tr>
                        <tr class="data">
                            <th class="description">Tax Expences</th>
                            <td class="current">0</td>
                        </tr>
                        <tr class="data">
                            <th class="description">Profit after tax</th>
                            <td class="current">' . $profit_before_tax . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>'
?>
<?php

require 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

//how-to-convert-dynamic-php-file-to-pdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
// Render the HTML as PDF
$dompdf->render();

ob_end_clean();
// displays the generated PDF in a browser
$dompdf->stream("profit_and_loss_for_" . $row['end_acc'] . ".pdf", array("Attachment" => false));

// Outputs the generated PDF to Browser downloads directly
//  $dompdf->stream();
exit(0);

?>

</html>