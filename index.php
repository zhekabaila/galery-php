<?php

include './koneksi.php';

session_start();

$query = mysqli_query($koneksi, "SELECT * FROM foto ORDER BY foto_id DESC");

function jumlah_like($foto_id)
{
    global $koneksi;
    $q = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah_like FROM like_foto WHERE foto_id = $foto_id");
    $row = mysqli_fetch_assoc($q);
    return $row['jumlah_like'];
}

function jumlah_komen($foto_id)
{
    global $koneksi;
    $r = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah_komen FROM komentar_foto WHERE foto_id = $foto_id");
    $row = mysqli_fetch_assoc($r);
    return $row['jumlah_komen'];
}

function nama_user($user_id)
{
    global $koneksi;
    $r = mysqli_query($koneksi, "SELECT username FROM user WHERE user_id = $user_id");
    $row = mysqli_fetch_assoc($r);
    return $row['username'];
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
    <header>
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
    </header>
    <div class="" style="display: flex; flex-direction: column; gap: 25px;">
        <?php while ($row = mysqli_fetch_assoc($query)) : ?>
            <div style="display: flex; flex-direction: column; border: 1px solid black; padding: 16px; border-radius: 6px; max-width: 400px; margin: 0 auto;">
                <h1>
                    Pemilik:
                    <a href="./user.php?user_id=<?= $row['user_id'] ?>">
                        <?= nama_user($row['user_id']) ?>
                    </a>
                </h1>
                <p>Tanggal Unggah: <?= $row['tanggal_unggah'] ?></p>
                <p>Judul: <?= $row['judul_foto'] ?></p>
                <p>Deskripsi: <?= $row['deskripsi_foto'] ?></p>
                <img src="./foto/<?= $row['lokasi_file'] ?>" alt="" width="" style="100%">
                <div style="display: flex; align-items: center; gap: 20px;">
                    <?php if (!empty($_SESSION['user'])) : ?>
                        <a href="./like.php?foto_id=<?= $row['foto_id'] ?>">Like <?= jumlah_like($row['foto_id']) ?></a>
                        <a href="./detail-post.php?foto_id=<?= $row['foto_id'] ?>">Komen <?= jumlah_komen($row['foto_id']) ?></a>
                    <?php else : ?>
                        <p>Like <?= jumlah_like($row['foto_id']) ?></p>
                        <a href="./detail-post.php?foto_id=<?= $row['foto_id'] ?>">Komen <?= jumlah_komen($row['foto_id']) ?></a>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['user'])) : ?>
                        <?php if ($_SESSION['user']['user_id'] == $row['user_id']) : ?>
                            <a href="./update.php?foto_id=<?= $row['foto_id'] ?>">Update</a>
                            <a onclick="return confirm('Yakin ingin menghapus?')" href="./delete.php?foto_id=<?= $row['foto_id'] ?>">Delete</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>

</html>