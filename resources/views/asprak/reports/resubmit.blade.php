<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIAP - Submit Ulang Laporan</title>
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
    <section class="max-w-4xl mx-auto px-4 lg:px-6 py-10">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900">Submit Ulang Laporan</h1>
        <a href="{{ route('asprak.reports.show', $report) }}" class="inline-flex items-center text-sm font-medium text-slate-700 px-5 py-2.5 rounded-full border border-slate-200 bg-white hover:bg-slate-50 transition">
          <span class="mr-2">←</span> Kembali
        </a>
      </div>

      <!-- Revision Notes -->
      @if($report->revision_notes)
        <div class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4">
          <h3 class="text-sm font-semibold text-amber-900 mb-2 flex items-center gap-2">
            <span>📝</span> Catatan Revisi dari Laboran
          </h3>
          <p class="text-sm text-amber-800 leading-relaxed whitespace-pre-wrap">{{ $report->revision_notes }}</p>
        </div>
      @endif

      <!-- Original Report Info -->
      <div class="mb-6 bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4">
        <h3 class="text-sm font-semibold text-slate-700 mb-3">Informasi Laporan Sebelumnya</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <p class="text-xs text-slate-500 mb-1">Judul</p>
            <p class="text-sm font-medium text-slate-900">{{ $report->title }}</p>
          </div>
          <div>
            <p class="text-xs text-slate-500 mb-1">File Lama</p>
            <div class="flex items-center gap-2">
              <span class="text-sm text-slate-700">📎 {{ $report->original_filename }}</span>
              <a href="{{ route('asprak.reports.download', $report) }}" class="text-xs text-blue-600 hover:text-blue-700">Download</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Resubmit Form -->
      <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 overflow-hidden">
        <div class="bg-teal-50 border-b border-teal-100 px-6 py-4 flex items-center gap-3">
          <div class="h-9 w-9 rounded-full bg-teal-500 text-white flex items-center justify-center shadow-sm">
            <span class="text-lg">🔄</span>
          </div>
          <p class="text-sm text-slate-700 font-medium">Upload file laporan yang sudah diperbaiki</p>
        </div>

        <div class="px-6 lg:px-8 py-8">
          <form method="POST" action="{{ route('asprak.reports.updateResubmit', $report) }}" enctype="multipart/form-data">
            @csrf

            <!-- File Upload -->
            <div class="mb-6">
              <label for="file" class="block text-xs font-semibold text-slate-500 mb-1.5">
                File Laporan Baru <span class="text-red-500">*</span>
              </label>
              <input type="file" id="file" name="file" 
                     class="w-full border-slate-200 rounded-xl shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm @error('file') border-red-500 @enderror"
                     accept=".pdf,.doc,.docx,.zip,.rar" required>
              <p class="mt-1.5 text-xs text-slate-500">Format yang diterima: PDF, DOC, DOCX, ZIP, RAR (Max 10MB)</p>
              @error('file')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Info Box -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-100 rounded-xl">
              <h3 class="text-sm font-semibold text-blue-900 mb-2 flex items-center gap-2">
                <span>ℹ️</span> Informasi Penting
              </h3>
              <ul class="text-xs text-blue-700 space-y-1 list-disc list-inside">
                <li>File lama akan digantikan dengan file baru yang Anda upload</li>
                <li>Status laporan akan kembali menjadi "Pending" dan menunggu review ulang</li>
                <li>Pastikan file sudah sesuai dengan catatan revisi dari Laboran</li>
                <li>Judul dan deadline laporan tetap sama, hanya file yang diganti</li>
              </ul>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-slate-100">
              <a href="{{ route('asprak.reports.show', $report) }}" class="inline-flex items-center justify-center text-sm font-medium text-slate-700 px-6 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 transition">
                Batal
              </a>
              <button type="submit" class="inline-flex items-center justify-center text-sm font-medium text-white px-6 py-2.5 rounded-xl bg-teal-500 hover:bg-teal-600 transition shadow-sm">
                <span class="mr-2">🔄</span> Submit Ulang
              </button>
            </div>
          </form>
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
