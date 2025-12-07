<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Shift - Asprak</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FONT POPPINS -->
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
<div class="max-w-6xl mx-auto py-10 px-4">

    <!-- Tombol Kembali -->
    <a href="{{ url()->previous() }}"
       class="inline-flex items-center gap-2 px-4 py-2 mb-6 rounded-full text-[13px] font-medium
              border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:border-slate-300
              shadow-sm transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali
    </a>

    <!-- Judul -->
    <h1 class="text-3xl font-bold text-slate-900 mb-1">Jadwal Shift</h1>
    <p class="text-slate-600 mb-2">
        Berikut shift yang tersedia. Ambil shift sesuai kemampuan Anda.
    </p>

    <p class="text-sm text-slate-500 mb-6">
        Anda sudah mengambil <span class="font-semibold">{{ $takenCount ?? 0 }}</span>
        dari maksimal <span class="font-semibold">3</span> shift.
    </p>

    <!-- Flash -->
    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg text-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- CARD -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

        <div class="px-6 py-3 border-b bg-slate-50/80">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-[0.16em]">
                Daftar Shift Tersedia
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Praktikum</th>
                        <th class="px-6 py-3 text-left">Shift</th>
                        <th class="px-6 py-3 text-left">Kelas</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                        <th class="px-6 py-3 text-left">Jam</th>
                        <th class="px-6 py-3 text-left">Kuota</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($shifts as $s)
                    @php
                        $sudahAmbil = in_array($s->id, $takenShiftIds ?? []);
                        $kapasitasPenuh = $s->registrations->count() >= $s->capacity;
                        $maksimalTercapai = ($takenCount ?? 0) >= 3 && !$sudahAmbil;
                    @endphp

                    <tr class="border-t border-slate-100 hover:bg-slate-50 transition">
                        <td class="px-6 py-3 font-medium text-slate-800">{{ $s->praktikum }}</td>

                        <td class="px-6 py-3">
                            <span class="px-2.5 py-1 rounded-full bg-teal-50 text-teal-700 text-[11px] border border-teal-100">
                                {{ $s->name }}
                            </span>
                        </td>

                        <td class="px-6 py-3">{{ $s->class_code }}</td>

                        <td class="px-6 py-3 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($s->date)->format('d M Y') }}
                        </td>

                        <td class="px-6 py-3 whitespace-nowrap">
                            {{ $s->start_time }} – {{ $s->end_time }}
                        </td>

                        <td class="px-6 py-3">
                            <span class="font-semibold">{{ $s->registrations->count() }}</span>
                            / {{ $s->capacity }}
                        </td>

                        <td class="px-6 py-3">
                            @if($sudahAmbil)
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-semibold text-emerald-600">✔ Sudah diambil</span>

                                    <form action="{{ route('asprak.jadwal.batal', $s->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Batalkan shift ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 text-xs">
                                            Batalkan
                                        </button>
                                    </form>
                                </div>

                            @elseif($kapasitasPenuh)
                                <span class="text-xs font-semibold text-red-500">Penuh</span>

                            @elseif($maksimalTercapai)
                                <span class="text-xs font-semibold text-red-500">Max 3 shift</span>

                            @else
                                <a href="{{ route('asprak.jadwal.ambil', $s->id) }}"
                                   class="px-3 py-1 bg-teal-500 text-white rounded-lg hover:bg-teal-600 text-xs">
                                    Ambil Shift
                                </a>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-slate-400">
                            Tidak ada shift tersedia.
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
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
