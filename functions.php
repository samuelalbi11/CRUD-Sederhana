<!-- 
$_SESSION

Mekanisme penyimpanan informasi ke dalam variable agar bisa digunakan lebih dar satu halaman.

Informasi disimpan di server.

Syarat : 
menjalankan sebuah function yaitu = session_start()

 -->



<?php
// konkesi ke database
$conn = mysqli_connect('localhost', 'root', '', 'phpdasar');
//Parameter  = "hostname", "username","password","database"

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    $rows = []; //kotak kosong
    while ($row = mysqli_fetch_assoc($result)) {
        //baju yang diambil dari lemari result
        $rows[] = $row;
        //menambahkan element baru diakhir array
    }

    return $rows; //mengembalikan kotaknya
    // jadi fungsi diatas analoginya seperti mengambil baju daru lemari dikamar lalu menaruh baju ke kotak dan fungsi rows[] = row itu menaruh baju supaya berjejer kesamping, pada akhirnya mereturn rows dimana kita memberu baju ke teman kita lewat kotak yang sudah kita susun
}

function tambah($data)
{
    // menerima intputan lewat data
    //parameter diatas dikirim lewat metode post

    global $conn;
    $nrp = htmlspecialchars($data['nrp']); //fungsi htmlspecialchars untuk menyimpan ke database tetapi tidak menjalankan program
    $nama = htmlspecialchars($data['nama']);
    $email = htmlspecialchars($data['email']);
    $jurusan = htmlspecialchars($data['jurusan']);

    // $gambar = htmlspecialchars( $data['gambar']);
    //upload gambar

    $gambar = upload(); //fungsi ini ada dua fungsi yaitu megirim ke $gambar dan mengapload gambar

    if (!$gambar) {
        return 0;
        //kalau ketemu return false berhenti insert datanya tidak dijalankan
        // dalam artian jika tidak ada gambar yang diupload data tidak akan dimasukan database
    }

    //query insert data
    $query = "INSERT INTO mahasiswa
  VALUES
  ('','$nama','$nrp','$email','$jurusan','$gambar')
  ";

    mysqli_query($conn, $query); //setelah dijalankan querynya akan dibikin function mengembalikan angka angka yang diambil dari mysqli_affected_rows; jadi selain dijalankan akan memberi tahu apakah ini benar atau tidak

    return mysqli_affected_rows($conn);
}

function upload()
{
    //namaFile = gambar yang merupakan array associative sendiri dikarenakan sudah dibedakan menggunakan function enctype ["namaArray"]["namaNestedArray"] karena array gambar itu nested / multidimensi
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        //4 artinya error dalam array gamber
        echo "<script>
            alert('pilih gambar dulu');
        </script>";

        return false;
    }

    //cek apakah yang diapload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];

    // explode adalah sebuha fungsi di php untuk memecah string menjadi php
    $ekstensiGambar = explode('.', $namaFile); // seperti jika kita memiliki nama file spt samuel.png akan dirubah menjadi ['samuel','png'] jadinya array

    //mengambil array paling akhir dimana paling akhir merupakan ekstensi gambar berupa(png,jpg,jpeg)
    $ekstensiGambar = strtolower(end($ekstensiGambar)); //dimana fungsi end disini menggambil arau terakhir, str to lower menjadikan nilai ekstensi yang diinput pengguna menjadi kecil

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        // fungsi mengecek apakah di dalam array ekstensiGambar ada ekstensiGambaryangvalid??

        echo "<script>
        alert('yang anda upload bukan gambar');
        </script>";

        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranFile > 1000000 ) {
        
        echo "
            <script>
        alert('ukuran gambar terlalu besar');
            </script>
        ";
        return false;
        
    }


    //generate nama gambar baru
    $namaFileBaru = uniqid();// akan membangkitkan string random angka yang nanti akan menajdi nama file
    $namaFileBaru .= ['.'];
    $namaFileBaru .= $ekstensiGambar;






    // lolos pengecekan, gambar siap diupload
    move_uploaded_file($tmpName,'img/'. $namaFileBaru);

    return $namaFileBaru;// kenapa direturn unutk fungsi upload gambar,jadi jika gambar berhasil di upload isi dari gambar adalah nama file sehingga gambar bsia dimasukan inser to mahasiswa di database;

    











}

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function ubah($data)
{
    global $conn;
    $id = $data['id'];
    $nrp = htmlspecialchars($data['nrp']); //fungsi htmlspecialchars untuk menyimpan ke database tetapi tidak menjalankan program
    $nama = htmlspecialchars($data['nama']);
    $email = htmlspecialchars($data['email']);
    $jurusan = htmlspecialchars($data['jurusan']);
    $gambarLama  = htmlspecialchars($data['gambarLama']);

    //cek apakah usre pilih gambar baru atau tidak 
    // array gambar diambil dari input type file name gambar di function ubah.php
    if($_FILES['gambar']['error'] === 4){ //jika tidak menginput gambar maka biarkan gambar dengan gambar lama
        $gambar = $gambarLama;
    }else{
        //jika menginput maka gabar itu adalah function upload dimana akan meninput gambar baru ke dalam database
    $gambar = upload();
    }




    //query insert data
    //update mahasiswa set semuanya ke data baru walaupun yang dibah hanya nrp tetapi akan merubah semuanya
    $query = "UPDATE mahasiswa SET
                nrp = '$nrp',
                nama = '$nama',
                email = '$email',
                jurusan = '$jurusan',
                gambar = '$gambar'

                WHERE id = $id
                ";

    mysqli_query($conn, $query); //setelah dijalankan querynya akan dibikin function mengembalikan angka angka yang diambil dari mysqli_affected_rows; jadi selain dijalankan akan memberi tahu apakah ini benar atau tidak

    return mysqli_affected_rows($conn);
}

function cari($keyword)
{
    $query = "SELECT * FROM mahasiswa 
    WHERE 
    nama LIKE '%$keyword%' OR
    nrp LIKE '%$keyword%' OR
    email LIKE '%$keyword%'OR
    jurusan LIKE '%$keyword%'

    ";
    // menampilkan semua nama dari kata depan yang dicari ( WHERE nama = '$keyword%')
    // menampilkan semua nama depan dan belakang ( WHERE nama = '%$keyword%')

    return query($query);
}


    function registrasi($data){ //function registrasi yang menerima inputan data yang dikirimkan melalui post
        global $conn;

         // jadi data username di registrasi.php diambil oleh $data dimasukan ke dalam $username.
        $username = strtolower(stripslashes($data["username"]));//stripslashes untuk membershikan dari tanda slash (/ atau \) dan strtolower mengubah username yang dimasukan menjadi huruf kecil semua

        $password = mysqli_real_escape_string($conn,$data["password"]); //fungsi untuk memungkinkan user memasukan password dalam dengan tanda kutip
        
        $password2 = mysqli_real_escape_string($conn,$data["password2"]);


        //cek username sudah ada atau belum

        $result = mysqli_query($conn,"SELECT username FROM user WHERE username = '$username'"); 

        if(mysqli_fetch_assoc($result)){

            echo "<script>
                alert('username sudah terdaftar');
            </script>";

            return false;
        }




        //cek konfirmasi password
        if ($password != $password2) {
            echo "<script>
                alert('konfirmasi password tidak sesuai');
            </script>";

            return false;
        }

    

    // enkripsi password
     $password = password_hash($password,PASSWORD_DEFAULT);



    // tambahkan user baru ke database

    mysqli_query($conn,"INSERT INTO user VALUES ('','$username','$password')");

    return mysqli_affected_rows($conn); //untuk menghasilakan angka 1 jika berhasil dan -1 jika gagal

}












?>  

