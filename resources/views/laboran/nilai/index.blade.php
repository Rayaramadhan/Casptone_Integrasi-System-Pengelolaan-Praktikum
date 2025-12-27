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
        <div class="flex items-stretch">
            <div class="flex items-center bg-teal-500 text-white px-5 py-4 rounded-br-3xl rounded-tr-3xl">
                <div class="flex items-center gap-3">
                    <div class="h-11 w-11 bg-white/20 rounded-full flex items-center justify-center">
                        <img src="/images/utama/logo.png" class="h-9 w-9 object-contain rounded-full"/>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-widest text-teal-50/90">Sistem Informasi</p>
                        <span class="font-semibold text-lg">SIAP</span>
                    </div>
                </div>
            </div>
        </div>

        @auth
        <div class="hidden md:flex items-center gap-4 pr-4">
            <span class="text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</span>
            <a href="{{ url('/dashboard') }}"
               class="px-4 py-1.5 rounded-full border border-teal-400 text-teal-600 bg-teal-50 hover:bg-teal-500 hover:text-white transition text-sm">
                Dashboard
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="px-4 py-1.5 rounded-full border border-slate-200 text-slate-600 bg-white text-sm">
                    Logout
                </button>
            </form>
        </div>
        @endauth
    </div>
</header>

<!-- MAIN -->
<main class="flex-1">
<div class="max-w-6xl mx-auto py-10 px-4">

    <a href="{{ url()->previous() }}"
       class="inline-flex items-center gap-2 px-4 py-2 mb-6 rounded-full text-[13px]
              border border-slate-200 bg-white text-slate-600 hover:bg-slate-50">
        ← Kembali
    </a>

    <h1 class="text-2xl font-bold mb-2">Rekap Nilai Praktikum (Laboran)</h1>
    <p class="text-sm text-slate-600 mb-4">
        Berikut rekap nilai praktikum yang telah diinput oleh Laboran.
    </p>

    <!-- FILTER -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- LAB -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Lab</label>
                <select id="lab_select"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
                    <option value="">Pilih Lab</option>
                    @php
                        $labs = collect($nilai)->pluck('lab')->filter()->unique()->values();
                    @endphp
                    @foreach($labs as $lab)
                        <option value="{{ $lab }}">{{ $lab }}</option>
                    @endforeach
                </select>
            </div>

            <!-- PRAKTIKUM -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Praktikum</label>
                <select id="praktikum_select" disabled
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm disabled:bg-slate-200">
                    <option value="">Pilih Praktikum</option>
                </select>
            </div>

            <!-- MODUL -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Modul</label>
                <select id="modul_select" disabled
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm disabled:bg-slate-200">
                    <option value="">Pilih Modul</option>
                </select>
            </div>

            <!-- RESET -->
            <div class="flex items-end">
                <button id="reset_filter" type="button"
                        class="px-4 py-2.5 rounded-xl text-sm font-semibold border border-slate-200 bg-white hover:bg-slate-50">
                    Reset
                </button>
            </div>

        </div>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-3xl shadow-md border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Lab</th>
                        <th class="px-4 py-3">Praktikum</th>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3">NIM</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Modul</th>
                        <th class="px-4 py-3">Nilai</th>
                        <th class="px-4 py-3">Bukti</th>
                        <th class="px-4 py-3">Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($nilai as $i => $row)
                <tr data-lab="{{ $row->lab }}"
                    data-praktikum="{{ $row->praktikum }}"
                    data-modul="{{ $row->modul }}"
                    class="border-t hover:bg-slate-50">
                    <td class="px-4 py-3">{{ $i+1 }}</td>
                    <td class="px-4 py-3">{{ $row->lab }}</td>
                    <td class="px-4 py-3">{{ $row->praktikum }}</td>
                    <td class="px-4 py-3">{{ $row->kelas }}</td>
                    <td class="px-4 py-3 font-mono">{{ $row->nim }}</td>
                    <td class="px-4 py-3">{{ $row->nama_lengkap }}</td>
                    <td class="px-4 py-3">{{ $row->modul }}</td>
                    <td class="px-4 py-3 font-semibold">{{ $row->nilai_total }}</td>
                    <td class="px-4 py-3">
                        @if($row->bukti_nilai_modul)
                            <a href="{{ asset($row->bukti_nilai_modul) }}" target="_blank" class="text-teal-600 underline text-xs">
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
                    <td colspan="10" class="text-center py-6 text-slate-400">
                        Belum ada nilai praktikum
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
<footer class="bg-teal-500 text-white text-center py-4">
    <p class="text-sm">Created by Tim The Third-Party Gang</p>
</footer>

<!-- SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const labSelect = document.getElementById('lab_select');
    const praktikumSelect = document.getElementById('praktikum_select');
    const modulSelect = document.getElementById('modul_select');
    const resetBtn = document.getElementById('reset_filter');
    const rows = [...document.querySelectorAll('tbody tr[data-lab]')];

    const map = {};
    rows.forEach(r => {
        const lab = r.dataset.lab;
        const prak = r.dataset.praktikum;
        const modul = r.dataset.modul;

        if (!map[lab]) map[lab] = {};
        if (!map[lab][prak]) map[lab][prak] = new Set();
        map[lab][prak].add(modul);
    });

    function resetPraktikum() {
        praktikumSelect.innerHTML = '<option value="">Pilih Praktikum</option>';
        praktikumSelect.disabled = true;
    }

    function resetModul() {
        modulSelect.innerHTML = '<option value="">Pilih Modul</option>';
        modulSelect.disabled = true;
    }

    function loadPraktikum(lab) {
        resetPraktikum();
        resetModul();
        if (!map[lab]) return;

        Object.keys(map[lab]).sort().forEach(p => {
            praktikumSelect.innerHTML += `<option value="${p}">${p}</option>`;
        });

        praktikumSelect.disabled = false;
    }

    function loadModul(lab, prak) {
        resetModul();
        if (!map[lab] || !map[lab][prak]) return;

        [...map[lab][prak]].sort((a,b) => Number(a) - Number(b)).forEach(m => {
            modulSelect.innerHTML += `<option value="${m}">Modul ${m}</option>`;
        });

        modulSelect.disabled = false;
    }

    function applyFilter() {
        const lab = labSelect.value;
        const prak = praktikumSelect.value;
        const modul = modulSelect.value;

        rows.forEach(r => {
            const show =
                (!lab || r.dataset.lab === lab) &&
                (!prak || r.dataset.praktikum === prak) &&
                (!modul || r.dataset.modul === modul);

            r.style.display = show ? '' : 'none';
        });
    }

    labSelect.addEventListener('change', () => {
        loadPraktikum(labSelect.value);
        praktikumSelect.value = '';
        modulSelect.value = '';
        applyFilter();
    });

    praktikumSelect.addEventListener('change', () => {
        loadModul(labSelect.value, praktikumSelect.value);
        modulSelect.value = '';
        applyFilter();
    });

    modulSelect.addEventListener('change', applyFilter);

    resetBtn.addEventListener('click', () => {
        labSelect.value = '';
        resetPraktikum();
        resetModul();
        applyFilter();
    });

    resetPraktikum();
    resetModul();
});
</script>

</body>
</html>
