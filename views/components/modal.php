<div class="modal modal-big flex" style="background-color: <?= $_SESSION['modal']['operation'] == 'success' ? '#35bd0f' : '#f01616' ?>">
    <?= $_SESSION['modal']['operation'] == 'success' ? "<i class='fa-regular fa-circle-check'></i>" : "<i class='fa-solid fa-exclamation'></i>" ?>
    <p class="modal-text"><?= $_SESSION['modal']['message'] ?></p>
</div>