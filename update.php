<?php

session_start();
if (empty($_SESSION['user'])) {
    header('Location: login.php');
}
include './koneksi.php';

$foto_id = $_GET['foto_id'];

$query = mysqli_query($koneksi, "SELECT * FROM `foto` WHERE `foto_id` = $foto_id LIMIT 1");
$foto = mysqli_fetch_assoc($query);

if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];


    if ($_FILES['file']) {
        $filename = uniqid() . "_" . $_FILES['file']['name'];

        move_uploaded_file($_FILES['file']['tmp_name'], './foto/' . $filename);
    } else {
        $filename = $foto['lokasi_file'];
    }

    $query = mysqli_query($koneksi, "UPDATE `foto` SET `judul_foto` = '$judul', `deskripsi_foto` = '$deskripsi', `lokasi_file` = '$filename' WHERE foto_id = $foto_id");

    if ($query > 0) {
        header('Location: index.php');
    } else {
        echo "<script>alert('Gagal Update')</script>";
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
        <input type="text" name="judul" value="<?= $foto['judul_foto'] ?>" required placeholder="Judul">
        <input type="text" name="deskripsi" value="<?= $foto['deskripsi_foto'] ?>" required placeholder="Deskripsi">
        <input type="file" name="file">
        <button type="submit" name="submit">submit</button>
    </form>
</body>

</html>