<?php
session_start();

//jika user tidak berhasil login maka pindahkan ke login
if(!isset($_SESSION['login'])) 
{
    header('Location: login.php');

    exit;
}



require 'functions.php';

// koneksi ke DBMS
$conn = mysqli_connect('localhost', 'root', '', 'phpdasar');

//cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST['submit'])) {
    //$_POST berfungsi menjalankan perintah user ketika user men-submit tombol button

    // var_dump($_POST);
    // var_dump($_FILES); die;
    // die; berfungsi untuk mengakhiri program jadi program dibawah tidak akan dijalanka

    //cek apakah data berhasil ditambahkan atau tidak
    if (tambah($_POST) > 0) {
        //jadi data didalam element diambil dimasukan kedalam elemen tambah nanti akan ditangkan oleh data
        echo "
        <script>
            alert('data berhasil ditambahkan');
            document.location.href = 'index.php';
        </script>
    ";
    } else {
        echo "
        <script>
            alert('data gagal ditambahkan');
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
    <h1>Tambah data mahasiswa</h1>
    <!-- post supaya data tidak ditampilkan di url -->
    <form action="" method="post" enctype="multipart/form-data">
    <!-- fungsi dari enctype="multipart/form-data" = Jadi data di dalam post tidak menampilkan gambar ketika di var_dump -->
        <ul>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required>
            </li>
            <li>
                <label for="nrp">NRP :</label>
                <input type="text" name="nrp" id="nrp" required>
                <!-- name dan id sesuaikan dengan nama field di atribut -->
            </li>
         
            <li>
                <label for="email">Email : </label>
                <input type ="text" name="email" id="email" required>
            </li>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan" required>
            </li>
            <li>
                <label for="gambar">Gambar : </label>
                <input type="file" name="gambar" id="gambar" required>
            </li>
            <li>
                <button type="submit" name="submit">Tambah Data!</button>
            </li>
        </ul>
    </form>

</body>

</html>

