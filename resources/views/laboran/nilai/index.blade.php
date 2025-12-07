<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SIAP - Rekap Nilai Praktikum (Laboran)</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-[#f5f7fb] min-h-screen flex flex-col">

<!-- HEADER -->
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

<!-- MAIN CONTENT -->
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

    <h1 class="text-2xl font-bold mb-2">Rekap Nilai Praktikum (Laboran)</h1>
    <p class="text-sm text-slate-600 mb-4">
        Berikut rekap nilai praktikum yang telah diinput oleh Laboran.
    </p>

    <!-- CARD -->
    <div class="bg-white rounded-3xl shadow-md border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-slate-100 text-slate-700">
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
                    @forelse($nilai as $i => $row)
                    <tr class="hover:bg-slate-50 transition duration-150 ease-in-out">
                        <td class="px-4 py-3">{{ $i + 1 }}</td>
                        <td class="px-4 py-3">{{ $row->lab }}</td>
                        <td class="px-4 py-3">{{ $row->praktikum }}</td>
                        <td class="px-4 py-3">{{ $row->kelas }}</td>
                        <td class="px-4 py-3 font-mono">{{ $row->nim }}</td>
                        <td class="px-4 py-3">{{ $row->nama_lengkap }}</td>
                        <td class="px-4 py-3">{{ $row->modul }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $row->nilai_total }}</td>

                        <td class="px-4 py-3">
                            @if($row->bukti_nilai_modul)
                                <a href="{{ asset($row->bukti_nilai_modul) }}"
                                   target="_blank"
                                   class="text-teal-600 underline text-xs">
                                   Lihat
                                </a>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-xs text-slate-500">
                            {{ $row->created_at?->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-4 py-6 text-center text-slate-400">
                            Belum ada nilai praktikum.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</main>

<!-- FOOTER -->
<footer class="bg-teal-500 text-white text-center py-4 mt-4">
    <p class="text-sm">Created by Tim The Third-Party Gang</p>
</footer>

</body>
</html>
