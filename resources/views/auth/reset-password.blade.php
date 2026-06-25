<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password — Taleem ul Quran Institute</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --green-900: #06402b;
            --green-700: #0b6e4f;
            --green-500: #14916b;
            --gold:      #c79a3a;
            --gold-soft: #e7cf8f;
            --cream:     #f6f2e8;
            --ink:       #1c2620;
            --muted:     #6b7670;
            --line:      #e3ddcf;
            --danger:    #c0392b;
            --white:     #ffffff;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--green-900);
            background-image:
                radial-gradient(circle at 12% 18%, rgba(199,154,58,0.10), transparent 38%),
                radial-gradient(circle at 88% 82%, rgba(20,145,107,0.18), transparent 42%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: var(--ink);
        }

        /* Subtle Islamic geometric texture behind the card */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image:
                repeating-linear-gradient(45deg, rgba(255,255,255,0.025) 0 2px, transparent 2px 22px),
                repeating-linear-gradient(-45deg, rgba(255,255,255,0.025) 0 2px, transparent 2px 22px);
            pointer-events: none;
        }

        .card {
            position: relative;
            width: 100%;
            max-width: 440px;
            background: var(--cream);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(0,0,0,0.35);
            animation: rise 0.5s cubic-bezier(.2,.7,.3,1) both;
        }

        @keyframes rise {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ---- Header ---- */
        .head {
            background: linear-gradient(160deg, var(--green-700), var(--green-900));
            padding: 34px 36px 30px;
            text-align: center;
            position: relative;
        }
        .head::after {
            content: "";
            position: absolute;
            left: 0; right: 0; bottom: 0;
            height: 4px;
            background: repeating-linear-gradient(90deg,
                var(--gold) 0 16px, transparent 16px 26px);
            opacity: .8;
        }

        .crest {
            width: 54px; height: 54px;
            margin: 0 auto 14px;
            border: 2px solid var(--gold-soft);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--gold-soft);
            font-size: 22px;
            position: relative;
        }
        .crest::before {
            content: "";
            position: absolute; inset: 4px;
            border: 1px solid rgba(231,207,143,0.45);
            border-radius: 50%;
        }

        .head h1 {
            font-family: 'Amiri', serif;
            color: var(--white);
            font-size: 26px;
            font-weight: 700;
            letter-spacing: .3px;
            line-height: 1.15;
        }
        .head .sub {
            color: var(--gold-soft);
            font-size: 12px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin-top: 6px;
        }

        /* ---- Body ---- */
        .body { padding: 32px 36px 36px; }

        .body h2 {
            font-family: 'Amiri', serif;
            font-size: 22px;
            color: var(--green-900);
            text-align: center;
            margin-bottom: 4px;
        }
        .body .lead {
            text-align: center;
            color: var(--muted);
            font-size: 13.5px;
            margin-bottom: 26px;
            line-height: 1.5;
        }

        .field { margin-bottom: 18px; }
        .field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--green-900);
            margin-bottom: 7px;
            letter-spacing: .2px;
        }

        .input-wrap { position: relative; }
        .input-wrap .icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--green-500);
            font-size: 14px;
            pointer-events: none;
        }
        .input-wrap input {
            width: 100%;
            padding: 13px 44px 13px 40px;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            background: var(--white);
            font-size: 14.5px;
            color: var(--ink);
            font-family: inherit;
            transition: border-color .18s, box-shadow .18s;
        }
        .input-wrap input:focus {
            outline: none;
            border-color: var(--green-500);
            box-shadow: 0 0 0 3px rgba(20,145,107,0.14);
        }
        .input-wrap input:read-only {
            background: #efeadd;
            color: var(--muted);
            cursor: not-allowed;
        }

        .toggle {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: var(--muted);
            cursor: pointer;
            font-size: 14px;
            padding: 4px;
        }
        .toggle:hover { color: var(--green-700); }

        .err {
            color: var(--danger);
            font-size: 12px;
            margin-top: 6px;
            display: none;
        }
        .field.invalid input { border-color: var(--danger); }
        .field.invalid .err { display: block; }

        /* Strength meter */
        .meter {
            height: 4px;
            border-radius: 4px;
            background: var(--line);
            margin-top: 9px;
            overflow: hidden;
        }
        .meter span {
            display: block; height: 100%; width: 0;
            transition: width .25s, background .25s;
            border-radius: 4px;
        }

        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--green-700), var(--green-500));
            color: var(--white);
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            letter-spacing: .3px;
            cursor: pointer;
            margin-top: 8px;
            transition: transform .12s, box-shadow .2s, opacity .2s;
            box-shadow: 0 8px 20px rgba(11,110,79,0.30);
        }
        .btn:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 12px 26px rgba(11,110,79,0.38); }
        .btn:active:not(:disabled) { transform: translateY(0); }
        .btn:disabled { opacity: .65; cursor: not-allowed; }
        .btn .spin { display: none; }
        .btn.loading .label { display: none; }
        .btn.loading .spin { display: inline-block; animation: rot 0.7s linear infinite; }
        @keyframes rot { to { transform: rotate(360deg); } }

        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--green-700);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
        }
        .back:hover { text-decoration: underline; }

        /* Success / error banners */
        .alert {
            display: none;
            align-items: flex-start;
            gap: 10px;
            padding: 13px 15px;
            border-radius: 10px;
            font-size: 13.5px;
            line-height: 1.45;
            margin-bottom: 20px;
        }
        .alert.show { display: flex; }
        .alert.ok  { background: #e3f4ec; color: #0b5e3f; border: 1px solid #b8e0cc; }
        .alert.bad { background: #fbe9e7; color: #9c2a1c; border: 1px solid #f1c4bd; }
        .alert i { margin-top: 1px; }

        @media (max-width: 480px) {
            .head { padding: 28px 24px 26px; }
            .body { padding: 28px 24px 30px; }
            .head h1 { font-size: 23px; }
        }
    </style>
</head>
<body>
    <main class="card">
        <header class="head">
            <div class="crest">&#9770;</div>
            <h1>Taleem ul Quran</h1>
            <div class="sub">Institute</div>
        </header>

        <section class="body">
            <h2>Reset Your Password</h2>
            <p class="lead">Choose a new password for your account to continue your learning journey.</p>

            <div id="alertOk" class="alert ok">
                <i class="fa">&#10003;</i>
                <span id="alertOkMsg">Password updated successfully.</span>
            </div>
            <div id="alertBad" class="alert bad">
                <i class="fa">&#9888;</i>
                <span id="alertBadMsg">Something went wrong.</span>
            </div>

            <form id="resetForm" novalidate>
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="field">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <span class="icon">&#9993;</span>
                        <input type="email" id="email" name="email"
                               value="{{ $email }}" readonly>
                    </div>
                </div>

                <div class="field" id="pwField">
                    <label for="password">New Password</label>
                    <div class="input-wrap">
                        <span class="icon">&#128274;</span>
                        <input type="password" id="password" name="password"
                               placeholder="Enter new password" autocomplete="new-password">
                        <button type="button" class="toggle" data-target="password" aria-label="Show password">&#128065;</button>
                    </div>
                    <div class="meter"><span id="meterBar"></span></div>
                    <div class="err" id="pwErr">Password must be at least 6 characters.</div>
                </div>

                <div class="field" id="cpwField">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="input-wrap">
                        <span class="icon">&#128274;</span>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               placeholder="Re-enter new password" autocomplete="new-password">
                        <button type="button" class="toggle" data-target="password_confirmation" aria-label="Show password">&#128065;</button>
                    </div>
                    <div class="err" id="cpwErr">Passwords do not match.</div>
                </div>

                <button type="submit" class="btn" id="submitBtn">
                    <span class="label">Change Password</span>
                    <span class="spin">&#8635;</span>
                </button>
            </form>

            <a href="{{ url('/') }}" class="back">&#8592; Back to login</a>
        </section>
    </main>

    <script>
        const form      = document.getElementById('resetForm');
        const submitBtn = document.getElementById('submitBtn');
        const pw        = document.getElementById('password');
        const cpw       = document.getElementById('password_confirmation');
        const pwField   = document.getElementById('pwField');
        const cpwField  = document.getElementById('cpwField');
        const meterBar  = document.getElementById('meterBar');
        const alertOk   = document.getElementById('alertOk');
        const alertBad  = document.getElementById('alertBad');

        const SUBMIT_URL = "{{ route('password.reset.submit') }}";
        const LOGIN_URL  = "{{ url('/') }}";
        const CSRF       = document.querySelector('meta[name="csrf-token"]').content;

        // Show / hide password
        document.querySelectorAll('.toggle').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = document.getElementById(btn.dataset.target);
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        });

        // Strength meter
        pw.addEventListener('input', () => {
            const v = pw.value;
            let score = 0;
            if (v.length >= 6) score++;
            if (v.length >= 10) score++;
            if (/[A-Z]/.test(v) && /[a-z]/.test(v)) score++;
            if (/\d/.test(v) || /[^A-Za-z0-9]/.test(v)) score++;
            const pct  = [0, 30, 55, 80, 100][score];
            const cols = ['#e3ddcf', '#c0392b', '#e08e0b', '#c79a3a', '#14916b'][score];
            meterBar.style.width = pct + '%';
            meterBar.style.background = cols;
            pwField.classList.remove('invalid');
        });
        cpw.addEventListener('input', () => cpwField.classList.remove('invalid'));

        function hideAlerts() {
            alertOk.classList.remove('show');
            alertBad.classList.remove('show');
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            hideAlerts();

            let ok = true;
            if (pw.value.length < 6) { pwField.classList.add('invalid'); ok = false; }
            if (cpw.value !== pw.value) { cpwField.classList.add('invalid'); ok = false; }
            if (!ok) return;

            submitBtn.classList.add('loading');
            submitBtn.disabled = true;

            try {
                const res = await fetch(SUBMIT_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        token: form.token.value,
                        email: document.getElementById('email').value,
                        password: pw.value,
                        password_confirmation: cpw.value
                    })
                });

                const data = await res.json();

                if (res.ok && data.success) {
                    document.getElementById('alertOkMsg').textContent =
                        data.message + ' Redirecting to login…';
                    alertOk.classList.add('show');
                    form.style.display = 'none';
                    setTimeout(() => { window.location.href = LOGIN_URL; }, 2200);
                } else {
                    let msg = data.error || 'Unable to reset password. The link may have expired.';
                    if (data.errors) {
                        msg = Object.values(data.errors).flat().join(' ');
                    }
                    document.getElementById('alertBadMsg').textContent = msg;
                    alertBad.classList.add('show');
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                }
            } catch (err) {
                document.getElementById('alertBadMsg').textContent =
                    'Network error. Please try again.';
                alertBad.classList.add('show');
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>