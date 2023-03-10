<main class="login flex flex-col">
    <div class="container">
        <form action="/login" method="post" class="form flex flex-col">
            <h1 class="title">Prisijunkite</h1>
            <?php if (isset($_SESSION['login_error'])) : ?>
                <div class="modal modal-sm flex" style="background-color: #f01616">
                    <i class='fa-solid fa-exclamation'></i>
                    <p class="modal-text"><?= $_SESSION['login_error'] ?></p>
                </div>
                <?php unset($_SESSION['login_error']) ?>
            <?php endif ?>
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
                <a href="/login" class="btn form-delete-btn">atšaukti</a>
                <button type="submit" class="btn form-submit-btn">prisijungti</button>
            </div>
        </form>
    </div>
</main>

</body>

</html>