<div class="wrapper flex flex-col">
    <main class="container">
        <div class="admin flex">
            <button class="burger-menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="admin-info">
                <i class="fa-solid fa-user"></i>
                <?= $_SESSION['admin'] ?>
            </div>
        </div>
        <section class="add-content">
            <?php if (isset($_SESSION['modal'])) :
                require('./../views/components/modal.php');
                unset($_SESSION['modal']);
            endif ?>
            <article class="add-card flex flex-col">
                <div class="add-card-info flex">
                    <p class="add-card-name"><?= $user['name'] . ' ' . $user['surname'] ?></p>
                    <p class="add-card-money">&#8364;<?= number_format($user['money'], 2, '.', ',') ?></p>
                </div>
                <form action="/add-money/update/<?= $user['id'] ?>" method="post" class="add-card-form flex">
                    <input type="text" name="add_amount" class="add-card-input input" autocomplete="off" placeholder="Įveskite sumą...">
                    <button type="submit" class="btn submit-btn">pridėti</button>
                </form>
            </article>
        </section>
    </main>

    <?php require('../views/layouts/footer.php'); ?>
</div>

<script>
    const input = document.querySelector('input[name="amount"]');
    window.addEventListener('DOMContentLoaded', () => input.focus());
</script>

</body>

</html>