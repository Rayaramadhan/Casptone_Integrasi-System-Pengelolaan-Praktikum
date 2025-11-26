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

    <div class="container mx-auto mt-10 px-4">
    {{-- Judul --}}
    <h1 class="text-3xl font-bold mb-6">Presensi Asisten</h1>

    {{-- Pesan Sukses & Error --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl mb-5">
            ✔ {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl mb-5">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- Card Form Presensi --}}
    <div class="bg-white shadow rounded-xl p-6 mb-8">
    
        <form id="formCheckin" action="{{ route('presensi.checkin') }}" 
            method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Input Tanggal --}}
                <div>
                    <label class="block mb-2 font-semibold">Tanggal</label>
                    <input type="date" 
                        name="tanggal"
                        class="w-full border-gray-300 rounded-xl shadow-sm" required>
                </div>

                {{-- Input Shift --}}
                <div>
                    <label class="block mb-2 font-semibold">Kelas/Shift</label>
                    <select name="shift" class="w-full border-gray-300 rounded-xl shadow-sm" required>
                        <option value="">-- Pilih Kelas/Shift --</option>
                        <option value="SHIFT 3 (SI-46-06)" {{ old('shift') == 'SHIFT 3 (SI-46-06)' ? 'selected' : '' }}>
                            SHIFT 3 (SI-46-06)
                        </option>
                        <option value="SHIFT 5 (SI-46-09)" {{ old('shift') == 'SHIFT 5 (SI-46-09)' ? 'selected' : '' }}>
                            SHIFT 5 (SI-46-09)
                        </option>
                    </select>
                </div>
            </div>

            {{-- Upload Bukti --}}
            <div class="mt-6">
                <button id="btnBukti" type="button"
                    class="px-6 py-2 border rounded-lg font-semibold hover:bg-gray-100"
                    onclick="document.getElementById('buktiInput').click()">
                    📎 Bukti Hadir
                </button>
                <input type="file" name="proof" id="buktiInput" class="hidden" accept="image/*,application/pdf">

                <p id="statusBukti" class="text-sm text-green-600 font-semibold mt-2 hidden">
                    ✔ Bukti hadir telah diupload
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    
                {{-- Tombol Check-In --}}
                <button type="submit" 
                    id="btnCheckin"
                    onclick="handleCheckinClick()"
                    class="w-full py-3 bg-gray-300 text-gray-700 rounded-xl font-semibold"
                    disabled>
                    Check-in
                </button>
            
        </form>

        {{-- Tombol Check-out --}}
        <form id="formCheckout" action="{{ route('presensi.checkout') }}" method="POST">
            @csrf

            @if($todayPresensi && $todayPresensi->check_in_at && !$todayPresensi->check_out_at)
                <input type="hidden" name="shift" value="{{ $todayPresensi->shift }}">
                <button type="submit" 
                    id="btnCheckout" 
                    class="w-full py-3 bg-gray-300 text-gray-700 rounded-xl font-semibold">
                    Check-out
                </button>
            @else
                <button type="button" disabled
                    class="w-full py-3 bg-gray-400 text-gray-700 rounded-xl font-semibold cursor-not-allowed">
                    @if($todayPresensi?->check_out_at)
                        Sudah Check-out pada {{ $todayPresensi->check_out_at->format('H:i') }}
                    @elseif($todayPresensi?->check_in_at)
                        Belum bisa check-out (tunggu shift selesai)
                    @else
                        Belum Check-in
                    @endif
                </button>
            @endif
            </div>
        </form>
        
    </div>
    
    {{-- Status Kehadiran --}}
    <div class="bg-white shadow rounded-xl p-6 mb-8">
        
        <h2 class="text-lg font-bold mb-3">Status Kehadiran Kamu Hari Ini</h2>

        @if ($todayPresensi)
            {{-- Sudah Check-in --}}
            @if ($todayPresensi->check_out_at)
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl">
                    Kamu sudah check-out pada {{ $todayPresensi->check_out_at->format('H:i') }}.
                </div>
            
            @elseif ($todayPresensi->check_in_at)
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl">
                    Kamu sudah check-in pada {{ $todayPresensi->check_in_at->format('H:i') }}.
                </div>
            @endif

        @else
        {{-- Belum ada presensi --}}
            <div id="statusBox"
                class="bg-teal-100 text-gray-700 px-4 py-3 rounded-xl">
                ℹ️ Belum ada data kehadiran
            </div>
        @endif
        
    </div>

    {{-- Riwayat Kehadiran --}}
    <div class="bg-white shadow rounded-xl p-6 mb-8">

        <h2 class="text-lg font-bold mb-3">Riwayat Kehadiran</h2>

        <table class="w-full text-left text-gray-700">
            <thead>
                <tr class="border-b">
                    <th class="py-3">Tanggal</th>
                    <th class="py-3">Kelas/Shift</th>
                    <th class="py-3">Waktu Check-in</th>
                    <th class="py-3">Waktu Check-out</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($history as $p)
                    <tr class="border-b">
                        <td class="py-3">{{ $p->tanggal }}</td>
                        <td>{{ $p->shift }}</td>
                        <td>{{ $p->check_in_at ? $p->check_in_at->format('H:i') : '-' }}</td>
                        <td>{{ $p->check_out_at ? $p->check_out_at->format('H:i') : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-gray-400">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
                    
            </tbody>
        </table>
    </div>
    
    </div>

    {{-- POPUP ERROR CHECK-IN --}}
    <div id="popupCheckinError"
        class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center z-50 hidden">

        <div class="bg-white rounded-xl shadow-xl p-8 w-80 text-center">
            <div class="text-5xl mb-4">⚠️</div>
            <h2 class="text-xl font-bold mb-3">Gagal Check-In</h2>
            <p class="text-gray-600 mb-6">Upload bukti hadir terlebih dahulu.</p>

            <button onclick="closePopup()"
                    class="px-6 py-2 bg-teal-600 text-white rounded-xl hover:bg-teal-700">
                    Oke
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

    {{-- SCRIPT --}}
    <script>
        const proofInput = document.getElementById('buktiInput');
        const btnCheckin = document.getElementById('btnCheckin');
        const statusBukti = document.getElementById('statusBukti');

        proofInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                statusBukti.classList.remove('hidden');
                statusBukti.textContent = `✔ ${this.files[0].name}`;

                btnCheckin.disabled = false;
                btnCheckin.classList.remove('bg-gray-300', 'text-gray-700', 'cursor-not-allowed');
                btnCheckin.classList.add('bg-teal-600', 'text-white', 'hover:bg-teal-700');
            } else {
                resetCheckinButton();
            }
        });

        // Jika form di-submit tapi belum ada bukti (untuk jaga-jaga)
        document.getElementById('formCheckin').addEventListener('submit', function(e) {
            if (!proofInput.files || proofInput.files.length === 0) {
                e.preventDefault();
                document.getElementById('popupCheckinError').classList.remove('hidden');
            }
        });

        function resetCheckinButton() {
            statusBukti.classList.add('hidden');
            btnCheckin.disabled = true;
            btnCheckin.classList.add('bg-gray-300', 'text-gray-700', 'cursor-not-allowed');
            btnCheckin.classList.remove('bg-teal-600', 'text-white', 'hover:bg-teal-700');
        }

        function closePopup() {
            document.getElementById('popupCheckinError').classList.add('hidden');
        }

        // Reset saat halaman dimuat ulang (jika ada error sebelumnya)
        document.addEventListener('DOMContentLoaded', function() {
            if (!proofInput.files || proofInput.files.length === 0) {
                resetCheckinButton();
            }
        });
    </script>
</body>
</html>