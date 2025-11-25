<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name='description' content="SIAP - Sistem Informasi Asisten Praktikum Telkom University. Kelola jadwal, presensi, penilaian, dan pelaporan asisten praktikum dalam satu platform terintegrasi.">
    <meta name='keywords' content="SIAP, sistem informasi asisten praktikum, praktikum Telkom University, manajemen asisten, jadwal praktikum">
    <meta property="og:title" content="SIAP - Sistem Informasi Asisten Praktikum">
    <meta property="og:description" content="Kelola aktivitas asisten praktikum dengan mudah, terstruktur, dan terintegrasi di SIAP.">
    <meta property="og:image" content="/images/utama/social-share-siap.jpg">
    <meta property="og:url" content="/">
    <meta name="twitter:card" content="summary_large_image">
    <title>SIAP - Sistem Informasi Asisten Praktikum</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f5f7fb;
        }

        /* CSS untuk Efek Cahaya */
        .hero-section {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #0f766e, #14b8a6);
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(255, 255, 255, 0.35) 0%, transparent 70%);
            animation: lightPulse 5s infinite ease-in-out;
            pointer-events: none;
            z-index: 0;
        }

        @keyframes lightPulse {
            0% {
                transform: scale(0.5) rotate(0deg);
                opacity: 0.2;
            }
            50% {
                transform: scale(1.2) rotate(180deg);
                opacity: 0.5;
            }
            100% {
                transform: scale(0.5) rotate(360deg);
                opacity: 0.2;
            }
        }

        /* Efek cahaya kecil pada panah */
        .arrow:hover {
            background: rgba(0, 0, 0, 0.55) !important;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.7);
        }
    </style>
</head>
<body>

    {{-- Header Section --}}
    <header style="display: flex; justify-content: space-between; align-items: center; padding: 15px 50px; background-color: #ffffff; box-shadow: 0 2px 4px rgba(15,118,110,0.12); position: sticky; top: 0; z-index: 50;">
        <div style="display:flex; align-items:center; gap:10px;">
            {{-- Jika punya logo, bisa ganti span ini jadi <img src="/images/utama/logo.png" ...> --}}
            <div style="width:36px; height:36px; border-radius:999px; background:#e0f7f5; display:flex; align-items:center; justify-content:center; color:#0f766e; font-weight:700;">
                S
            </div>
            <div style="font-weight: 700; font-size: 22px; color: #0f766e;">
            SIAP
            </div>
        </div>
        <nav>
            <a href="/" style="margin-left: 30px; text-decoration: none; color: #0f172a; font-weight: 500;">Beranda</a>
            <a href="#tentang-siap" style="margin-left: 30px; text-decoration: none; color: #0f172a; font-weight: 500;">Tentang SIAP</a>
            <a href="#fitur" style="margin-left: 30px; text-decoration: none; color: #0f172a; font-weight: 500;">Fitur</a>
            <a href="#lokasi" style="margin-left: 30px; text-decoration: none; color: #0f172a; font-weight: 500;">Lokasi</a>
        </nav>
        <div style="display: flex; align-items:center;">
            <a href="/login" style="margin-left: 20px; text-decoration: none; color: #0f172a; font-weight: 500;">Login</a>
            <a href="/register" style="margin-left: 20px; text-decoration: none; color: #ffffff; background-color:#14b8a6; padding:8px 18px; border-radius:999px; font-weight: 500; box-shadow:0 4px 10px rgba(20,184,166,0.35);">
                Daftar
            </a>
        </div>
    </header>

    {{-- Hero/Banner Section --}}
    <section class="hero-section" style="color: #fff; display: flex; justify-content: center; align-items: center; padding: 80px 50px; position: relative;">
        <div class="arrow left" style="position: absolute; top: 50%; transform: translateY(-50%); background: rgba(15, 23, 42, 0.35); color: #fff; padding: 15px; cursor: pointer; user-select: none; font-size: 24px; border-radius: 50%; width: 40px; height: 40px; display: flex; justify-content: center; align-items: center; transition: background 0.3s ease; left: 20px; z-index: 2;">&lt;</div>

        <div class="hero-content" style="max-width: 50%; text-align: left; z-index: 1;">
            <h1 style="font-size: 42px; margin-bottom: 10px; line-height: 1.25;">
                Kelola Praktikum Lebih Mudah, Terstruktur, dan Terintegrasi
            </h1>
            <p style="font-size: 18px; margin-top: 0; opacity:0.95;">
                Sistem Informasi Asisten Praktikum <strong>Telkom University</strong> untuk jadwal, presensi, penilaian, dan pelaporan dalam satu platform.
            </p>
        </div>

        <div class="hero-image-container" style="position: absolute; right: 50px; top: 50%; transform: translateY(-50%); width: 40%; z-index: 0;">
            <img src="/images/utama/navbar.png" alt="Dashboard SIAP" style="max-width: 100%; height: auto; display: block; border-radius:12px; box-shadow:0 18px 45px rgba(15,23,42,0.45);">
        </div>

        <div class="arrow right" style="position: absolute; top: 50%; transform: translateY(-50%); background: rgba(15, 23, 42, 0.35); color: #fff; padding: 15px; cursor: pointer; user-select: none; font-size: 24px; border-radius: 50%; width: 40px; height: 40px; display: flex; justify-content: center; align-items: center; transition: background 0.3s ease; right: 20px; z-index: 2;">&gt;</div>

        <div class="hero-navigation" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); display: flex; gap: 20px;">
            <span style="color: #ffffff; font-size: 16px; cursor: pointer; font-weight: bold;">Dashboard Praktikum</span>
            <span style="color: rgba(255, 255, 255, 0.7); font-size: 16px; cursor: pointer;">Monitoring Asisten</span>
        </div>
    </section>

    {{-- About SIAP Section --}}
    <section id="tentang-siap" class="about-section" style="background-color: #ffffff; margin: 40px auto; padding: 40px 50px; max-width: 1200px; box-shadow: 0 6px 16px rgba(15,118,110,0.09); border-radius: 16px;">
        <h2 style="font-size: 30px; color: #0f172a; margin-bottom: 30px;">Tentang SIAP</h2>
        <div class="about-content" style="display: flex; gap: 50px; align-items: flex-start; flex-wrap: wrap;">
            <div class="about-image" style="flex: 0 0 340px;">
                <img src="/images/utama/labeisd.png" alt="Tampilan SIAP" style="max-width: 100%; height: auto; border-radius: 12px; display: block; box-shadow:0 10px 25px rgba(15,23,42,0.18);">
            </div>
            <div class="about-text" style="flex: 1; min-width:260px;">
                <h3 style="font-size: 24px; color: #0f172a; margin-bottom: 15px;">
                    SIAP membantu <span style="color: #14b8a6;">mengelola seluruh aktivitas asisten praktikum</span> dalam satu sistem.
                </h3>
                <p style="font-size: 15px; line-height: 1.7; color: #4b5563;">
                    Dari penjadwalan, pembagian kelas, presensi, hingga penilaian, SIAP dirancang untuk memudahkan koordinator dan asisten praktikum dalam mengelola kegiatan di laboratorium Sistem Informasi Telkom University. Semua data tercatat rapi, transparan, dan mudah dipantau.
                </p>
                <a href="#fitur" style="color: #0f766e; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; margin-top: 20px;">
                    Lihat Fitur Utama SIAP
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg" style="margin-left: 8px;">
                        <path d="M9 5L16 12L9 19" stroke="#14b8a6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Fitur Utama --}}
    <div id="fitur" style="padding: 40px 50px; max-width: 1200px; margin: 40px auto; background-color: #ffffff; box-shadow: 0 6px 16px rgba(15,118,110,0.08); border-radius: 16px;">
        <h2 style="text-align: center; font-size: 30px; color: #0f172a; margin-bottom: 40px;">Fitur Utama SIAP</h2>
        <div style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 30px;">
            <div style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(15,23,42,0.07); overflow: hidden; width: 300px; text-align: left; border:1px solid #e5e7eb;">
                <div style="background:#e0f7f5; height: 6px;"></div>
                <div style="padding: 20px;">
                    <h3 style="font-size: 18px; color: #0f172a; margin-bottom: 10px;">Manajemen Jadwal Praktikum</h3>
                    <p style="font-size: 14px; color: #4b5563; margin-bottom: 16px;">
                        Atur jadwal kelas, ruangan, dan pembagian asisten dalam satu tampilan kalender yang rapi.
                    </p>
                    <button style="background-color: #14b8a6; color: #fff; border: none; padding: 10px 20px; border-radius: 999px; cursor: pointer; font-size: 14px; font-weight: 500;">
                        Lihat Detail
                    </button>
                </div>
            </div>

            <div style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(15,23,42,0.07); overflow: hidden; width: 300px; text-align: left; border:1px solid #e5e7eb;">
                <div style="background:#e0f7f5; height: 6px;"></div>
                <div style="padding: 20px;">
                    <h3 style="font-size: 18px; color: #0f172a; margin-bottom: 10px;">Presensi & Monitoring Asisten</h3>
                    <p style="font-size: 14px; color: #4b5563; margin-bottom: 16px;">
                        Catat kehadiran asisten, rekap otomatis, dan pantau keaktifan setiap praktikum.
                    </p>
                    <button style="background-color: #14b8a6; color: #fff; border: none; padding: 10px 20px; border-radius: 999px; cursor: pointer; font-size: 14px; font-weight: 500;">
                        Lihat Detail
                    </button>
                </div>
            </div>

            <div style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(15,23,42,0.07); overflow: hidden; width: 300px; text-align: left; border:1px solid #e5e7eb;">
                <div style="background:#e0f7f5; height: 6px;"></div>
                <div style="padding: 20px;">
                    <h3 style="font-size: 18px; color: #0f172a; margin-bottom: 10px;">Penilaian & Laporan</h3>
                    <p style="font-size: 14px; color: #4b5563; margin-bottom: 16px;">
                        Kelola penilaian asisten dan hasil praktikum, serta ekspor laporan untuk kebutuhan akademik.
                    </p>
                    <button style="background-color: #14b8a6; color: #fff; border: none; padding: 10px 20px; border-radius: 999px; cursor: pointer; font-size: 14px; font-weight: 500;">
                        Lihat Detail
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Lokasi / Lab --}}
    <div id="lokasi" style="padding: 40px 50px; max-width: 1200px; margin: 40px auto; background-color: #ffffff; box-shadow: 0 6px 16px rgba(15,118,110,0.08); border-radius: 16px; text-align: center;">
        <h2 style="font-size: 30px; color: #0f172a; margin-bottom: 30px;">Lokasi Laboratorium Sistem Informasi</h2>
        <div style="margin-bottom: 30px;">
            <img src="/images/utama/labeisd.png" alt="Lokasi Lab SI Telkom University" style="max-width: 100%; height: auto; border-radius: 12px; box-shadow: 0 4px 10px rgba(15,23,42,0.18);">
        </div>
        <div style="display: flex; justify-content: center; gap: 15px; flex-wrap:wrap;">
            <input type="text" placeholder="Masukkan lokasi Anda" style="padding: 12px 15px; border: 1px solid #cbd5f5; border-radius: 999px; width: 280px; font-size: 14px; outline:none;">
            <button style="background-color: #14b8a6; color: #fff; border: none; padding: 12px 25px; border-radius: 999px; cursor: pointer; font-size: 14px; font-weight: 500;">
                Cek Rute ke Lab
            </button>
        </div>
    </div>

    <footer style="background-color: #0f766e; color: #fff; padding: 30px 50px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap:20px;">
        <div style="max-width: 420px; line-height: 1.6; font-size: 13px;">
            <p style="margin: 0;">
                Laboratorium Sistem Informasi, Telkom University<br>
                Jl. Telekomunikasi No. 1, Sukapura, Kec. Dayeuhkolot, Kabupaten Bandung, Jawa Barat 40257
            </p>
        </div>
        <div style="text-align: right;">
            <h3 style="margin-top: 0; margin-bottom: 10px; font-size: 18px;">Kontak</h3>
            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <a href="#" style="color: #fff; text-decoration: none;">
                    <img src="https://via.placeholder.com/24/0f766e/ffffff?text=E" alt="Email" style="width: 24px; height: 24px; vertical-align: middle; border-radius:999px; background:#e0f7f5;">
                </a>
                <a href="#" style="color: #fff; text-decoration: none;">
                    <img src="https://via.placeholder.com/24/0f766e/ffffff?text=I" alt="Instagram" style="width: 24px; height: 24px; vertical-align: middle; border-radius:999px; background:#e0f7f5;">
                </a>
                <a href="#" style="color: #fff; text-decoration: none;">
                    <img src="https://via.placeholder.com/24/0f766e/ffffff?text=W" alt="Website" style="width: 24px; height: 24px; vertical-align: middle; border-radius:999px; background:#e0f7f5;">
                </a>
            </div>
        </div>
    </footer>

    {{-- Script untuk slider --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const heroSection = document.querySelector('.hero-section');
            const heroImage = heroSection.querySelector('.hero-image-container img');
            const heroTitle = heroSection.querySelector('.hero-content h1');
            const heroSubtitle = heroSection.querySelector('.hero-content p');
            const navItems = document.querySelectorAll('.hero-navigation span');
            const leftArrow = document.querySelector('.arrow.left');
            const rightArrow = document.querySelector('.arrow.right');

            const slides = [
                {
                    image: '/images/utama/navbar.png',
                    title: 'Kelola Praktikum Lebih Mudah, Terstruktur, dan Terintegrasi',
                    subtitle: 'Satu platform untuk jadwal, presensi, penilaian, dan laporan.'
                },
                {
                    image: '/images/utama/labeisd.png',
                    title: 'Monitoring Asisten Praktikum Secara Real-Time',
                    subtitle: 'Pantau kehadiran, aktivitas, dan kinerja asisten di setiap kelas.'
                }
            ];

            let currentSlide = 0;

            function updateSlide() {
                heroImage.src = slides[currentSlide].image;
                heroTitle.textContent = slides[currentSlide].title;
                heroSubtitle.textContent = slides[currentSlide].subtitle;

                navItems.forEach((item, index) => {
                    if (index === currentSlide) {
                        item.style.color = '#ffffff';
                        item.style.fontWeight = 'bold';
                    } else {
                        item.style.color = 'rgba(255, 255, 255, 0.7)';
                        item.style.fontWeight = 'normal';
                    }
                });
            }

            leftArrow.addEventListener('click', () => {
                currentSlide = (currentSlide > 0) ? currentSlide - 1 : slides.length - 1;
                updateSlide();
            });

            rightArrow.addEventListener('click', () => {
                currentSlide = (currentSlide < slides.length - 1) ? currentSlide + 1 : 0;
                updateSlide();
            });

            navItems.forEach((item, index) => {
                item.addEventListener('click', () => {
                    currentSlide = index;
                    updateSlide();
                });
            });

            updateSlide();
        });
    </script>

</body>
</html>
