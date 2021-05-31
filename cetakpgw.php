<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <title>Cetak Pegawai</title>
</head>

<body>
    <div class="container">

        <h2 style="margin-top: 2%; margin-bottom: 2%;">Laporan Data Pegawai</h2>

        <div class="card mt-4">

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
                </tr>

                <?php
                    $cari = "";

                    if (isset($_GET['cari'])) {
                        $cari = $_GET['cari'];
                    }
                ?>

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
                                    </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='7'>Data Tidak Ada</td></tr>";
                }
                ?>
            </table>
            <script>
                window.print();
            </script>
        </div>
    </div>
</body>

</html>