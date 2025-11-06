<?php require('parciales/head.php') ?>

<?php require('parciales/nav.php') ?>
    <main>
            <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                <?php require('parciales/banner.php') ?>
                <div class="text-center">
                    <p>Hola, <?= $_SESSION['user']['email'] ?? 'Guest' ?>. Bienvenido a la pagina principal</p>
                </div>
            </div>
    </main>
<?php require('parciales/footer.php') ?>