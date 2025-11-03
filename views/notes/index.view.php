<?php require base_path('views/parciales/head.php') ?>

<?php require base_path('views/parciales/nav.php') ?>
    <main>
        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
            <?php require base_path('views/parciales/banner.php') ?>
            <div class="text-center">
                <ul>
                    <?php foreach ($notes as $note):?>
                        <li>
                            <a href="/note?id<?= $note['id'] ?>" class="text blue 500 hover:underline">
                                <?= htmlspecialchars($note['body']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p class="mt-6">
                    <a href="/notes/create" class="text blue 500 hover:underline">Crear Nota</a>
                </p>
            </div>
        </div>
    </main>
<?php require base_path('views/parciales/footer.php') ?>