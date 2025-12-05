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
                    <div class="w-10 h-10 bg-teal-500 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg">📋</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Detail Penugasan</h1>
                        <p class="text-xs text-slate-500">Informasi lengkap penugasan</p>
                    </div>
                </div>
                <a href="{{ route('asprak.submissions.index') }}" class="text-sm text-slate-600 hover:text-teal-600 transition">
                    ← Kembali ke Daftar Penugasan
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Assignment Detail Card -->
        <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(15,23,42,0.08)] border border-slate-100 overflow-hidden mb-6">
            <!-- Header -->
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-8 py-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-white mb-2">{{ $assignment->judul }}</h2>
                        <div class="flex items-center gap-4 text-teal-100">
                            <span class="flex items-center gap-1.5 bg-white/10 backdrop-blur-sm px-3 py-1 rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                {{ $assignment->tipe }}
                            </span>
                            <span class="flex items-center gap-1.5 bg-white/10 backdrop-blur-sm px-3 py-1 rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                {{ $assignment->praktikum }}
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        @php
                            $statusColors = [
                                'active' => 'bg-green-100 text-green-700 border-green-300',
                                'draft' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                'closed' => 'bg-red-100 text-red-700 border-red-300',
                            ];
                        @endphp
                        <span class="px-3 py-1.5 text-xs font-bold rounded-full border-2 {{ $statusColors[$assignment->status] ?? 'bg-gray-100 text-gray-700 border-gray-300' }}">
                            {{ ucfirst($assignment->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="px-8 py-6 space-y-6">
                <!-- Description -->
                <div>
                    <h3 class="text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Deskripsi
                    </h3>
                    <div class="bg-slate-50 rounded-xl p-4 text-slate-700 text-sm leading-relaxed border border-slate-200">
                        {{ $assignment->deskripsi ?? 'Tidak ada deskripsi' }}
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Deadline -->
                    <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl p-4 border border-orange-200 shadow-sm hover:shadow-md transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-orange-700 font-medium">Deadline</p>
                                <p class="text-sm font-bold text-orange-900">{{ $assignment->deadline ? \Carbon\Carbon::parse($assignment->deadline)->format('d M Y, H:i') : 'Tidak ada deadline' }}</p>
                                @if($assignment->deadline)
                                <p class="text-xs text-orange-600">{{ \Carbon\Carbon::parse($assignment->deadline)->diffForHumans() }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Creator -->
                    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl p-4 border border-teal-200 shadow-sm hover:shadow-md transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-teal-700 font-medium">Pembuat</p>
                                <p class="text-sm font-bold text-teal-900">{{ optional($assignment->creator)->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-teal-600">{{ optional($assignment->created_at)->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- File Attachment (if any) -->
                @if($assignment->file_path)
                <div>
                    <h3 class="text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                        </svg>
                        File Lampiran
                    </h3>
                    <a href="{{ Storage::url($assignment->file_path) }}" 
                       target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-xl text-sm text-purple-700 font-medium transition shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download File
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Submission Status / Action -->
        @if($mySubmission)
            <!-- Already Submitted -->
            <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(15,23,42,0.08)] border border-slate-100 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-emerald-500 px-8 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Sudah Mengumpulkan
                    </h3>
                </div>
                <div class="px-8 py-6">
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-200">
                        <div>
                            <p class="text-sm text-slate-600 mb-1">Submitted pada:</p>
                            <p class="text-lg font-semibold text-slate-900">{{ $mySubmission->created_at->format('d M Y, H:i') }}</p>
                            <p class="text-xs text-slate-500">{{ $mySubmission->created_at->diffForHumans() }}</p>
                        </div>
                        <div>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-300',
                                    'approved' => 'bg-green-50 text-green-700 border-green-300',
                                    'rejected' => 'bg-red-50 text-red-700 border-red-300',
                                ];
                                $statusLabels = [
                                    'pending' => 'Pending Review',
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak',
                                ];
                            @endphp
                            <span class="px-4 py-2 text-sm font-bold rounded-xl border-2 {{ $statusColors[$mySubmission->status] ?? 'bg-gray-50 text-gray-700 border-gray-300' }}">
                                {{ $statusLabels[$mySubmission->status] ?? ucfirst($mySubmission->status) }}
                            </span>
                        </div>
                    </div>

                    @if($mySubmission->file_path)
                    <div class="mb-4">
                        <p class="text-sm font-semibold text-slate-700 mb-2">File Submission:</p>
                        <a href="{{ Storage::url($mySubmission->file_path) }}" 
                           target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-teal-50 hover:bg-teal-100 border border-teal-200 rounded-xl text-sm text-teal-700 font-medium transition shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download File Submission
                        </a>
                    </div>
                    @endif

                    @if($mySubmission->catatan)
                    <div class="mb-4">
                        <p class="text-sm font-semibold text-slate-700 mb-2">Catatan Anda:</p>
                        <div class="bg-slate-50 rounded-xl p-4 text-sm text-slate-700 border border-slate-200">
                            {{ $mySubmission->catatan }}
                        </div>
                    </div>
                    @endif

                    @if($mySubmission->feedback)
                    <div class="bg-teal-50 border-2 border-teal-200 rounded-xl p-4">
                        <p class="text-sm font-bold text-teal-900 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            Feedback dari Reviewer:
                        </p>
                        <p class="text-sm text-teal-800">{{ $mySubmission->feedback }}</p>
                        @if($mySubmission->reviewer)
                        <p class="text-xs text-teal-600 mt-2 font-medium">— {{ $mySubmission->reviewer->name }}</p>
                        @endif
                    </div>
                    @endif

                    <div class="mt-6 pt-4 border-t border-slate-200 flex items-center gap-3">
                        <a href="{{ route('asprak.submissions.show', $mySubmission->id) }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white rounded-xl font-semibold transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Lihat Detail Submission
                        </a>

                        @if($mySubmission->status === 'pending')
                        <a href="{{ route('asprak.submissions.edit', $mySubmission->id) }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-semibold transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Submission
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <!-- Submit Button -->
            @if($assignment->status === 'active')
            <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(15,23,42,0.08)] border border-slate-100 p-8 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-20 h-20 bg-gradient-to-br from-teal-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">Belum Mengumpulkan</h3>
                    <p class="text-sm text-slate-600 mb-6">Silakan submit pekerjaan Anda untuk penugasan ini</p>
                    <a href="{{ route('asprak.submissions.create', $assignment->id) }}" 
                       class="inline-flex items-center gap-2 px-8 py-3.5 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Submit Sekarang
                    </a>
                </div>
            </div>
            @else
            <div class="bg-red-50 border-2 border-red-200 rounded-2xl p-8 text-center shadow-sm">
                <div class="text-6xl mb-4">🔒</div>
                <h3 class="text-xl font-bold text-red-900 mb-2">Penugasan Tidak Aktif</h3>
                <p class="text-sm text-red-700">Penugasan ini sudah ditutup dan tidak menerima submission baru</p>
            </div>
            @endif
        @endif

    </main>
</body>
</html>
