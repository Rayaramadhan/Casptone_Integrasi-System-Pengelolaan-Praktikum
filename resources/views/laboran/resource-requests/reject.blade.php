<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tolak Permintaan - SIAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', system-ui, sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-red-50/30 to-slate-50 min-h-screen">
    
    <!-- Header -->
    <header class="bg-white border-b border-red-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg">❌</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Tolak Permintaan Resource</h1>
                        <p class="text-xs text-slate-500">Berikan alasan penolakan yang jelas</p>
                    </div>
                </div>
                <a href="{{ route('laboran.resource-requests.show', $resourceRequest) }}" class="text-sm text-slate-600 hover:text-red-600 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Request Summary -->
        <div class="mb-6 bg-white rounded-2xl shadow-[0_8px_30px_rgba(15,23,42,0.08)] border border-slate-100 p-6">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wide mb-4">Ringkasan Permintaan</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-slate-500">Judul</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $resourceRequest->title }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Tipe Resource</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $resourceRequest->resource_type_icon }} {{ $resourceRequest->resource_type_label }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Nama Resource</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $resourceRequest->resource_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Jumlah</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $resourceRequest->quantity }} unit</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Diajukan oleh</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $resourceRequest->user->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Tanggal Dibutuhkan</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $resourceRequest->formatted_needed_date }}</p>
                </div>
            </div>
        </div>

        <!-- Rejection Form -->
         formal action="{{ route('laboran.resource-requests.reject', $resourceRequest) }}" method="POST" class="space-y-6">
        <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 p-8">
            
            <form action="{{ route('laboran.resource-requests.reject', $resourceRequest) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Warning -->
                <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                    <div class="flex items-start gap-3">
                        <span class="text-3xl">❌</span>
                        <div class="flex-1">
                            <h3 class="font-bold text-red-900 text-lg mb-2">Konfirmasi Penolakan</h3>
                            <p class="text-sm text-red-700 mb-3">
                                Anda akan menolak permintaan ini. Asisten Praktikum akan menerima notifikasi dan dapat mengajukan ulang dengan perbaikan.
                            </p>
                            <p class="text-sm text-red-800 font-semibold">
                                ⚠️ Feedback penolakan WAJIB diisi dengan detail untuk membantu Asisten memahami alasan penolakan.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feedback (MANDATORY) -->
                <div>
                    <label for="feedback" class="block text-sm font-semibold text-slate-700 mb-2">
                        Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="feedback" id="feedback" required rows="6"
                              class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                              placeholder="Jelaskan secara detail alasan penolakan dan saran perbaikan (minimal 20 karakter)...">{{ old('feedback') }}</textarea>
                    @error('feedback')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-slate-500">
                        💡 Feedback wajib diisi (minimal 20 karakter). Berikan alasan yang jelas dan konstruktif agar Asisten dapat memperbaiki permintaan.
                    </p>
                </div>

                <!-- Example Feedbacks -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                    <h3 class="text-sm font-semibold text-slate-700 mb-3">💡 Contoh Feedback Penolakan yang Baik:</h3>
                    <ul class="space-y-2 text-xs text-slate-600">
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 mt-0.5">✗</span>
                            <span>"Lab EISD 1 sudah dibooking untuk acara seminar pada tanggal tersebut. Silakan pilih tanggal lain atau gunakan Lab EISD 2 sebagai alternatif."</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 mt-0.5">✗</span>
                            <span>"Permintaan terlalu mendadak (kurang dari 3 hari). Untuk peminjaman ruangan, mohon ajukan minimal H-3. Silakan ajukan ulang dengan tanggal yang lebih sesuai."</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 mt-0.5">✗</span>
                            <span>"Deskripsi kebutuhan kurang detail. Mohon jelaskan: 1) Jumlah peserta praktikum, 2) Spesifikasi software yang dibutuhkan, 3) Konfigurasi khusus yang diperlukan."</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 mt-0.5">✗</span>
                            <span>"Laptop dengan spesifikasi yang diminta sedang tidak tersedia. Tersedia laptop dengan RAM 8GB (bukan 16GB). Apakah masih dapat digunakan? Jika ya, silakan ajukan ulang dengan spesifikasi yang tersedia."</span>
                        </li>
                    </ul>
                </div>

                <!-- Guidelines -->
                <div class="bg-teal-50 border border-teal-200 rounded-2xl p-5">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl">📋</span>
                        <div class="flex-1">
                            <h3 class="font-semibold text-teal-900 text-sm mb-2">Panduan Feedback Penolakan:</h3>
                            <ul class="space-y-1.5 text-xs text-teal-800">
                                <li class="flex items-start gap-2">
                                    <span class="text-teal-500 mt-0.5">•</span>
                                    <span>Jelaskan alasan penolakan secara spesifik dan detail</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-teal-500 mt-0.5">•</span>
                                    <span>Berikan saran atau alternatif jika memungkinkan</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-teal-500 mt-0.5">•</span>
                                    <span>Gunakan bahasa yang profesional dan konstruktif</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-teal-500 mt-0.5">•</span>
                                    <span>Bantu Asisten memahami cara memperbaiki permintaan untuk pengajuan ulang</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-teal-500 mt-0.5">•</span>
                                    <span>Feedback yang baik akan membantu Asisten belajar dan berkembang</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-rose-500 text-white rounded-lg hover:from-red-600 hover:to-rose-600 transition font-semibold shadow-lg shadow-red-500/30">
                        ❌ Ya, Tolak Permintaan
                    </button>
                    <a href="{{ route('laboran.resource-requests.show', $resourceRequest) }}" class="px-6 py-3 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium">
                        Batal
                    </a>
                </div>

                <!-- Info -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs text-slate-600">
                    ℹ️ <strong>Catatan:</strong> Setelah ditolak, Asisten dapat melihat feedback Anda dan mengajukan ulang permintaan dengan perbaikan yang sesuai.
                </div>
            </form>

        </div>

    </main>

</body>
</html>
