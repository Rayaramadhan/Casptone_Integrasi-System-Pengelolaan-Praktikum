<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penugasan - SIAP</title>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg">📄</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Detail Penugasan</h1>
                        <p class="text-xs text-slate-500">Informasi lengkap dan daftar submission</p>
                    </div>
                </div>
                <a href="{{ route('laboran.assignments.index') }}" class="text-sm text-slate-600 hover:text-teal-600 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Assignment Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Main Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <div class="flex items-center gap-3 mb-3">
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                    {{ $assignment->tipe }}
                                </span>
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $assignment->status_color }}">
                                    {{ $assignment->status_label }}
                                </span>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-900 mb-2">{{ $assignment->judul }}</h2>
                            <p class="text-sm text-slate-600">📚 {{ $assignment->praktikum }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('laboran.assignments.edit', $assignment) }}" 
                               class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm rounded-lg transition">
                                ✏️ Edit
                            </a>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 pt-6 space-y-4">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-700 mb-2">Deskripsi</h3>
                            <p class="text-sm text-slate-600 whitespace-pre-line">{{ $assignment->deskripsi }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 pt-4">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Deadline</p>
                                <p class="text-sm font-semibold text-slate-900">{{ $assignment->deadline->format('d M Y, H:i') }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ $assignment->deadline->diffForHumans() }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Dibuat</p>
                                <p class="text-sm font-semibold text-slate-900">{{ $assignment->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-slate-500 mt-1">Oleh: {{ $assignment->creator->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="border-t border-slate-200 mt-6 pt-6 flex gap-3">
                        @if($assignment->status == 'active')
                            <form method="POST" action="{{ route('laboran.assignments.close', $assignment) }}" class="flex-1">
                                @csrf
                                <button type="submit" onclick="return confirm('Tutup penugasan ini? Asprak tidak bisa submit lagi.')"
                                        class="w-full px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition">
                                    🔒 Tutup Penugasan
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('laboran.assignments.reopen', $assignment) }}" class="flex-1">
                                @csrf
                                <button type="submit"
                                        class="w-full px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition">
                                    🔓 Buka Kembali
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('laboran.assignments.destroy', $assignment) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus penugasan ini? Semua submission akan terhapus!')"
                                    class="px-4 py-2.5 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-medium rounded-lg transition">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Submissions List -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                        <h3 class="font-bold text-slate-900">📥 Daftar Submission</h3>
                        <p class="text-xs text-slate-500 mt-1">Total: {{ $assignment->total_submissions }} submission</p>
                    </div>

                    @if($assignment->submissions->count() > 0)
                    <div class="divide-y divide-slate-100">
                        @foreach($assignment->submissions as $submission)
                        <div class="p-6 hover:bg-slate-50 transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h4 class="font-semibold text-slate-900">{{ $submission->asprak->name }}</h4>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $submission->status_color }}">
                                            {{ $submission->status_label }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 mb-2">Disubmit: {{ $submission->created_at->diffForHumans() }}</p>
                                    @if($submission->catatan)
                                        <p class="text-sm text-slate-600 italic">"{{ Str::limit($submission->catatan, 80) }}"</p>
                                    @endif
                                    @if($submission->feedback)
                                        <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-100">
                                            <p class="text-xs font-semibold text-blue-900 mb-1">Feedback:</p>
                                            <p class="text-sm text-blue-800">{{ $submission->feedback }}</p>
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('laboran.submissions.show', $submission) }}" 
                                   class="ml-4 px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white text-sm rounded-lg transition">
                                    Detail
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="p-12 text-center">
                        <div class="text-5xl mb-4">📭</div>
                        <p class="text-sm text-slate-500">Belum ada submission</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar Statistics -->
            <div class="space-y-6">
                <!-- Stats -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="font-bold text-slate-900 mb-4">📊 Statistik</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600">Total Submission</span>
                            <span class="text-lg font-bold text-slate-900">{{ $assignment->total_submissions }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-green-600">✅ Approved</span>
                            <span class="text-lg font-bold text-green-600">{{ $assignment->approved_count }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-yellow-600">⏳ Pending</span>
                            <span class="text-lg font-bold text-yellow-600">{{ $assignment->pending_count }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-red-600">❌ Rejected</span>
                            <span class="text-lg font-bold text-red-600">{{ $assignment->rejected_count }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gradient-to-br from-teal-50 to-blue-50 rounded-2xl shadow-sm border border-teal-100 p-6">
                    <h3 class="font-bold text-slate-900 mb-4">⚡ Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('laboran.submissions.index') }}?assignment={{ $assignment->id }}" 
                           class="block w-full px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-lg border border-slate-200 transition text-center">
                            📋 Lihat Semua Submission
                        </a>
                        <a href="{{ route('laboran.assignments.edit', $assignment) }}" 
                           class="block w-full px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-lg border border-slate-200 transition text-center">
                            ✏️ Edit Penugasan
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </main>

</body>
</html>
