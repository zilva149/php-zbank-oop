<main class="login flex flex-col">
    <div class="container">
        <form action="http://localhost:8080/intro/personal-projects/php-zbank/login.php" method="post" class="form flex flex-col">
            <h1 class="title">Prisijunkite</h1>
            <?php if (isset($_SESSION['modal_sm'])) :
                require(__DIR__ . '/inc/modal-sm.php');
                unset($_SESSION['modal_sm']);
            endif ?>
            <div class="form-info grid">
                <div class="input-container" style="grid-column: 1 / span 2;">
                    <label for="email" class="label">El. paštas</label>
                    <input type="email" name="email" class="input form-input" id="email">
                </div>
                <div class="input-container" style="grid-column: 1 / span 2;">
                    <label for="pass" class="label">Slaptažodis</label>
                    <input type="password" name="pass" class="input form-input" id="pass">
                </div>
            </div>
            <div class="form-btns">
                <a href="http://localhost:8080/intro/personal-projects/php-zbank/add-account.php" class="btn form-delete-btn">atšaukti</a>
                <button type="submit" class="btn form-submit-btn">išsaugoti</button>
            </div>
        </form>
    </div>
</main>

</body>

</html>