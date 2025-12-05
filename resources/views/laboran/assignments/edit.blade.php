<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penugasan - SIAP</title>
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
                    <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg">✏️</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Edit Penugasan</h1>
                        <p class="text-xs text-slate-500">Perbarui informasi penugasan</p>
                    </div>
                </div>
                <a href="{{ route('laboran.assignments.index') }}" class="text-sm text-slate-600 hover:text-teal-600 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <form method="POST" action="{{ route('laboran.assignments.update', $assignment) }}">
                @csrf
                @method('PUT')

                <!-- Judul -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Penugasan <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $assignment->judul) }}" required
                           class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('judul') border-red-500 @enderror"
                           placeholder="Contoh: Laporan Praktikum Semester Ganjil 2024">
                    @error('judul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi" rows="5" required
                              class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('deskripsi') border-red-500 @enderror"
                              placeholder="Jelaskan detail penugasan...">{{ old('deskripsi', $assignment->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipe & Praktikum -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tipe Penugasan <span class="text-red-500">*</span></label>
                        <select name="tipe" required
                                class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('tipe') border-red-500 @enderror">
                            <option value="">Pilih Tipe</option>
                            <option value="LPJ" {{ old('tipe', $assignment->tipe) == 'LPJ' ? 'selected' : '' }}>LPJ</option>
                            <option value="RAB" {{ old('tipe', $assignment->tipe) == 'RAB' ? 'selected' : '' }}>RAB</option>
                            <option value="Laporan" {{ old('tipe', $assignment->tipe) == 'Laporan' ? 'selected' : '' }}>Laporan</option>
                            <option value="Proposal" {{ old('tipe', $assignment->tipe) == 'Proposal' ? 'selected' : '' }}>Proposal</option>
                            <option value="Lainnya" {{ old('tipe', $assignment->tipe) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('tipe')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Praktikum <span class="text-red-500">*</span></label>
                        <input type="text" name="praktikum" value="{{ old('praktikum', $assignment->praktikum) }}" required
                               class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('praktikum') border-red-500 @enderror">
                        @error('praktikum')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Deadline & Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Deadline <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="deadline" value="{{ old('deadline', $assignment->deadline->format('Y-m-d\TH:i')) }}" required
                               class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('deadline') border-red-500 @enderror">
                        @error('deadline')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" required
                                class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            <option value="active" {{ old('status', $assignment->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="closed" {{ old('status', $assignment->status) == 'closed' ? 'selected' : '' }}>Ditutup</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-6 border-t border-slate-200">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all">
                        💾 Update Penugasan
                    </button>
                    <a href="{{ route('laboran.assignments.index') }}" 
                       class="px-6 py-3 border-2 border-slate-300 rounded-xl text-slate-700 font-semibold hover:bg-slate-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </main>

</body>
</html>
