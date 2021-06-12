<!DOCTYPE html>
<html>
<head>
    <title>Office</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script> -->
</head>
<body>
<div 
    <h1>主页</h1>
    <?php
        require '../vendor/autoload.php';
        use App\Models\Template;

        $template = Template::find(1);

        // print_r($template);

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load('../Templates/' . $template->hash)->getActiveSheet();

        echo '<table border="1">';

        function getMerger($spreadsheet, $nowcell) {
            $mergecell = $spreadsheet->getMergeCells();
            $merger_check = 0;
            foreach ($mergecell as $merge) {
                if ($spreadsheet->getCell($nowcell)->isInRange($merge)) {
                    $merger_check = 1;
                }
            }
            if ($merger_check == 1) { 
                return TRUE;
            } else {
                return FALSE;
            }
        }

        foreach ($spreadsheet->getRowIterator() as $row) {
            echo '<tr>';
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);
            foreach ($cellIterator as $cell) {                
                if (!getMerger($spreadsheet, $cell->getCoordinate()) && ($cell->getValue() != "")) {
                    echo '<th width="100px">' . $cell->getValue() . '</th>';
                } elseif (getMerger($spreadsheet, $cell->getCoordinate()) && ($cell->getValue() != "")) {
                    echo '<th bgcolor="f8f8ff" style="border-right-style:none;border-left-style:none;border-top-style:none;border-bottom-style:none">' . $cell->getValue() . '</th>';
                } elseif (getMerger($spreadsheet, $cell->getCoordinate()) && ($cell->getValue() == "")) {
                    echo '<td bgcolor="f8f8ff" style="border-right-style:none;border-left-style:none;border-top-style:none;border-bottom-style:none"></td>';
                } else {
                    echo '<td style="border-right-style:none;border-left-style:none;border-top-style:none;border-bottom-style:none"><input type="text" name="a" /></td>';
                }
            }
            echo '</tr>';
        }
        echo '</table>';
        echo '<pre>';
        print_r($spreadsheet->getCell("A1"));
        echo '</pre>';

    ?>
</body>
</html>