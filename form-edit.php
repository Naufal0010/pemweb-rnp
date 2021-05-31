<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <title>Edit Data Pegawai</title>
</head>

<body>
    <?php
    include 'connection.php';

    $nip = $_GET['nip'];
    $pegawai = mysqli_query($connection, "SELECT * FROM 
                            pegawai pgw JOIN unit_kerja unk ON pgw.id_unitkerja = unk.id_unitkerja
                            JOIN jabatan jbtn ON pgw.id_jabatan = jbtn.id_jabatan WHERE nip = '$nip'");
    $data = mysqli_fetch_array($pegawai);

    ?>

    <div class="container">

        <h1 class="text-center mt-2" style="margin-bottom: 2%; ">Form Edit Data Pegawai</h1>

        <div class="card mt-4">
            <h6 class="card-header text-white" style="background-color: #212529;">Edit Data Pegawai</h6>
            <div class="card-body">

            <?php 
                include('database.php');

                $db = new Database();
                $nip = $_GET['nip'];

                if ($nip != "") {
                    $data = $db -> get_by_nip($nip);
                    $unit_kerja = $db -> unit_kerja();
                    $jabatan = $db -> jabatan();
                }
                else {
                    header('location:list-pegawai.php');
                }
            ?>

                <form method="POST" action="simpan.php?action=update&nip=<?php echo $nip ?>" enctype="multipart/form-data">

                    <input type="hidden" value="<?php echo $data['id_unitkerja']; ?>" name="id_unitkerja">

                    <input type="hidden" value="<?php echo $data['id_jabatan']; ?>" name="id_jabatan">

                    <div class="mb-3">
                        <input type="text" name="nip" id="nip" class="form-control" placeholder="NIP" value="<?php echo $data['nip']; ?>" required>
                    </div>

                    <div class="input-group mb-3">
                        <label class="input-group-text" for="unitKerjaSelect">Unit Kerja</label>
                        <select name="unit_kerja" id="unit_kerja" class="form-select required">

                            <?php foreach($unit_kerja as $row) { ?>
                                <option value="<?php echo $row['id_unitkerja'] ?>"
                                    <?php echo ($data['id_unitkerja'] == $row['id_unitkerja']) ? "Selected" : "" ?>>
                                    <?php echo $row['nama_unitkerja'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <label class="input-group-text" for="jabatanSelect">Jabatan</label>
                        <select name="jabatan" id="jabatan" class="form-select required">

                        <?php foreach($jabatan as $row) { ?>
                            <option value="<?php echo $row['id_jabatan'] ?>"
                                <?php echo ($data['id_jabatan'] == $row['id_jabatan']) ? "Selected" : "" ?>>
                                <?php echo $row['nama_jabatan'] ?>
                            </option>
                        <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control" placeholder="Nama Pegawai" value="<?php echo $data['nama_pegawai']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Tempat Lahir" value="<?php echo $data['tempat_lahir']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="<?php echo $data['tanggal_lahir']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload Foto</label>
                        <input class="form-control" type="file" id="foto" name="foto">
                    </div>

                    <button type="submit" class="btn btn-success" id="edit" name="edit">simpan</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>