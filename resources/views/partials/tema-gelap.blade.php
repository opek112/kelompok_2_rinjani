<script>
    (function () {
        try {
            var pilihan = localStorage.getItem('tema');
            var gelap = pilihan ? pilihan === 'gelap' : window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.classList.toggle('dark', gelap);
        } catch (e) {
            /* localStorage tidak tersedia */
        }
    })();

    function gantiTema() {
        var gelap = document.documentElement.classList.toggle('dark');

        try {
            localStorage.setItem('tema', gelap ? 'gelap' : 'terang');
        } catch (e) {
            /* abaikan */
        }
    }
</script>

<style>
    html { scroll-behavior: smooth; }
    html.dark { color-scheme: dark; }

    .ikon-gelap { display: none; }
    .dark .ikon-terang { display: none; }
    .dark .ikon-gelap { display: inline-block; }

    body,
    .bg-white,
    .bg-gray-50,
    .bg-gray-100,
    header,
    aside,
    footer {
        transition: background-color .25s ease, border-color .25s ease, color .25s ease;
    }

    .dark body { background-color: #0b1210; color: #e4ece8; }
    .dark .bg-white { background-color: #131d19 !important; }
    .dark .bg-brand-light { background-color: #0b1210 !important; }
    .dark .bg-\[\#f8f9fa\],
    .dark .bg-\[\#F6F5F1\] { background-color: #0b1210 !important; }
    .dark .bg-gray-50 { background-color: #0f1815 !important; }
    .dark .bg-gray-100 { background-color: #1a2520 !important; }
    .dark .bg-gray-200 { background-color: #26332d !important; }
    .dark .bg-\[\#1e4035\],
    .dark .bg-brand-dark { background-color: #103026 !important; }
    .dark .bg-white\/90,
    .dark .bg-white\/95 { background-color: rgba(19, 29, 25, .92) !important; }
    .dark .bg-white\/10 { background-color: rgba(255, 255, 255, .06) !important; }

    .dark .border-gray-100,
    .dark .border-gray-200,
    .dark .border-gray-300,
    .dark .border-white\/10 { border-color: #26332d !important; }
    .dark .divide-gray-100 > :not([hidden]) ~ :not([hidden]),
    .dark .divide-gray-200 > :not([hidden]) ~ :not([hidden]) { border-color: #26332d !important; }
    .dark .border-brand-dark { border-color: #d9a267 !important; }

    .dark .text-gray-900,
    .dark .text-gray-800 { color: #f2f7f4 !important; }
    .dark .text-gray-700,
    .dark .text-gray-600 { color: #c2cec8 !important; }
    .dark .text-gray-500,
    .dark .text-gray-400 { color: #94a49c !important; }
    .dark .text-brand-dark { color: #e9f2ee !important; }

    .dark .bg-green-50,
    .dark .bg-green-50\/50,
    .dark .bg-green-50\/40 { background-color: #10241b !important; }
    .dark .bg-orange-50,
    .dark .bg-orange-50\/50 { background-color: #2a1c10 !important; }
    .dark .bg-red-50 { background-color: #2a1414 !important; }
    .dark .bg-yellow-50,
    .dark .bg-yellow-100 { background-color: #2a2410 !important; }
    .dark .bg-blue-50 { background-color: #10202a !important; }

    .dark input,
    .dark select,
    .dark textarea {
        background-color: #0f1815 !important;
        border-color: #2b3a33 !important;
        color: #e6eeea !important;
    }

    .dark .shadow,
    .dark .shadow-sm,
    .dark .shadow-md,
    .dark .shadow-lg,
    .dark .shadow-xl,
    .dark .shadow-2xl {
        box-shadow: 0 18px 40px -26px rgba(0, 0, 0, .95) !important;
    }

    .dark .hover\:bg-gray-50:hover,
    .dark .hover\:bg-gray-100:hover { background-color: #1a2520 !important; }

    .dark .ring-orange-500 { --tw-ring-color: #f27a21 !important; }

    .dark .form-panel { background-color: #0f1815 !important; }

    /* Aksen modern yang tetap mempertahankan bentuk asli */
    .kartu-modern { transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
    .kartu-modern:hover { transform: translateY(-2px); box-shadow: 0 18px 40px -28px rgba(26, 54, 38, .55); }
    .dark .kartu-modern:hover { box-shadow: 0 18px 40px -24px rgba(0, 0, 0, .9); }
</style>
