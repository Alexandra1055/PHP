<?php require base_path('views/parciales/head.php') ?>

<?php require base_path('views/parciales/nav.php') ?>
    <main>
        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
            <?php require base_path('views/parciales/banner.php') ?>
            <div class="text-center">
                <p class="mb-6">
                    <a href="/notes" class="text-blue-500 underline">Go back</a>
                </p>
                <p> <?= htmlspecialchars($note['body']) ?></p>
                <form class="mt-6" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" value="<?= $note['id'] ?>" name="id">
                    <button class="text-sm text-red-500">Eliminar</button>
                </form>

            </div>
        </div>
    </main>
<?php require base_path('views/parciales/footer.php') ?>