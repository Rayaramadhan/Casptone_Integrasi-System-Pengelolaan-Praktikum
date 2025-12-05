<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIAP - Laporan Praktikum</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
    <div class="w-full px-0 py-3 flex items-center justify-between gap-4">
      <div class="flex items-stretch">
        <div class="flex items-center bg-teal-500 text-white px-5 sm:px-7 py-3 sm:py-4 rounded-br-3xl rounded-tr-3xl shadow-sm">
          <div class="flex items-center gap-3">
            <div class="h-10 w-10 sm:h-11 sm:w-11 bg-white/20 rounded-full flex items-center justify-center shadow-inner">
              <img src="/images/utama/logo.png" alt="Logo SIAP" class="h-8 w-8 sm:h-9 sm:w-9 object-contain rounded-full" />
            </div>
            <div class="leading-tight">
              <p class="text-[10px] sm:text-[11px] uppercase tracking-[0.16em] text-teal-50/90">Sistem Informasi</p>
              <span class="font-semibold text-sm sm:text-lg tracking-wide">SIAP</span>
            </div>
          </div>
        </div>
      </div>

      <div class="flex items-center justify-end flex-1 pr-0">
        @auth
            @php
                $initial = strtoupper(mb_substr(Auth::user()->name, 0, 1));
                $dashUrl = url('/dashboard');
            @endphp
            <div class="hidden md:flex items-center gap-4 rounded-full bg-white/80 border border-slate-200 px-5 py-2.5 shadow-[0_6px_18px_rgba(15,23,42,0.08)] backdrop-blur-sm max-w-md mr-4">
                <div class="flex flex-col leading-tight">
                    <span class="font-semibold text-sm text-slate-900">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-slate-500">{{ Auth::user()->email }}</span>
                </div>
                <a href="{{ $dashUrl }}" class="inline-flex items-center justify-center text-xs md:text-sm font-medium px-4 py-1.5 rounded-full border border-teal-400 text-teal-600 bg-teal-50 hover:bg-teal-500 hover:text-white hover:border-teal-500 transition-colors duration-150">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center text-xs md:text-sm font-medium px-4 py-1.5 rounded-full border border-slate-200 text-slate-600 bg-white hover:bg-slate-50 hover:border-slate-300 transition-colors duration-150">Logout</button>
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

  <!-- MAIN CONTENT -->
  <main class="flex-1 w-full">
    <section class="max-w-7xl mx-auto px-4 lg:px-6 py-10">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900">📄 Laporan Praktikum</h1>
        <a href="{{ route('asprak.reports.create') }}" class="inline-flex items-center text-sm font-medium text-white px-6 py-2.5 rounded-full bg-teal-500 shadow-[0_4px_10px_rgba(20,184,166,0.35)] hover:bg-teal-600 transition">
          <span class="mr-2">➕</span> Submit Laporan Baru
        </a>
      </div>

      <!-- Statistics Cards -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl shadow-[0_8px_24px_rgba(15,23,42,0.06)] border border-slate-100 p-4 md:p-5 hover:shadow-lg transition">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs text-slate-500 mb-1">Total Laporan</p>
              <p class="text-xl md:text-2xl font-bold text-slate-900">{{ $stats['total'] }}</p>
            </div>
            <div class="h-10 w-10 md:h-12 md:w-12 bg-slate-100 rounded-xl flex items-center justify-center">
              <span class="text-xl md:text-2xl">📄</span>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow-[0_8px_24px_rgba(15,23,42,0.06)] border border-slate-100 p-4 md:p-5 hover:shadow-lg transition">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs text-slate-500 mb-1">Pending</p>
              <p class="text-xl md:text-2xl font-bold text-blue-600">{{ $stats['pending'] }}</p>
            </div>
            <div class="h-10 w-10 md:h-12 md:w-12 bg-blue-50 rounded-xl flex items-center justify-center">
              <span class="text-xl md:text-2xl">⏳</span>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow-[0_8px_24px_rgba(15,23,42,0.06)] border border-slate-100 p-4 md:p-5 hover:shadow-lg transition">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs text-slate-500 mb-1">Disetujui</p>
              <p class="text-xl md:text-2xl font-bold text-green-600">{{ $stats['approved'] }}</p>
            </div>
            <div class="h-10 w-10 md:h-12 md:w-12 bg-green-50 rounded-xl flex items-center justify-center">
              <span class="text-xl md:text-2xl">✅</span>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-2xl shadow-[0_8px_24px_rgba(15,23,42,0.06)] border border-slate-100 p-4 md:p-5 hover:shadow-lg transition">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs text-slate-500 mb-1">Perlu Revisi</p>
              <p class="text-xl md:text-2xl font-bold text-amber-600">{{ $stats['revision'] }}</p>
            </div>
            <div class="h-10 w-10 md:h-12 md:w-12 bg-amber-50 rounded-xl flex items-center justify-center">
              <span class="text-xl md:text-2xl">🔄</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Filter Section -->
      <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 overflow-hidden mb-6">
        <div class="bg-sky-50 border-b border-sky-100 px-6 py-4 flex items-center gap-3">
          <div class="h-9 w-9 rounded-full bg-sky-500 text-white flex items-center justify-center shadow-sm">
            <span class="text-lg">🔍</span>
          </div>
          <p class="text-sm text-slate-700 font-medium">Filter & Pencarian Laporan</p>
        </div>
        <div class="px-6 py-6">
          <form method="GET" action="{{ route('asprak.reports.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1.5">Status</label>
              <select name="status" class="w-full border-slate-200 rounded-xl shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="revision_requested" {{ request('status') == 'revision_requested' ? 'selected' : '' }}>Perlu Revisi</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1.5">Cari Judul</label>
              <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laporan..." class="w-full border-slate-200 rounded-xl shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
            </div>

            <div class="flex items-end">
              <button type="submit" class="w-full inline-flex items-center justify-center text-sm font-medium text-white px-4 py-2.5 rounded-xl bg-teal-500 hover:bg-teal-600 transition shadow-sm">
                <span class="mr-2">🔍</span> Filter
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Success Message -->
      @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl px-5 py-4 mb-6 flex items-start gap-3">
          <span class="text-2xl">✓</span>
          <div>
            <p class="font-medium text-emerald-800">Berhasil!</p>
            <p class="text-sm text-emerald-700 mt-0.5">{{ session('success') }}</p>
          </div>
        </div>
      @endif

      @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-2xl px-5 py-4 mb-6 flex items-start gap-3">
          <span class="text-2xl">⚠️</span>
          <div>
            <p class="font-medium text-red-800">Error!</p>
            <p class="text-sm text-red-700 mt-0.5">{{ session('error') }}</p>
          </div>
        </div>
      @endif

      <!-- Reports List -->
      <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 overflow-hidden">
        <div class="px-6 py-6">
          @if($reports->count() > 0)
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                      Laporan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                      Deadline
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                      Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                      Reviewed By
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                      Aksi
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                  @foreach($reports as $report)
                    <tr class="hover:bg-slate-50 transition">
                      <td class="px-6 py-4">
                        <div class="text-sm font-medium text-slate-900">{{ $report->title }}</div>
                        @if($report->description)
                          <div class="text-sm text-slate-500 mt-1">{{ Str::limit($report->description, 50) }}</div>
                        @endif
                        <div class="text-xs text-slate-400 mt-1">📎 {{ $report->original_filename }}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                        📅 {{ $report->deadline->format('d M Y') }}
                        @if($report->isOverdue())
                          <span class="block text-xs text-red-600 mt-1">⚠️ Terlambat</span>
                        @endif
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        @php $color = $report->status_color; @endphp
                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full {{ $color['bg'] }} {{ $color['text'] }}">
                          {{ $color['icon'] }} {{ $report->status_label }}
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                        @if($report->reviewer)
                          {{ $report->reviewer->name }}
                          <div class="text-xs text-slate-500">{{ $report->reviewed_at->format('d M Y') }}</div>
                        @else
                          <span class="text-slate-400">-</span>
                        @endif
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2">
                          <a href="{{ route('asprak.reports.show', $report) }}" 
                             class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition" 
                             title="Lihat Detail">
                            👁️
                          </a>
                          @if($report->status === 'revision_requested')
                            <a href="{{ route('asprak.reports.resubmit', $report) }}" 
                               class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition" 
                               title="Submit Ulang">
                              🔄
                            </a>
                          @endif
                          @if(in_array($report->status, ['pending', 'revision_requested']))
                            <form method="POST" action="{{ route('asprak.reports.destroy', $report) }}" 
                                  onsubmit="return confirm('Yakin ingin menghapus laporan ini?')" class="inline">
                              @csrf
                              @method('DELETE')
                              <button type="submit" 
                                      class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition" 
                                      title="Hapus">
                                🗑️
                              </button>
                            </form>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
              {{ $reports->links() }}
            </div>
          @else
            <div class="text-center py-16">
              <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 mb-4">
                <span class="text-4xl">📄</span>
              </div>
              <p class="text-slate-500 text-lg mb-4">Belum ada laporan yang disubmit.</p>
              <a href="{{ route('asprak.reports.create') }}" class="inline-flex items-center text-sm font-medium text-white px-6 py-2.5 rounded-full bg-teal-500 shadow-[0_4px_10px_rgba(20,184,166,0.35)] hover:bg-teal-600 transition">
                <span class="mr-2">➕</span> Submit Laporan Pertama
              </a>
            </div>
          @endif
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="w-full bg-white border-t border-slate-100 py-6 mt-auto">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <p class="text-sm text-slate-500">© 2025 SIAP - Sistem Informasi Asisten Praktikum</p>
    </div>
  </footer>

</body>
</html>
