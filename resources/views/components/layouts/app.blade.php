@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? $title.' — NLG Inventory' : 'NLG Inventory' }}</title>

    <script>
        (function () {
            var stored = localStorage.getItem('theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (stored === 'dark' || (!stored && prefersDark)) {
                document.documentElement.classList.add('dark');
            }

            function dismissAlert(alert) {
                alert.classList.add('opacity-0');
                setTimeout(function () {
                    alert.remove();
                }, 300);
            }

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('[data-alert]').forEach(function (alert) {
                    setTimeout(function () {
                        dismissAlert(alert);
                    }, 4500);
                });
            });

            document.addEventListener('click', function (event) {
                var alertClose = event.target.closest('[data-alert-close]');
                if (alertClose) {
                    var alert = alertClose.closest('[data-alert]');
                    if (alert) dismissAlert(alert);
                    return;
                }

                if (event.target.closest('#theme-toggle')) {
                    var isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('theme', isDark ? 'dark' : 'light');
                    return;
                }

                if (event.target.closest('#sidebar-toggle') || event.target.closest('#sidebar-backdrop')) {
                    document.getElementById('sidebar').classList.toggle('-translate-x-full');
                    document.getElementById('sidebar-backdrop').classList.toggle('hidden');
                    return;
                }

                var opener = event.target.closest('[data-modal-open]');
                if (opener) {
                    var modal = document.getElementById(opener.getAttribute('data-modal-open'));
                    if (modal) {
                        var action = opener.getAttribute('data-action');
                        if (action) {
                            var form = modal.querySelector('form');
                            if (form) form.action = action;
                        }

                        var name = opener.getAttribute('data-name');
                        if (name) {
                            var nameEl = modal.querySelector('[data-modal-name]');
                            if (nameEl) nameEl.textContent = name;
                        }

                        modal.classList.remove('hidden');
                    }
                    return;
                }

                var closer = event.target.closest('[data-modal-close]');
                if (closer) {
                    var modal = closer.closest('[data-modal]');
                    if (modal) modal.classList.add('hidden');
                }
            });
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-neutral-50 text-neutral-900 dark:bg-neutral-950 dark:text-neutral-50 font-sans antialiased">

    <aside id="sidebar" class="sidebar -translate-x-full lg:translate-x-0">
        <div class="flex h-14 items-center gap-2 border-b border-neutral-200 px-4 dark:border-neutral-800">
            <span class="font-display text-lg font-extrabold text-brand-600 dark:text-brand-dark-accent">NLG</span>
            <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Inventory</span>
        </div>

        <nav class="flex flex-col gap-1 p-3">
            <a
                href="{{ route('products.index') }}"
                class="sidebar-link {{ request()->routeIs('products.*') ? 'sidebar-link-active' : '' }}"
            >
                <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                </svg>
                Products
            </a>
        </nav>
    </aside>

    <div id="sidebar-backdrop" class="sidebar-backdrop hidden"></div>

    <div class="lg:pl-56">
        <header class="topbar">
            <div class="flex h-14 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        id="sidebar-toggle"
                        aria-label="Toggle sidebar"
                        class="topbar-icon-btn lg:hidden"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5m-16.5 5.25h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    @if ($title)
                        <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ $title }}</span>
                    @endif
                </div>

                <button
                    type="button"
                    id="theme-toggle"
                    aria-label="Toggle dark mode"
                    class="topbar-icon-btn"
                >
                    <svg class="h-4 w-4 dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z" />
                    </svg>
                    <svg class="hidden h-4 w-4 dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1.5m0 15V21m9-9h-1.5m-15 0H3m15.36-6.36-1.06 1.06M6.7 17.3l-1.06 1.06m12.72 0-1.06-1.06M6.7 6.7 5.64 5.64M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                    </svg>
                </button>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>

        <footer class="border-t border-neutral-200 bg-white px-4 py-6 text-center text-sm text-neutral-500 dark:border-neutral-800 dark:bg-neutral-900 dark:text-neutral-400">
            © {{ date('Y') }} NLG Inventory. Built by Muhammad Sulthan Al Fahrezi.
        </footer>
    </div>
</body>
</html>
