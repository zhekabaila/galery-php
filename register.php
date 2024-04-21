<?php

include './koneksi.php';
session_start();
if (!empty($_SESSION['user'])) {
    header('Location: index.php');
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $email = $_POST['email'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];

    $query = mysqli_query($koneksi, "INSERT INTO user VALUES ('', '$username', '$password', '$email', '$nama_lengkap', '$alamat')");

    if ($query > 0) {
        header("location: login.php");
    } else {
        echo "<script>
            alert('Gagal Register');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <nav style="display: flex; gap: 20px; justify-content: space-between;">
        <h1>Galery</h1>
        <div style="display: flex; gap: 20px; align-items: center;">
            <a href="./index.php">Home</a>
            <?php if (!empty($_SESSION['user'])) : ?>
                <a href="./insert.php">Create</a>
                <a href="./profile.php">Profile</a>
                <a href="./logout.php">Logout</a>
            <?php else : ?>
                <a href="./login.php">Login</a>
                <a href="./register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>
    <form action="" method="post">
        <div style="display: flex; flex-direction: column; gap: 20px; max-width: 50%;">
            <input type="text" name="username" required placeholder="username">
            <input type="email" name="email" required placeholder="email">
            <input type="text" name="nama_lengkap" required placeholder="nama_lengkap">
            <textarea name="alamat" id="alamat" cols="30" rows="10"></textarea>
            <input type="password" name="password" required placeholder="password">
            <button type="submit" name="submit">submit</button>
        </div>
    </form>
</body>

</html>