<div class="wrapper flex flex-col">
    <main class="container">
        <div class="admin flex">
            <button class="burger-menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="admin-info flex">
                <i class="fa-solid fa-user"></i>
                <?= $_SESSION['admin'] ?>
            </div>
        </div>
        <?php if (isset($_SESSION['modal'])) :
            require('./../views/components/modal.php');
            unset($_SESSION['modal']);
        endif ?>
        <?php if (isset($users) && count($users) != 0) : ?>
            <section class="currencies-container flex">
                <h2 class="currency-title">Valiutos:</h2>
                <div class="currencies flex">
                    <a href="/accounts" class="currency <?= $current === 'eur' ? 'current' : '' ?>">EUR</a>
                    <a href="/accounts/usd" class="currency <?= $current === 'usd' ? 'current' : '' ?>">USD</a>
                    <a href="/accounts/gbp" class="currency <?= $current === 'gbp' ? 'current' : '' ?>">GBP</a>
                </div>
            </section>
            <section class="users grid">
                <?php foreach ($users as $i => $user) : ?>
                    <article class="user grid">
                        <p class="acc-name"><?= $user['surname'] . ', ' . $user['name'] ?></p>
                        <p class="acc-id"><span class="highlight">ID: </span><?= $user['id'] ?></p>
                        <p class="acc-idnum"><span class="highlight">Asmens kodas: </span><?= $user['id_num'] ?></p>
                        <p class="acc-iban"><span class="highlight">Sąskaitos Nr.: </span><?= $user['bank_acc'] ?></p>
                        <p class="acc-money"><?= getCurrency($current) ?><?= number_format($user['money'], 2, '.', ',') ?></p>
                        <div class="user-btns flex">
                            <a href="/add-money/<?= $user['id'] ?>" class="btn plus-btn">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                            <a href="/withdraw-money/<?= $user['id'] ?>" class="btn minus-btn">
                                <i class="fa-solid fa-minus"></i>
                            </a>
                            <form action="/delete/<?= $user['id'] ?>" method="post">
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

<script>
    const plusBtns = document.querySelectorAll('.plus-btn');
    const minusBtns = document.querySelectorAll('.minus-btn');
    const deleteBtns = document.querySelectorAll('.delete-btn');

    window.addEventListener('DOMContentLoaded', () => {
        const width = window.innerWidth;
        if (width >= 992) {
            plusBtns.forEach((btn) => {
                btn.innerHTML = 'pridėti';
            });
            minusBtns.forEach((btn) => {
                btn.innerHTML = 'nuskaičiuoti';
            });
            deleteBtns.forEach((btn) => {
                btn.innerHTML = 'ištrinti';
            });
        } else {
            plusBtns.forEach((btn) => {
                btn.innerHTML = `<i class="fa-solid fa-plus"></i>`;
            });
            minusBtns.forEach((btn) => {
                btn.innerHTML = `<i class="fa-solid fa-minus"></i>`;
            });
            deleteBtns.forEach((btn) => {
                btn.innerHTML = `<i class="fa-solid fa-trash"></i>`;
            });
        }
    });

    window.addEventListener('resize', () => {
        const width = window.innerWidth;
        if (width >= 992) {
            plusBtns.forEach((btn) => {
                btn.innerHTML = 'pridėti';
            });
            minusBtns.forEach((btn) => {
                btn.innerHTML = 'nuskaičiuoti';
            });
            deleteBtns.forEach((btn) => {
                btn.innerHTML = 'ištrinti';
            });
        } else {
            plusBtns.forEach((btn) => {
                btn.innerHTML = `<i class="fa-solid fa-plus"></i>`;
            });
            minusBtns.forEach((btn) => {
                btn.innerHTML = `<i class="fa-solid fa-minus"></i>`;
            });
            deleteBtns.forEach((btn) => {
                btn.innerHTML = `<i class="fa-solid fa-trash"></i>`;
            });
        }
    });
</script>

</body>

</html>