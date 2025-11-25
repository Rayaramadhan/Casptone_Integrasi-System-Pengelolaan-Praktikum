<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIAP - Sistem Informasi Asisten Praktikum</title>
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- Optional: font Poppins biar mirip desain welcome --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
      body { font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
  </style>
</head>
<body class="bg-[#f5f7fb] min-h-full flex flex-col">

  <!-- TOP BAR -->
  <header class="w-full bg-white border-b border-teal-50 shadow-[0_2px_6px_rgba(15,118,110,0.08)]">
    <!-- di sini: w-full, tanpa max-w & mx-auto, px-0 supaya mentok kiri-kanan -->
    <div class="w-full px-0 py-3 flex items-center justify-between gap-4">

      <!-- blok kiri hijau (logo + title) -->
      <div class="flex items-stretch">
        <div class="flex items-center bg-teal-500 text-white px-5 sm:px-7 py-3 sm:py-4 rounded-br-3xl rounded-tr-3xl shadow-sm">
          <div class="flex items-center gap-3">
            <div class="h-10 w-10 sm:h-11 sm:w-11 bg-white/20 rounded-full flex items-center justify-center shadow-inner">
              <img
                src="/images/utama/logo.png"
                alt="Logo SIAP"
                class="h-8 w-8 sm:h-9 sm:w-9 object-contain rounded-full"
              />
            </div>
            <div class="leading-tight">
              <p class="text-[10px] sm:text-[11px] uppercase tracking-[0.16em] text-teal-50/90">
                Sistem Informasi
              </p>
              <span class="font-semibold text-sm sm:text-lg tracking-wide">
                SIAP
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- kanan: info user + tombol -->
      <div class="flex items-center justify-end flex-1 pr-0">
        @auth
            @php
                $initial = strtoupper(mb_substr(Auth::user()->name, 0, 1));
                $isAdmin = Auth::user()->usertype === 'admin';
                $dashUrl = $isAdmin ? url('/admin/dashboard') : url('/dashboard');
            @endphp

            {{-- DESKTOP / TABLET: kapsul lengkap --}}
            <div
                class="hidden md:flex items-center gap-4 rounded-full bg-white/80 border border-slate-200
                       px-5 py-2.5 shadow-[0_6px_18px_rgba(15,23,42,0.08)] backdrop-blur-sm
                       max-w-md mr-4">

                {{-- Nama + email --}}
                <div class="flex flex-col leading-tight">
                    <span class="font-semibold text-sm text-slate-900">
                        {{ Auth::user()->name }}
                    </span>
                    <span class="text-xs text-slate-500">
                        {{ Auth::user()->email }}
                    </span>
                </div>

                {{-- Tombol Dashboard --}}
                <a href="{{ $dashUrl }}"
                   class="inline-flex items-center justify-center text-xs md:text-sm font-medium
                          px-4 py-1.5 rounded-full border border-teal-400
                          text-teal-600 bg-teal-50
                          hover:bg-teal-500 hover:text-white hover:border-teal-500
                          transition-colors duration-150">
                    Dashboard
                </a>

                {{-- Tombol Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center justify-center text-xs md:text-sm font-medium
                                   px-4 py-1.5 rounded-full border border-slate-200
                                   text-slate-600 bg-white
                                   hover:bg-slate-50 hover:border-slate-300
                                   transition-colors duration-150">
                        Logout
                    </button>
                </form>

                {{-- Avatar inisial --}}
                <div class="relative">
                    <div
                        class="flex items-center justify-center h-9 w-9 rounded-full
                               bg-teal-500 text-white text-xs md:text-sm font-semibold shadow-sm">
                        {{ $initial }}
                    </div>
                    {{-- indikator online kecil --}}
                    <span
                        class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-400
                               border-2 border-white">
                    </span>
                </div>
            </div>

            {{-- MOBILE: versi ringkas --}}
            <div class="flex md:hidden items-center gap-2 mr-2">
                <div class="text-right leading-tight mr-1">
                    <p class="text-[11px] font-medium text-slate-900">
                        {{ \Illuminate\Support\Str::limit(Auth::user()->name, 14) }}
                    </p>
                    <p class="text-[10px] text-slate-500">
                        {{ \Illuminate\Support\Str::limit(Auth::user()->email, 18) }}
                    </p>
                </div>

                <a href="{{ $dashUrl }}"
                   class="text-[11px] font-medium px-3 py-1 rounded-full border border-teal-400
                          text-teal-600 bg-white hover:bg-teal-50 transition">
                    Dash
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-[11px] px-3 py-1 rounded-full border border-slate-300
                                   text-slate-600 bg-white hover:bg-slate-50 transition">
                        Out
                    </button>
                </form>

                <div
                    class="flex items-center justify-center h-8 w-8 rounded-full bg-teal-500 text-white
                           text-[11px] font-semibold shadow-sm">
                    {{ $initial }}
                </div>
            </div>
        @else
            <!-- Kalau belum login: seperti header welcome (Login + Daftar) -->
            <div class="flex items-center gap-3 sm:gap-4 pr-4">
                <a href="{{ route('login') }}"
                   class="text-xs sm:text-sm font-medium text-slate-800 px-3 sm:px-4 py-1.5 rounded-full
                          border border-slate-200 bg-white hover:bg-slate-50 transition">
                    Login
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="text-xs sm:text-sm font-medium text-white px-4 sm:px-5 py-1.5 rounded-full
                              bg-teal-500 shadow-[0_4px_10px_rgba(20,184,166,0.35)]
                              hover:bg-teal-600 transition">
                        Daftar Asisten
                    </a>
                @endif
            </div>
        @endauth
      </div>
    </div>
  </header>

<!-- MAIN CONTENT -->
  <main class="flex-1 w-full">
    <section class="max-w-6xl mx-auto px-4 lg:px-6 py-10">
      <!-- Judul -->
      <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900 mb-6">
        Form Input Nilai
      </h1>

      <!-- Card Form -->
      <div
        class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)]
               border border-slate-100 overflow-hidden"
      >
        <!-- Info Bar -->
        <div class="bg-sky-50 border-b border-sky-100 px-6 py-4 flex items-center gap-3">
          <div
            class="h-9 w-9 rounded-full bg-sky-500 text-white flex items-center justify-center shadow-sm"
          >
            <span class="text-lg">🔔</span>
          </div>
          <p class="text-sm text-slate-700">
            Masukkan data nilai yang sesuai.
          </p>
        </div>

        <!-- Body Form -->
        <div class="px-6 lg:px-8 py-8">
          <form action="#" method="POST" class="space-y-6">
            @csrf

            <!-- Baris 1: Lab & Praktikum -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">
                  Lab
                </label>
                <div
                  class="relative flex items-center bg-slate-50 border border-slate-200
                         rounded-xl px-3 py-2.5 focus-within:ring-2 focus-within:ring-teal-400
                         focus-within:border-teal-400"
                >
                  <select
                    name="lab"
                    class="w-full bg-transparent text-sm text-slate-800 outline-none appearance-none pr-6"
                  >
                    <option value="" selected hidden>Pilih Lab</option>
                    <option value="lab1">Lab 1</option>
                    <option value="lab2">Lab 2</option>
                  </select>
                  <span class="absolute right-3 text-slate-400 text-xs">▾</span>
                </div>
              </div>

              <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">
                  Praktikum
                </label>
                <div
                  class="relative flex items-center bg-slate-50 border border-slate-200
                         rounded-xl px-3 py-2.5 focus-within:ring-2 focus-within:ring-teal-400
                         focus-within:border-teal-400"
                >
                  <select
                    name="praktikum"
                    class="w-full bg-transparent text-sm text-slate-800 outline-none appearance-none pr-6"
                  >
                    <option value="" selected hidden>Pilih Praktikum</option>
                    <option value="pbo">Pemrograman Berorientasi Objek</option>
                    <option value="bd">Basis Data</option>
                  </select>
                  <span class="absolute right-3 text-slate-400 text-xs">▾</span>
                </div>
              </div>
            </div>

            <!-- Baris 2: Kelas, NIM, Nama Lengkap -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
              <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">
                  Kelas
                </label>
                <input
                  type="text"
                  name="kelas"
                  placeholder="Contoh: IF-3B"
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5
                         text-sm text-slate-800 outline-none focus:ring-2 focus:ring-teal-400
                         focus:border-teal-400"
                />
              </div>

              <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">
                  NIM
                </label>
                <input
                  type="text"
                  name="nim"
                  placeholder="Masukkan NIM"
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5
                         text-sm text-slate-800 outline-none focus:ring-2 focus:ring-teal-400
                         focus:border-teal-400"
                />
              </div>

              <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">
                  Nama Lengkap
                </label>
                <input
                  type="text"
                  name="nama"
                  placeholder="Nama lengkap praktikan"
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5
                         text-sm text-slate-800 outline-none focus:ring-2 focus:ring-teal-400
                         focus:border-teal-400"
                />
              </div>
            </div>

            <!-- Baris 3: Modul & Nilai Total -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">
                  Modul
                </label>
                <div
                  class="relative flex items-center bg-slate-50 border border-slate-200
                         rounded-xl px-3 py-2.5 focus-within:ring-2 focus-within:ring-teal-400
                         focus-within:border-teal-400"
                >
                  <select
                    name="modul"
                    class="w-full bg-transparent text-sm text-slate-800 outline-none appearance-none pr-6"
                  >
                    <option value="" selected hidden>Pilih Modul</option>
                    <option value="modul1">Modul 1</option>
                    <option value="modul2">Modul 2</option>
                  </select>
                  <span class="absolute right-3 text-slate-400 text-xs">▾</span>
                </div>
              </div>

              <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">
                  Nilai Keseluruhan Total
                </label>
                <input
                  type="number"
                  step="0.01"
                  name="nilai_total"
                  placeholder="0 - 100"
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5
                         text-sm text-slate-800 outline-none focus:ring-2 focus:ring-teal-400
                         focus:border-teal-400"
                />
              </div>
            </div>

            <!-- Baris 4: Bukti Nilai Modul -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
              <label class="block text-xs font-semibold text-slate-500">
                Bukti Nilai Modul
              </label>

              <label
                class="inline-flex items-center gap-2 text-xs sm:text-sm font-medium
                       px-4 py-2 rounded-xl border border-slate-200 bg-slate-50
                       hover:bg-slate-100 cursor-pointer transition"
              >
                <span class="text-sm">📎</span>
                <span>Upload Bukti</span>
                <input type="file" name="bukti_modul" class="hidden" />
              </label>
            </div>

            <!-- Baris 5: Tombol Simpan & Reset -->
            <div class="mt-4 flex flex-col md:flex-row items-stretch md:items-center gap-4">
              <button
                type="submit"
                class="w-full md:flex-1 inline-flex items-center justify-center px-6 py-3
                       rounded-2xl bg-teal-500 text-white text-sm font-semibold
                       shadow-[0_10px_28px_rgba(20,184,166,0.4)]
                       hover:bg-teal-600 transition"
              >
                Simpan Data
              </button>

              <button
                type="reset"
                class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3
                       rounded-2xl border border-slate-200 bg-white text-sm font-medium
                       text-slate-600 hover:bg-slate-50 transition"
              >
                Reset
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>

  <!-- FOOTER -->
  <footer class="w-full mt-10">
    <div class="w-full bg-teal-500 text-center py-4">
      <p class="text-xs sm:text-sm font-medium text-white tracking-wide">
        Created By Tim The Third-Party Gang
      </p>
    </div>
  </footer>

</body>
</html>