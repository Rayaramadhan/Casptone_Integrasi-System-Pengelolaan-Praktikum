<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Gaji Asisten Praktikum</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: "Poppins", sans-serif; }
    </style>
</head>

<body class="bg-[#f5f7fb] min-h-screen">
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

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
            Gaji Asisten Praktikum
        </h1>
        <p class="text-sm text-slate-600 mt-1">
            Hai, <span class="font-semibold text-teal-700">{{ $asprak->name }}</span>.
            Berikut adalah riwayat gaji Anda.
        </p>
    </div>

    <!-- CARD WRAPPER -->
    <div class="rounded-[24px] bg-gradient-to-br from-[#e8fffd] via-white to-[#e7f0ff] p-[1px] shadow-xl">
        
        <div class="bg-white rounded-[22px] overflow-hidden">

            <div class="overflow-x-auto">
                <table class="min-w-full text-xs md:text-sm border-separate border-spacing-0">

                    <thead>
                        <tr class="bg-teal-50 text-slate-700 uppercase text-[11px] tracking-wide">
                            <th class="py-3 px-3 text-left border-b border-teal-100">No</th>
                            <th class="py-3 px-3 text-left border-b border-teal-100">Nama</th>
                            <th class="py-3 px-3 text-left border-b border-teal-100">NIM</th>
                            <th class="py-3 px-3 text-left border-b border-teal-100">Kelas</th>
                            <th class="py-3 px-3 text-center border-b border-teal-100">Shift</th>
                            <th class="py-3 px-3 text-right border-b border-teal-100">Slip Gaji</th>
                            <th class="py-3 px-3 text-center border-b border-teal-100">Bukti</th>
                            <th class="py-3 px-3 text-center border-b border-teal-100">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($salaries as $index => $salary)
                        <tr class="group border-t border-slate-100 hover:bg-teal-50/40 transition">

                            <td class="py-3 px-3">
                                {{ $salaries->firstItem() + $index }}
                            </td>

                            <td class="py-3 px-3 font-medium text-slate-800">
                                {{ $salary->nama_mahasiswa }}
                            </td>

                            <td class="py-3 px-3 text-slate-700">
                                {{ $salary->nim }}
                            </td>

                            <td class="py-3 px-3 text-slate-700">
                                {{ $salary->kelas ?? '-' }}
                            </td>

                            <td class="py-3 px-3 text-center font-semibold text-slate-900">
                                {{ $salary->jumlah_shift }}
                            </td>

                            <td class="py-3 px-3 text-right font-semibold text-teal-700">
                                Rp{{ number_format($salary->slip_gaji, 0, ',', '.') }}
                            </td>

                            <!-- BUKTI -->
                            <td class="py-3 px-3 text-center">

                                @if($salary->bukti_foto)

                                    @php
                                        // Path sudah disimpan sebagai: storage/salary_receipts/xxx.jpg
                                        $imageUrl = asset($salary->bukti_foto);
                                    @endphp

                                    <a href="{{ $imageUrl }}" target="_blank" class="inline-block transform hover:scale-110 transition">
                                        <img src="{{ $imageUrl }}"
                                             class="h-10 w-10 rounded-md object-cover border border-slate-200 shadow-sm">
                                    </a>

                                @else
                                    <span class="text-[11px] text-slate-400">Tidak Ada</span>
                                @endif

                            </td>

                            <!-- STATUS -->
                            <td class="py-3 px-3 text-center">

                                @if($salary->status === 'success')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-semibold">
                                        <span class="h-2 w-2 bg-emerald-500 rounded-full"></span>
                                        Selesai
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-700 text-[11px] font-semibold">
                                        Pending
                                    </span>
                                @endif

                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-6 text-center text-slate-500 italic">
                                Belum ada data gaji untuk akun Anda.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <!-- PAGINATION -->
    <div class="mt-6 flex justify-center">
        {{ $salaries->links() }}
    </div>

</div>

<!-- FOOTER -->
<footer class="bg-teal-500 text-white text-center py-4 mt-4">
    <p class="text-sm">Created by Tim The Third-Party Gang</p>
</footer>


</body>
</html>
