<?php require('views/parciales/head.php') ?>

<?php require('views/parciales/nav.php') ?>
    <main>
        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
            <?php require('views/parciales/banner.php') ?>
            <div class="text-center">
                <p class="mb-6">
                    <a href="/notes" class="text-blue-500 underline">Go back</a>
                </p>
                <p> <?= $note['body'] ?></p>

            </div>
        </div>
    </main>
<?php require('views/parciales/footer.php') ?>