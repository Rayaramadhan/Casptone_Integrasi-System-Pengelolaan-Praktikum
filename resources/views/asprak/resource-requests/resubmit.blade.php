<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Ulang Kebutuhan - SIAP</title>
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
                        <span class="text-white text-lg">🔄</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Ajukan Ulang Kebutuhan</h1>
                        <p class="text-xs text-slate-500">Perbaiki dan ajukan kembali kebutuhan Anda</p>
                    </div>
                </div>
                <a href="{{ route('asprak.resource-requests.show', $resourceRequest) }}" class="text-sm text-slate-600 hover:text-teal-600 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Rejection Feedback -->
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-6">
            <div class="flex items-start gap-3">
                <span class="text-3xl">❌</span>
                <div class="flex-1">
                    <h3 class="font-bold text-red-900 text-lg mb-2">Permintaan Sebelumnya Ditolak</h3>
                    <p class="text-sm text-red-700 mb-3">
                        Ditolak oleh <strong>{{ $resourceRequest->reviewer->name }}</strong> pada {{ $resourceRequest->reviewed_at->format('d M Y, H:i') }}
                    </p>
                    <div class="bg-white rounded-xl p-4 border border-red-300">
                        <p class="text-xs font-semibold text-red-900 uppercase tracking-wide mb-2">Alasan Penolakan:</p>
                        <p class="text-sm text-red-800 leading-relaxed whitespace-pre-line">{{ $resourceRequest->feedback }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips -->
        <div class="mb-6 bg-teal-50 border border-teal-200 rounded-2xl p-5">
            <div class="flex items-start gap-3">
                <span class="text-2xl">💡</span>
                <div class="flex-1">
                    <h3 class="font-semibold text-teal-900 text-sm mb-2">Tips Pengajuan Ulang:</h3>
                    <ul class="space-y-1.5 text-xs text-teal-800">
                        <li class="flex items-start gap-2">
                            <span class="text-teal-500 mt-0.5">•</span>
                            <span>Baca dengan seksama feedback dari Laboran</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-teal-500 mt-0.5">•</span>
                            <span>Perbaiki sesuai dengan alasan penolakan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-teal-500 mt-0.5">•</span>
                            <span>Berikan informasi yang lebih detail dan jelas</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-teal-500 mt-0.5">•</span>
                            <span>Pastikan semua field diisi dengan lengkap</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 p-8">
            
            <form action="{{ route('asprak.resource-requests.updateResubmit', $resourceRequest) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">
                        Judul Permintaan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required
                           value="{{ old('title', $resourceRequest->title) }}"
                           class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                           placeholder="Contoh: Peminjaman Lab untuk Praktikum Basis Data">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Resource Type -->
                <div>
                    <label for="resource_type" class="block text-sm font-semibold text-slate-700 mb-2">
                        Tipe Resource <span class="text-red-500">*</span>
                    </label>
                    <select name="resource_type" id="resource_type" required
                            class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <option value="">Pilih Tipe Resource</option>
                        <option value="room" {{ old('resource_type', $resourceRequest->resource_type) == 'room' ? 'selected' : '' }}>🏢 Ruangan (Lab/Kelas)</option>
                        <option value="tool_account" {{ old('resource_type', $resourceRequest->resource_type) == 'tool_account' ? 'selected' : '' }}>🔑 Akun Tools (GitHub, AWS, dll)</option>
                        <option value="hardware" {{ old('resource_type', $resourceRequest->resource_type) == 'hardware' ? 'selected' : '' }}>💻 Perangkat Keras</option>
                        <option value="software" {{ old('resource_type', $resourceRequest->resource_type) == 'software' ? 'selected' : '' }}>💿 Software/License</option>
                        <option value="other" {{ old('resource_type', $resourceRequest->resource_type) == 'other' ? 'selected' : '' }}>📦 Lainnya</option>
                    </select>
                    @error('resource_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Laboratorium & Nama Praktikum -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="laboratorium" class="block text-sm font-semibold text-slate-700 mb-2">
                            Laboratorium <span class="text-red-500">*</span>
                        </label>
                        <select name="laboratorium" id="laboratorium" required
                                class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                onchange="updatePraktikums()">
                            <option value="">Pilih Laboratorium</option>
                            @foreach($laboratoriums as $lab)
                                <option value="{{ $lab }}" {{ old('laboratorium', $resourceRequest->laboratorium) == $lab ? 'selected' : '' }}>
                                    {{ $lab }}
                                </option>
                            @endforeach
                        </select>
                        @error('laboratorium')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_praktikum" class="block text-sm font-semibold text-slate-700 mb-2">
                            Nama Praktikum <span class="text-red-500">*</span>
                        </label>
                        <select name="nama_praktikum" id="nama_praktikum" required
                                class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <option value="">Pilih Laboratorium Dulu</option>
                        </select>
                        @error('nama_praktikum')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block text-sm font-semibold text-slate-700 mb-2">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="quantity" id="quantity" required min="1"
                           value="{{ old('quantity', $resourceRequest->quantity) }}"
                           class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                           placeholder="1">
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">
                        Deskripsi Kebutuhan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" required rows="5"
                              class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                              placeholder="Jelaskan secara detail untuk apa resource ini dibutuhkan...">{{ old('description', $resourceRequest->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-slate-500">💡 Perbaiki dan lengkapi deskripsi sesuai feedback Laboran</p>
                </div>

                <!-- Date & Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="needed_date" class="block text-sm font-semibold text-slate-700 mb-2">
                            Tanggal Dibutuhkan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="needed_date" id="needed_date" required
                               value="{{ old('needed_date', $resourceRequest->needed_date->format('Y-m-d')) }}"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        @error('needed_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="needed_time" class="block text-sm font-semibold text-slate-700 mb-2">
                            Waktu Dibutuhkan <span class="text-slate-400">(Opsional)</span>
                        </label>
                        <input type="time" name="needed_time" id="needed_time"
                               value="{{ old('needed_time', $resourceRequest->needed_time) }}"
                               class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        @error('needed_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-slate-500">Khususnya untuk peminjaman ruangan</p>
                    </div>
                </div>

                <!-- Duration -->
                <div>
                    <label for="duration" class="block text-sm font-semibold text-slate-700 mb-2">
                        Durasi Penggunaan <span class="text-slate-400">(Menit, Opsional)</span>
                    </label>
                    <input type="number" name="duration" id="duration" min="15" step="15"
                           value="{{ old('duration', $resourceRequest->duration) }}"
                           class="w-full px-4 py-3 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                           placeholder="120">
                    @error('duration')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500">Khususnya untuk peminjaman ruangan (kelipatan 15 menit)</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-teal-500 to-emerald-500 text-white rounded-lg hover:from-teal-600 hover:to-emerald-600 transition font-semibold shadow-lg shadow-teal-500/30">
                        🔄 Ajukan Ulang Kebutuhan
                    </button>
                    <a href="{{ route('asprak.resource-requests.show', $resourceRequest) }}" class="px-6 py-3 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-medium">
                        Batal
                    </a>
                </div>

                <!-- Info -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs text-slate-600">
                    ℹ️ <strong>Catatan:</strong> Setelah Anda ajukan ulang, status akan kembali menjadi "Pending" dan feedback sebelumnya akan dihapus. 
                    Laboran akan melakukan review ulang terhadap kebutuhan Anda.
                </div>
            </form>

        </div>

    </main>

    <script>
        const praktikumData = @json($praktikums);
        
        function updatePraktikums() {
            const lab = document.getElementById('laboratorium').value;
            const praktikumSelect = document.getElementById('nama_praktikum');
            
            praktikumSelect.innerHTML = '<option value="">Pilih Nama Praktikum</option>';
            
            if (lab && praktikumData[lab]) {
                praktikumData[lab].forEach(praktikum => {
                    const option = document.createElement('option');
                    option.value = praktikum;
                    option.textContent = praktikum;
                    option.selected = '{{ old("nama_praktikum", $resourceRequest->nama_praktikum) }}' === praktikum;
                    praktikumSelect.appendChild(option);
                });
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const oldLab = '{{ old("laboratorium", $resourceRequest->laboratorium) }}';
            if (oldLab) {
                updatePraktikums();
            }
        });
    </script>

</body>
</html>
