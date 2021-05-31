<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <title>Form Input</title>


</head>

<body>
    <div class="container">

        <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Form</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Isi Data</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list-pegawai.php">List</a>
                        </li>
                    </ul>   
                </div>
            </div>
        </nav>

        <h1 class="text-center mt-2" style="margin-bottom: 2%; ">Form Input Pegawai</h1>

        <div class="card mb-4">
            <h6 class="card-header text-white" style="background-color: #212529;">Input Data Pegawai</h6>
            <div class="card-body">

            <?php 
                include ('database.php');
                
                $db = new Database();
                $unitKerja = $db -> unit_kerja();
                $jabatan = $db -> jabatan();
            ?>

                <form method="POST" action="simpan.php?action=add" enctype="multipart/form-data">

                    <div class="mb-3">
                        <input type="text" name="nip" id="nip" class="form-control" placeholder="NIP" required>
                    </div>

                    <div class="input-group mb-3">
                        <label class="input-group-text" for="unitKerjaSelect">Unit Kerja</label>
                        <select name="unit_kerja" id="unit_kerja" class="form-select required">

                            <?php foreach($unitKerja as $row) { ?>
                                <option value="<?php echo $row['id_unitkerja'] ?>"><?php echo $row['nama_unitkerja'] ?></option>

                            <?php } ?>

                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <label class="input-group-text" for="jabatanSelect">Jabatan</label>
                        <select name="jabatan" id="jabatan" class="form-select required">

                            <?php foreach($jabatan as $row) { ?>
                                <option value="<?php echo $row['id_jabatan'] ?>"><?php echo $row['nama_jabatan'] ?></option>
           
                            <?php } ?>

                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="hidden" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control" placeholder="Nama Pegawai" required>
                    </div>

                    <div class="mb-3">
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Tempat Lahir" required>
                    </div>

                    <div class="mb-3">
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload Foto</label>
                        <input class="form-control" type="file" id="foto" name="foto">
                    </div>

                    <button type="submit" class="btn btn-success" id="upload" name="upload">Upload</button>
                    <button type="reset" class="btn btn-primary" id="reset" name="reset">Reset</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>