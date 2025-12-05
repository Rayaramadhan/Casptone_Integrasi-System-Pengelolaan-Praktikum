<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kebutuhan Praktikum - SIAP</title>
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
                    <div class="w-10 h-10 bg-teal-500 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg">{{ $resourceRequest->resource_type_icon }}</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Detail Kebutuhan Praktikum</h1>
                        <p class="text-xs text-slate-500">{{ $resourceRequest->resource_type_label }}</p>
                    </div>
                </div>
                <a href="{{ route('asprak.resource-requests.index') }}" class="text-sm text-slate-600 hover:text-teal-600 transition">
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

        <!-- Status Badge -->
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full {{ $resourceRequest->status_color }}">
                    {{ $resourceRequest->status_label }}
                </span>
            </div>
            <p class="text-sm text-slate-500">
                Diajukan {{ $resourceRequest->created_at->diffForHumans() }}
            </p>
        </div>

        <!-- Overdue Warning -->
        @if($resourceRequest->isOverdue())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4 flex items-start gap-3">
            <span class="text-2xl">⚠️</span>
            <div class="flex-1">
                <h3 class="font-semibold text-red-900">Permintaan Terlambat!</h3>
                <p class="text-sm text-red-700 mt-1">
                    Tanggal kebutuhan sudah lewat ({{ $resourceRequest->needed_date->diffForHumans() }}). 
                    Segera hubungi Laboran jika permintaan masih diperlukan.
                </p>
            </div>
        </div>
        @endif

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column: Request Details -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Request Info Card -->
                <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 p-8">
                    <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <span>📋</span>
                        Informasi Permintaan
                    </h2>

                    <div class="space-y-5">
                        <!-- Title -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Judul</label>
                            <p class="text-base font-semibold text-slate-900">{{ $resourceRequest->title }}</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Deskripsi Kebutuhan</label>
                            <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $resourceRequest->description }}</p>
                        </div>

                        <!-- Resource Details -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Tipe Resource</label>
                                <p class="text-sm text-slate-900 font-medium">{{ $resourceRequest->resource_type_icon }} {{ $resourceRequest->resource_type_label }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Jumlah</label>
                                <p class="text-sm text-slate-900 font-medium">{{ $resourceRequest->quantity }} unit</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Laboratorium</label>
                                <p class="text-sm text-slate-900 font-medium">{{ $resourceRequest->laboratorium }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Nama Praktikum</label>
                                <p class="text-sm text-slate-900 font-medium">{{ $resourceRequest->nama_praktikum }}</p>
                            </div>
                        </div>

                        <!-- Date & Time -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Tanggal Dibutuhkan</label>
                                <p class="text-sm text-slate-900 font-medium">{{ $resourceRequest->formatted_needed_date }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ $resourceRequest->needed_date->diffForHumans() }}</p>
                            </div>
                            @if($resourceRequest->needed_time)
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Waktu</label>
                                <p class="text-sm text-slate-900 font-medium">{{ $resourceRequest->formatted_needed_time }}</p>
                            </div>
                            @endif
                            @if($resourceRequest->duration)
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Durasi</label>
                                <p class="text-sm text-slate-900 font-medium">{{ $resourceRequest->duration_text }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Feedback Card (if reviewed) -->
                @if($resourceRequest->feedback)
                <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 p-8">
                    <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <span>💬</span>
                        Feedback dari Laboran
                    </h2>

                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200">
                        <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ $resourceRequest->feedback }}</p>
                    </div>

                    @if($resourceRequest->status === 'rejected')
                    <div class="mt-4 bg-red-50 border border-red-200 rounded-xl p-4">
                        <p class="text-sm text-red-700">
                            💡 <strong>Permintaan ditolak.</strong> Baca feedback di atas untuk memahami alasan penolakan. 
                            Anda dapat mengajukan permintaan baru dengan perbaikan yang sesuai.
                        </p>
                    </div>
                    @endif
                </div>
                @endif

            </div>

            <!-- Right Column: Submitter Info & Actions -->
            <div class="space-y-6">
                
                <!-- Submitter Info -->
                <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 p-6">
                    <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span>👤</span>
                        Pengaju
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-slate-500">Nama</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $resourceRequest->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Email</p>
                            <p class="text-sm text-slate-700">{{ $resourceRequest->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Tanggal Pengajuan</p>
                            <p class="text-sm text-slate-700">{{ $resourceRequest->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Reviewer Info (if reviewed) -->
                @if($resourceRequest->reviewed_by)
                <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 p-6">
                    <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span>👨‍💼</span>
                        Direview Oleh
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-slate-500">Laboran</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $resourceRequest->reviewer->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Email</p>
                            <p class="text-sm text-slate-700">{{ $resourceRequest->reviewer->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Waktu Review</p>
                            <p class="text-sm text-slate-700">{{ $resourceRequest->reviewed_at->format('d M Y, H:i') }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $resourceRequest->reviewed_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 p-6">
                    <h3 class="text-sm font-bold text-slate-900 mb-4">Aksi</h3>
                    
                    <div class="space-y-3">
                        <!-- Delete (only pending) -->
                        @if($resourceRequest->status === 'pending')
                        <form action="{{ route('asprak.resource-requests.destroy', $resourceRequest) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kebutuhan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm font-medium">
                                🗑️ Hapus Kebutuhan
                            </button>
                        </form>
                        @endif

                        <!-- Resubmit (only rejected) -->
                        @if($resourceRequest->status === 'rejected')
                        <a href="{{ route('asprak.resource-requests.resubmit', $resourceRequest) }}" class="block w-full px-4 py-2.5 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition text-sm font-medium text-center">
                            🔄 Ajukan Ulang
                        </a>
                        @endif

                        <!-- Back to List -->
                        <a href="{{ route('asprak.resource-requests.index') }}" class="block w-full px-4 py-2.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition text-sm font-medium text-center">
                            ← Kembali ke Daftar
                        </a>
                    </div>

                    <!-- Status Info -->
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        @if($resourceRequest->status === 'pending')
                        <p class="text-xs text-slate-500">
                            ⏳ Permintaan sedang menunggu review dari Laboran
                        </p>
                        @elseif($resourceRequest->status === 'approved')
                        <p class="text-xs text-green-700">
                            ✅ Permintaan telah disetujui oleh Laboran
                        </p>
                        @else
                        <p class="text-xs text-red-700">
                            ❌ Permintaan ditolak. Baca feedback untuk detail.
                        </p>
                        @endif
                    </div>
                </div>

            </div>

        </div>

    </main>

</body>
</html>
