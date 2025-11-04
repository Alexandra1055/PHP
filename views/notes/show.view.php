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
                <a href="/note/edit?id=<?= $note['id'] ?>" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-black focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Editar</a>

            </div>
        </div>
    </main>
<?php require base_path('views/parciales/footer.php') ?>