<?php

namespace Dompdf;

require 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

//how-to-convert-dynamic-php-file-to-pdf
$dompdf = new Dompdf();
ob_start();
require('statement_of_cashflows.php');
$html = ob_get_contents();
ob_get_clean();

$dompdf->loadHtml($table1);
$dompdf->setPaper('A4', 'landscape');
// Render the HTML as PDF
$dompdf->render();

// displays the generated PDF in a browser
$dompdf->stream("sample.pdf", array("Attachment" => false));

// Outputs the generated PDF to Browser downloads directly
//  $dompdf->stream();

exit(0);
