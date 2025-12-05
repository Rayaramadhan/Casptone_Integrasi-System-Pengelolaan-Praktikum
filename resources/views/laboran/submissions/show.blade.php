<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Submission - SIAP</title>
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
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg">📄</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Detail Submission</h1>
                        <p class="text-xs text-slate-500">Informasi lengkap submission asprak</p>
                    </div>
                </div>
                <a href="{{ route('laboran.submissions.index') }}" class="text-sm text-slate-600 hover:text-teal-600 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
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

        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="px-4 py-2 text-sm font-medium rounded-full {{ $submission->status_color }}">
                            {{ $submission->status_label }}
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-500">Submitted</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $submission->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Submission Details -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
                <h2 class="text-xl font-bold text-slate-900 mb-6">Informasi Submission</h2>
                
                <!-- Asprak Info -->
                <div class="mb-6 pb-6 border-b border-slate-200">
                    <h3 class="text-sm font-semibold text-slate-700 mb-3">Asprak</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center">
                            <span class="text-xl">👤</span>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">{{ $submission->asprak->name }}</p>
                            <p class="text-sm text-slate-500">{{ $submission->asprak->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Assignment Info -->
                <div class="mb-6 pb-6 border-b border-slate-200">
                    <h3 class="text-sm font-semibold text-slate-700 mb-3">Penugasan</h3>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <div class="flex items-start justify-between mb-3">
                            <h4 class="font-bold text-slate-900">{{ $submission->assignment->judul }}</h4>
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                {{ $submission->assignment->tipe }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 mb-2">{{ $submission->assignment->deskripsi }}</p>
                        <div class="flex items-center gap-4 text-xs text-slate-500">
                            <span>📚 {{ $submission->assignment->praktikum }}</span>
                            <span>📅 Deadline: {{ $submission->assignment->deadline->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- File -->
                <div class="mb-6 pb-6 border-b border-slate-200">
                    <h3 class="text-sm font-semibold text-slate-700 mb-3">File Submission</h3>
                    <a href="{{ $submission->file_url }}" target="_blank" 
                       class="inline-flex items-center gap-3 px-6 py-4 bg-gradient-to-r from-blue-50 to-teal-50 border border-blue-200 rounded-xl hover:shadow-md transition">
                        <span class="text-3xl">📎</span>
                        <div class="text-left">
                            <p class="font-semibold text-blue-900">{{ basename($submission->file_path) }}</p>
                            <p class="text-xs text-blue-600">Klik untuk download</p>
                        </div>
                    </a>
                </div>

                <!-- Catatan -->
                @if($submission->catatan)
                <div class="mb-6 pb-6 border-b border-slate-200">
                    <h3 class="text-sm font-semibold text-slate-700 mb-3">Catatan dari Asprak</h3>
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                        <p class="text-sm text-slate-700">{{ $submission->catatan }}</p>
                    </div>
                </div>
                @endif

                <!-- Feedback -->
                @if($submission->feedback)
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-slate-700 mb-3">Feedback Anda</h3>
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <p class="text-sm text-slate-700 mb-2">{{ $submission->feedback }}</p>
                        <div class="flex items-center gap-4 text-xs text-slate-500 mt-3">
                            <span>Direview oleh: {{ $submission->reviewer->name }}</span>
                            <span>•</span>
                            <span>{{ $submission->reviewed_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Actions -->
                @if($submission->status == 'pending')
                <div class="flex gap-3 pt-6 border-t border-slate-200">
                    <a href="{{ route('laboran.submissions.approveForm', $submission) }}" 
                       class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition text-center">
                        ✅ Approve Submission
                    </a>
                    <a href="{{ route('laboran.submissions.rejectForm', $submission) }}" 
                       class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition text-center">
                        ❌ Reject Submission
                    </a>
                </div>
                @endif
            </div>
        </div>

    </main>

</body>
</html>
