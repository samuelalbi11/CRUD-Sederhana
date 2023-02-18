<?php


session_start();
//jika user tidak berhasil login maka pindahkan ke login
if(!isset($_SESSION['login'])) 
{
    header('Location: login.php');

    exit;
}

require 'functions.php';


$mahasiswa = query('SELECT * FROM mahasiswa');
/*
order by id (mengurutkan dengan id), 
syntax ASC = id pertama ke id terakhir, jadi jika kita menambahkan id maka akan muncul di paling bawah dari form, 

DESC sebaliknya.

*/

// tombol cari ditekan
if (isset($_POST['cari'])) {
    $mahasiswa = cari($_POST['keyword']);
// jadi $mahasiswa akan berisi data hasil pencarian dari function cari
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>

<body>

    <a href="logout.php">logout</a>
    <h1>Daftar Mahasiswa</h1>

    <a href="tambah.php">Tambah data mahasiswa</a>
    <br><br>

    <form action="" method="post">
        <input type="text" name="keyword" size="40" autofocus placeholder="masukan keyword pencarian.." autocomplete= "off">
        <button type="submit" name="cari">Cari</button>
    </form>
    <br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>NRP</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>


        <?php $i = 1; ?>

        <?php foreach ($mahasiswa as $row):
            //harus menggunakan :
            ?>

        <tr>
            <td><?= $i; ?></td>
            <td>
                
            <!-- link yang mau dikirm datanya, lalu manampilkan isi dari foreach data diatas karena sebagai row maka menjadi row  -->
                <a href="ubah.php?id=<?= $row['id']; ?>">Ubah</a> 


                <!-- Tanda tanya untuk mengirim id -->
                <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin');">Hapus</a> 
            </td>
            <td><img src="img/<?= $row['gambar'] ?>" width="50"></td>
            <td><?= $row['nrp'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['jurusan'] ?></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>

</body>

</html>
