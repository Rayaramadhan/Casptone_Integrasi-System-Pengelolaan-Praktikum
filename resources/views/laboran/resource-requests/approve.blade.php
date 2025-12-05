<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setujui Permintaan - SIAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', system-ui, sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-green-50/30 to-slate-50 min-h-screen">
    
    <!-- Header -->
    <header class="bg-white border-b border-green-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg">✅</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Setujui Permintaan Resource</h1>
                        <p class="text-xs text-slate-500">Berikan feedback persetujuan Anda</p>
                    </div>
                </div>
                <a href="{{ route('laboran.resource-requests.show', $resourceRequest) }}" class="text-sm text-slate-600 hover:text-green-600 transition">
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

        <!-- Approval Form -->
        <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 p-8">
            
            <form action="{{ route('laboran.resource-requests.approve', $resourceRequest) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Confirmation -->
                <div class="bg-green-50 border border-green-200 rounded-2xl p-6">
                    <div class="flex items-start gap-3">
                        <span class="text-3xl">✅</span>
                        <div class="flex-1">
                            <h3 class="font-bold text-green-900 text-lg mb-2">Konfirmasi Persetujuan</h3>
                            <p class="text-sm text-green-700">
                                Anda akan menyetujui permintaan ini. Asisten Praktikum akan menerima notifikasi dan dapat menggunakan resource sesuai jadwal yang diminta.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feedback (MANDATORY) -->
                <div>
                    <label for="feedback" class="block text-sm font-semibold text-slate-700 mb-2">
                        Feedback / Catatan Persetujuan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="feedback" id="feedback" required rows="5"
                              class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                              placeholder="Berikan catatan atau instruksi tambahan untuk Asisten (minimal 10 karakter)...">{{ old('feedback') }}</textarea>
                    @error('feedback')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-slate-500">
                        💡 Feedback wajib diisi (minimal 10 karakter). Berikan instruksi, lokasi pengambilan, atau informasi penting lainnya.
                    </p>
                </div>

                <!-- Example Feedbacks -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                    <h3 class="text-sm font-semibold text-slate-700 mb-3">💡 Contoh Feedback Persetujuan:</h3>
                    <ul class="space-y-2 text-xs text-slate-600">
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 mt-0.5">✓</span>
                            <span>"Permintaan disetujui. Lab EISD 1 dapat digunakan sesuai jadwal. Ambil kunci di ruang Laboran 15 menit sebelum praktikum."</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 mt-0.5">✓</span>
                            <span>"Akun GitHub Education telah dibuat. Credentials akan dikirim via email dalam 1x24 jam."</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 mt-0.5">✓</span>
                            <span>"Laptop tersedia. Pastikan untuk mengisi form peminjaman dan mengembalikan maksimal pukul 17:00."</span>
                        </li>
                    </ul>
                </div>

                <!-- Important Notes -->
                <div class="bg-teal-50 border border-teal-200 rounded-2xl p-5">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl">⚠️</span>
                        <div class="flex-1">
                            <h3 class="font-semibold text-teal-900 text-sm mb-2">Penting:</h3>
                            <ul class="space-y-1.5 text-xs text-teal-800">
                                <li class="flex items-start gap-2">
                                    <span class="text-teal-500 mt-0.5">•</span>
                                    <span>Feedback WAJIB diisi untuk transparansi komunikasi</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-teal-500 mt-0.5">•</span>
                                    <span>Berikan instruksi yang jelas dan detail</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-teal-500 mt-0.5">•</span>
                                    <span>Pastikan Anda telah memverifikasi ketersediaan resource</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-teal-500 mt-0.5">•</span>
                                    <span>Keputusan ini akan tercatat dan Asisten akan mendapat notifikasi</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-lg hover:from-green-600 hover:to-emerald-600 transition font-semibold shadow-lg shadow-green-500/30">
                        ✅ Ya, Setujui Permintaan
                    </button>
                    <a href="{{ route('laboran.resource-requests.show', $resourceRequest) }}" class="px-6 py-3 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium">
                        Batal
                    </a>
                </div>
            </form>

        </div>

    </main>

</body>
</html>
