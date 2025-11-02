<?php require('parciales/head.php') ?>

<?php require('parciales/nav.php') ?>
    <main>
        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
            <?php require('parciales/banner.php') ?>
            <div class="text-center">
                <form method="POST">
                    <div class="space-y-12">
                        <div class="border-b border-white/10 pb-12">
                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="col-span-full">
                                    <label for="body" class="block text-sm/6 font-medium text-black">Body</label>
                                    <div class="mt-2">
                                        <textarea id="body" name="bod" rows="3" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" placeholder="Idea para nota..."></textarea>
                                        <?php if (isset($errors['body'])) : ?>
                                        <p class="text-red-500 text-xs mt-2"><?= $errors['body'] ?></p>
                                        <?php endif ?>
                                    </div>
                                </div>

                            </div>
                        </div>


                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="button" class="text-sm/6 font-semibold text-black">Cancel</button>
                        <button type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-black focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </main>
<?php require('parciales/footer.php') ?>