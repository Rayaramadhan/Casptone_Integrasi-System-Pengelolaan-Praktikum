<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Submission - SIAP</title>
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
                    <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg">✏️</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Edit Submission</h1>
                        <p class="text-xs text-slate-500">Perbarui file atau catatan submission Anda</p>
                    </div>
                </div>
                <a href="{{ route('asprak.submissions.show', $submission) }}" class="text-sm text-slate-600 hover:text-teal-600 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-2xl p-4 flex items-start gap-3">
            <span class="text-2xl">✅</span>
            <div class="flex-1">
                <h3 class="font-semibold text-green-900">Berhasil!</h3>
                <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4 flex items-start gap-3">
            <span class="text-2xl">❌</span>
            <div class="flex-1">
                <h3 class="font-semibold text-red-900">Error!</h3>
                <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Assignment Details -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-slate-900 mb-2">{{ $submission->assignment->judul }}</h2>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                            {{ $submission->assignment->tipe }}
                        </span>
                        <span class="text-sm text-slate-600">📚 {{ $submission->assignment->praktikum }}</span>
                    </div>
                </div>
            </div>

            <!-- Current Status -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-4">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">⏳</span>
                    <div>
                        <p class="text-xs text-yellow-700 font-semibold">Status Submission</p>
                        <p class="text-sm font-bold text-yellow-900">Pending Review</p>
                        <p class="text-xs text-yellow-600 mt-1">Submitted: {{ $submission->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Current File -->
            @if($submission->file_path)
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                <p class="text-xs text-slate-600 font-semibold mb-2">File Saat Ini:</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-sm font-medium text-slate-700">{{ basename($submission->file_path) }}</span>
                    </div>
                    <a href="{{ Storage::url($submission->file_path) }}" 
                       target="_blank"
                       class="text-xs text-teal-600 hover:text-teal-700 font-medium">
                        Download
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <div class="mb-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">✏️</span>
                </div>
                <h2 class="text-xl font-bold text-slate-900 text-center mb-2">Edit Submission</h2>
                <p class="text-sm text-slate-600 text-center">Perbarui file atau catatan submission Anda</p>
            </div>

            <form method="POST" action="{{ route('asprak.submissions.update', $submission) }}" enctype="multipart/form-data" id="editForm">
                @csrf
                @method('PUT')

                <!-- File Upload (Optional) -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Ganti File Submission <span class="text-slate-400">(Opsional)</span>
                    </label>
                    <p class="text-xs text-slate-500 mb-3">Kosongkan jika tidak ingin mengganti file</p>
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-blue-400 transition">
                        <input 
                            type="file" 
                            name="file" 
                            id="file" 
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar"
                            class="hidden"
                            onchange="updateFileName(this)"
                        >
                        <label for="file" class="cursor-pointer">
                            <div class="mb-3">
                                <svg class="w-12 h-12 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-sm font-semibold text-slate-700">Klik untuk upload file baru</p>
                                <p class="text-xs text-slate-500 mt-1">atau drag & drop file di sini</p>
                            </div>
                            <p id="fileName" class="text-xs text-slate-600 font-medium"></p>
                        </label>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">
                        Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR (Max: 20MB)
                    </p>
                    @error('file')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan (Optional) -->
                <div class="mb-6">
                    <label for="catatan" class="block text-sm font-semibold text-slate-700 mb-2">
                        Catatan <span class="text-slate-400">(Opsional)</span>
                    </label>
                    <textarea 
                        name="catatan" 
                        id="catatan" 
                        rows="4"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Tambahkan catatan untuk submission Anda (opsional)..."
                    >{{ old('catatan', $submission->catatan) }}</textarea>
                    <p class="text-xs text-slate-500 mt-1">Max 500 karakter</p>
                    @error('catatan')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-blue-900 mb-1">Informasi Penting</p>
                            <ul class="text-xs text-blue-700 space-y-1">
                                <li>• Submission hanya bisa diedit selama status masih <strong>Pending</strong></li>
                                <li>• Jika mengganti file, file lama akan dihapus otomatis</li>
                                <li>• Pastikan file yang diupload sesuai dengan ketentuan penugasan</li>
                                <li>• Edit tidak akan mengubah waktu submit awal</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center gap-3">
                    <button 
                        type="submit"
                        class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3.5 rounded-xl font-bold transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                    <a 
                        href="{{ route('asprak.submissions.show', $submission) }}"
                        class="px-6 py-3.5 border-2 border-slate-300 rounded-xl font-semibold text-slate-700 hover:bg-slate-50 transition"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </main>

    <script>
        function updateFileName(input) {
            const fileNameDisplay = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
                fileNameDisplay.textContent = `📄 ${fileName} (${fileSize} MB)`;
                fileNameDisplay.classList.add('text-blue-600', 'font-semibold');
            } else {
                fileNameDisplay.textContent = '';
            }
        }

        // Confirm before submit
        document.getElementById('editForm').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('file');
            if (fileInput.files.length > 0) {
                if (!confirm('Yakin ingin mengganti file submission? File lama akan dihapus.')) {
                    e.preventDefault();
                }
            }
        });
    </script>
</body>
</html>
