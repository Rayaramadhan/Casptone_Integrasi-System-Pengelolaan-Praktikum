<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Backlog - SIAP</title>
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
                    <div class="w-10 h-10 bg-teal-500 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg">➕</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Tambah Backlog Baru</h1>
                        <p class="text-xs text-slate-500">Buat backlog untuk merencanakan tugas</p>
                    </div>
                </div>
                <a href="{{ route('asprak.backlogs.index') }}" class="text-sm text-slate-600 hover:text-teal-600 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <form action="{{ route('asprak.backlogs.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg border border-slate-100 p-8">
            @csrf

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-semibold text-slate-900 mb-2">
                    Judul Backlog <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 @error('title') border-red-500 @enderror"
                       placeholder="Masukkan judul backlog..."
                       required>
                @error('title')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-slate-900 mb-2">
                    Deskripsi <span class="text-red-500">*</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="5"
                          class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 @error('description') border-red-500 @enderror"
                          placeholder="Jelaskan detail backlog..."
                          required>{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deadline & Assign To -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Deadline -->
                <div>
                    <label for="deadline" class="block text-sm font-semibold text-slate-900 mb-2">
                        Deadline <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="deadline" 
                           name="deadline" 
                           value="{{ old('deadline') }}"
                           min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 @error('deadline') border-red-500 @enderror"
                           required>
                    @error('deadline')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Assign To -->
                <div>
                    <label for="assign_to" class="block text-sm font-semibold text-slate-900 mb-2">
                        Assign To
                    </label>
                    <input type="text" 
                           id="assign_to" 
                           name="assign_to" 
                           value="{{ old('assign_to') }}"
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 @error('assign_to') border-red-500 @enderror"
                           placeholder="Nama orang yang ditugaskan...">
                    @error('assign_to')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Progress Notes -->
            <div class="mb-6">
                <label for="progress_notes" class="block text-sm font-semibold text-slate-900 mb-2">
                    Catatan Progress (Opsional)
                </label>
                <textarea id="progress_notes" 
                          name="progress_notes" 
                          rows="3"
                          class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 @error('progress_notes') border-red-500 @enderror"
                          placeholder="Catatan progress atau update...">{{ old('progress_notes') }}</textarea>
                @error('progress_notes')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Progress File -->
            <div class="mb-8">
                <label for="progress_file" class="block text-sm font-semibold text-slate-900 mb-2">
                    Upload Dokumen Progress (Opsional)
                </label>
                <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-teal-400 transition">
                    <input type="file" 
                           id="progress_file" 
                           name="progress_file" 
                           accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                           class="hidden"
                           onchange="updateFileName(this)">
                    <label for="progress_file" class="cursor-pointer">
                        <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <span class="text-2xl">📎</span>
                        </div>
                        <p class="text-sm font-medium text-slate-900 mb-1">Klik untuk upload file</p>
                        <p class="text-xs text-slate-500" id="file-name">PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (Max 5MB)</p>
                    </label>
                </div>
                @error('progress_file')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-3 justify-end">
                <a href="{{ route('asprak.backlogs.index') }}" 
                   class="px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-medium hover:bg-slate-200 transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-500 text-white rounded-xl font-medium hover:from-teal-600 hover:to-cyan-600 transition shadow-lg hover:shadow-xl">
                    Simpan Backlog
                </button>
            </div>
        </form>
    </main>

    <script>
        function updateFileName(input) {
            const fileName = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                fileName.textContent = input.files[0].name;
            }
        }
    </script>
</body>
</html>
