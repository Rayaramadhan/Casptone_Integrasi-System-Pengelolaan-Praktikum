<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Backlog - SIAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', system-ui, sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-teal-50/30 to-slate-50 min-h-screen">
    
    <!-- Header -->
    <header class="bg-white border-b border-teal-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-teal-500 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg">📋</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Detail Backlog</h1>
                        <p class="text-xs text-slate-500">Informasi lengkap backlog</p>
                    </div>
                </div>
                <a href="{{ route('asprak.backlogs.index') }}" class="text-sm text-slate-600 hover:text-teal-600 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-2xl p-4 flex items-start gap-3">
            <span class="text-2xl">✅</span>
            <div class="flex-1">
                <h3 class="font-semibold text-green-900">Berhasil!</h3>
                <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Backlog Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden mb-6">
            <!-- Header -->
            <div class="bg-gradient-to-r from-teal-500 to-cyan-500 px-8 py-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-white mb-2">{{ $backlog->title }}</h2>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white">
                                {{ $backlog->status_label }}
                            </span>
                            @if($backlog->is_overdue)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-500 text-white">
                                ⚠️ Overdue
                            </span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('asprak.backlogs.edit', $backlog) }}" 
                       class="px-4 py-2 bg-white text-teal-700 rounded-xl font-medium hover:bg-teal-50 transition">
                        ✏️ Edit
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="px-8 py-6 space-y-6">
                <!-- Description -->
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 mb-2">📝 Deskripsi</h3>
                    <p class="text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $backlog->description }}</p>
                </div>

                <!-- Meta Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Deadline -->
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <p class="text-xs font-semibold text-slate-500 mb-1">📅 Deadline</p>
                        <p class="text-lg font-bold text-slate-900">
                            {{ $backlog->deadline->format('d F Y') }}
                        </p>
                        <p class="text-xs text-slate-600 mt-1">
                            {{ $backlog->deadline->diffForHumans() }}
                        </p>
                    </div>

                    <!-- Assign To -->
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <p class="text-xs font-semibold text-slate-500 mb-1">👤 Assign To</p>
                        <p class="text-lg font-bold text-slate-900">
                            {{ $backlog->assign_to ?? '-' }}
                        </p>
                    </div>
                </div>

                <!-- Progress Notes -->
                @if($backlog->progress_notes)
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 mb-2">📌 Catatan Progress</h3>
                    <div class="p-4 bg-blue-50 border border-blue-100 rounded-xl">
                        <p class="text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $backlog->progress_notes }}</p>
                    </div>
                </div>
                @endif

                <!-- Progress File -->
                @if($backlog->progress_file)
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 mb-2">📎 Dokumen Progress</h3>
                    <a href="{{ $backlog->progress_file_url }}" 
                       target="_blank"
                       class="flex items-center gap-3 p-4 bg-teal-50 border border-teal-100 rounded-xl hover:bg-teal-100 transition group">
                        <div class="w-12 h-12 bg-teal-500 rounded-xl flex items-center justify-center text-white text-xl">
                            📄
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-slate-900 group-hover:text-teal-700 transition">
                                {{ basename($backlog->progress_file) }}
                            </p>
                            <p class="text-xs text-slate-600">Klik untuk membuka file</p>
                        </div>
                        <span class="text-teal-600 text-xl">→</span>
                    </a>
                </div>
                @endif

                <!-- Timestamps -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-slate-200">
                    <div>
                        <p class="text-xs text-slate-500">Dibuat pada:</p>
                        <p class="text-sm font-medium text-slate-900">
                            {{ $backlog->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Terakhir diupdate:</p>
                        <p class="text-sm font-medium text-slate-900">
                            {{ $backlog->updated_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-4">⚡ Quick Actions</h3>
            <div class="grid grid-cols-3 gap-3">
                <!-- Change Status to Belum Dikerjakan -->
                @if($backlog->status != 'belum_dikerjakan')
                <form action="{{ route('asprak.backlogs.updateStatus', $backlog) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="belum_dikerjakan">
                    <button type="submit" 
                            class="w-full px-4 py-3 bg-yellow-50 text-yellow-700 rounded-xl font-medium hover:bg-yellow-100 transition border border-yellow-200">
                        ⏳ Belum Dikerjakan
                    </button>
                </form>
                @endif

                <!-- Change Status to On Progress -->
                @if($backlog->status != 'on_progress')
                <form action="{{ route('asprak.backlogs.updateStatus', $backlog) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="on_progress">
                    <button type="submit" 
                            class="w-full px-4 py-3 bg-blue-50 text-blue-700 rounded-xl font-medium hover:bg-blue-100 transition border border-blue-200">
                        🔄 On Progress
                    </button>
                </form>
                @endif

                <!-- Change Status to Done -->
                @if($backlog->status != 'done')
                <form action="{{ route('asprak.backlogs.updateStatus', $backlog) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="done">
                    <button type="submit" 
                            class="w-full px-4 py-3 bg-green-50 text-green-700 rounded-xl font-medium hover:bg-green-100 transition border border-green-200">
                        ✅ Done
                    </button>
                </form>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
