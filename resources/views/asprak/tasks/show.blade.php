<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIAP - Detail Tugas</title>
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
        <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900">Detail Tugas</h1>
        <a href="{{ route('asprak.tasks.index') }}" class="inline-flex items-center text-sm font-medium text-slate-700 px-5 py-2.5 rounded-full border border-slate-200 bg-white hover:bg-slate-50 transition">
          <span class="mr-2">←</span> Kembali
        </a>
      </div>

      <!-- Overdue Warning -->
      @if($task->isOverdue() && $task->status !== 'completed')
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl px-5 py-4 flex items-start gap-3">
          <span class="text-2xl">⚠️</span>
          <div class="flex-1">
            <h3 class="text-sm font-semibold text-red-900 mb-1">Tugas Terlambat</h3>
            <p class="text-xs text-red-700">Deadline tugas ini sudah terlewat. Segera selesaikan tugas ini!</p>
          </div>
        </div>
      @endif

      <!-- Task Detail Card -->
      <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 overflow-hidden mb-6">
        <div class="bg-teal-50 border-b border-teal-100 px-6 py-4 flex items-center gap-3">
          <div class="h-9 w-9 rounded-full bg-teal-500 text-white flex items-center justify-center shadow-sm">
            <span class="text-lg">📋</span>
          </div>
          <p class="text-sm text-slate-700 font-medium">Informasi Tugas</p>
        </div>

        <div class="px-6 lg:px-8 py-8">
          <!-- Title -->
          <div class="mb-6">
            <h2 class="text-xl font-semibold text-slate-900 mb-2">{{ $task->title }}</h2>
            <div class="flex flex-wrap gap-2 items-center">
              @php
                $statusBadge = match($task->status) {
                  'completed' => 'bg-emerald-100 text-emerald-700',
                  'in_progress' => 'bg-blue-100 text-blue-700',
                  default => 'bg-slate-100 text-slate-700'
                };
                $statusText = match($task->status) {
                  'completed' => '✅ Selesai',
                  'in_progress' => '⏳ Dikerjakan',
                  default => '⏸️ Pending'
                };
                $priorityBadge = match($task->priority) {
                  'high' => 'bg-red-100 text-red-700',
                  'medium' => 'bg-amber-100 text-amber-700',
                  default => 'bg-slate-100 text-slate-600'
                };
                $priorityText = match($task->priority) {
                  'high' => '🔴 Tinggi',
                  'medium' => '🟡 Sedang',
                  default => '🟢 Rendah'
                };
              @endphp
              <span class="inline-flex items-center text-xs font-medium px-3 py-1.5 rounded-full {{ $statusBadge }}">{{ $statusText }}</span>
              <span class="inline-flex items-center text-xs font-medium px-3 py-1.5 rounded-full {{ $priorityBadge }}">{{ $priorityText }}</span>
              @if($task->category)
                <span class="inline-flex items-center text-xs font-medium px-3 py-1.5 rounded-full bg-purple-100 text-purple-700">
                  🏷️ {{ $task->category }}
                </span>
              @endif
            </div>
          </div>

          <!-- Description -->
          <div class="mb-6">
            <h3 class="text-sm font-semibold text-slate-500 mb-2">Deskripsi</h3>
            <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $task->description }}</p>
          </div>

          <!-- Meta Info -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-4 bg-slate-50 rounded-xl">
            <div>
              <p class="text-xs font-semibold text-slate-500 mb-1">Deadline</p>
              <p class="text-sm text-slate-800">📅 {{ $task->deadline->format('d F Y') }}</p>
              @if($task->isOverdue() && $task->status !== 'completed')
                <p class="text-xs text-red-600 mt-1">Terlambat {{ $task->deadline->diffForHumans() }}</p>
              @else
                <p class="text-xs text-slate-500 mt-1">{{ $task->deadline->diffForHumans() }}</p>
              @endif
            </div>
            <div>
              <p class="text-xs font-semibold text-slate-500 mb-1">Dibuat</p>
              <p class="text-sm text-slate-800">🕐 {{ $task->created_at->format('d F Y H:i') }}</p>
              <p class="text-xs text-slate-500 mt-1">{{ $task->created_at->diffForHumans() }}</p>
            </div>
          </div>

          <!-- Quick Status Update -->
          @if($task->status !== 'completed')
            <div class="border-t border-slate-100 pt-6">
              <h3 class="text-sm font-semibold text-slate-700 mb-3">Update Status Cepat</h3>
              <form action="{{ route('asprak.tasks.updateStatus', $task) }}" method="POST" class="flex flex-wrap gap-2">
                @csrf
                @method('PATCH')
                @if($task->status === 'pending')
                  <button type="submit" name="status" value="in_progress" class="inline-flex items-center text-sm font-medium text-white px-5 py-2.5 rounded-xl bg-blue-500 hover:bg-blue-600 transition shadow-sm">
                    ▶️ Mulai Kerjakan
                  </button>
                @endif
                @if($task->status === 'in_progress')
                  <button type="submit" name="status" value="completed" class="inline-flex items-center text-sm font-medium text-white px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 transition shadow-sm">
                    ✅ Tandai Selesai
                  </button>
                @endif
              </form>
            </div>
          @endif
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex flex-col sm:flex-row justify-between gap-3">
        <a href="{{ route('asprak.tasks.edit', $task) }}" class="inline-flex items-center justify-center text-sm font-medium text-white px-6 py-3 rounded-xl bg-teal-500 hover:bg-teal-600 transition shadow-sm">
          ✏️ Edit Tugas
        </a>
        <form action="{{ route('asprak.tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="w-full inline-flex items-center justify-center text-sm font-medium text-white px-6 py-3 rounded-xl bg-red-500 hover:bg-red-600 transition shadow-sm">
            🗑️ Hapus Tugas
          </button>
        </form>
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
