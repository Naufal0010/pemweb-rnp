<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <title>List Pegawai</title>

</head>

<body>
    <div class="container">

        <?php 
            session_start();
            if (empty($_SESSION['login'])) {
                header("location:login.php");
            }
        ?>

        <nav aria-label="navigationTop" class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Form</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="form-input.php">Isi Data</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="list-pegawai.php">List</a>
                        </li>
                    </ul>
                </div>
                <form class="d-flex">
                    <ul class="navbar-nav"> 
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" ><?php echo $_SESSION['nama'] ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </form>
            </div>
        </nav>

        <h2 style="margin-top: 2%; margin-bottom: 2%;">List Pegawai</h2>



        <div class="card mt-4">
            <h6 class="card-header text-white" style="background-color: #212529;">Input Data Pegawai</h6>
            <div class="card-body">
                <form action="list-pegawai.php" method="GET">
                    <label for="pencarian" class="form-label">Pencarian</label>
                    <input class="form-control" id="cari" name="cari" placeholder="Search pegawai..." style="margin-bottom: 20px;">
                </form>

                <?php
                $cari = "";

                if (isset($_GET['cari'])) {
                    $cari = $_GET['cari'];
                }
                ?>

                <table class="table" aria-label="table_pegawai">
                    <tr>
                        <th id="no">No.</th>
                        <th id="nip">NIP</th>
                        <th id="unit_kerja">Unit Kerja</th>
                        <th id="jabatan">Jabatan</th>
                        <th id="nama_pegawai">Nama Pegawai</th>
                        <th id="tempat_lahir">Tempat Lahir</th>
                        <th id="tanggal_lahir">Tanggal Lahir</th>
                        <th id="foto">Foto</th>
                        <th id="action">Action</th>
                    </tr>

                    <?php
                    include 'connection.php';

                    $limit = 4;
                    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                    $start = $limit * ($page - 1);
                    $get = mysqli_fetch_array(mysqli_query($connection, "SELECT COUNT(*) total FROM pegawai"));
                    $total = $get['total'];
                    $pages = ceil($total / $limit);
                    ?>

                    <?php
                    include 'connection.php';

                    if ($cari != "") {
                        $pegawai = mysqli_query($connection, "SELECT * FROM 
                                pegawai pgw JOIN unit_kerja unk ON pgw.id_unitkerja = unk.id_unitkerja
                                JOIN jabatan jbtn ON pgw.id_jabatan = jbtn.id_jabatan 
                                WHERE nama_pegawai LIKE '%" . $cari . "%' LIMIT $start, $limit");
                    } else {
                        $pegawai = mysqli_query($connection, "SELECT * FROM 
                                pegawai pgw JOIN unit_kerja unk ON pgw.id_unitkerja = unk.id_unitkerja
                                JOIN jabatan jbtn ON pgw.id_jabatan = jbtn.id_jabatan 
                                LIMIT $start, $limit");
                    }

                    if (mysqli_num_rows($pegawai) > 0) {
                        $no = 1;

                        foreach ($pegawai as $row) {

                            echo "<tr>
                                        <td>$no</td>
                                        <td>" . $row['nip'] . "</td>
                                        <td>" . $row['nama_unitkerja'] . "</td>
                                        <td>" . $row['nama_jabatan'] . "</td>
                                        <td>" . $row['nama_pegawai'] . "</td>
                                        <td>" . $row['tempat_lahir'] . "</td>
                                        <td>" . $row['tanggal_lahir'] . "</td>
                                        <td> <img src='uploaded/" . $row['foto'] . "' width='100' height='100'> </td>
                                        <td> <a href='form-edit.php?nip=$row[nip]' class='btn btn-success'>Edit</a> 
                                            <a href='delete.php?nip=$row[nip]' class='btn btn-primary'>Delete</a>
                                        </td>
                                    </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='7'>Data Tidak Ada</td></tr>";
                    }
                    ?>
                </table>

                <nav aria-label="pagination">

                <a type="button" class="btn btn-info" href="cetakpgw.php" target="_BLANK">Print List Pegawai</a>
                    <ul class="pagination mt-3">
                        <?php
                        for ($indexNumber = 1; $indexNumber <= $pages; $indexNumber++) {
                            if ($indexNumber != $page) {
                                echo "<li class='page-item'><a class='page-link' href='list-pegawai.php?page=$indexNumber'>$indexNumber</a></li>";
                            } else {
                                echo "<li class='page-item-active'><a class='page-link' href='#'>$indexNumber</a></li>";
                            }
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</body>

</html>