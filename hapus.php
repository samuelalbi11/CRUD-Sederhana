<?php
session_start();

//jika user tidak berhasil login maka pindahkan ke login
if (!isset($_SESSION['login'])) {
    header('Location: login.php');

    exit();
}

require 'functions.php';

$id = $_GET['id']; // ditangkan data dari url index php yang ?

//kalo hapus berhasil (analoginya adalah jika data bertambah menjadi 1 maka akan menjalankan perintah berikut)
if (hapus($id) > 0) {
    echo "
        <script>
            alert('data berhasil dihapus');
            document.location.href = 'index.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('data gagal dihapus');
            document.location.href = 'index.php';
        </script>
    ";
}

?>
