<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIAP - Review Laporan</title>
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
    <section class="max-w-5xl mx-auto px-4 lg:px-6 py-10">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900">Review Laporan</h1>
        <a href="{{ route('laboran.reports.index') }}" class="inline-flex items-center text-sm font-medium text-slate-700 px-5 py-2.5 rounded-full border border-slate-200 bg-white hover:bg-slate-50 transition">
          <span class="mr-2">←</span> Kembali
        </a>
      </div>

      <!-- Status Info -->
      @if($report->status === 'approved')
        <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-2xl px-5 py-4 flex items-start gap-3">
          <span class="text-2xl">✅</span>
          <div>
            <h3 class="text-sm font-semibold text-emerald-900 mb-1">Laporan Sudah Disetujui</h3>
            <p class="text-xs text-emerald-700">Laporan ini telah disetujui pada {{ $report->reviewed_at->format('d F Y H:i') }}</p>
          </div>
        </div>
      @elseif($report->status === 'revision_requested')
        <div class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4 flex items-start gap-3">
          <span class="text-2xl">🔄</span>
          <div>
            <h3 class="text-sm font-semibold text-amber-900 mb-1">Revisi Diminta</h3>
            <p class="text-xs text-amber-700">Revisi telah diminta pada {{ $report->reviewed_at->format('d F Y H:i') }}</p>
          </div>
        </div>
      @elseif($report->isOverdue())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl px-5 py-4 flex items-start gap-3">
          <span class="text-2xl">⚠️</span>
          <div>
            <h3 class="text-sm font-semibold text-red-900 mb-1">Laporan Terlambat</h3>
            <p class="text-xs text-red-700">Deadline laporan ini sudah terlewat sejak {{ $report->deadline->diffForHumans() }}</p>
          </div>
        </div>
      @endif

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Report Details -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Report Info Card -->
          <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 overflow-hidden">
            <div class="bg-teal-50 border-b border-teal-100 px-6 py-4 flex items-center gap-3">
              <div class="h-9 w-9 rounded-full bg-teal-500 text-white flex items-center justify-center shadow-sm">
                <span class="text-lg">📄</span>
              </div>
              <p class="text-sm text-slate-700 font-medium">Detail Laporan</p>
            </div>

            <div class="px-6 lg:px-8 py-8">
              <!-- Title & Status -->
              <div class="mb-6">
                <h2 class="text-xl font-semibold text-slate-900 mb-2">{{ $report->title }}</h2>
                <div class="flex flex-wrap gap-2 items-center">
                  @php $color = $report->status_color; @endphp
                  <span class="inline-flex items-center text-xs font-medium px-3 py-1.5 rounded-full {{ $color['bg'] }} {{ $color['text'] }}">
                    {{ $color['icon'] }} {{ $report->status_label }}
                  </span>
                </div>
              </div>

              <!-- Description -->
              @if($report->description)
                <div class="mb-6">
                  <h3 class="text-sm font-semibold text-slate-500 mb-2">Deskripsi</h3>
                  <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $report->description }}</p>
                </div>
              @endif

              <!-- File Info -->
              <div class="mb-6 p-4 bg-slate-50 rounded-xl">
                <h3 class="text-sm font-semibold text-slate-500 mb-3">File Laporan</h3>
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                      <span class="text-lg">📎</span>
                    </div>
                    <div>
                      <p class="text-sm font-medium text-slate-900">{{ $report->original_filename }}</p>
                      <p class="text-xs text-slate-500">{{ $report->file_size }} • {{ strtoupper($report->file_extension) }}</p>
                    </div>
                  </div>
                  <a href="{{ route('laboran.reports.download', $report) }}" class="inline-flex items-center text-xs font-medium text-white px-4 py-2 rounded-lg bg-blue-500 hover:bg-blue-600 transition">
                    <span class="mr-1">⬇️</span> Download
                  </a>
                </div>
              </div>

              <!-- Meta Info -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-slate-50 rounded-xl">
                <div>
                  <p class="text-xs font-semibold text-slate-500 mb-1">Deadline</p>
                  <p class="text-sm text-slate-800">📅 {{ $report->deadline->format('d F Y') }}</p>
                  @if($report->isOverdue())
                    <p class="text-xs text-red-600 mt-1">Terlambat {{ $report->deadline->diffForHumans() }}</p>
                  @else
                    <p class="text-xs text-slate-500 mt-1">{{ $report->deadline->diffForHumans() }}</p>
                  @endif
                </div>
                <div>
                  <p class="text-xs font-semibold text-slate-500 mb-1">Disubmit</p>
                  <p class="text-sm text-slate-800">🕐 {{ $report->created_at->format('d F Y H:i') }}</p>
                  <p class="text-xs text-slate-500 mt-1">{{ $report->created_at->diffForHumans() }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Revision Notes (if exists) -->
          @if($report->revision_notes)
            <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 overflow-hidden">
              <div class="bg-amber-50 border-b border-amber-100 px-6 py-4 flex items-center gap-3">
                <div class="h-9 w-9 rounded-full bg-amber-500 text-white flex items-center justify-center shadow-sm">
                  <span class="text-lg">📝</span>
                </div>
                <p class="text-sm text-slate-700 font-medium">Catatan Revisi</p>
              </div>
              <div class="px-6 py-6">
                <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $report->revision_notes }}</p>
              </div>
            </div>
          @endif
        </div>

        <!-- Right Column: Submitter Info & Actions -->
        <div class="space-y-6">
          <!-- Submitter Info -->
          <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 overflow-hidden">
            <div class="bg-purple-50 border-b border-purple-100 px-6 py-4 flex items-center gap-3">
              <div class="h-9 w-9 rounded-full bg-purple-500 text-white flex items-center justify-center shadow-sm">
                <span class="text-lg">👤</span>
              </div>
              <p class="text-sm text-slate-700 font-medium">Disubmit Oleh</p>
            </div>
            <div class="px-6 py-6">
              <div class="flex items-center gap-3 mb-4">
                <div class="h-12 w-12 rounded-full bg-teal-500 text-white flex items-center justify-center text-lg font-semibold">
                  {{ strtoupper(substr($report->user->name, 0, 1)) }}
                </div>
                <div>
                  <p class="text-sm font-semibold text-slate-900">{{ $report->user->name }}</p>
                  <p class="text-xs text-slate-500">{{ $report->user->email }}</p>
                </div>
              </div>
              <div class="pt-4 border-t border-slate-100">
                <p class="text-xs text-slate-500 mb-1">Role</p>
                <p class="text-sm font-medium text-slate-800">{{ ucfirst($report->user->usertype ?? 'Asprak') }}</p>
              </div>
            </div>
          </div>

          <!-- Review Actions -->
          @if($report->status === 'pending')
            <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 overflow-hidden">
              <div class="bg-sky-50 border-b border-sky-100 px-6 py-4 flex items-center gap-3">
                <div class="h-9 w-9 rounded-full bg-sky-500 text-white flex items-center justify-center shadow-sm">
                  <span class="text-lg">⚙️</span>
                </div>
                <p class="text-sm text-slate-700 font-medium">Aksi Review</p>
              </div>
              <div class="px-6 py-6 space-y-3">
                <!-- Approve Button -->
                <form method="POST" action="{{ route('laboran.reports.approve', $report) }}" onsubmit="return confirm('Yakin ingin menyetujui laporan ini?')">
                  @csrf
                  <button type="submit" class="w-full inline-flex items-center justify-center text-sm font-medium text-white px-6 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 transition shadow-sm">
                    <span class="mr-2">✅</span> Approve Laporan
                  </button>
                </form>

                <!-- Request Revision Button -->
                <a href="{{ route('laboran.reports.revisionForm', $report) }}" class="w-full inline-flex items-center justify-center text-sm font-medium text-amber-700 px-6 py-3 rounded-xl bg-amber-50 border border-amber-200 hover:bg-amber-100 transition">
                  <span class="mr-2">🔄</span> Minta Revisi
                </a>
              </div>
            </div>
          @endif

          <!-- Review Info (if reviewed) -->
          @if($report->reviewer)
            <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 overflow-hidden">
              <div class="bg-slate-50 border-b border-slate-100 px-6 py-4 flex items-center gap-3">
                <div class="h-9 w-9 rounded-full bg-slate-500 text-white flex items-center justify-center shadow-sm">
                  <span class="text-lg">ℹ️</span>
                </div>
                <p class="text-sm text-slate-700 font-medium">Info Review</p>
              </div>
              <div class="px-6 py-6 space-y-3">
                <div>
                  <p class="text-xs text-slate-500 mb-1">Direview Oleh</p>
                  <p class="text-sm font-medium text-slate-800">{{ $report->reviewer->name }}</p>
                </div>
                <div>
                  <p class="text-xs text-slate-500 mb-1">Tanggal Review</p>
                  <p class="text-sm font-medium text-slate-800">{{ $report->reviewed_at->format('d F Y H:i') }}</p>
                </div>
              </div>
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
