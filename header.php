<?php
// header.php
?>
<div class="header">
    <div class="user-info">
        <span>Selamat datang, <?php echo $_SESSION['username']; ?></span>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</div>