<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- App Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* =====================================================
           FLOATING CHAT BUTTON — animasi + glass
        ===================================================== */
        #chatToggle {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 9999;
            width: 58px;
            height: 58px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
            background: linear-gradient(135deg, #2563eb 0%, #6366f1 100%);
            box-shadow:
                0 6px 24px rgba(99,102,241,0.5),
                0 2px 8px rgba(37,99,235,0.3),
                inset 0 1px 0 rgba(255,255,255,0.25);
            transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s;
            animation: floatBtn 3s ease-in-out infinite;
            backdrop-filter: blur(4px);
        }

        #chatToggle:hover {
            transform: scale(1.1) translateY(-3px) !important;
            box-shadow: 0 12px 32px rgba(99,102,241,0.6), 0 4px 12px rgba(37,99,235,0.4);
            animation-play-state: paused;
        }

        #chatToggle.active {
            animation: none;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            box-shadow: 0 6px 24px rgba(239,68,68,0.5);
        }

        @keyframes floatBtn {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }

        /* Pulse ring behind button */
        #chatToggle::before {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            background: rgba(99,102,241,0.25);
            animation: ringPulse 2.5s ease-out infinite;
            z-index: -1;
        }

        @keyframes ringPulse {
            0%   { transform: scale(1); opacity: 0.7; }
            70%  { transform: scale(1.4); opacity: 0; }
            100% { transform: scale(1.4); opacity: 0; }
        }

        /* Notification badge */
        #chatBadge {
            position: absolute;
            top: -3px;
            right: -3px;
            width: 18px;
            height: 18px;
            background: #ef4444;
            border: 2px solid #fff;
            border-radius: 50%;
            font-size: 10px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: popIn 0.3s cubic-bezier(0.34,1.56,0.64,1);
        }

        @keyframes popIn {
            from { transform: scale(0); }
            to   { transform: scale(1); }
        }

        /* =====================================================
           CHAT PANEL — sliding glass panel
        ===================================================== */
        #chatPanel {
            position: fixed;
            bottom: 100px;
            right: 28px;
            z-index: 9998;
            width: 360px;
            height: 520px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow:
                0 20px 60px rgba(31,38,135,0.25),
                0 4px 16px rgba(99,102,241,0.15),
                inset 0 1px 0 rgba(255,255,255,0.6);
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(248,250,255,0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);

            /* Hidden state */
            transform: scale(0.88) translateY(16px);
            opacity: 0;
            pointer-events: none;
            transform-origin: bottom right;
            transition:
                transform 0.28s cubic-bezier(0.34,1.36,0.64,1),
                opacity 0.22s ease;
        }

        #chatPanel.open {
            transform: scale(1) translateY(0);
            opacity: 1;
            pointer-events: all;
        }

        #chatFrame {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }

        /* Responsive */
        @media (max-width: 480px) {
            #chatPanel {
                width: calc(100vw - 20px);
                height: 70vh;
                right: 10px;
                bottom: 90px;
            }
            #chatToggle {
                right: 16px;
                bottom: 16px;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col bg-white">

        @include('layouts.partialsapp.navbar')

        <main>
            {{ $slot }}
        </main>

        @include('layouts.partialsapp.footer')

    </div>

    @stack('scripts')

    <!-- =====================================================
         FLOATING CHAT BUTTON (CUSTOM — no default bubble)
    ====================================================== -->
    <button id="chatToggle" aria-label="Buka Chat Support" title="Chat Support">
        <i class="fas fa-comment-dots" id="chatIcon"></i>
        <span id="chatBadge">1</span>
    </button>

    <!-- =====================================================
         CHAT PANEL — iframe ke /botman/chat
         (widget dimuat sekali, tidak reload saat buka/tutup)
    ====================================================== -->
    <div id="chatPanel" role="dialog" aria-label="Jendela Chat Support">
        <iframe
            id="chatFrame"
            src="{{ route('botman.chat') }}"
            title="Ticketing Chat Support"
            loading="lazy"
        ></iframe>
    </div>

    <script>
    (function () {
        'use strict';

        const toggleBtn = document.getElementById('chatToggle');
        const chatIcon  = document.getElementById('chatIcon');
        const chatPanel = document.getElementById('chatPanel');
        const chatBadge = document.getElementById('chatBadge');

        let isOpen = false;

        // Toggle panel open/close
        toggleBtn.addEventListener('click', function () {
            isOpen = !isOpen;

            if (isOpen) {
                chatPanel.classList.add('open');
                toggleBtn.classList.add('active');
                chatIcon.className = 'fas fa-times';

                // Hapus badge saat dibuka
                if (chatBadge) chatBadge.style.display = 'none';
            } else {
                chatPanel.classList.remove('open');
                toggleBtn.classList.remove('active');
                chatIcon.className = 'fas fa-comment-dots';
            }
        });

        // Tutup panel jika klik di luar
        document.addEventListener('click', function (e) {
            if (isOpen && !chatPanel.contains(e.target) && !toggleBtn.contains(e.target)) {
                chatPanel.classList.remove('open');
                toggleBtn.classList.remove('active');
                chatIcon.className = 'fas fa-comment-dots';
                isOpen = false;
            }
        });
    })();
    </script>

</body>
</html>
