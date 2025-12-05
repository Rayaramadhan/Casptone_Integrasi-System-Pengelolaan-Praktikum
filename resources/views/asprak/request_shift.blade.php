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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            @foreach($myShifts as $shift)
            <label class="border-2 border-blue-200 rounded-xl p-6 cursor-pointer hover:bg-blue-50 transition">
                <input type="radio" name="my_shift" class="hidden" 
                       data-date="{{ $shift['date'] }}" 
                       data-time="{{ $shift['time'] }}" 
                       data-code="{{ $shift['code'] }}">
                <p class="font-bold text-lg text-blue-600">{{ \Carbon\Carbon::parse($shift['date'])->translatedFormat('l, d M Y') }}</p>
                <p class="text-2xl font-bold text-blue-600 mt-2">{{ $shift['time'] }}</p>
                <p class="text-sm text-gray-500">{{ $shift['code'] }}</p>
            </label>
            @endforeach
        </div>

        <hr class="my-6 border-gray-300">
        
        <h2 class="text-xl font-semibold mb-6">Cari Jadwal Baru</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-medium mb-2">Pilih Nama</label>
                <select id="target_user_id" class="w-full border rounded-lg p-3">
                    <option value="">-- Pilih Nama --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium mb-2">Tanggal</label>
                <input type="date" id="target_date" class="w-full border rounded-lg p-3">
            </div>

            <div>
                <label class="block font-medium mb-2">Jam</label>
                <select id="target_time" class="w-full border rounded-lg p-3">
                    <option value="">-- Pilih Jam --</option>
                    <option value="06.30 - 09.30">06.30 – 09.30</option>
                    <option value="09.30 - 12.30">09.30 – 12.30</option>
                    <option value="12.30 - 15.30">12.30 – 15.30</option>
                    <option value="15.30 - 18.30">15.30 – 18.30</option>
                </select>
            </div>

            <div>
                <label class="block font-medium mb-2">Kode Shift</label>
                <input type="text" id="target_shift_code" placeholder="ex: SHIFT 4 (SI-46-09)" class="w-full border rounded-lg p-3">
            </div>
        </div>

        <div class="mt-6">
            <label class="block font-medium mb-2">Pesan (Opsional)</label>
            <textarea id="message" class="w-full border rounded-lg p-3 h-32" placeholder="Tulis alasan tukar shift..."></textarea>
        </div>

        <div class="mt-8 flex justify-end">
            <button id="btnKirim" class="bg-teal-500 text-white px-8 py-4 rounded-lg text-lg hover:bg-teal-600 transition">
                Kirim Permintaan →
            </button>
        </div>
    </div>
</div>

<!-- Modal Sukses -->
<div id="modalSukses" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    <div class="bg-white p-10 rounded-2xl shadow-2xl text-center max-w-md">
        <h3 class="text-3xl font-bold mb-4">Permintaan Terkirim!</h3>
        <p class="text-gray-600 mb-8">Permintaan tukar shift berhasil dikirim.</p>
        <button onclick="window.location.href='{{ route('tukar_shift') }}'" 
                class="bg-teal-500 text-white px-8 py-4 rounded-lg w-full text-lg">
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
    // 1. Highlight radio yang dipilih
    document.querySelectorAll('input[name="my_shift"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('label[for]').forEach(label => {
                label.classList.remove('border-blue-500', 'bg-blue-50');
            });
            if (this.id) {
                document.querySelector(`label[for="${this.id}"]`)?.classList.add('border-blue-500', 'bg-blue-50');
            }
        });
    });

    // 2. Kirim permintaan
    document.getElementById('btnKirim').addEventListener('click', function (e) {
        e.preventDefault(); // safety

        // Pastikan ada yang dipilih
        const selectedMyShift = document.querySelector('input[name="my_shift"]:checked');
        if (!selectedMyShift) {
            alert('Pilih jadwal kamu dulu!');
            return;
        }

        // Ambil data dari dataset (pastikan di HTML ada data-xxx)
        const myDate = selectedMyShift.dataset.date;
        const myTime = selectedMyShift.dataset.time;
        const myCode = selectedMyShift.dataset.code;

        if (!myDate || !myTime || !myCode) {
            console.error('Radio button tidak punya data-date/time/code!', selectedMyShift);
            alert('Error: data shift tidak lengkap. Hubungi admin.');
            return;
        }

        const data = {
            my_shift_date: myDate,
            my_shift_time: myTime,
            my_shift_code: myCode,
            target_user_id: document.getElementById('target_user_id').value,
            target_date: document.getElementById('target_date').value,
            target_time: document.getElementById('target_time').value,
            target_shift_code: document.getElementById('target_shift_code').value,
            message: document.getElementById('message').value.trim(),
        };

        // Validasi field wajib
        if (!data.target_user_id || !data.target_date || !data.target_time || !data.target_shift_code) {
            alert('Lengkapi semua field Cari Jadwal Baru!');
            return;
        }

        // Disable tombol + loading
        this.disabled = true;
        this.innerHTML = 'Mengirim...';

        fetch("{{ route('request-shift.store') }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(res => {
            if (res.success) {
                document.getElementById('modalSukses').classList.remove('hidden');
            } else {
                alert(res.message || 'Gagal mengirim permintaan');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan jaringan');
        })
        .finally(() => {
            this.disabled = false;
            this.innerHTML = 'Kirim Permintaan';
        });
    });
</script>
</body>
</html>