<?php
session_start();
require "functions.php";


    
    //fungsi jika, browser di close, komputer dimatikan pada saat dinyalakan kembali, saya ingin yang pertama di cek cookie
    //cek cookie, kalau ada sessioon dijalankan berarti dia masih login
    
    if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) { //mengecek apakah user login dan menekan key dimana key = remember me 
        $id = $_COOKIE['id'];
        $key = $_COOKIE['key'];

        //ambil username berdasarkan id
        $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
        $row = mysqli_fetch_assoc($result);

        //cek cookie dan username
         if ($key === hash('sha256', $row['username'])) {
            
                $_SESSION['login'] = true;


        }


    }

    



    if(isset($_SESSION["login"])){
        header('Location: index.php');
        exit;

    }


if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];


    //cek apakah user yang sama di database sama dengan username yang inputkan saat login

    $result = mysqli_query($conn,"SELECT * FROM user WHERE username = '$username'");
    
    if (mysqli_num_rows($result) === 1) { //menghitung ada berapa baris yang dikembalikan dari function select kalau ketemu nilai = 1, jika tidak = 0
  

        
        //cek password
        $row = mysqli_fetch_assoc($result);
       if( password_verify($password, $row['password'])){// megecek apakah sebuah string sama dengan hashnya, parameter = stringYangSudahDiacak,StringYangBelumDiacak

        // set session
        $_SESSION ["login"] = true; //jika berhasil login ke halaman index dibikin true


        //cek remember me
        if (isset($_POST['remember'])) {
        //buat cookie

        //ambil user id sama username nanti usernya di enkripsi, sehingga yang dicek usernamnya 

        //jadi id disini bisa diganti menjadi apapun agar hacker tidak tahu bahwa yang kita masukan adalah id karena id itu key common
        setcookie('id',$row['id'],time()+ 60);      
        setcookie('key',hash('sha256',$row['username']),time() + 60); //mengacak string username menggunakan teknik hash dari php dan alogirtmanya 'sha256'
        
        
        }



        header("location: index.php"); // mengarahkan ke index.php
        exit;


    }
  
    }
    //jika salah maka program error dijalankan
    $error = true;



}


?> 
 
 
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        li{
            padding-top: 5px;
        }
    </style>
 </head>
 <body>

<h1>
    Halaman Login
</h1>

<?php

        if(isset($error)) :
?>
    <p style="color:red; font-style:italic;">username / password salah</p>
<?php endif; ?>

<form action="" method="post">

 <ul>
    <li>
        <label for="username">Username : </label>
        <input type="text" name="username" id="username">
    </li>
    <li>
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
    </li>
    <li>
    <input type="checkbox" name="remember" id="remember">

    <label for="remember">Remember me </label>


    </li>
    <li>
       <button type="submit" name="login">Login</button>
    </li>
 </ul>

</form>


 </body>
 </html>