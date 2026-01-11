<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Metrochilon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #dc2626;
            --primary-light: #ef4444;
            --bg: #0a0a0f;
            --card: rgba(255, 255, 255, 0.95);
            --text: #1f2937;
            --muted: #6b7280;
            --border: rgba(220, 38, 38, 0.2);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
            position: relative;
        }
        
        /* Animated Background - Telecommunication Theme */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }
        
        /* Signal Waves */
        .signal-wave {
            position: absolute;
            border-radius: 50%;
            border: 2px solid rgba(220, 38, 38, 0.1);
            animation: pulse 4s ease-in-out infinite;
        }
        
        .signal-wave:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .signal-wave:nth-child(2) {
            width: 400px;
            height: 400px;
            top: 20%;
            right: 15%;
            animation-delay: 1s;
        }
        
        .signal-wave:nth-child(3) {
            width: 250px;
            height: 250px;
            bottom: 15%;
            left: 20%;
            animation-delay: 2s;
        }
        
        .signal-wave:nth-child(4) {
            width: 350px;
            height: 350px;
            bottom: 10%;
            right: 10%;
            animation-delay: 3s;
        }
        
        @@keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.1;
            }
        }
        
        /* Network Nodes */
        .network-node {
            position: absolute;
            width: 8px;
            height: 8px;
            background: var(--primary);
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(220, 38, 38, 0.5);
            animation: nodePulse 3s ease-in-out infinite;
        }
        
        .network-node:nth-child(5) { top: 15%; left: 25%; animation-delay: 0s; }
        .network-node:nth-child(6) { top: 35%; left: 60%; animation-delay: 0.5s; }
        .network-node:nth-child(7) { top: 60%; left: 30%; animation-delay: 1s; }
        .network-node:nth-child(8) { top: 75%; left: 70%; animation-delay: 1.5s; }
        .network-node:nth-child(9) { top: 45%; right: 25%; animation-delay: 2s; }
        
        @@keyframes nodePulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.8;
            }
            50% {
                transform: scale(1.5);
                opacity: 1;
            }
        }
        
        /* Connection Lines */
        .connection-line {
            position: absolute;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(220, 38, 38, 0.3), transparent);
            animation: lineFlow 4s linear infinite;
        }
        
        .connection-line:nth-child(10) {
            top: 20%;
            left: 25%;
            width: 200px;
            transform: rotate(25deg);
            animation-delay: 0s;
        }
        
        .connection-line:nth-child(11) {
            top: 50%;
            left: 30%;
            width: 180px;
            transform: rotate(-35deg);
            animation-delay: 1s;
        }
        
        .connection-line:nth-child(12) {
            top: 70%;
            right: 30%;
            width: 220px;
            transform: rotate(45deg);
            animation-delay: 2s;
        }
        
        @@keyframes lineFlow {
            0% {
                opacity: 0.2;
            }
            50% {
                opacity: 0.6;
            }
            100% {
                opacity: 0.2;
            }
        }
        
        /* Signal Bars */
        .signal-bars {
            position: absolute;
            display: flex;
            gap: 3px;
            align-items: flex-end;
        }
        
        .signal-bars:nth-child(13) {
            top: 25%;
            right: 20%;
        }
        
        .signal-bars:nth-child(14) {
            bottom: 25%;
            left: 15%;
        }
        
        .signal-bar {
            width: 4px;
            background: var(--primary);
            border-radius: 2px;
            animation: barGrow 2s ease-in-out infinite;
        }
        
        .signal-bar:nth-child(1) { height: 10px; animation-delay: 0s; }
        .signal-bar:nth-child(2) { height: 15px; animation-delay: 0.2s; }
        .signal-bar:nth-child(3) { height: 20px; animation-delay: 0.4s; }
        .signal-bar:nth-child(4) { height: 25px; animation-delay: 0.6s; }
        
        @@keyframes barGrow {
            0%, 100% {
                opacity: 0.4;
                transform: scaleY(0.8);
            }
            50% {
                opacity: 1;
                transform: scaleY(1);
            }
        }
        
        /* Main Container */
        .login-container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        
        .login-card {
            background: var(--card);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3),
                        0 0 0 1px rgba(255, 255, 255, 0.1);
            animation: cardFadeIn 0.6s ease-out;
        }
        
        @@keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }
        
        .logo h1 {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }
        
        .logo p {
            color: var(--muted);
            font-size: 14px;
            font-weight: 400;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            width: 20px;
            height: 20px;
            z-index: 1;
        }
        
        .input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid var(--border);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.8);
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            transition: all 0.3s ease;
            outline: none;
        }
        
        .input:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
        }
        
        .input::placeholder {
            color: var(--muted);
        }
        
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }
        
        .password-toggle:hover {
            color: var(--primary);
        }
        
        .error-message {
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #dc2626;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            animation: shake 0.5s;
        }
        
        @@keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(220, 38, 38, 0.3);
            margin-top: 8px;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(220, 38, 38, 0.4);
        }
        
        .btn-submit:active {
            transform: translateY(0);
        }
        
        .hint {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: 12px;
            color: var(--muted);
            line-height: 1.6;
        }
        
        @media (max-width: 640px) {
            .login-card {
                padding: 32px 24px;
            }
            
            .logo h1 {
                font-size: 24px;
            }
            
            .signal-wave {
                width: 200px !important;
                height: 200px !important;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="signal-wave"></div>
        <div class="signal-wave"></div>
        <div class="signal-wave"></div>
        <div class="signal-wave"></div>
        
        <div class="network-node"></div>
        <div class="network-node"></div>
        <div class="network-node"></div>
        <div class="network-node"></div>
        <div class="network-node"></div>
        
        <div class="connection-line"></div>
        <div class="connection-line"></div>
        <div class="connection-line"></div>
        
        <div class="signal-bars">
            <div class="signal-bar"></div>
            <div class="signal-bar"></div>
            <div class="signal-bar"></div>
            <div class="signal-bar"></div>
        </div>
        <div class="signal-bars">
            <div class="signal-bar"></div>
            <div class="signal-bar"></div>
            <div class="signal-bar"></div>
            <div class="signal-bar"></div>
        </div>
    </div>
    
    <!-- Login Form -->
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <div class="logo-icon">
                    @if(file_exists(public_path('images/logo/logo.png')))
                        <img src="{{ asset('images/logo/logo.png') }}" alt="Logo MPG">
                    @elseif(file_exists(public_path('images/logo/logo.jpg')))
                        <img src="{{ asset('images/logo/logo.jpg') }}" alt="Logo MPG">
                    @elseif(file_exists(public_path('images/logo/logo.svg')))
                        <img src="{{ asset('images/logo/logo.svg') }}" alt="Logo MPG">
                    @else
                        <!-- Fallback jika logo belum diupload -->
                        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #dc2626, #ef4444); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: white; font-size: 28px; font-weight: 700; box-shadow: 0 8px 24px rgba(220, 38, 38, 0.3);">
                            M
                        </div>
                    @endif
                </div>
                <h1>Metrochilon</h1>
                <p>Sistem Absensi & Pelacakan Lokasi</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf
                
                <div class="form-group">
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input 
                            class="input" 
                            type="email" 
                            name="email" 
                            placeholder="Email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                        >
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                        <input 
                            class="input" 
                            id="password" 
                            type="password" 
                            name="password" 
                            placeholder="Password" 
                            required
                        >

                        <button 
                            type="button" 
                            class="password-toggle" 
                            onclick="togglePassword()"
                            aria-label="Toggle password visibility"
                        >
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                @if ($errors->any())
                    <div class="error-message">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                
                <button type="submit" class="btn-submit">
                    Masuk
                </button>
            </form>
            
            <div class="hint">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai Karyawan</a>
            </div>
        </div>
    </div>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = event.currentTarget;
            const icon = toggleBtn.querySelector('svg');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>
                `;
            } else {
                passwordInput.type = 'password';
                icon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                `;
            }
        }
        
        // Prevent form resubmission on refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>
