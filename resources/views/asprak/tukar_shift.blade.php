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

  <div class="p-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Data Permintaan Ganti Shift</h1>
        <a href="{{ route('request-shift.create') }}" class="flex items-center bg-teal-500 text-white px-4 py-2 rounded-lg hover:bg-teal-600">
            Request Tukar
        </a>
    </div>

    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Tanggal</th>
                    <th class="p-4 text-left">Jam</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left"><input type="checkbox" id="checkAll"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4">{{ $req->requester->name }}</td>
                    <td class="p-4">{{ \Carbon\Carbon::parse($req->requester_date)->format('d M Y') }}</td>
                    <td class="p-4">{{ $req->requester_time }}</td>
                    <td class="p-4">
                        @if($req->isTaken())
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">Sudah Diambil</span>
                        @else
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Tersedia</span>
                        @endif
                    </td>
                    <td class="p-4">
                        @if(!$req->isTaken())
                        <input type="checkbox" class="shift-checkbox" value="{{ $req->id }}">
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex justify-end mt-4">
        <button id="btnAmbil"
            class="bg-teal-400 text-white px-4 py-2 rounded-lg disabled:bg-gray-300 disabled:text-gray-600"
            disabled>
            Ambil
        </button>
    </div>
  </div>

    <!-- Modal Sukses Ambil -->
    <div id="modalAmbil" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-xl shadow-2xl text-center max-w-sm">
            <h3 class="text-2xl font-bold mb-3">Berhasil Mengambil Shift!</h3>
            <p class="text-gray-600 mb-6">Silahkan cek di bagian menu</p>
            <button onclick="location.reload()" class="bg-teal-500 text-white px-6 py-3 rounded-lg w-full">
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

    <script>
    document.getElementById('checkAll').onclick = function() {
        document.querySelectorAll('.shift-checkbox').forEach(cb => cb.checked = this.checked);
        toggleAmbilButton();
    };

    document.querySelectorAll('.shift-checkbox').forEach(cb => {
        cb.addEventListener('change', toggleAmbilButton);
    });

    function toggleAmbilButton() {
        const checked = document.querySelectorAll('.shift-checkbox:checked').length > 0;
        document.getElementById('btnAmbil').disabled = !checked;
    }

    document.getElementById('btnAmbil').onclick = function() {
        const selected = document.querySelector('.shift-checkbox:checked');
        if (!selected) return;

        const id = selected.value;

        fetch("{{ route('shift-exchange.take') }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                document.getElementById('modalAmbil').classList.remove('hidden');
            } else {
                alert(data.message || 'Gagal mengambil shift');
            }
        });
    };
    </script>
</body>
</html>