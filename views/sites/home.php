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
        <section class="users grid">
            <article class="user grid">
                <p class="acc-name"><?= $user->surname . ', ' . $user->name ?></p>
                <p class="acc-id"><span class="highlight">ID: </span><?= $user->id ?></p>
                <p class="acc-idnum"><span class="highlight">Asmens kodas: </span><?= $user->id_num ?></p>
                <p class="acc-iban"><span class="highlight">Sąskaitos Nr.: </span><?= $user->bank_acc ?></p>
                <p class="acc-money">&#8364;<?= number_format($user->money, 2, '.', ',') ?></p>
                <div class="user-btns flex">
                    <a href="http://localhost:8080/intro/personal-projects/php-zbank/add-money.php?id=<?= $user->id ?>" class="btn plus-btn">
                        <i class="fa-solid fa-plus"></i>
                    </a>
                    <a href="http://localhost:8080/intro/personal-projects/php-zbank/withdraw-money.php?id=<?= $user->id ?>" class="btn minus-btn">
                        <i class="fa-solid fa-minus"></i>
                    </a>
                    <form action="http://localhost:8080/intro/personal-projects/php-zbank/accounts.php?id=<?= $user->id ?>" method="post">
                        <button type="submit" class="btn delete-btn">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </article>
        </section>
    </main>
</div>