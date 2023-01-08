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
        <form action="/create-account/save" method="post" class="form flex flex-col">
            <h1 class="title">Nauja sąskaita</h1>
            <div class="form-info grid">
                <div class="form-name-container input-container">
                    <label for="name" class="label">Vardas</label>
                    <input type="text" value="<?= !isset($_SESSION['name_error']) && isset($_SESSION['info']) ? $_SESSION['info']['name'] : '' ?>" name="name" class="input form-input" id="name">
                    <?php if (isset($_SESSION['name_error']) && $_SESSION['name_error'] !== '') : ?>
                        <div class="modal modal-sm flex" style="background-color: #f01616">
                            <i class='fa-solid fa-exclamation'></i>
                            <p class="modal-text"><?= $_SESSION['name_error'] ?></p>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-surname-container input-container">
                    <label for="surname" class="label">Pavardė</label>
                    <input type="text" value="<?= !isset($_SESSION['surname_error']) && isset($_SESSION['info']) ? $_SESSION['info']['surname'] : '' ?>" name="surname" class="input form-input" id="surname">
                    <?php if (isset($_SESSION['surname_error']) && $_SESSION['surname_error'] !== '') : ?>
                        <div class="modal modal-sm flex" style="background-color: #f01616">
                            <i class='fa-solid fa-exclamation'></i>
                            <p class="modal-text"><?= $_SESSION['surname_error'] ?></p>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-id-container input-container">
                    <label for="id" class="label">Asmens kodas</label>
                    <input type="text" value="<?= !isset($_SESSION['id_error']) && isset($_SESSION['info']) ? $_SESSION['info']['id'] : '' ?>" name="id" class="input form-input" id="id">
                    <?php if (isset($_SESSION['id_error']) && $_SESSION['id_error'] !== '') : ?>
                        <div class="modal modal-sm flex" style="background-color: #f01616">
                            <i class='fa-solid fa-exclamation'></i>
                            <p class="modal-text"><?= $_SESSION['id_error'] ?></p>
                        </div>
                    <?php endif ?>
                </div>
                <div class="form-id-container input-container">
                    <label for="iban" class="label">Sąskaitos Nr.</label>
                    <input type="text" name="iban" class="input form-input" id="iban" value="<?= generateIBAN($users) ?>" readonly>
                </div>
            </div>
            <div class="form-btns">
                <a href="/create-account" class="btn form-delete-btn">atšaukti</a>
                <button type="submit" class="btn form-submit-btn">išsaugoti</button>
            </div>
        </form>
    </main>

    <?php require('../views/layouts/footer.php'); ?>
    <?php unset($_SESSION['info'], $_SESSION['name_error'], $_SESSION['surname_error'], $_SESSION['id_error']) ?>
</div>

</body>

</html>