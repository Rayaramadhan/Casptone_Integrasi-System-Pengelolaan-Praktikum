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

  <div id="pageRequest" class="p-10">

    <h1 class="text-2xl font-bold mb-6">Request Jadwal Shift</h1>

    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-lg font-semibold mb-3">Jadwal Saat Ini</h2>

        <div class="grid grid-cols-2 gap-4">
            <div class="border rounded-xl p-4 bg-blue-50">
                <p class="font-bold">Kamis, 23 Okt 2025</p>
                <p class="text-sm mt-2">06.30 – 09.30</p>
                <p class="text-xs text-gray-500">SHIFT 3 (SI-48-06)</p>
            </div>

            <div class="border rounded-xl p-4 bg-blue-50">
                <p class="font-bold">Kamis, 23 Okt 2025</p>
                <p class="text-sm mt-2">15.30 – 18.30</p>
                <p class="text-xs text-gray-500">SHIFT 5 (SI-46-07)</p>
            </div>
        </div>

        <hr class="my-6 border-gray-300">
        <h2 class="text-lg font-semibold mb-3">Cari Jadwal Baru</h2>

        <div class="grid grid-cols-2 gap-6">

            <!-- Pilih Nama -->
            <div>
                <label class="block mb-1 text-sm font-medium">Pilih Nama</label>
                <select id="namaBaru"
                    class="w-full border p-2 rounded-lg">
                    <option value="">-- Pilih Nama --</option>
                    <option>Raya Ramadhan</option>
                    <option>Kamalia</option>
                    <option>Handra</option>
                </select>
            </div>

            <!-- Pilih Tanggal -->
            <div>
                <label class="block mb-1 text-sm font-medium">Tanggal</label>
                <input id="tanggalBaru" type="date"
                    class="w-full border p-2 rounded-lg">
            </div>

            <!-- Pilih Jam -->
            <div>
                <label class="block mb-1 text-sm font-medium">Jam Baru</label>
                <select id="jamBaru"
                    class="w-full border p-2 rounded-lg">
                    <option value="">-- Pilih Jam --</option>
                    <option value="06.30 – 09.30">06.30 – 09.30</option>
                    <option value="12.30 – 15.30">12.30 – 15.30</option>
                    <option value="15.30 – 18.30">15.30 – 18.30</option>
                </select>
            </div>

            <!-- Pesan -->
            <div>
                <label class="block mb-1 text-sm font-medium">Pesan (Opsional)</label>
                <textarea id="pesanBaru"
                    class="w-full border p-2 rounded-lg h-24"
                    placeholder="Tulis pesan..."></textarea>
            </div>

        </div>

        <!-- Tombol Kirim -->
        <div class="mt-6 flex justify-end">
            <button id="btnKirim"
                class="bg-teal-500 text-white px-6 py-2 rounded-lg hover:bg-teal-600">
                Kirim Permintaan →
            </button>
        </div>
    </div>
</div>

<div id="modalSukses"
     class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center">

    <div class="bg-white p-6 w-80 rounded-xl text-center shadow-lg">
        <h3 class="font-bold text-lg mb-2">Permintaan Terkirim!</h3>
        <p class="text-gray-600 mb-5">
            Permintaan tukar shift berhasil dikirim.
        </p>

        <button id="btnModalOk"
            class="bg-teal-500 text-white px-4 py-2 w-full rounded-lg hover:bg-teal-600">
            OK
        </button>
    </div>
</div>

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