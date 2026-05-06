<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketing Support Chat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden;
            background: transparent;
            font-family: 'Inter', sans-serif;
        }

        /* =====================================================
           CHAT CONTAINER — Glass Morphism
        ===================================================== */
        .chat-wrapper {
            display: flex;
            flex-direction: column;
            height: 100vh;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 16px;
            overflow: hidden;
            box-shadow:
                0 8px 32px rgba(31, 38, 135, 0.2),
                inset 0 1px 0 rgba(255,255,255,0.3);
        }

        /* =====================================================
           HEADER
        ===================================================== */
        .chat-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.92) 0%, rgba(99, 102, 241, 0.88) 100%);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255,255,255,0.15);
            flex-shrink: 0;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            border: 2px solid rgba(255,255,255,0.4);
        }

        .header-info {
            flex: 1;
        }

        .header-title {
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.01em;
        }

        .header-status {
            color: rgba(255,255,255,0.75);
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 2px;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            background: #4ade80;
            border-radius: 50%;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(0.85); }
        }

        /* =====================================================
           MESSAGES AREA
        ===================================================== */
        #botmanMessages {
            flex: 1;
            overflow-y: auto;
            padding: 16px 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            scrollbar-width: thin;
            scrollbar-color: rgba(99,102,241,0.3) transparent;
        }

        #botmanMessages::-webkit-scrollbar {
            width: 4px;
        }
        #botmanMessages::-webkit-scrollbar-thumb {
            background: rgba(99,102,241,0.35);
            border-radius: 4px;
        }

        /* Message bubbles */
        .msg {
            display: flex;
            gap: 8px;
            animation: fadeUp 0.25s ease-out;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .msg.bot { align-self: flex-start; align-items: flex-end; }
        .msg.user { align-self: flex-end; flex-direction: row-reverse; }

        .msg-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #fff;
            flex-shrink: 0;
        }

        .bubble {
            max-width: 78%;
            padding: 10px 13px;
            border-radius: 16px;
            font-size: 13px;
            line-height: 1.55;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .bot .bubble {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(8px);
            color: #1e1b4b;
            border-bottom-left-radius: 4px;
            border: 1px solid rgba(99,102,241,0.12);
            box-shadow: 0 2px 8px rgba(99,102,241,0.08);
        }

        .user .bubble {
            background: linear-gradient(135deg, #2563eb, #6366f1);
            color: #fff;
            border-bottom-right-radius: 4px;
            box-shadow: 0 2px 12px rgba(99,102,241,0.35);
        }

        /* Typing indicator */
        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 10px 13px;
            background: rgba(255,255,255,0.65);
            border-radius: 16px;
            border-bottom-left-radius: 4px;
            width: fit-content;
            border: 1px solid rgba(99,102,241,0.12);
        }

        .typing-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #6366f1;
            animation: typingBounce 1.2s infinite;
        }

        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes typingBounce {
            0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
            30% { transform: translateY(-5px); opacity: 1; }
        }

        /* =====================================================
           INPUT AREA
        ===================================================== */
        .chat-input-area {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            padding: 12px 14px;
            background: rgba(255,255,255,0.45);
            backdrop-filter: blur(8px);
            border-top: 1px solid rgba(99,102,241,0.12);
            flex-shrink: 0;
        }

        #botmanInput {
            flex: 1;
            border: 1.5px solid rgba(99,102,241,0.25);
            border-radius: 22px;
            padding: 9px 16px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            background: rgba(255,255,255,0.8);
            color: #1e1b4b;
            resize: none;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            min-height: 40px;
            max-height: 100px;
            overflow-y: auto;
        }

        #botmanInput:focus {
            border-color: rgba(99,102,241,0.55);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }

        #botmanInput::placeholder {
            color: rgba(99,102,241,0.45);
        }

        #botmanSend {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: linear-gradient(135deg, #2563eb, #6366f1);
            color: #fff;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 3px 12px rgba(99,102,241,0.35);
        }

        #botmanSend:hover {
            transform: scale(1.08);
            box-shadow: 0 5px 18px rgba(99,102,241,0.5);
        }

        #botmanSend:active { transform: scale(0.95); }
        #botmanSend:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

        /* Quick replies */
        .quick-replies {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            padding: 6px 14px 0;
        }

        .quick-btn {
            background: rgba(99,102,241,0.1);
            border: 1px solid rgba(99,102,241,0.25);
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 12px;
            color: #4338ca;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
            font-family: 'Inter', sans-serif;
        }

        .quick-btn:hover {
            background: rgba(99,102,241,0.2);
            transform: translateY(-1px);
        }
    </style>
</head>

<body>
<div class="chat-wrapper">

    {{-- HEADER --}}
    <div class="chat-header">
        <div class="avatar">🤖</div>
        <div class="header-info">
            <div class="header-title">Ticketing Support</div>
            <div class="header-status">
                <span class="status-dot"></span>
                <span>Online • Siap Membantu</span>
            </div>
        </div>
    </div>

    {{-- MESSAGES --}}
    <div id="botmanMessages">
        {{-- Pesan sambutan awal --}}
        <div class="msg bot">
            <div class="msg-avatar">🤖</div>
            <div class="bubble">👋 Halo! Selamat datang di <strong>Ticketing Support</strong>.

Saya siap membantu Anda. Ketik pertanyaan atau pilih topik di bawah:</div>
        </div>
    </div>

    {{-- QUICK REPLIES --}}
    <div class="quick-replies" id="quickReplies">
        <button class="quick-btn" onclick="sendQuick('tiket')">🎟️ Tiket Saya</button>
        <button class="quick-btn" onclick="sendQuick('event')">📅 Event</button>
        <button class="quick-btn" onclick="sendQuick('harga')">💰 Harga</button>
        <button class="quick-btn" onclick="sendQuick('bantuan')">🆘 Bantuan</button>
        <button class="quick-btn" onclick="sendQuick('kontak')">📞 Kontak</button>
    </div>

    {{-- INPUT AREA --}}
    <div class="chat-input-area">
        <textarea
            id="botmanInput"
            placeholder="Ketik pesan Anda..."
            rows="1"
            autocomplete="off"
        ></textarea>
        <button id="botmanSend" title="Kirim">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>

</div>

<script>
    const messagesEl  = document.getElementById('botmanMessages');
    const inputEl     = document.getElementById('botmanInput');
    const sendBtn     = document.getElementById('botmanSend');
    const CHAT_SERVER = '/botman';

    // ── Auto-resize textarea ───────────────────────────────
    inputEl.addEventListener('input', () => {
        inputEl.style.height = 'auto';
        inputEl.style.height = Math.min(inputEl.scrollHeight, 100) + 'px';
    });

    // ── Send on Enter (Shift+Enter = newline) ──────────────
    inputEl.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    sendBtn.addEventListener('click', sendMessage);

    // ── Quick reply helper ─────────────────────────────────
    function sendQuick(text) {
        inputEl.value = text;
        sendMessage();
    }

    // ── Append message bubble ──────────────────────────────
    function appendMessage(text, role) {
        const wrap = document.createElement('div');
        wrap.className = 'msg ' + role;

        if (role === 'bot') {
            const av = document.createElement('div');
            av.className = 'msg-avatar';
            av.textContent = '🤖';
            wrap.appendChild(av);
        }

        const bubble = document.createElement('div');
        bubble.className = 'bubble';
        // Render bold via simple markdown-like replacement
        bubble.innerHTML = escapeHtml(text)
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>');
        wrap.appendChild(bubble);

        messagesEl.appendChild(wrap);
        messagesEl.scrollTop = messagesEl.scrollHeight;
        return wrap;
    }

    function escapeHtml(str) {
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    // ── Typing indicator ───────────────────────────────────
    function showTyping() {
        const wrap = document.createElement('div');
        wrap.className = 'msg bot';
        wrap.id = 'typingIndicator';

        const av = document.createElement('div');
        av.className = 'msg-avatar';
        av.textContent = '🤖';
        wrap.appendChild(av);

        const dots = document.createElement('div');
        dots.className = 'typing-indicator';
        for (let i = 0; i < 3; i++) {
            const d = document.createElement('div');
            d.className = 'typing-dot';
            dots.appendChild(d);
        }
        wrap.appendChild(dots);
        messagesEl.appendChild(wrap);
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    function hideTyping() {
        const el = document.getElementById('typingIndicator');
        if (el) el.remove();
    }

    // ── Main send function ─────────────────────────────────
    async function sendMessage() {
        const text = inputEl.value.trim();
        if (!text) return;

        // Reset input
        inputEl.value = '';
        inputEl.style.height = 'auto';
        sendBtn.disabled = true;

        // Show user bubble
        appendMessage(text, 'user');

        // Show typing
        showTyping();

        try {
            const res = await fetch(CHAT_SERVER, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message: text, driver: 'web' }),
            });

            if (!res.ok) throw new Error('Server error ' + res.status);

            const data = await res.json();
            hideTyping();

            // BotMan Web Driver returns array of messages
            const messages = Array.isArray(data.messages) ? data.messages : [];
            if (messages.length === 0) {
                appendMessage('Maaf, tidak ada respons dari server.', 'bot');
            } else {
                messages.forEach(m => {
                    const txt = typeof m === 'string' ? m : (m.text || m.message || JSON.stringify(m));
                    appendMessage(txt, 'bot');
                });
            }

        } catch (err) {
            hideTyping();
            appendMessage('⚠️ Koneksi gagal. Silakan coba lagi.', 'bot');
            console.error('[BotMan]', err);
        } finally {
            sendBtn.disabled = false;
            inputEl.focus();
        }
    }
</script>
</body>
</html>
