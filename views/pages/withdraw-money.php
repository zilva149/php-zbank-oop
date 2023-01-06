<div class="wrapper flex flex-col">
    <main class="container">
        <div class="admin flex">
            <button class="burger-menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="admin-info">
                <i class="fa-solid fa-user"></i>
                <?= isset($_SESSION['admin']) && $_SESSION['admin'] ?>
            </div>
        </div>
        <section class="add-content">
            <?php if (isset($_SESSION['modal'])) :
                require(__DIR__ . '/inc/modal.php');
                unset($_SESSION['modal']);
            endif ?>
            <article class="add-card flex flex-col">
                <div class="add-card-info flex">
                    <p class="add-card-name"><?= $user['name'] . ' ' . $user['surname'] ?></p>
                    <p class="add-card-money">&#8364;<?= number_format($user['money'], 2, '.', ',') ?></p>
                </div>
                <form action="/withdraw-money/update/<?= $user['id'] ?>" method="post" class="add-card-form flex">
                    <input type="text" name="withdraw_amount" class="add-card-input input" autocomplete="off" placeholder="Įveskite sumą...">
                    <button type="submit" class="btn submit-btn">nuskaičiuoti</button>
                </form>
            </article>
        </section>
    </main>

    <?php require('../views/layouts/footer.php'); ?>
</div>

</body>

</html>