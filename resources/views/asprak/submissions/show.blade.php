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
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg">📄</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Detail Submission</h1>
                        <p class="text-xs text-slate-500">Informasi submission Anda</p>
                    </div>
                </div>
                <a href="{{ route('asprak.submissions.index', ['tab' => 'submissions']) }}" class="text-sm text-slate-600 hover:text-teal-600 transition">
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Status Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 mb-2">Status Submission</p>
                            <span class="px-4 py-2 text-sm font-medium rounded-full {{ $submission->status_color }}">
                                {{ $submission->status_label }}
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-500">Submitted</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $submission->created_at->format('d M Y, H:i') }}</p>
                            <p class="text-xs text-slate-500">{{ $submission->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Assignment Details -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
                    <h2 class="text-lg font-bold text-slate-900 mb-6">Detail Penugasan</h2>
                    
                    <div class="bg-slate-50 rounded-xl p-5 mb-6">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="font-bold text-slate-900 text-lg">{{ $submission->assignment->judul }}</h3>
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                {{ $submission->assignment->tipe }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 mb-4 whitespace-pre-line">{{ $submission->assignment->deskripsi }}</p>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs text-slate-500">Praktikum</p>
                                <p class="font-semibold text-slate-900">📚 {{ $submission->assignment->praktikum }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Deadline</p>
                                <p class="font-semibold text-slate-900">📅 {{ $submission->assignment->deadline->format('d M Y') }}</p>
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
                        <h3 class="text-sm font-semibold text-slate-700 mb-3">Catatan Anda</h3>
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                            <p class="text-sm text-slate-700">{{ $submission->catatan }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Feedback -->
                    @if($submission->feedback)
                    <div>
                        <h3 class="text-sm font-semibold text-slate-700 mb-3">Feedback dari Laboran</h3>
                        <div class="bg-{{ $submission->status == 'approved' ? 'green' : 'red' }}-50 border border-{{ $submission->status == 'approved' ? 'green' : 'red' }}-200 rounded-xl p-5">
                            <div class="flex items-start gap-3 mb-3">
                                <span class="text-2xl">{{ $submission->status == 'approved' ? '✅' : '❌' }}</span>
                                <div class="flex-1">
                                    <h4 class="font-bold text-{{ $submission->status == 'approved' ? 'green' : 'red' }}-900 mb-1">
                                        {{ $submission->status == 'approved' ? 'Submission Disetujui' : 'Submission Ditolak' }}
                                    </h4>
                                    <p class="text-sm text-{{ $submission->status == 'approved' ? 'green' : 'red' }}-700">{{ $submission->feedback }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-xs text-{{ $submission->status == 'approved' ? 'green' : 'red' }}-600 pt-3 border-t border-{{ $submission->status == 'approved' ? 'green' : 'red' }}-200">
                                <span>Direview oleh: {{ $submission->reviewer->name }}</span>
                                <span>•</span>
                                <span>{{ $submission->reviewed_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">⏳</span>
                            <div class="flex-1">
                                <h4 class="font-semibold text-yellow-900 text-sm mb-1">Menunggu Review</h4>
                                <p class="text-xs text-yellow-700">Submission Anda sedang dalam proses review oleh laboran. Anda akan menerima notifikasi setelah direview.</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Quick Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-sm font-bold text-slate-900 mb-4">Quick Info</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Status</p>
                            <p class="text-sm font-semibold text-slate-900">
                                @if($submission->status == 'pending')
                                    ⏳ Pending Review
                                @elseif($submission->status == 'approved')
                                    ✅ Approved
                                @else
                                    ❌ Rejected
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Submitted</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $submission->created_at->format('d M Y') }}</p>
                        </div>
                        @if($submission->reviewed_at)
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Reviewed</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $submission->reviewed_at->format('d M Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                @if($submission->status == 'pending')
                <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl shadow-sm border border-red-200 p-6">
                    <h3 class="text-sm font-bold text-red-900 mb-2">⚠️ Hapus Submission</h3>
                    <p class="text-xs text-red-700 mb-4">Submission hanya bisa dihapus jika masih pending. Setelah direview, tidak bisa dihapus.</p>
                    <form method="POST" action="{{ route('asprak.submissions.destroy', $submission) }}" 
                          onsubmit="return confirm('Yakin ingin hapus submission ini? Tindakan tidak dapat dibatalkan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition">
                            🗑️ Hapus Submission
                        </button>
                    </form>
                </div>
                @endif

                @if($submission->status == 'rejected')
                <div class="bg-gradient-to-br from-teal-50 to-blue-50 rounded-2xl shadow-sm border border-teal-200 p-6">
                    <h3 class="text-sm font-bold text-teal-900 mb-2">📝 Submit Ulang</h3>
                    <p class="text-xs text-teal-700 mb-4">Perbaiki submission sesuai feedback dan submit ulang.</p>
                    <a href="{{ route('asprak.submissions.create', $submission->assignment) }}" 
                       class="block w-full px-4 py-2 bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white text-sm font-semibold rounded-lg text-center transition">
                        📤 Submit Ulang
                    </a>
                </div>
                @endif

            </div>

        </div>

    </main>

</body>
</html>
