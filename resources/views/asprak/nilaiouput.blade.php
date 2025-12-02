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
  {{-- ====== MAIN CONTENT ====== --}}
  <main class="flex-1 w-full">
    <section class="max-w-6xl mx-auto px-4 lg:px-6 py-10 space-y-10">

      {{-- FLASH MESSAGE --}}
      @if(session('success'))
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
          {{ session('success') }}
        </div>
      @endif

      {{-- ========== FORM INPUT NILAI ========== --}}
      <div>
        <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900 mb-6">
          Form Input Nilai
        </h1>

        <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 overflow-hidden">
          {{-- Info bar --}}
          <div class="bg-sky-50 border-b border-sky-100 px-6 py-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-sky-500 text-white flex items-center justify-center shadow-sm">
              🔔
            </div>
            <p class="text-sm text-slate-700">
              Masukkan data nilai yang sesuai.
            </p>
          </div>

          {{-- Body form --}}
          <div class="px-6 lg:px-8 py-8">
            <form action="{{ route('asprak.nilai.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
              @csrf

              {{-- Baris 1: Lab & Praktikum --}}
              <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1.5">Lab</label>
                  <select name="lab" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-teal-400 focus:border-teal-400">
                    <option value="" hidden selected>Pilih Lab</option>
                    <option value="Lab Komputer 1">Lab Komputer 1</option>
                    <option value="Lab Komputer 2">Lab Komputer 2</option>
                  </select>
                </div>

                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1.5">Praktikum</label>
                  <select name="praktikum" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-teal-400 focus:border-teal-400">
                    <option value="" hidden selected>Pilih Praktikum</option>
                    <option value="Pemrograman Dasar">Pemrograman Dasar</option>
                    <option value="Basis Data">Basis Data</option>
                  </select>
                </div>
              </div>

              {{-- Baris 2: Kelas, NIM, Nama --}}
              <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1.5">Kelas</label>
                  <input type="text" name="kelas"
                         class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-teal-400 focus:border-teal-400"
                         placeholder="IF-3B">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1.5">NIM</label>
                  <input type="text" name="nim"
                         class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-teal-400 focus:border-teal-400"
                         placeholder="NIM praktikan">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1.5">Nama Lengkap</label>
                  <input type="text" name="nama"
                         class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-teal-400 focus:border-teal-400"
                         placeholder="Nama lengkap praktikan">
                </div>
              </div>

              {{-- Baris 3: Modul & Nilai --}}
              <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1.5">Modul</label>
                  <input type="text" name="modul"
                         class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-teal-400 focus:border-teal-400"
                         placeholder="Modul praktikum">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1.5">Nilai Keseluruhan Total</label>
                  <input type="number" step="0.01" name="nilai_total"
                         class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-teal-400 focus:border-teal-400"
                         placeholder="0 - 100">
                </div>
              </div>

              {{-- Baris 4: Bukti --}}
              <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <label class="block text-xs font-semibold text-slate-500">
                    Bukti Nilai Modul
                </label>

                <label
                    class="inline-flex items-center gap-2 text-xs sm:text-sm font-medium px-4 py-2
                           rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100
                           cursor-pointer transition"
                >
                  {{-- ikon + teks --}}
                  <span class="text-sm" id="bukti_icon">📎</span>
                  <span id="bukti_text">Upload Bukti</span>

                  {{-- badge tanda sudah terpilih --}}
                  <span
                      id="bukti_badge"
                      class="hidden ml-1 inline-flex items-center gap-1 px-2 py-0.5 rounded-full
                             text-[10px] font-semibold bg-emerald-100 text-emerald-700"
                  >
                      ✔ Terpilih
                  </span>

                  <input type="file" name="bukti_modul" id="bukti_modul" class="hidden">
                </label>

                {{-- nama file (optional) --}}
                <p id="bukti_filename" class="text-[11px] text-slate-400 mt-1 sm:mt-0"></p>
              </div>

              {{-- Tombol --}}
              <div class="mt-4 flex flex-col md:flex-row items-stretch md:items-center gap-4">
                <button type="submit"
                        class="w-full md:flex-1 inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-teal-500 text-white text-sm font-semibold shadow-[0_10px_28px_rgba(20,184,166,0.4)] hover:bg-teal-600 transition">
                  Simpan Data
                </button>
                <button type="reset"
                        class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 rounded-2xl border border-slate-200 bg-white text-sm font-medium text-slate-600 hover:bg-slate-50 transition">
                  Reset
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      {{-- ========== TABEL REKAP NILAI ========== --}}
      <div>
        <h2 class="text-xl font-semibold text-slate-900 mb-4">
          Rekap Nilai Praktikum
        </h2>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
          <div class="overflow-x-auto">
            <table class="min-w-full text-xs sm:text-sm text-left">
              <thead class="bg-slate-50 text-slate-600">
                <tr>
                  <th class="px-4 py-3 border-b">No</th>
                  <th class="px-4 py-3 border-b">Lab</th>
                  <th class="px-4 py-3 border-b">Praktikum</th>
                  <th class="px-4 py-3 border-b">Kelas</th>
                  <th class="px-4 py-3 border-b">NIM</th>
                  <th class="px-4 py-3 border-b">Nama</th>
                  <th class="px-4 py-3 border-b">Modul</th>
                  <th class="px-4 py-3 border-b">Nilai</th>
                  <th class="px-4 py-3 border-b">Bukti</th>
                  <th class="px-4 py-3 border-b">Tanggal</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                @forelse($nilai as $index => $row)
                  <tr class="hover:bg-slate-50/60">
                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                    <td class="px-4 py-3">{{ $row->lab }}</td>
                    <td class="px-4 py-3">{{ $row->praktikum }}</td>
                    <td class="px-4 py-3">{{ $row->kelas }}</td>
                    <td class="px-4 py-3 font-mono text-xs">{{ $row->nim }}</td>
                    <td class="px-4 py-3">{{ $row->nama_lengkap }}</td>
                    <td class="px-4 py-3">{{ $row->modul }}</td>
                    <td class="px-4 py-3 font-semibold">{{ $row->nilai_total }}</td>
                    <td class="px-4 py-3">
                      @if($row->bukti_nilai_modul)
                        <a href="{{ Storage::url($row->bukti_nilai_modul) }}" target="_blank"
                           class="text-[11px] text-teal-600 underline">
                          Lihat
                        </a>
                      @else
                        <span class="text-[11px] text-slate-400">-</span>
                      @endif
                    </td>
                    <td class="px-4 py-3 text-[11px] text-slate-500">
                      {{ $row->created_at?->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="10" class="px-4 py-5 text-center text-slate-400 text-xs">
                      Belum ada data nilai.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </section>
  </main>

  {{-- FOOTER --}}
  <footer class="w-full mt-10">
    <div class="w-full bg-teal-500 text-center py-4">
      <p class="text-xs sm:text-sm font-medium text-white tracking-wide">
        Created By Tim The Third-Party Gang
      </p>
    </div>
  </footer>

  {{-- SCRIPT: indikator file sudah terpilih --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const input   = document.getElementById('bukti_modul');
        const text    = document.getElementById('bukti_text');
        const badge   = document.getElementById('bukti_badge');
        const fileNameEl = document.getElementById('bukti_filename');

        if (!input) return;

        input.addEventListener('change', function () {
            if (this.files && this.files.length > 0) {
                const file = this.files[0];

                // Ubah teks & tampilkan badge
                text.textContent = 'Bukti terupload';
                badge.classList.remove('hidden');

                // Tampilkan nama file (dipotong kalau kepanjangan)
                let name = file.name;
                if (name.length > 30) {
                    name = name.substring(0, 27) + '...';
                }
                if (fileNameEl) {
                    fileNameEl.textContent = 'File: ' + name;
                }
            } else {
                // Kalau file dihapus/dibatalkan
                text.textContent = 'Upload Bukti';
                badge.classList.add('hidden');
                if (fileNameEl) {
                    fileNameEl.textContent = '';
                }
            }
        });
    });
  </script>

</body>
</html>
