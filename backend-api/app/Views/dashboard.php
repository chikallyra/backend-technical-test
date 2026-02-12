<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang | Aero Portal</title>
    <style>
        :root {
            --aero-blue: #00a8ff;
            --aero-green: #44bd32;
            --glass-bg: rgba(255, 255, 255, 0.4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', 'Frutiger', sans-serif;
        }

        body {
            /* Background gradasi dinamis khas Frutiger Aero */
            background: radial-gradient(circle at top left, #81ecec, #74b9ff);
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        /* Ornamen Gelembung (Bubbles) */
        .bubble {
            position: absolute;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            pointer-events: none;
            box-shadow: inset -5px -5px 15px rgba(255, 255, 255, 0.3);
            animation: float 20s infinite linear;
        }

        @keyframes float {
            from { transform: translateY(100vh) scale(1); }
            to { transform: translateY(-20vh) scale(1.2); }
        }

        .welcome-container {
            position: relative;
            width: 90%;
            max-width: 500px;
            padding: 40px;
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.6);
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 
                        inset 0 0 20px rgba(255, 255, 255, 0.5);
            text-align: center;
            z-index: 10;
        }

        /* Efek Glossy pada kartu */
        .welcome-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.4), transparent);
            border-radius: 30px 30px 0 0;
            pointer-events: none;
        }

        .icon-wrapper {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #f5f6fa, #dcdde1);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 5px 5px 15px rgba(0,0,0,0.1), 
                        -5px -5px 15px rgba(255,255,255,0.8);
            border: 1px solid rgba(255,255,255,0.8);
        }

        .icon-wrapper span {
            font-size: 45px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        h1 {
            color: #2f3640;
            font-weight: 300;
            font-size: 32px;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(255, 255, 255, 0.8);
        }

        strong {
            color: var(--aero-blue);
            font-weight: 600;
        }

        p {
            color: #353b48;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn {
            padding: 14px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .btn-main {
            background: linear-gradient(to bottom, #00d2ff, #3a7bd5);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .btn-main:hover {
            box-shadow: 0 6px 20px rgba(58, 123, 213, 0.4);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.8);
            color: #2f3640;
            border: 1px solid rgba(255, 255, 255, 1);
        }

        .btn-outline:hover {
            background: white;
            transform: translateY(-2px);
        }

        .logout-btn {
            margin-top: 25px;
            display: inline-block;
            color: #2f3640;
            font-size: 14px;
            opacity: 0.7;
            text-decoration: none;
        }

        .logout-btn:hover {
            opacity: 1;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Animasi Gelembung -->
    <script>
        for (let i = 0; i < 15; i++) {
            let b = document.createElement('div');
            b.className = 'bubble';
            let size = Math.random() * 60 + 20 + 'px';
            b.style.width = size;
            b.style.height = size;
            b.style.left = Math.random() * 100 + 'vw';
            b.style.animationDuration = Math.random() * 10 + 10 + 's';
            b.style.animationDelay = Math.random() * 5 + 's';
            document.body.appendChild(b);
        }
    </script>

    <div class="welcome-container">
        <div class="icon-wrapper">
            <span>🌐</span>
        </div>
        
        <h1>Halo, <strong id="user-name">Pengguna</strong></h1>
        <p>Selamat datang kembali di sistem Aero. <br>Semuanya sudah siap untuk Anda hari ini.</p>

        <div class="button-group">
            <a href="#" class="btn btn-main">Mulai Eksplorasi</a>
            <a href="#" class="btn btn-outline">Pengaturan Akun</a>
        </div>

        <a href="#" class="logout-btn">Keluar Sesi</a>
    </div>

    <script>
        // Simulasi data user
        const userName = "Andi Wijaya";
        document.getElementById('user-name').textContent = userName;
    </script>
</body>
</html>