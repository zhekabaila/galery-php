<?php

include './koneksi.php';
session_start();
if (!empty($_SESSION['user'])) {
    header('Location: index.php');
}

if (isset($_POST['suhmit'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email' AND password = '$password'");

    if ($query > 0) {

        $_SESSION['user'] = mysqli_fetch_array($query);

        header("location: index.php");
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
    <form action="" method="post" style="display: flex; flex-direction: column; max-width: 50%;">
        <input type="email" name="email" required placeholder="email">
        <input type="password" name="password" required placeholder="password">
        <button type="submit" name="suhmit">submit</button>
    </form>
</body>

</html>