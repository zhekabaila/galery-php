<?php

session_start();
if (empty($_SESSION['user'])) {
    header('Location: login.php');
}
include './koneksi.php';

if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $user_id = $_SESSION['user']['user_id'];
    $tanggal_unggah = date('Y-m-d');

    $tmp_file = $_FILES['lokasi_file']['tmp_name'];
    $nama_file = uniqid() . "_" . $_FILES['lokasi_file']['name'];

    move_uploaded_file($tmp_file, './foto/' . $nama_file);

    $query = mysqli_query($koneksi, "INSERT INTO `foto` VALUES ('', '$judul', '$deskripsi', '$tanggal_unggah', '$nama_file', '$user_id')");

    if ($query > 0) {
        header('Location: index.php');
    } else {
        echo "<script>alert('Upload Gagal')</script>";
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
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="judul" required placeholder="Judul">
        <input type="text" name="deskripsi" required placeholder="Deskripsi">
        <input type="file" name="lokasi_file" required>
        <button type="submit" name="submit">submit</button>
    </form>
</body>

</html>