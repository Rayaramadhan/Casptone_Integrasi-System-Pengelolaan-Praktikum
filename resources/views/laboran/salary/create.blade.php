<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Gaji Asprak - Laboran</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FONT POPPINS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>

<body class="bg-[#f5f7fb] min-h-screen">

<div class="max-w-3xl mx-auto py-10 px-4">

    <!-- Back button -->
    <a href="{{ route('laboran.salary.index') }}"
       class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[11px] font-medium
              border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:border-slate-300
              shadow-sm transition mb-5">
        <span class="text-base">←</span> Kembali
    </a>

    <!-- Title -->
    <h1 class="text-3xl font-bold text-slate-900 tracking-tight mb-3">
        Input Salary Asisten Praktikum
    </h1>
    <p class="text-sm text-slate-500 mb-6">
        Pastikan semua data diisi dengan benar sebelum menyimpan.
    </p>

    <!-- FORM WRAPPER WITH GRADIENT BORDER -->
    <div class="rounded-[26px] bg-gradient-to-br from-teal-100/50 via-white to-sky-100/40 p-[1px]
                shadow-[0_12px_36px_rgba(15,23,42,0.08)]">
        <form method="POST"
              action="{{ route('laboran.salary.store') }}"
              enctype="multipart/form-data"
              class="bg-white rounded-[24px] p-6 md:p-8 space-y-6">
            @csrf

            <!-- Select Asprak -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Asisten Praktikum (Opsional)
                </label>
                <select name="asprak_id"
                        class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm
                               focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                    <option value="">-- Pilih Asprak --</option>
                    @foreach($aspraks as $asprak)
                        <option value="{{ $asprak->id }}" {{ old('asprak_id') == $asprak->id ? 'selected' : '' }}>
                            {{ $asprak->name }} ({{ $asprak->email }})
                        </option>
                    @endforeach
                </select>
                @error('asprak_id')
                <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Student Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Mahasiswa</label>
                    <input type="text" name="nama_mahasiswa"
                           value="{{ old('nama_mahasiswa') }}"
                           class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm
                                  focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                    @error('nama_mahasiswa')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">NIM</label>
                    <input type="text" name="nim"
                           value="{{ old('nim') }}"
                           class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm
                                  focus:ring-2 focus:ring-teal-500 transition">
                    @error('nim')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Class + Shift + Salary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Kelas</label>
                    <input type="text" name="kelas"
                           value="{{ old('kelas') }}"
                           class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
                    @error('kelas')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Jumlah Shift</label>
                    <input type="number" name="jumlah_shift" min="0"
                           value="{{ old('jumlah_shift', 0) }}"
                           class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
                    @error('jumlah_shift')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Slip Gaji (Rp)</label>
                    <input type="number" name="slip_gaji" min="0"
                           value="{{ old('slip_gaji', 0) }}"
                           class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500">
                    @error('slip_gaji')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Status Pembayaran</label>
                <select name="status"
                        class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm
                               focus:ring-2 focus:ring-teal-500 transition">
                    <option value="success" {{ old('status') === 'success' ? 'selected' : '' }}>Success</option>
                    <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
                @error('status')
                <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Bukti Foto -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Upload Bukti Foto</label>

                <input type="file" name="bukti_foto" accept="image/*"
                       class="block w-full text-sm text-slate-600
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0 file:font-semibold
                              file:bg-teal-50 file:text-teal-700
                              hover:file:bg-teal-100 cursor-pointer" />

                <p class="text-[11px] text-slate-400 mt-1">Format JPG/PNG, maksimal 2 MB.</p>

                @error('bukti_foto')
                <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="pt-2 flex justify-end gap-3">
                <a href="{{ route('laboran.salary.index') }}"
                   class="px-4 py-2 rounded-lg border border-slate-200 text-xs font-medium
                          text-slate-600 bg-white hover:bg-slate-50 transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-teal-500 text-xs font-semibold text-white
                               hover:bg-teal-600 shadow-md hover:shadow-lg transition">
                    Simpan Data
                </button>
            </div>

        </form>
    </div>
</div>

</body>
</html>
