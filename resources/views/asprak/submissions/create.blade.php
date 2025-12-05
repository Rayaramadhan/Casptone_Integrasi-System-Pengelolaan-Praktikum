<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Penugasan - SIAP</title>
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
                    <div class="w-10 h-10 bg-teal-500 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg">📤</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Submit Penugasan</h1>
                        <p class="text-xs text-slate-500">Upload file submission Anda</p>
                    </div>
                </div>
                <a href="{{ route('asprak.submissions.index') }}" class="text-sm text-slate-600 hover:text-teal-600 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Assignment Details -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-slate-900 mb-2">{{ $assignment->judul }}</h2>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                            {{ $assignment->tipe }}
                        </span>
                        <span class="text-sm text-slate-600">📚 {{ $assignment->praktikum }}</span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-slate-50 rounded-xl p-4 mb-4">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">Deskripsi Penugasan</h3>
                <p class="text-sm text-slate-600 whitespace-pre-line">{{ $assignment->deskripsi }}</p>
            </div>

            <!-- Deadline -->
            <div class="flex items-center gap-3 p-4 {{ $assignment->deadline->isPast() ? 'bg-red-50 border border-red-200' : 'bg-green-50 border border-green-200' }} rounded-xl">
                <span class="text-2xl">{{ $assignment->deadline->isPast() ? '⚠️' : '📅' }}</span>
                <div>
                    <p class="text-xs {{ $assignment->deadline->isPast() ? 'text-red-600' : 'text-green-600' }} font-semibold">
                        {{ $assignment->deadline->isPast() ? 'DEADLINE TERLEWAT!' : 'Deadline' }}
                    </p>
                    <p class="text-sm font-bold {{ $assignment->deadline->isPast() ? 'text-red-900' : 'text-green-900' }}">
                        {{ $assignment->deadline->format('d M Y, H:i') }}
                        <span class="font-normal">({{ $assignment->deadline->diffForHumans() }})</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Submission Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <div class="mb-6">
                <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">📤</span>
                </div>
                <h2 class="text-xl font-bold text-slate-900 text-center mb-2">Upload Submission</h2>
                <p class="text-sm text-slate-600 text-center">Pastikan file yang diupload sesuai dengan ketentuan</p>
            </div>

            <form method="POST" action="{{ route('asprak.submissions.store', $assignment) }}" enctype="multipart/form-data">
                @csrf

                <!-- File Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        File Submission <span class="text-red-500">*</span>
                    </label>
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-teal-400 transition">
                        <input 
                            type="file" 
                            name="file" 
                            id="file" 
                            required
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar"
                            class="hidden"
                            onchange="updateFileName(this)">
                        <label for="file" class="cursor-pointer">
                            <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-3xl">📎</span>
                            </div>
                            <p class="text-sm font-semibold text-slate-900 mb-1">Klik untuk pilih file</p>
                            <p class="text-xs text-slate-500">atau drag & drop file di sini</p>
                            <p class="text-xs text-slate-400 mt-2">Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR</p>
                            <p class="text-xs text-slate-400">Maksimal: 10 MB</p>
                        </label>
                    </div>
                    <div id="file-name" class="mt-3 text-sm text-teal-600 font-semibold hidden"></div>
                    @error('file')
                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Catatan (Opsional)
                    </label>
                    <textarea 
                        name="catatan" 
                        rows="4" 
                        placeholder="Tambahkan catatan untuk submission Anda (jika ada)&#10;Contoh: Terlambat karena sakit, atau penjelasan tambahan lainnya"
                        class="w-full border border-slate-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Guidelines -->
                <div class="mb-6 bg-amber-50 border border-amber-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl">💡</span>
                        <div class="flex-1">
                            <h3 class="font-semibold text-amber-900 text-sm mb-2">Panduan Submission</h3>
                            <ul class="text-xs text-amber-800 space-y-1">
                                <li>✓ Pastikan file tidak corrupt dan bisa dibuka</li>
                                <li>✓ Periksa kembali isi file sebelum upload</li>
                                <li>✓ Gunakan format file yang sesuai ketentuan</li>
                                <li>✓ Ukuran file maksimal 10 MB</li>
                                <li>✓ Submission hanya bisa dilakukan sekali (tidak bisa edit)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Warning if past deadline -->
                @if($assignment->deadline->isPast())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl">⚠️</span>
                        <div class="flex-1">
                            <h3 class="font-semibold text-red-900 text-sm mb-1">Peringatan!</h3>
                            <p class="text-xs text-red-700">Deadline sudah terlewat. Submission Anda mungkin mendapat penilaian khusus atau pengurangan nilai.</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="flex gap-3">
                    <button 
                        type="submit" 
                        onclick="return confirm('Yakin ingin submit? Pastikan file sudah benar karena tidak bisa diubah setelah submit.')"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition">
                        📤 Submit Sekarang
                    </button>
                    <a href="{{ route('asprak.submissions.index') }}" 
                       class="px-6 py-3 border-2 border-slate-300 hover:border-slate-400 text-slate-700 font-semibold rounded-xl transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </main>

    <script>
        function updateFileName(input) {
            const fileNameDisplay = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
                fileNameDisplay.textContent = `✅ File dipilih: ${fileName} (${fileSize} MB)`;
                fileNameDisplay.classList.remove('hidden');
            } else {
                fileNameDisplay.classList.add('hidden');
            }
        }
    </script>

</body>
</html>
