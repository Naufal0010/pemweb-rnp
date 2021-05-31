<?php 

    require_once 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;

    $spreadsheet = new Spreadsheet();

    $spreadsheet -> setActiveSheetIndex(0) -> setCellValue('A1', 'LAPORAN DATA PEGAWAI');
    $spreadsheet -> getActiveSheet() -> getStyle('A1') -> getFont() -> setSize(13);
    $spreadsheet -> getActiveSheet() -> mergeCells('A1:F1');
    $spreadsheet -> getActiveSheet() -> getStyle('A1') -> getAlignment() -> setHorizontal('center');

    $spreadsheet -> getActiveSheet()
        -> setCellValue('A3', 'NO')
        -> setCellValue('B3', 'NIP')
        -> setCellValue('C3', 'NAMA PEGAWAI')
        -> setCellValue('D3', 'TEMPAT LAHIR')
        -> setCellValue('E3', 'TANGGAL LAHIR')
        -> setCellValue('F3', 'FOTO');

    $spreadsheet -> getActiveSheet() -> getStyle('A1:F3') -> getFont() -> setBold(true);

    include 'connection.php';

    $sql = "SELECT * FROM pegawai";
    $data = mysqli_query($connection, $sql);
    $rowID = 4; $i = 1;

    foreach ($data as $d) {

        $spreadsheet -> getActiveSheet()
            -> setCellValue('A' . $rowID, $i++)
            -> setCellValue('B' . $rowID, $d['nip'])
            -> setCellValue('C' . $rowID, $d['nama_pegawai'])
            -> setCellValue('D' . $rowID, $d['tempat_lahir'])
            -> setCellValue('E' . $rowID, $d['tanggal_lahir']);

        $objDrawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $objDrawing -> setPath('uploaded/' . $d['foto']);
        $objDrawing -> setCoordinates('F' . $rowID);
        $objDrawing -> setOffsetX(5); $objDrawing -> setOffsetY(5);
        $objDrawing -> setWidth(50); $objDrawing -> setHeight(50);
        $objDrawing -> setWorksheet($spreadsheet -> getActiveSheet());

        $spreadsheet -> getActiveSheet() -> getRowDimension($rowID) -> setRowHeight(50);
        $rowID++;
    }

    foreach (range('A', 'E') as $columnID) {
        $spreadsheet -> getActiveSheet() -> getColumnDimension($columnID) -> setAutoSize(true);
    }

    $border = array(
        'allBorders' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        )
    );

    $spreadsheet -> getActiveSheet() -> getStyle('A3' . ':F' . ($rowID - 1))
                                     -> getBorders() -> applyFromArray($border);

    $alignment = array(
        'alignment' => array(
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        )
    );

    $spreadsheet -> getActiveSheet() -> getStyle('A3' . ':F' . ($rowID - 1)) -> applyFromArray($alignment);

    $filename = 'datapgw-excel.xlsx';
    ob_end_clean();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $objWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $objWriter -> save('php://output');
    ob_end_clean();
    exit;
?>      