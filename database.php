<?php 
    class Database {
        var $host = "localhost";
        var $user = "root";
        var $password = "";
        var $db = "pemwebdas_db";
        var $koneksi = "";

        function __construct() {
            $this -> koneksi = mysqli_connect(
                $this -> host,    
                $this -> user,
                $this -> password,
                $this -> db);

            if (mysqli_connect_errno()) {
                die("Failed to connect database : " . mysqli_connect_error());
            }
        }

        function show_data() {
            $sql = "SELECT * FROM pegawai pgw 
                    JOIN unit_kerja unk ON pgw.id_unitkerja = unk.id_unitkerja
                    JOIN jabatan jbtn ON pgw.id_jabatan = jbtn.id_jabatan";
            
            $query = mysqli_query($this -> koneksi, $sql);

            if (mysqli_num_rows($query) > 0) {
                foreach($query as $row) {
                    $data[] = $row; 
                }

                return $data;
            }
            else {
                return 0;
            } 
        }

        function unit_kerja() {
            $query = mysqli_query($this -> koneksi, "SELECT * FROM unit_kerja");

            foreach ($query as $row) {
                $data[] = $row;
            }

            return $data;
        }

        function jabatan() {
            $query = mysqli_query($this -> koneksi, "SELECT * FROM jabatan");

            foreach ($query as $row) {
                $data[] = $row;
            }

            return $data;
        }

        function get_by_nip($nip) {
            $query = mysqli_query($this -> koneksi, "SELECT * FROM pegawai WHERE nip = '$nip'");

            return $query -> fetch_array();
        }

        function update_data($nip, $data) {
            
            $dataset = "";

            foreach($data as $key => $value) {
                $dataset .= $key . '="' . $value . '",';
            }

            $dataset = rtrim($dataset, ',');
            mysqli_query($this -> koneksi, "UPDATE pegawai SET $dataset 
                    WHERE nip='$nip'");
        }
        
        function delete_data($nip) {

            mysqli_query($this -> koneksi, "DELETE FROM pegawai WHERE nip = '$nip'");
        }

        function insert_data($data) {

            $column = implode(',' , array_keys($data));

            $value = "'" . implode("','", array_values($data)) . "'";
            mysqli_query($this -> koneksi, "INSERT INTO pegawai($column) VALUES($value)");
        }
    }
?>