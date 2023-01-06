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
        <form action="/create-account/save" method="post" class="form flex flex-col">
            <h1 class="title">Nauja sąskaita</h1>
            <div class="form-info grid">
                <div class="form-name-container input-container">
                    <label for="name" class="label">Vardas</label>
                    <input type="text" name="name" class="input form-input" id="name">
                    <?php if (isset($_SESSION['modal_sm']) && $_SESSION['modal_sm']['modal_place'] == 'name') :
                        require('./assets/inc/modal-sm.php');
                        unset($_SESSION['modal_sm']);
                    endif ?>
                </div>
                <div class="form-surname-container input-container">
                    <label for="surname" class="label">Pavardė</label>
                    <input type="text" name="surname" class="input form-input" id="surname">
                    <?php if (isset($_SESSION['modal_sm']) && $_SESSION['modal_sm']['modal_place'] == 'surname') :
                        require('./assets/inc/modal-sm.php');
                        unset($_SESSION['modal_sm']);
                    endif ?>
                </div>
                <div class="form-id-container input-container">
                    <label for="id" class="label">Asmens kodas</label>
                    <input type="text" name="id" class="input form-input" id="id">
                    <?php if (isset($_SESSION['modal_sm']) && $_SESSION['modal_sm']['modal_place'] == 'id') :
                        require('./assets/inc/modal-sm.php');
                        unset($_SESSION['modal_sm']);
                    endif ?>
                </div>
                <div class="form-id-container input-container">
                    <label for="iban" class="label">Sąskaitos Nr.</label>
                    <input type="text" name="iban" class="input form-input" id="iban" value="<?= generateIBAN($users) ?>" readonly>
                    <?php if (isset($_SESSION['modal_sm']) && $_SESSION['modal_sm']['modal_place'] == 'id') :
                        require('./assets/inc/modal-sm.php');
                        unset($_SESSION['modal_sm']);
                    endif ?>
                </div>
            </div>
            <div class="form-btns">
                <a href="http://localhost:8080/intro/personal-projects/php-zbank/add-account.php" class="btn form-delete-btn">atšaukti</a>
                <button type="submit" class="btn form-submit-btn">išsaugoti</button>
            </div>
        </form>
    </main>

    <?php require('../views/layouts/footer.php'); ?>
</div>

</body>

</html>