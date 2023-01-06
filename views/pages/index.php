<div class="wrapper flex flex-col">
    <main class="container">
        <div class="admin flex">
            <button class="burger-menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="admin-info flex">
                <i class="fa-solid fa-user"></i>
                <?= isset($_SESSION['admin']) && $_SESSION['admin'] ?>
            </div>
        </div>
        <?php if (isset($_SESSION['modal'])) :
            require(__DIR__ . '/inc/modal.php');
            unset($_SESSION['modal']);
        endif ?>
        <?php if (isset($users) && count($users) != 0) : ?>
            <section class="users grid">
                <?php foreach ($users as $i => $user) : ?>
                    <article class="user grid">
                        <p class="acc-name"><?= $user['surname'] . ', ' . $user['name'] ?></p>
                        <p class="acc-id"><span class="highlight">ID: </span><?= $user['id'] ?></p>
                        <p class="acc-idnum"><span class="highlight">Asmens kodas: </span><?= $user['id_num'] ?></p>
                        <p class="acc-iban"><span class="highlight">Sąskaitos Nr.: </span><?= $user['bank_acc'] ?></p>
                        <p class="acc-money">&#8364;<?= number_format($user['money'], 2, '.', ',') ?></p>
                        <div class="user-btns flex">
                            <a href="/add-money/<?= $user['id'] ?>" class="btn plus-btn">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                            <a href="/withdraw-money/<?= $user['id'] ?>" class="btn minus-btn">
                                <i class="fa-solid fa-minus"></i>
                            </a>
                            <form action="<?=$_SERVER['PHP_SELF'] . '/' . $user['id'] ?>" method="post">
                                <button type="submit" class="btn delete-btn">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </article>
                <?php endforeach ?>
            </section>
        <?php else : ?>
            <h1 class="empty">Sąskaitų nėra</h1>
        <?php endif ?>
    </main>

    <?php require('../views/layouts/footer.php'); ?>
</div>

</body>

</html>