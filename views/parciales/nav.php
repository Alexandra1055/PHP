<nav aria-label="Global" class="flex items-center justify-between p-6 lg:px-8">
    <div class="flex lg:flex-1">
        <a href="#" class="-m-1.5 p-1.5">
            <span class="sr-only">Your Company</span>
            <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="" class="h-8 w-auto dark:hidden" />
            <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="" class="h-8 w-auto not-dark:hidden" />
        </a>
    </div>
    <div class="flex lg:hidden">
        <button type="button" command="show-modal" commandfor="mobile-menu" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700 dark:text-gray-200">
            <span class="sr-only">Open main menu</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </div>
    <div class="hidden lg:flex lg:gap-x-12">
        <a href="/" class="<?= $_SERVER['REQUEST_URI'] === '/' ? 'bg-gray-300 text-white' : 'text-gray-900' ?>-mx-3 block rounded-lg px-3 py-2 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">Home</a>
        <a href="/about.php" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">About</a>
        <a href="/contacto.php" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">Contacto</a</div>
    </div>
    <div class="hidden lg:flex lg:flex-1 lg:justify-end">
        <a href="#" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Log in <span aria-hidden="true">&rarr;</span></a>
    </div>
</nav>
</header>