<?php 

    require_once 'vendor/autoload.php';
    use PhpOffice\PhpWord\IOFactory;
    use PhpOffice\PhpWord\PhpWord;

    $phpWord = new PhpWord();
    $section = $phpWord -> addSection();
    $title = array('size' => 16, 'bold' => true);
    $section -> addText("Laporan Data Pegawai", $title);
    $section -> addTextBreak(1);

    $styleTable = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80);
    $styleCell = array('valign' => 'center');
    $fontHeader = array('bold' => true);
    $noSpace = array('spaceAfter' => 0);
    $imgStyle = array('width' => 50, 'height' => 50);

    $phpWord -> addTableStyle('mytable', $styleTable);

    $table = $section -> addTable('mytable');
    $table -> addRow();
    $table -> addCell(500, $styleCell) -> addText('NO', $fontHeader, $noSpace);
    $table -> addCell(750, $styleCell) -> addText('NIP', $fontHeader, $noSpace);
    $table -> addCell(1250, $styleCell) -> addText('NAMA', $fontHeader, $noSpace);
    $table -> addCell(1250, $styleCell) -> addText('TPT LAHIR', $fontHeader, $noSpace);
    $table -> addCell(1250, $styleCell) -> addText('TGL LAHIR', $fontHeader, $noSpace);
    $table -> addCell(1500, $styleCell) -> addText('FOTO', $fontHeader, $noSpace);

    include 'connection.php';

    $sql = "SELECT * FROM pegawai";
    $data = mysqli_query($connection, $sql);
    $i = 1;

    foreach ($data as $d) {
        $table -> addRow();
        $table -> addCell(500, $styleCell) -> addText($i++, array(), $noSpace);
        $table -> addCell(750, $styleCell) -> addText($d['nip'], array(), $noSpace);
        $table -> addCell(1250, $styleCell) -> addText($d['nama_pegawai'], array(), $noSpace);
        $table -> addCell(1250, $styleCell) -> addText($d['tempat_lahir'], array(), $noSpace);
        $table -> addCell(1250, $styleCell) -> addText($d['tanggal_lahir'], array(), $noSpace);
        $table -> addCell(1500, $styleCell) -> addImage('uploaded/' . $d['foto'], $imgStyle);
    }

    $filename = "datapgw-word.docx";
    header('Content-Type: application/msword');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter -> save('php://output');
    exit;
?>