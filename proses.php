<?php 
    include 'connection.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) or empty($password)) {
        echo "<script> alert('Masukan Username atau Password') </script>";
    }
    else {
        $password = sha1($password);
        $query = "SELECT * FROM pengguna WHERE username='$username' AND password='$password'";
        $sql_query = mysqli_query($connection, $query);

        if (mysqli_num_rows($sql_query) > 0) {
            $data = mysqli_fetch_array($sql_query);

            session_start();
            $_SESSION['login'] = true;
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama'] = $data['nama'];

            $remember = $_POST['remember'];

            if ($remember != "") {
                $randomCode = hash(MHASH_SHA256, $username);
                setcookie('login', $randomCode, time() + 3600);
            }

            header("location:list-pegawai.php");
        }
        else {
            echo "<script> alert('Gagal Login') </script>";
        }
    }
?>  