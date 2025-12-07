<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ambil Shift</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>

<body class="bg-[#f5f7fb] min-h-screen flex flex-col">

<!-- HEADER (tidak diubah) -->
<header class="w-full bg-white border-b border-teal-50 shadow-[0_2px_6px_rgba(15,118,110,0.08)]">
    <div class="w-full px-0 py-3 flex items-center justify-between gap-4">

        <!-- Logo kiri -->
        <div class="flex items-stretch">
            <div class="flex items-center bg-teal-500 text-white px-5 sm:px-7 py-3 sm:py-4 rounded-br-3xl rounded-tr-3xl shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 sm:h-11 sm:w-11 bg-white/20 rounded-full flex items-center justify-center shadow-inner">
                        <img src="/images/utama/logo.png" class="h-8 w-8 sm:h-9 sm:w-9 object-contain rounded-full"/>
                    </div>
                    <div class="leading-tight">
                        <p class="text-[10px] sm:text-[11px] uppercase tracking-[0.16em] text-teal-50/90">Sistem Informasi</p>
                        <span class="font-semibold text-sm sm:text-lg tracking-wide">SIAP</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanan: user -->
        <div class="flex items-center justify-end flex-1 pr-0">
            @auth
            @php
                $initial = strtoupper(mb_substr(Auth::user()->name, 0, 1));
                $dashUrl = url('/dashboard');
            @endphp

            <!-- Desktop -->
            <div class="hidden md:flex items-center gap-4 rounded-full bg-white/80 border border-slate-200
                        px-5 py-2.5 shadow-[0_6px_18px_rgba(15,23,42,0.08)] backdrop-blur-sm max-w-md mr-4">

                <div class="flex flex-col leading-tight">
                    <span class="font-semibold text-sm text-slate-900">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-slate-500">{{ Auth::user()->email }}</span>
                </div>

                <a href="{{ $dashUrl }}" class="text-xs md:text-sm font-medium px-4 py-1.5 rounded-full
                        border border-teal-400 text-teal-600 bg-teal-50 hover:bg-teal-500 hover:text-white transition">
                    Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-xs md:text-sm font-medium px-4 py-1.5 rounded-full border border-slate-200
                                   text-slate-600 bg-white hover:bg-slate-50 transition">
                        Logout
                    </button>
                </form>

                <div class="relative">
                    <div class="flex items-center justify-center h-9 w-9 rounded-full bg-teal-500 text-white font-semibold shadow-sm">
                        {{ $initial }}
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-400 border-2 border-white"></span>
                </div>
            </div>
            @endauth
        </div>

    </div>
</header>

<!-- CONTENT -->
<main class="flex-1">
<div class="max-w-xl mx-auto py-10 px-4">

    <!-- Judul & Pesan -->
    <h1 class="text-2xl font-bold mb-2">Konfirmasi Pengambilan Shift</h1>
    <p class="text-sm text-slate-600 mb-4">
        Anda sudah mengambil <span class="font-semibold">{{ $takenCount ?? 0 }}</span> dari maksimal <span class="font-semibold">3</span> shift.
    </p>

    @if(session('success'))
        <div class="bg-emerald-100 text-emerald-700 p-3 mb-4 rounded text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- DETAIL SHIFT -->
    <div class="bg-white shadow-md p-6 rounded-lg">
        <p class="mb-3"><strong>Praktikum:</strong> {{ $shift->praktikum }}</p>
        <p class="mb-3"><strong>Shift:</strong> {{ $shift->name }}</p>
        <p class="mb-3"><strong>Kelas:</strong> {{ $shift->class_code }}</p>
        <p class="mb-3"><strong>Tanggal:</strong> {{ date('d M Y', strtotime($shift->date)) }}</p>
        <p class="mb-3"><strong>Jam:</strong> {{ $shift->start_time }} - {{ $shift->end_time }}</p>
        <p class="mb-3"><strong>Kuota:</strong> {{ $shift->registrations->count() }} / {{ $shift->capacity }}</p>

        {{-- STATUS --}}
        @if($isTaken)
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm p-3 rounded mb-4">
                Status: <strong>Anda sudah mengambil shift ini.</strong>
            </div>

            <form action="{{ route('asprak.jadwal.batal', $shift->id) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin batalkan shift ini?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 text-sm font-semibold">
                    Batalkan Shift Ini
                </button>
            </form>

        @elseif(($takenCount ?? 0) >= 3)
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm p-3 rounded mb-4">
                Anda sudah mengambil <strong>3 shift</strong>. Batalkan salah satu shift terlebih dahulu
                jika ingin mengambil shift ini.
            </div>

        @else
            <form action="{{ route('asprak.jadwal.ambil.store', $shift->id) }}" method="POST" class="mt-3">
                @csrf
                <button type="submit"
                    class="w-full bg-teal-600 text-white py-2 rounded hover:bg-teal-700 text-sm font-semibold">
                    Ambil Shift Ini
                </button>
            </form>
        @endif

        <a href="{{ route('asprak.jadwal.index') }}"
           class="block text-center mt-4 text-slate-600 hover:underline text-sm">
            Kembali ke daftar jadwal
        </a>
    </div>

</div>
</main>

<!-- FOOTER (tidak diubah) -->
<footer class="mt-4 bg-teal-600 border-t border-teal-700 shadow-inner">
    <div class="max-w-6xl mx-auto px-4 py-4 text-center">
        <p class="text-white text-[11px] md:text-sm tracking-wide">
            Created By <span class="font-semibold">Tim The Third-Party Gang</span>
        </p>
    </div>
</footer>

</body>
</html>
