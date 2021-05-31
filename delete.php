<?php 
    include 'connection.php';

    $nip = $_GET['nip'];

    $query = "DELETE FROM pegawai WHERE nip = '$nip'";

    mysqli_query($connection, $query);

    header("location:list-pegawai.php");
?>