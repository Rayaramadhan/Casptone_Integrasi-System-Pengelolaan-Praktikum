<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Praktikum - Praktikan</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>

<body class="bg-[#f5f7fb] min-h-screen flex flex-col">

  <header class="w-full bg-white border-b border-teal-50 shadow-[0_2px_6px_rgba(15,118,110,0.08)]">
    <div class="w-full px-0 py-3 flex items-center justify-between gap-4">

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

      <div class="flex items-center justify-end flex-1 pr-0">
        @auth
            @php
                $initial = strtoupper(mb_substr(Auth::user()->name, 0, 1));
                $isAdmin = Auth::user()->usertype === 'admin';
                $dashUrl = $isAdmin ? url('/admin/dashboard') : url('/dashboard');
            @endphp

            <div class="hidden md:flex items-center gap-4 rounded-full bg-white/80 border border-slate-200 px-5 py-2.5 shadow-[0_6px_18px_rgba(15,23,42,0.08)] backdrop-blur-sm max-w-md mr-4">
                <div class="flex flex-col leading-tight">
                    <span class="font-semibold text-sm text-slate-900">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-slate-500">{{ Auth::user()->email }}</span>
                </div>

                <a href="{{ $dashUrl }}" class="inline-flex items-center justify-center text-xs md:text-sm font-medium px-4 py-1.5 rounded-full border border-teal-400 text-teal-600 bg-teal-50 hover:bg-teal-500 hover:text-white transition">Dashboard</a>

                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center text-xs md:text-sm font-medium px-4 py-1.5 rounded-full border border-slate-200 text-slate-600 bg-white hover:bg-slate-50 transition">Logout</button>
                </form>

                <div class="relative">
                    <div class="flex items-center justify-center h-9 w-9 rounded-full bg-teal-500 text-white text-xs md:text-sm font-semibold shadow-sm">{{ $initial }}</div>
                    <span class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-400 border-2 border-white"></span>
                </div>
            </div>
        @endauth
      </div>
    </div>
  </header>
  <main class="flex-1">
    <div class="max-w-6xl mx-auto py-10 px-4">

      <a href="{{ url()->previous() }}"
         class="inline-flex items-center gap-2 px-4 py-2 mb-6 rounded-full text-[13px] font-medium border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 shadow-sm transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
          </svg>
          Kembali
      </a>

      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
          <div>
              <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Jadwal Praktikum</h1>
              <p class="text-sm text-slate-500 mt-1">Berikut jadwal praktikum yang telah disusun oleh Laboran untuk Anda.</p>
          </div>

          <div class="flex items-center gap-2">
              <select id="filter_lab" class="text-xs border border-slate-200 rounded-lg px-4 py-2.5 bg-white outline-none focus:ring-2 focus:ring-teal-500 shadow-sm transition">
                  <option value="">Semua Lab</option>
                  <option value="Lab SAG">Lab SAG</option>
                  <option value="Lab ERP">Lab ERP</option>
                  <option value="Lab EISD">Lab EISD</option>
                  <option value="Lab EIM">Lab EIM</option>
                  <option value="Lab EDM">Lab EDM</option>
              </select>
          </div>
      </div>

      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

          <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
              <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Daftar Jadwal yang Dapat Diikuti</p>
          </div>

          <div class="overflow-x-auto">
              <table class="min-w-full text-sm">
                  <thead class="bg-slate-50 text-slate-600 text-xs uppercase font-semibold tracking-wide">
                      <tr>
                          <th class="px-6 py-4 text-left">Lab</th>
                          <th class="px-6 py-4 text-left">Praktikum</th>
                          <th class="px-6 py-4 text-left">Shift</th>
                          <th class="px-6 py-4 text-left">Kelas</th>
                          <th class="px-6 py-4 text-left">Tanggal</th>
                          <th class="px-6 py-4 text-left">Jam</th>
                      </tr>
                  </thead>

                  <tbody id="shift_table_body">
                      @forelse($shifts as $s)
                      <tr class="shift-row border-t border-slate-100 hover:bg-slate-50/80 transition" data-lab="{{ $s->lab }}">
                          <td class="px-6 py-4 font-semibold text-teal-600">{{ $s->lab }}</td>
                          <td class="px-6 py-4 font-medium text-slate-800">{{ $s->praktikum }}</td>
                          <td class="px-6 py-4">
                              <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-teal-50 text-[10px] font-bold text-teal-700 border border-teal-100 uppercase">
                                  {{ $s->name }}
                              </span>
                          </td>
                          <td class="px-6 py-4 text-slate-600">{{ $s->class_code }}</td>
                          <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                              {{ \Carbon\Carbon::parse($s->date)->format('d M Y') }}
                          </td>
                          <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                              {{ $s->start_time }} – {{ $s->end_time }}
                          </td>
                      </tr>
                      @empty
                      <tr>
                          <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">
                              Jadwal praktikum belum tersedia.
                          </td>
                      </tr>
                      @endforelse
                  </tbody>
              </table>
          </div>
      </div>

    </div>
  </main>

  <footer class="mt-auto bg-teal-600 border-t border-teal-700 shadow-inner">
    <div class="max-w-6xl mx-auto px-4 py-4 text-center">
      <p class="text-white text-[11px] md:text-sm tracking-wide">
        Created By <span class="font-semibold">Tim The Third-Party Gang</span>
      </p>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterLab = document.getElementById('filter_lab');
        const rows = document.querySelectorAll('.shift-row');

        filterLab.addEventListener('change', function() {
            const selectedLab = this.value;
            rows.forEach(row => {
                if (selectedLab === "" || row.getAttribute('data-lab') === selectedLab) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });
  </script>

</body>
</html>