<?php

require 'functions.php';

// ambil data di url
$id = $_GET['id'];    
//query data mahasiswa berdasarkan id
// memanggil function query begitu dimasukan ke rowsnya maka elemen yang kita ambil langusng indexnya yaitu index 0 karena query merupakan index numerik.

$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];


// koneksi ke DBMS
$conn = mysqli_connect('localhost', 'root', '', 'phpdasar');

//cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST['submit'])){
    //akan dibuat element yang keynya submit

    //cek apakah data berhasil diubah atau tidak
    if (ubah($_POST) > 0) {
        //jadi data didalam element diambil dimasukan kedalam elemen tambah nanti akan ditangkan oleh data
        echo "
        <script>
            alert('data berhasil diubah');
            document.location.href = 'index.php';
        </script>
    ";
    } else {
        echo "
    <script>
            alert('data gagal diubah') ;    
            document.location.href = 'index.php';
        </script>
    ";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah data mahasiswa</title>
</head>

<body>
    <h1>Ubah data mahasiswa</h1>
    <!-- post supaya data tidak ditampilkan di url -->
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $mhs["id"];?>">
        <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"];?>">

        <ul>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required value="<?= $mhs["nama"]?>">
            </li>
            <li>
                <label for="nrp">NRP :</label>
                <input type="text" name="nrp" id="nrp" required value="<?= $mhs["nrp"]?>">
                <!-- name dan id sesuaikan dengan nama field di atribut -->
            </li>
         
            <li>
                <label for="email">Email : </label>
                <input type ="text" name="email" id="email" required value="<?= $mhs["email"]?>">
            </li>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan" required value="<?= $mhs["jurusan"]?>">
            </li>
            <li>
                <label for="gambar">Gambar : </label> <br>
                <img src="img/<?php echo $mhs['gambar'];?>" width="50"><br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Ubah Data!</button>
            </li>
        </ul>
    </form>

</body>

</html>

