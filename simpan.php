<?php 
    include('database.php');

    $db = new Database();

    $action = $_GET['action'];

    if ($action == "add") {
        
        $temp = $_FILES['foto']['tmp_name'];
        $foto = $_FILES['foto']['name'];
        $folder = "uploaded/";
        
        move_uploaded_file($temp, $folder . $foto);

        $data = array(
            'nip' => $nip = $_POST['nip'],
            'id_unitkerja' => $_POST['unit_kerja'],
            'id_jabatan' => $_POST['jabatan'],
            'id_pengguna' => 1,
            'nama_pegawai' => $_POST['nama_pegawai'],
            'tempat_lahir' => $_POST['tempat_lahir'],
            'tanggal_lahir' => $_POST['tanggal_lahir'],
            'foto' => $foto
        );

        $db -> insert_data($data);    
        header("location:list-pegawai.php");
    }
    else if ($action == "update") {

        $temp = $_FILES['foto']['tmp_name'];
        $foto = $_FILES['foto']['name'];
        $folder = "uploaded/";

        move_uploaded_file($temp, $folder . $foto);

        $data = array(
            'id_unitkerja' => $id_unitkerja = $_POST['unit_kerja'],
            'id_jabatan' => $id_jabatan = $_POST['jabatan'],
            'nama_pegawai' => $_POST['nama_pegawai'],
            'tempat_lahir' => $_POST['tempat_lahir'],
            'tanggal_lahir' => $_POST['tanggal_lahir']
        );
        if ($foto != "") $data['foto'] = $foto;

        $nip = $_GET['nip'];

        $db -> update_data($nip, $data);

        header('location:list-pegawai.php');
    }
    else if ($action == "delete") {
        
        $nip = $_GET['nip'];
        $db -> delete_data($nip);

        header('location:list-pegawai.php');
    }
?>