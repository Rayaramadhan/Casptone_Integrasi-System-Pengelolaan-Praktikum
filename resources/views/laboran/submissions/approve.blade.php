<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Submission - SIAP</title>
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
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg">✅</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Approve Submission</h1>
                        <p class="text-xs text-slate-500">Setujui submission dengan feedback</p>
                    </div>
                </div>
                <a href="{{ route('laboran.submissions.show', $submission) }}" class="text-sm text-slate-600 hover:text-teal-600 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Submission Summary -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
            <h2 class="text-lg font-bold text-slate-900 mb-4">Informasi Submission</h2>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">👤</span>
                    <div>
                        <p class="text-xs text-slate-500">Asprak</p>
                        <p class="font-semibold text-slate-900">{{ $submission->asprak->name }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📝</span>
                    <div>
                        <p class="text-xs text-slate-500">Penugasan</p>
                        <p class="font-semibold text-slate-900">{{ $submission->assignment->judul }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📎</span>
                    <div>
                        <p class="text-xs text-slate-500">File</p>
                        <a href="{{ $submission->file_url }}" target="_blank" class="font-semibold text-teal-600 hover:text-teal-700">
                            {{ basename($submission->file_path) }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approve Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <div class="mb-6">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">✅</span>
                </div>
                <h2 class="text-xl font-bold text-slate-900 text-center mb-2">Approve Submission</h2>
                <p class="text-sm text-slate-600 text-center">Berikan feedback positif untuk asprak</p>
            </div>

            <form method="POST" action="{{ route('laboran.submissions.approve', $submission) }}" id="approveForm">
                @csrf
                <input type="hidden" name="_method" value="POST">

                <!-- Feedback -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Feedback <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="feedback" 
                        rows="6" 
                        required
                        placeholder="Berikan feedback untuk asprak (minimal 10 karakter)&#10;Contoh:&#10;- Pengerjaan sudah baik dan sesuai dengan ketentuan&#10;- Format laporan rapi dan lengkap&#10;- Data yang disajikan akurat"
                        class="w-full border border-slate-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm @error('feedback') border-red-500 @enderror">{{ old('feedback') }}</textarea>
                    @error('feedback')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-slate-500">💡 Tips: Berikan pujian yang spesifik dan saran untuk perbaikan di masa depan</p>
                </div>

                <!-- Info Box -->
                <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl">ℹ️</span>
                        <div class="flex-1">
                            <h3 class="font-semibold text-green-900 text-sm mb-1">Informasi</h3>
                            <ul class="text-xs text-green-700 space-y-1">
                                <li>• Submission akan ditandai sebagai <strong>Approved</strong></li>
                                <li>• Asprak akan menerima notifikasi approval</li>
                                <li>• Feedback Anda akan ditampilkan ke asprak</li>
                                <li>• Status tidak dapat diubah setelah di-approve</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3">
                    <button 
                        type="submit" 
                        onclick="return confirm('Yakin ingin approve submission ini? Tindakan tidak dapat dibatalkan.')"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition">
                        ✅ Approve Submission
                    </button>
                    <a href="{{ route('laboran.submissions.show', $submission) }}" 
                       class="px-6 py-3 border-2 border-slate-300 hover:border-slate-400 text-slate-700 font-semibold rounded-xl transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </main>

    <script>
        // Debug form submission
        document.getElementById('approveForm').addEventListener('submit', function(e) {
            console.log('Form Method:', this.method);
            console.log('Form Action:', this.action);
            console.log('Hidden _method:', document.querySelector('input[name="_method"]')?.value);
            
            // Pastikan method adalah POST
            this.method = 'POST';
        });
    </script>

</body>
</html>
