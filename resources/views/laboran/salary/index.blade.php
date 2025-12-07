<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transparasi Gaji - Laboran</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: "Poppins", sans-serif; } </style>
</head>

<body class="bg-[#f5f7fb] min-h-screen flex flex-col">

<!-- ====================== HEADER ====================== -->
<header class="w-full bg-white border-b border-teal-50 shadow-[0_2px_6px_rgba(15,118,110,0.08)]">
    <div class="w-full flex items-center justify-between px-0 py-3">
        <!-- Left Logo Block -->
        <div class="flex items-stretch">
            <div class="flex items-center bg-teal-500 text-white px-6 py-3 rounded-br-3xl rounded-tr-3xl shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 bg-white/20 rounded-full flex items-center justify-center shadow-inner">
                        <img src="/images/utama/logo.png" class="h-8 w-8 rounded-full" />
                    </div>
                    <div class="leading-tight">
                        <p class="text-[10px] uppercase tracking-[0.16em] text-teal-50/90">Sistem Informasi</p>
                        <span class="font-semibold text-lg tracking-wide">SIAP</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right User Capsule -->
        <div class="flex items-center justify-end flex-1 pr-2">
            @auth
                @php
                    $initial = strtoupper(substr(Auth::user()->name, 0, 1));
                    $isAdmin = Auth::user()->usertype === 'admin';
                    $dashUrl = $isAdmin ? url('/admin/dashboard') : url('/dashboard');
                @endphp

                <div class="hidden md:flex items-center gap-4 rounded-full bg-white/90 border border-slate-200 px-5 py-2.5
                            shadow-[0_6px_18px_rgba(15,23,42,0.08)] backdrop-blur-sm max-w-md mr-4">
                    <div class="flex flex-col leading-tight">
                        <span class="font-semibold text-sm text-slate-900">{{ Auth::user()->name }}</span>
                        <span class="text-xs text-slate-500">{{ Auth::user()->email }}</span>
                    </div>

                    <a href="{{ $dashUrl }}"
                       class="text-xs font-medium px-4 py-1.5 rounded-full border border-teal-400
                              text-teal-600 bg-teal-50 hover:bg-teal-500 hover:text-white transition">
                        Dashboard
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-xs font-medium px-4 py-1.5 rounded-full border border-slate-300
                                   text-slate-600 bg-white hover:bg-slate-50 transition">
                            Logout
                        </button>
                    </form>

                    <div class="relative">
                        <div class="flex items-center justify-center h-9 w-9 rounded-full bg-teal-500 text-white font-semibold">
                            {{ $initial }}
                        </div>
                        <span class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-400 border-2 border-white"></span>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>

<!-- ====================== CONTENT ====================== -->
<main class="flex-1">
    <section class="relative py-12 bg-gradient-to-b from-transparent via-[#eefdfc] to-[#e5f6f5]">
        <div class="pointer-events-none absolute -left-10 top-20 w-40 h-40 bg-teal-300/20 blur-3xl rounded-full"></div>
        <div class="pointer-events-none absolute -right-16 bottom-20 w-48 h-48 bg-emerald-300/20 blur-3xl rounded-full"></div>

        <div class="max-w-6xl mx-auto px-4 relative z-10">

            {{-- BACK TO DASHBOARD --}}
            <div class="mb-4">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[11px] font-medium
                          border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:border-slate-300
                          shadow-sm transition">
                    <span class="text-base">←</span>
                    Kembali ke Dashboard
                </a>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight mb-1">Transparasi Gaji</h1>
            <p class="text-sm text-slate-500 mb-6">Kelola salary asisten praktikum dengan mudah.</p>

            <!-- ALERT -->
            @if(session('success'))
                <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-2 text-sm text-emerald-800 shadow-sm">
                    ✔ {{ session('success') }}
                </div>
            @endif

            <!-- FILTER BOX -->
            <form method="GET" class="rounded-[26px] bg-gradient-to-br from-teal-100/40 via-white to-emerald-100/40 p-[1px] shadow-[0_10px_30px_rgba(15,23,42,0.08)] mb-8">
                <div class="bg-white rounded-[24px] p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label class="text-xs font-semibold text-slate-600">NIM</label>
                            <input name="nim" value="{{ request('nim') }}"
                                   class="w-full border border-slate-200 rounded-xl px-3 py-2 mt-1 text-sm focus:ring-2 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-slate-600">Nama</label>
                            <input name="nama" value="{{ request('nama') }}"
                                   class="w-full border border-slate-200 rounded-xl px-3 py-2 mt-1 text-sm focus:ring-2 focus:ring-teal-500">
                        </div>

                        <div class="flex gap-3 justify-end mt-2">
                            <a href="{{ route('laboran.salary.index') }}"
                               class="px-4 py-2 text-xs font-medium rounded-xl border bg-white hover:bg-slate-50">
                                Reset
                            </a>
                            <button class="px-4 py-2 text-xs font-semibold text-white rounded-xl bg-teal-500 hover:bg-teal-600 shadow">
                                Cari
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- HEADER + INPUT BUTTON -->
            <div class="flex justify-between items-center mb-4">
                <span class="text-sm text-slate-500">Daftar gaji asisten praktikum.</span>

                <a href="{{ route('laboran.salary.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-xs font-semibold text-white bg-teal-500 hover:bg-teal-600 shadow-md hover:shadow-lg transition">
                    <span class="text-lg">＋</span> Input Salary
                </a>
            </div>

            <!-- TABLE WRAPPER -->
            <div class="rounded-[26px] bg-gradient-to-br from-teal-100/35 via-white to-emerald-100/35 p-[1px] shadow-[0_12px_36px_rgba(15,23,42,0.10)]">
                <div class="bg-white rounded-[24px] overflow-hidden">
                    <table class="min-w-full text-xs md:text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-slate-700">
                            <th class="py-3 px-3 text-left">No</th>
                            <th class="py-3 px-3 text-left">Nama</th>
                            <th class="py-3 px-3 text-left">NIM</th>
                            <th class="py-3 px-3 text-left">Kelas</th>
                            <th class="py-3 px-3 text-center">Shift</th>
                            <th class="py-3 px-3 text-right">Slip Gaji</th>
                            <th class="py-3 px-3 text-center">Bukti</th>
                            <th class="py-3 px-3 text-center">Status</th>
                            <th class="py-3 px-3 text-center">Aksi</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($salaries as $index => $salary)
                            <tr class="border-t border-slate-100 hover:bg-slate-50/70 transition">
                                <td class="py-2.5 px-3">{{ $salaries->firstItem() + $index }}</td>
                                <td class="py-2.5 px-3">{{ $salary->nama_mahasiswa }}</td>
                                <td class="py-2.5 px-3">{{ $salary->nim }}</td>
                                <td class="py-2.5 px-3">{{ $salary->kelas ?? '-' }}</td>
                                <td class="py-2.5 px-3 text-center">{{ $salary->jumlah_shift }}</td>
                                <td class="py-2.5 px-3 text-right">Rp{{ number_format($salary->slip_gaji, 0, ',', '.') }}</td>

                                <td class="py-2.5 px-3 text-center">
                                    @if($salary->bukti_foto)
                                        <a href="{{ asset($salary->bukti_foto) }}" target="_blank">
                                            <img src="{{ asset($salary->bukti_foto) }}"
                                                 class="h-9 w-9 rounded-lg border object-cover shadow-sm hover:scale-110 transition">
                                        </a>
                                    @else
                                        <span class="text-[11px] text-slate-400">-</span>
                                    @endif
                                </td>

                                <td class="py-2.5 px-3 text-center">
                                    @if($salary->status === 'success')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200 text-[11px]">
                                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                            Success
                                        </span>
                                    @else
                                        <span class="inline-flex px-3 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-[11px]">
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                <!-- ================== ACTION BUTTONS ================== -->
                                <td class="py-2.5 px-3 text-center flex items-center gap-2 justify-center">

                                    <!-- EDIT BUTTON -->
                                    <a href="{{ route('laboran.salary.edit', $salary->id) }}"
                                       class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-amber-400 text-white hover:bg-amber-500 transition">
                                        Edit
                                    </a>

                                    <!-- DELETE BUTTON -->
                                    <form action="{{ route('laboran.salary.destroy', $salary->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus data salary ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-500 text-white hover:bg-red-600 transition">
                                            Hapus
                                        </button>
                                    </form>

                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="py-5 text-center text-slate-400">Belum ada data salary.</td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

            <div class="mt-5">
                {{ $salaries->withQueryString()->links() }}
            </div>

        </div>
    </section>
</main>

<footer class="mt-4 bg-teal-600 border-t border-teal-700 shadow-inner">
    <div class="max-w-6xl mx-auto px-4 py-4 text-center">
        <p class="text-white text-[11px] md:text-sm tracking-wide">
            Created By <span class="font-semibold">Tim The Third-Party Gang</span>
        </p>
    </div>
</footer>

</body>
</html>
