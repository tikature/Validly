<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validly — Platform Sertifikat Digital Terpercaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy:      #0F1E3C;
            --navy-mid:  #1a3260;
            --navy-soft: #e8edf8;
            --gold:      #C9A84C;
            --gold-lt:   #E8D48B;
            --gray:      #6b7280;
            --light:     #f8fafc;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: #1a1a2e; overflow-x: hidden; background: #fff; }

        /* ── NAVBAR ── */
        .nav-main {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            padding: 18px 60px;
            display: flex; align-items: center; justify-content: space-between;
            transition: all .3s;
        }
        .nav-main.scrolled {
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(14px);
            box-shadow: 0 1px 0 rgba(0,0,0,0.07);
            padding: 12px 60px;
        }
        .nav-logo {
            font-weight: 800; font-size: 1.3rem; color: #fff;
            text-decoration: none; letter-spacing: -0.5px;
            display: flex; align-items: center; gap: 9px;
        }
        .nav-main.scrolled .nav-logo { color: var(--navy); }
        .nav-logo-icon {
            width: 30px; height: 30px; background: var(--gold);
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem; color: var(--navy); font-weight: 900;
        }
        .nav-links { display: flex; align-items: center; gap: 36px; }
        .nav-links a { color: rgba(255,255,255,0.7); font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: color .2s; }
        .nav-main.scrolled .nav-links a { color: var(--gray); }
        .nav-links a:hover { color: #fff; }
        .nav-main.scrolled .nav-links a:hover { color: var(--navy); }
        .btn-nav-cta {
            background: var(--gold); color: var(--navy) !important;
            font-weight: 700; font-size: 0.82rem;
            padding: 9px 20px; border-radius: 8px;
            text-decoration: none; transition: all .2s; white-space: nowrap;
        }
        .btn-nav-cta:hover { background: var(--gold-lt); transform: translateY(-1px); }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            background: linear-gradient(150deg, #04091a 0%, #0c1a38 40%, #152d5e 100%);
            display: flex; flex-direction: column;
            position: relative; overflow: hidden;
        }
        .hero-orb-1 { position: absolute; width: 800px; height: 800px; border-radius: 50%; background: radial-gradient(circle, rgba(201,168,76,.07) 0%, transparent 60%); top: -250px; right: -150px; pointer-events:none; }
        .hero-orb-2 { position: absolute; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(13,148,136,.09) 0%, transparent 60%); bottom: -100px; left: -50px; pointer-events:none; }
        .hero-grid { position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px); background-size: 56px 56px; pointer-events:none; }

        .hero-inner { flex:1; display:flex; align-items:center; padding: 120px 60px 80px; position:relative; z-index:2; }

        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 7px;
            background: rgba(201,168,76,.1); border: 1px solid rgba(201,168,76,.22);
            color: var(--gold-lt); font-size: .7rem; font-weight: 700;
            letter-spacing: 2.5px; text-transform: uppercase;
            padding: 6px 14px; border-radius: 20px; margin-bottom: 26px;
        }
        .hero-eyebrow::before { content:''; width:6px; height:6px; background:var(--gold); border-radius:50%; }

        .hero-h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800; color: #fff;
            line-height: 1.1; letter-spacing: -1.5px;
            margin-bottom: 20px;
        }
        .hero-h1 .grad {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-lt) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .hero-p { font-size: 1rem; color: rgba(255,255,255,.5); line-height: 1.75; max-width: 480px; margin-bottom: 36px; }

        .hero-btns { display:flex; gap:12px; flex-wrap:wrap; }
        .btn-primary-hero {
            background: var(--gold); color: var(--navy); font-weight: 700;
            padding: 13px 28px; border-radius: 10px; font-size: .875rem;
            text-decoration: none; display:inline-flex; align-items:center; gap:7px;
            box-shadow: 0 8px 24px rgba(201,168,76,.28); transition: all .25s;
        }
        .btn-primary-hero:hover { background: var(--gold-lt); color: var(--navy); transform:translateY(-2px); box-shadow:0 14px 32px rgba(201,168,76,.38); }
        .btn-ghost-hero {
            background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.14);
            color: rgba(255,255,255,.8); font-weight: 500;
            padding: 13px 24px; border-radius: 10px; font-size: .875rem;
            text-decoration: none; display:inline-flex; align-items:center; gap:7px;
            transition: all .25s;
        }
        .btn-ghost-hero:hover { background:rgba(255,255,255,.1); color:#fff; border-color:rgba(255,255,255,.28); }

        .hero-kpi { display:flex; gap:30px; margin-top:44px; flex-wrap:wrap; }
        .kpi-val { font-size:1.75rem; font-weight:800; color:#fff; line-height:1; }
        .kpi-val em { color:var(--gold); font-style:normal; }
        .kpi-lbl { font-size:.72rem; color:rgba(255,255,255,.35); margin-top:3px; }
        .kpi-div { width:1px; background:rgba(255,255,255,.08); }

        /* Mockup */
        .mockup-wrap { position:relative; flex-shrink:0; }
        .mockup-card {
            width:360px; background:#fff; border-radius:18px;
            padding:28px 32px;
            box-shadow: 0 40px 80px rgba(0,0,0,.45), 0 0 0 1px rgba(255,255,255,.04);
            position:relative;
        }
        .mockup-card::before {
            content:''; position:absolute; top:0; left:28px; right:28px; height:3px;
            background: linear-gradient(90deg, var(--gold), var(--gold-lt));
            border-radius: 0 0 3px 3px;
        }
        .mk-id { font-size:.64rem; color:#bbb; letter-spacing:3px; text-transform:uppercase; text-align:right; margin-bottom:18px; }
        .mk-lbl { font-size:.63rem; letter-spacing:3px; text-transform:uppercase; color:#ccc; margin-bottom:5px; }
        .mk-name { font-family:'Playfair Display',serif; font-size:1.4rem; font-style:italic; color:var(--navy); margin-bottom:3px; }
        .mk-org { font-size:.75rem; color:#999; margin-bottom:14px; }
        .mk-bar { height:3px; border-radius:2px; margin-bottom:5px; }
        .mk-bar.a { background:var(--gold); width:68%; }
        .mk-bar.b { background:#eee; width:48%; }
        .mk-bar.c { background:#f4f4f4; width:38%; }
        .mk-foot { display:flex; justify-content:space-between; align-items:center; margin-top:20px; padding-top:14px; border-top:1px solid #f0f0f0; }
        .mk-signer { font-size:.7rem; }
        .mk-signer strong { display:block; color:var(--navy); font-size:.76rem; }
        .mk-signer span { color:#bbb; }
        .mk-seal { width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--navy),var(--navy-mid)); display:flex; align-items:center; justify-content:center; color:var(--gold-lt); font-size:.75rem; }
        .float-pill {
            position:absolute; background:#fff; border-radius:10px;
            padding:9px 14px; box-shadow:0 8px 24px rgba(0,0,0,.14);
            display:flex; align-items:center; gap:7px;
            font-size:.73rem; font-weight:600; color:var(--navy); white-space:nowrap;
        }
        .pill-dot { width:7px; height:7px; border-radius:50%; }
        .pill-top { top:-14px; right:-20px; }
        .pill-bot { bottom:-14px; left:-20px; }

        /* ── TRUSTED ── */
        .section-trusted { background:var(--light); padding:36px 0; border-top:1px solid #eef2f9; border-bottom:1px solid #eef2f9; }
        .trusted-lbl { font-size:.7rem; letter-spacing:2.5px; text-transform:uppercase; color:#bbb; font-weight:600; text-align:center; margin-bottom:22px; }
        .trusted-row { display:flex; align-items:center; justify-content:center; gap:44px; flex-wrap:wrap; }
        .trusted-item { font-weight:700; font-size:.875rem; color:#d1d5db; letter-spacing:-.2px; }

        /* ── FEATURES ── */
        .section-features { padding:100px 0; }
        .sec-lbl { font-size:.7rem; letter-spacing:3px; text-transform:uppercase; color:var(--gold); font-weight:700; margin-bottom:10px; }
        .sec-h2 { font-size:clamp(1.8rem,3.5vw,2.5rem); font-weight:800; color:var(--navy); letter-spacing:-.8px; line-height:1.2; margin-bottom:12px; }
        .sec-p { color:var(--gray); font-size:.95rem; line-height:1.7; max-width:500px; }
        .f-card { border:1px solid #eef2f9; border-radius:14px; padding:26px 22px; background:#fff; transition:all .25s; height:100%; }
        .f-card:hover { border-color:var(--navy-soft); box-shadow:0 8px 28px rgba(15,30,60,.07); transform:translateY(-3px); }
        .f-icon { width:46px; height:46px; border-radius:11px; background:var(--navy-soft); display:flex; align-items:center; justify-content:center; font-size:1.15rem; margin-bottom:14px; }
        .f-card h5 { font-size:.93rem; font-weight:700; color:var(--navy); margin-bottom:7px; letter-spacing:-.2px; }
        .f-card p { font-size:.83rem; color:var(--gray); line-height:1.65; margin:0; }

        /* ── HOW ── */
        .section-how { padding:100px 0; background:var(--light); }
        .step-card { display:flex; gap:14px; padding:22px; background:#fff; border-radius:13px; border:1px solid #eef2f9; height:100%; transition:all .2s; }
        .step-card:hover { border-color:var(--navy-soft); box-shadow:0 4px 18px rgba(15,30,60,.07); }
        .step-n { width:34px; height:34px; border-radius:9px; background:var(--navy); color:var(--gold); font-weight:800; font-size:.8rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .step-card h5 { font-size:.9rem; font-weight:700; color:var(--navy); margin-bottom:6px; }
        .step-card p { font-size:.8rem; color:var(--gray); line-height:1.65; margin:0; }

        /* ── STATS ── */
        .section-stats { padding:80px 0; background:linear-gradient(135deg,var(--navy) 0%,#1a3a6e 100%); }
        .st-val { font-size:2.8rem; font-weight:800; color:#fff; letter-spacing:-1.5px; line-height:1; }
        .st-val em { color:var(--gold); font-style:normal; }
        .st-lbl { font-size:.8rem; color:rgba(255,255,255,.35); margin-top:6px; }

        /* ── TESTI ── */
        .section-testi { padding:100px 0; }
        .t-card { background:var(--light); border:1px solid #eef2f9; border-radius:15px; padding:26px; height:100%; }
        .t-stars { color:var(--gold); font-size:.78rem; margin-bottom:12px; }
        .t-text { font-size:.875rem; color:#374151; line-height:1.7; font-style:italic; margin-bottom:18px; }
        .t-author { display:flex; align-items:center; gap:11px; }
        .t-av { width:38px; height:38px; border-radius:50%; background:linear-gradient(135deg,var(--navy),var(--navy-mid)); display:flex; align-items:center; justify-content:center; color:var(--gold-lt); font-weight:700; font-size:.8rem; flex-shrink:0; }
        .t-name { font-size:.83rem; font-weight:700; color:var(--navy); }
        .t-role { font-size:.72rem; color:var(--gray); }

        /* ── CTA ── */
        .section-cta {
            padding:100px 60px;
            background:linear-gradient(150deg,#04091a 0%,#0c1a38 50%,#152d5e 100%);
            text-align:center; position:relative; overflow:hidden;
        }
        .section-cta::before { content:''; position:absolute; width:700px; height:700px; border-radius:50%; background:radial-gradient(circle,rgba(201,168,76,.06) 0%,transparent 60%); top:-300px; left:50%; transform:translateX(-50%); }
        .cta-h2 { font-size:clamp(2rem,4vw,2.8rem); font-weight:800; color:#fff; letter-spacing:-1px; line-height:1.15; margin-bottom:16px; }
        .cta-p { color:rgba(255,255,255,.45); font-size:.95rem; margin-bottom:32px; max-width:440px; margin-left:auto; margin-right:auto; }
        .cta-btns { display:flex; gap:12px; justify-content:center; flex-wrap:wrap; }

        /* ── FOOTER ── */
        footer { background:#04091a; padding:60px 60px 28px; }
        .foot-logo { font-weight:800; font-size:1.15rem; color:#fff; display:flex; align-items:center; gap:8px; margin-bottom:10px; }
        .foot-logo-icon { width:26px; height:26px; background:var(--gold); border-radius:7px; display:flex; align-items:center; justify-content:center; font-size:.78rem; color:var(--navy); font-weight:900; }
        .foot-tag { font-size:.78rem; color:rgba(255,255,255,.25); line-height:1.6; max-width:220px; }
        .foot-h { font-size:.68rem; letter-spacing:2px; text-transform:uppercase; color:rgba(255,255,255,.2); font-weight:600; margin-bottom:14px; }
        .foot-ul { list-style:none; padding:0; margin:0; }
        .foot-ul li { margin-bottom:9px; }
        .foot-ul a { color:rgba(255,255,255,.38); font-size:.82rem; text-decoration:none; transition:color .2s; }
        .foot-ul a:hover { color:var(--gold-lt); }
        .foot-bottom { border-top:1px solid rgba(255,255,255,.05); padding-top:22px; margin-top:40px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; }
        .foot-copy { font-size:.75rem; color:rgba(255,255,255,.18); }
        .foot-copy strong { color:var(--gold); }

        @media(max-width:991px) {
            .nav-main,.nav-main.scrolled { padding:14px 24px; }
            .nav-links.d-lg-flex { display:none!important; }
            .hero-inner { padding:100px 24px 60px; }
            .mockup-wrap { display:none; }
            .section-cta { padding:80px 24px; }
            footer { padding:48px 24px 24px; }
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="nav-main" id="navbar">
    <a href="#" class="nav-logo">
        <div class="nav-logo-icon">V</div>
        Validly
    </a>
    <div class="nav-links d-none d-lg-flex align-items-center">
        <a href="#fitur">Fitur</a>
        <a href="#cara-kerja">Cara Kerja</a>
        <a href="#testimoni">Testimoni</a>
        <a href="{{ route('login') }}" class="btn-nav-cta ms-2">
            Masuk <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <a href="{{ route('login') }}" class="btn-nav-cta d-lg-none" style="font-size:.8rem;padding:8px 16px">Masuk</a>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-orb-1"></div>
    <div class="hero-orb-2"></div>
    <div class="hero-grid"></div>
    <div class="hero-inner">
        <div class="row align-items-center w-100 g-5">
            <div class="col-lg-6">
                <div class="hero-eyebrow">Platform Sertifikat Digital</div>
                <h1 class="hero-h1">
                    Sertifikat Resmi,<br>
                    Otomatis,<br>
                    <span class="grad">Tanpa Repot</span>
                </h1>
                <p class="hero-p">
                    Validly membantu lembaga pelatihan dan pendidikan menerbitkan sertifikat digital
                    profesional secara massal — dengan nomor otomatis, tanda tangan, cap, dan logo institusi Anda.
                </p>
                <div class="hero-btns">
                    <a href="{{ route('login') }}" class="btn-primary-hero">
                        Mulai Sekarang <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="#cara-kerja" class="btn-ghost-hero">
                        <i class="bi bi-play-circle"></i> Lihat Cara Kerja
                    </a>
                </div>
                <div class="hero-kpi">
                    <div><div class="kpi-val">10k<em>+</em></div><div class="kpi-lbl">Sertifikat diterbitkan</div></div>
                    <div class="kpi-div"></div>
                    <div><div class="kpi-val">500<em>+</em></div><div class="kpi-lbl">Lembaga aktif</div></div>
                    <div class="kpi-div"></div>
                    <div><div class="kpi-val">99<em>%</em></div><div class="kpi-lbl">Kepuasan pengguna</div></div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-flex justify-content-center">
                <div class="mockup-wrap">
                    <div class="float-pill pill-top">
                        <div class="pill-dot" style="background:#16a34a"></div>
                        Sertifikat berhasil dibuat
                    </div>
                    <div class="mockup-card">
                        <div class="mk-id">ID: VAL-{{ date('y') }}-001</div>
                        <div class="mk-lbl">Diberikan Kepada</div>
                        <div class="mk-name">Budi Santoso, S.T.</div>
                        <div class="mk-org">PT. Maju Bersama</div>
                        <div class="mk-bar a"></div>
                        <div class="mk-bar b"></div>
                        <div class="mk-bar c"></div>
                        <div class="mk-foot">
                            <div class="mk-signer">
                                <strong>Dr. Ahmad Fauzi, M.Pd.</strong>
                                <span>Direktur Lembaga</span>
                            </div>
                            <div class="mk-seal"><i class="bi bi-patch-check-fill"></i></div>
                        </div>
                    </div>
                    <div class="float-pill pill-bot">
                        <div class="pill-dot" style="background:#c9a84c"></div>
                        Auto-numbered · CERT/001/{{ date('Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TRUSTED BY --}}
<section class="section-trusted">
    <div class="container">
        <div class="trusted-lbl">Dipercaya oleh berbagai institusi</div>
        <div class="trusted-row">
            <div class="trusted-item">Lembaga Pelatihan Nasional</div>
            <div class="trusted-item">Universitas Nusantara</div>
            <div class="trusted-item">Balai Diklat Pemerintah</div>
            <div class="trusted-item">Yayasan Pendidikan Mandiri</div>
            <div class="trusted-item">Pusdiklat Kementerian</div>
        </div>
    </div>
</section>

{{-- FITUR --}}
<section class="section-features" id="fitur">
    <div class="container">
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-5">
                <div class="sec-lbl">Fitur Platform</div>
                <h2 class="sec-h2">Semua yang Anda Butuhkan, Dalam Satu Platform</h2>
                <p class="sec-p">Dirancang khusus untuk lembaga pelatihan, pendidikan, dan organisasi yang ingin menerbitkan sertifikat secara cepat, konsisten, dan profesional.</p>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="f-card">
                            <div class="f-icon">📄</div>
                            <h5>Generator Massal</h5>
                            <p>Upload Excel/CSV ratusan peserta, semua sertifikat dibuat otomatis dalam detik.</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="f-card">
                            <div class="f-icon">🔢</div>
                            <h5>Auto Numbering Fleksibel</h5>
                            <p>Format nomor bebas dikustomisasi — tambah segmen, atur urutan, pilih pemisah.</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="f-card">
                            <div class="f-icon">✍️</div>
                            <h5>TTD & Cap Digital</h5>
                            <p>Upload tanda tangan dan stempel institusi. Atur posisi, ukuran, dan opasitas bebas.</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="f-card">
                            <div class="f-icon">📦</div>
                            <h5>Download ZIP Massal</h5>
                            <p>Unduh semua sertifikat dalam satu klik, dikemas rapi dalam file ZIP siap kirim.</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="f-card">
                            <div class="f-icon">🖼️</div>
                            <h5>Background Custom</h5>
                            <p>Gunakan template default Validly atau upload background milik lembaga Anda sendiri.</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="f-card">
                            <div class="f-icon">🌐</div>
                            <h5>Bilingual ID / EN</h5>
                            <p>Pilih bahasa Indonesia atau Inggris — seluruh teks sertifikat menyesuaikan otomatis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="f-card" style="background:var(--light)">
                    <div class="f-icon" style="background:#fff">🏛</div>
                    <h5>Multi Lembaga</h5>
                    <p>Satu platform, banyak lembaga. Super Admin mengelola seluruh akun dari panel terpusat.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="f-card" style="background:var(--light)">
                    <div class="f-icon" style="background:#fff">🔐</div>
                    <h5>Akses Berbasis Peran</h5>
                    <p>Super Admin dan Admin Lembaga punya hak akses berbeda — aman dan terpisah jelas.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="f-card" style="background:var(--light)">
                    <div class="f-icon" style="background:#fff">⚡</div>
                    <h5>Tanpa Instalasi</h5>
                    <p>Semua berjalan di browser. Tidak perlu software tambahan atau keahlian desain grafis.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section class="section-how" id="cara-kerja">
    <div class="container">
        <div class="text-center mb-5">
            <div class="sec-lbl">Cara Kerja</div>
            <h2 class="sec-h2">Sertifikat Siap dalam 3 Langkah</h2>
            <p class="sec-p mx-auto" style="max-width:460px">Dari setup hingga download tidak lebih dari beberapa menit — tanpa kurva belajar.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-n">01</div>
                    <div>
                        <h5>Isi Pengaturan Sertifikat</h5>
                        <p>Masukkan nama acara, tanggal, penandatangan, lalu upload logo, tanda tangan, dan cap institusi Anda.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-n">02</div>
                    <div>
                        <h5>Input atau Upload Data Peserta</h5>
                        <p>Tambahkan peserta secara manual (hingga 4 orang), atau upload Excel/CSV untuk ribuan peserta sekaligus.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-n">03</div>
                    <div>
                        <h5>Generate & Download</h5>
                        <p>Klik Generate — pratinjau muncul langsung. Download individual sebagai PNG atau semua sekaligus dalam ZIP.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATS --}}
<section class="section-stats">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <div class="st-val" data-target="10000" data-suffix="k+">10k<em>+</em></div>
                <div class="st-lbl">Sertifikat diterbitkan</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="st-val" data-target="500" data-suffix="+">500<em>+</em></div>
                <div class="st-lbl">Lembaga aktif</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="st-val" data-target="90" data-suffix="%">90<em>%</em></div>
                <div class="st-lbl">Hemat waktu administrasi</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="st-val" data-target="4.9" data-suffix="★">4.9<em>★</em></div>
                <div class="st-lbl">Rating kepuasan pengguna</div>
            </div>
        </div>
    </div>
</section>

{{-- TESTIMONI --}}
<section class="section-testi" id="testimoni">
    <div class="container">
        <div class="text-center mb-5">
            <div class="sec-lbl">Testimoni</div>
            <h2 class="sec-h2">Apa Kata Mereka?</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="t-card">
                    <div class="t-stars">★★★★★</div>
                    <p class="t-text">"Sebelumnya kami butuh 2 hari untuk membuat 300 sertifikat secara manual. Dengan Validly, cukup 10 menit. Luar biasa efisien!"</p>
                    <div class="t-author">
                        <div class="t-av">SR</div>
                        <div>
                            <div class="t-name">Sari Rahayu, M.Pd.</div>
                            <div class="t-role">Koordinator Pelatihan, LPK Maju</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="t-card">
                    <div class="t-stars">★★★★★</div>
                    <p class="t-text">"Fitur auto-numbering dengan segmen custom sangat membantu. Format nomor kami yang panjang bisa diatur persis sesuai kebutuhan lembaga."</p>
                    <div class="t-author">
                        <div class="t-av">BH</div>
                        <div>
                            <div class="t-name">Bachtiar Hidayat</div>
                            <div class="t-role">Admin, Balai Diklat Provinsi</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="t-card">
                    <div class="t-stars">★★★★★</div>
                    <p class="t-text">"Tampilan sertifikat yang dihasilkan sangat profesional. Peserta kami bangga mendapatkan sertifikat dengan logo dan tanda tangan resmi lembaga."</p>
                    <div class="t-author">
                        <div class="t-av">DW</div>
                        <div>
                            <div class="t-name">Dewi Wulandari, S.E.</div>
                            <div class="t-role">Direktur, Yayasan Cerdas Bangsa</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="section-cta">
    <div class="container position-relative" style="z-index:2">
        <h2 class="cta-h2">Siap Menerbitkan Sertifikat<br>Secara Profesional?</h2>
        <p class="cta-p">Bergabunglah dengan ratusan lembaga yang sudah mempercayakan penerbitan sertifikat mereka ke Validly.</p>
        <div class="cta-btns">
            <a href="{{ route('login') }}" class="btn-primary-hero">
                Mulai Sekarang <i class="bi bi-arrow-right"></i>
            </a>
            <a href="#fitur" class="btn-ghost-hero">Pelajari Fitur Lengkap</a>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <div class="row g-5">
        <div class="col-lg-4">
            <div class="foot-logo">
                <div class="foot-logo-icon">V</div>
                Validly
            </div>
            <p class="foot-tag">Platform generator sertifikat digital untuk lembaga pelatihan dan pendidikan Indonesia.</p>
        </div>
        <div class="col-6 col-lg-2">
            <div class="foot-h">Platform</div>
            <ul class="foot-ul">
                <li><a href="#fitur">Fitur</a></li>
                <li><a href="#cara-kerja">Cara Kerja</a></li>
                <li><a href="#testimoni">Testimoni</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
            </ul>
        </div>
        <div class="col-6 col-lg-2">
            <div class="foot-h">Fitur</div>
            <ul class="foot-ul">
                <li><a href="#">Generator Massal</a></li>
                <li><a href="#">Auto Numbering</a></li>
                <li><a href="#">TTD Digital</a></li>
                <li><a href="#">Multi Lembaga</a></li>
            </ul>
        </div>
        <div class="col-6 col-lg-2">
            <div class="foot-h">Dukungan</div>
            <ul class="foot-ul">
                <li><a href="#">Dokumentasi</a></li>
                <li><a href="#">Panduan Penggunaan</a></li>
                <li><a href="#">Hubungi Kami</a></li>
            </ul>
        </div>
    </div>
    <div class="foot-bottom">
        <div class="foot-copy">&copy; {{ date('Y') }} <strong>Validly</strong> — Platform Generator Sertifikat Digital. All rights reserved.</div>
        <div style="font-size:.72rem;color:rgba(255,255,255,.12)"></div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 50);
    });

    // Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
        });
    });

    // Count-up animasi pada stats saat masuk viewport
    const statEls = document.querySelectorAll('.st-val');
    const ioStats = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const rawText = el.textContent;
            const numStr = rawText.replace(/[^0-9.]/g, '');
            const num = parseFloat(numStr);
            const suffix = rawText.replace(/[0-9.]/g, '').trim();
            const isFloat = numStr.includes('.');
            const isK = rawText.includes('k');
            let frame = 0, total = 60;
            const run = () => {
                frame++;
                const progress = frame / total;
                const eased = 1 - Math.pow(1 - progress, 3);
                let val = num * eased;
                let display = isFloat ? val.toFixed(1) : Math.floor(val);
                const em = suffix.replace(/[0-9]/g,'');
                el.innerHTML = display + (isK ? 'k' : '') + `<em>${em}</em>`;
                if (frame < total) requestAnimationFrame(run);
            };
            requestAnimationFrame(run);
            ioStats.unobserve(el);
        });
    }, { threshold: 0.6 });
    statEls.forEach(el => ioStats.observe(el));
</script>
</body>
</html>
