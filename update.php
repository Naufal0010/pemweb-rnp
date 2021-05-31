<?php 
    include 'connection.php';

    $nip = $_POST['nip'];
    $unitKerja = $_POST['unit_kerja'];
    $idUnitKerja = $_POST['id_unitkerja'];
    $jabatan = $_POST['jabatan'];
    $idJabatan = $_POST['id_jabatan'];
    $namaPegawai = $_POST['nama_pegawai'];
    $tempatLahir = $_POST['tempat_lahir'];
    $tanggalLahir = $_POST['tanggal_lahir'];
    
    $temp = $_FILES['foto']['tmp_name'];
    $foto = $_FILES['foto']['name'];
    $folder = "uploaded/";
    move_uploaded_file($temp, $folder . $foto);

    $query = "UPDATE pegawai SET 
        id_unitkerja = '$idUnitKerja',
        id_jabatan = '$idJabatan',
        nama_pegawai ='$namaPegawai', 
        tempat_lahir ='$tempatLahir', 
        tanggal_lahir ='$tanggalLahir', 
        foto = '$foto' 
        WHERE nip = '$nip'
        AND id_unitkerja = '$idUnitKerja'
        AND id_jabatan = '$idJabatan'";
    
    mysqli_query($connection, $query);

    header("location:list-pegawai.php");
?>      