<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIAP - Sistem Informasi Asisten Praktikum</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f7fb] font-sans min-h-full flex flex-col">

  <!-- TOP BAR ala SIAP -->
  <header class="w-full bg-white shadow">
    <div class="flex items-center justify-between">
      <!-- blok kiri hijau -->
      <div class="flex items-center bg-teal-500 text-white px-8 py-4 md:py-5 rounded-br-3xl">
        <div class="flex items-center gap-3">
          <div class="h-11 w-11 bg-white/20 rounded-full flex items-center justify-center">
            <!-- logo bulat pakai image -->
            <img
              src="/images/utama/logo.png"
              alt="Logo SIAP"
              class="h-9 w-9 object-contain rounded-full"
            />
          </div>
          <span class="font-semibold tracking-wide text-base md:text-lg">
            SIAP
          </span>
        </div>
      </div>

      <!-- kanan: tombol logout + icon user -->
      <div class="flex items-center gap-3 pr-6">
        <button
          class="text-xs md:text-sm border border-gray-300 text-gray-700 px-4 py-1.5 rounded-full hover:bg-gray-100 transition">
          Logout
        </button>
        <div class="h-9 w-9 rounded-full bg-gray-200 flex items-center justify-center text-xs text-gray-500">
          U
        </div>
      </div>
    </div>
  </header>

  <main class="flex-1 flex flex-col">

    <!-- HERO IMAGE seperti banner Telkom -->
    <section
      class="relative w-full h-[360px] md:h-[460px] bg-cover bg-center bg-no-repeat"
      style="background-image:url('/images/utama/navbar.png');"
    >
      <div class="absolute inset-0 bg-teal-900/20"></div>
      <div class="relative z-10 max-w-7xl mx-auto h-full flex items-center px-6">
        <div class="max-w-lg text-white drop-shadow">
          <p class="text-xs md:text-2xl font-semibold">Selamat Datang</p>
          <h1 class="text-xl md:text-4xl font-bold mt-1">
            Sistem Informasi Asisten Praktikum
          </h1>
          <p class="text-xs md:text-2xl mt- opacity-90">
            Telkom University
          </p>
        </div>
      </div>
    </section>

    <!-- MAIN MENU -->
    <section class="relative py-10">
      <!-- blob dekoratif -->
      <div class="pointer-events-none absolute -left-10 top-10 w-32 h-32 bg-teal-300/40 blur-3xl rounded-full"></div>
      <div class="pointer-events-none absolute -right-16 bottom-10 w-36 h-36 bg-teal-300/40 blur-3xl rounded-full"></div>

      <div class="max-w-5xl mx-auto px-4 relative z-10">
        <h2 class="text-center text-xl md:text-2xl font-bold text-gray-800 mb-8">
          Main Menu
        </h2>

        <!-- grid kartu main menu -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5 justify-items-center mb-4">
          <!-- Jadwal -->
          <a href="#"
             class="w-full max-w-[220px] bg-white border border-teal-300 rounded-xl shadow-sm
                    flex flex-col items-center py-4 px-3 hover:-translate-y-0.5 hover:shadow-md
                    hover:border-teal-500 transition">
            <div class="w-9 h-9 mb-2 flex items-center justify-center rounded-md bg-teal-50">
              📅
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-800">Jadwal</p>
          </a>

          <!-- Presensi -->
          <a href="#"
             class="w-full max-w-[220px] bg-white border border-teal-300 rounded-xl shadow-sm
                    flex flex-col items-center py-4 px-3 hover:-translate-y-0.5 hover:shadow-md
                    hover:border-teal-500 transition">
            <div class="w-9 h-9 mb-2 flex items-center justify-center rounded-md bg-teal-50">
              ✅
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-800">Presensi</p>
          </a>

          <!-- Nilai -->
          <a href="#"
             class="w-full max-w-[220px] bg-white border border-teal-300 rounded-xl shadow-sm
                    flex flex-col items-center py-4 px-3 hover:-translate-y-0.5 hover:shadow-md
                    hover:border-teal-500 transition">
            <div class="w-9 h-9 mb-2 flex items-center justify-center rounded-md bg-teal-50">
              📊
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-800">Nilai</p>
          </a>

          <!-- Backlog -->
          <a href="#"
             class="w-full max-w-[220px] bg-white border border-teal-300 rounded-xl shadow-sm
                    flex flex-col items-center py-4 px-3 hover:-translate-y-0.5 hover:shadow-md
                    hover:border-teal-500 transition">
            <div class="w-9 h-9 mb-2 flex items-center justify-center rounded-md bg-teal-50">
              📋
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-800">Backlog</p>
          </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-5 justify-items-center">
          <!-- Tukar Shift -->
          <a href="#"
             class="w-full max-w-[220px] bg-white border border-teal-300 rounded-xl shadow-sm
                    flex flex-col items-center py-4 px-3 hover:-translate-y-0.5 hover:shadow-md
                    hover:border-teal-500 transition">
            <div class="w-9 h-9 mb-2 flex items-center justify-center rounded-md bg-teal-50">
              🔁
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-800">Tukar Shift</p>
          </a>

          <!-- Report -->
          <a href="#"
             class="w-full max-w-[220px] bg-white border border-teal-300 rounded-xl shadow-sm
                    flex flex-col items-center py-4 px-3 hover:-translate-y-0.5 hover:shadow-md
                    hover:border-teal-500 transition">
            <div class="w-9 h-9 mb-2 flex items-center justify-center rounded-md bg-teal-50">
              📝
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-800">Report</p>
          </a>

          <!-- Salary -->
          <a href="#"
             class="w-full max-w-[220px] bg-white border border-teal-300 rounded-xl shadow-sm
                    flex flex-col items-center py-4 px-3 hover:-translate-y-0.5 hover:shadow-md
                    hover:border-teal-500 transition">
            <div class="w-9 h-9 mb-2 flex items-center justify-center rounded-md bg-teal-50">
              💰
            </div>
            <p class="text-xs md:text-sm font-medium text-gray-800">Salary</p>
          </a>
        </div>
      </div>
    </section>

    <!-- LAB SISTEM INFORMASI -->
    <section class="py-10 bg-gradient-to-b from-transparent to-teal-50/40">
      <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-center text-xl md:text-2xl font-bold text-gray-800 mb-8">
          Lab Sistem Informasi
        </h2>

        <!-- slider kartu lab (pakai flex + overflow-x) -->
        <div class="flex gap-6 overflow-x-auto pb-3 scrollbar-thin scrollbar-thumb-teal-300 scrollbar-track-transparent">
          <!-- contoh kartu lab, bisa diulang -->
          <div class="min-w-[320px] md:min-w-[360px] bg-white rounded-2xl shadow-md hover:shadow-xl
                      transition-transform hover:-translate-y-1 flex overflow-hidden">
            <div class="w-2/5 h-full">
              <img src="/images/utama/labeisd.png" alt="Lab 1"
                   class="w-full h-full object-cover">
            </div>
            <div class="w-3/5 bg-gray-50 p-4 flex flex-col justify-center">
              <p class="font-semibold text-sm text-gray-800 mb-1">EISD Laboratory</p>
              <p class="text-[11px] text-gray-600 leading-snug">
                Laboratorium yang mendukung kegiatan pembelajaran, praktikum, dan
                pengembangan riset di bidang Sistem Informasi dan Enterprise.
              </p>
            </div>
          </div>

          <div class="min-w-[320px] md:min-w-[360px] bg-white rounded-2xl shadow-md hover:shadow-xl
                      transition-transform hover:-translate-y-1 flex overflow-hidden">
            <div class="w-2/5 h-full">
              <img src="/images/utama/labeisd.png" alt="Lab 2"
                   class="w-full h-full object-cover">
            </div>
            <div class="w-3/5 bg-gray-50 p-4 flex flex-col justify-center">
              <p class="font-semibold text-sm text-gray-800 mb-1">SIB Laboratory</p>
              <p class="text-[11px] text-gray-600 leading-snug">
                Berfokus pada praktikum Sistem Informasi Bisnis dan kolaborasi
                project bersama mahasiswa.
              </p>
            </div>
          </div>

          <div class="min-w-[320px] md:min-w-[360px] bg-white rounded-2xl shadow-md hover:shadow-xl
                      transition-transform hover:-translate-y-1 flex overflow-hidden">
            <div class="w-2/5 h-full">
              <img src="/images/utama/labeisd.png" alt="Lab 3"
                   class="w-full h-full object-cover">
            </div>
            <div class="w-3/5 bg-gray-50 p-4 flex flex-col justify-center">
              <p class="font-semibold text-sm text-gray-800 mb-1">Lab SAG</p>
              <p class="text-[11px] text-gray-600 leading-snug">
                Mendukung kegiatan praktikum akuntansi, sistem informasi keuangan,
                dan simulasi bisnis digital.
              </p>
            </div>
          </div>

          <div class="min-w-[320px] md:min-w-[360px] bg-white rounded-2xl shadow-md hover:shadow-xl
                      transition-transform hover:-translate-y-1 flex overflow-hidden">
            <div class="w-2/5 h-full">
              <img src="/images/utama/labeisd.png" alt="Lab 4"
                   class="w-full h-full object-cover">
            </div>
            <div class="w-3/5 bg-gray-50 p-4 flex flex-col justify-center">
              <p class="font-semibold text-sm text-gray-800 mb-1">Innovation Lab</p>
              <p class="text-[11px] text-gray-600 leading-snug">
                Ruang eksplorasi ide, prototype, dan kompetisi berbasis teknologi
                informasi dan komunikasi.
              </p>
            </div>
          </div>

          <div class="min-w-[320px] md:min-w-[360px] bg-white rounded-2xl shadow-md hover:shadow-xl
                      transition-transform hover:-translate-y-1 flex overflow-hidden">
            <div class="w-2/5 h-full">
              <img src="/images/utama/labeisd.png" alt="Lab 5"
                   class="w-full h-full object-cover">
            </div>
            <div class="w-3/5 bg-gray-50 p-4 flex flex-col justify-center">
              <p class="font-semibold text-sm text-gray-800 mb-1">Collab Space</p>
              <p class="text-[11px] text-gray-600 leading-snug">
                Area kolaborasi untuk diskusi, mentoring, dan pengembangan
                project lintas mata kuliah.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- FOOTER ala "Created by..." -->
  <footer class="mt-4 bg-teal-500/95 border-t border-teal-600 shadow-inner">
    <div class="max-w-6xl mx-auto px-4 py-4 text-center">
      <p class="text-white text-[11px] md:text-sm tracking-wide">
        Created By <span class="font-semibold">Tim The Third-Party Gang</span>
      </p>
    </div>
  </footer>
</body>
</html>
