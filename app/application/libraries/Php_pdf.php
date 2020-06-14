<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PHP Excel Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class Php_pdf
{

    public function __construct()
    {
    }

    public function load($file)
    {

        //ob_clean();
        //echo "<pre>";
        $parser = new \Smalot\PdfParser\Parser();

        //print_r($parser->parseFile($file)->getObjectById('2_0'));


        // $pdf = $parser->parseFile($file);
        // print_r($pdf->getText());die;
        return $parser->parseFile($file);
    }

    public function details($file)
    {
        $parser = new \Smalot\PdfParser\Parser();
        $pdf    = $parser->parseFile($file);

        // Retrieve all details from the pdf file.
        return $details  = $pdf->getDetails();

        // Loop over each property to extract values (string or array).
        //   foreach ($details as $property => $value) {
        //     if (is_array($value)) {
        //         $value = implode(', ', $value);
        //     }
        //     echo $property . ' => ' . $value . "\n";
        // }
    }
}
