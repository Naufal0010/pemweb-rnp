<?php 

    require('fpdf/fpdf.php');

    $pdf = new FPDF('P', 'mm', 'A5');

    $pdf -> AddPage();
    $pdf -> SetFont('Arial', 'B', 16);
    $pdf -> Cell(100, 7, 'LAPORAN DATA PEGAWAI', 0, 1, 'C');

    $pdf -> Cell(10, 7, '', 0, 1);

    $pdf -> SetFont('Arial', 'B', 10);
    $pdf -> Cell(10, 6, 'NO', 1, 0);
    $pdf -> Cell(15, 6, 'NIP', 1, 0);
    $pdf -> Cell(25, 6, 'NAMA ', 1, 0);
    $pdf -> Cell(25, 6, 'TPT LAHIR', 1, 0);
    $pdf -> Cell(25, 6, 'TGL LAHIR', 1, 0);
    $pdf -> Cell(30, 6, 'FOTO', 1, 1);
    
    $pdf -> SetFont('Arial', '', 10);

    include 'connection.php';
    
    $sql = "SELECT * FROM pegawai";
    $data = mysqli_query($connection, $sql);
    $i = 1;

    foreach($data as $d) {
        $pdf -> Cell(10, 20, $i++, 1, 0);
        $pdf -> Cell(15, 20,$d['nip'], 1, 0);
        $pdf -> Cell(25, 20,$d['nama_pegawai'], 1, 0);
        $pdf -> Cell(25, 20,$d['tempat_lahir'], 1, 0);
        $pdf -> Cell(25, 20,$d['tanggal_lahir'], 1, 0);

        $img = 'uploaded/' . $d['foto'];
        $pdf -> Cell(30, 20, $pdf -> Image($img, $pdf -> GetX(), $pdf -> GetY(), 17), 1, 1);
    }


    $pdf -> Output();
?>