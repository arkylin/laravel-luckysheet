<?php

require 'vendor/autoload.php';

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
$spreadsheet = $reader->load('1.xlsx')->getActiveSheet();
$a = $spreadsheet->getCell('B1');

foreach ($spreadsheet->getMergeCells() as $cells) {
    if ($a->isInRange($cells)) {
        echo "1";
    } else {
        echo "2";
    }
}

print_r($spreadsheet->getMergeCells());