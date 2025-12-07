<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jadwal Shift - Laboran</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FONT POPPINS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>

<body class="bg-[#f5f7fb] min-h-screen">
<div class="max-w-3xl mx-auto py-10 px-4">

    <!-- Back button -->
    <a href="{{ route('laboran.jadwal.index') }}"
       class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[11px] font-medium
              border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:border-slate-300
              shadow-sm transition mb-5">
        <span class="text-base">←</span> Kembali ke Jadwal
    </a>

    <!-- Title -->
    <h1 class="text-3xl font-bold text-slate-900 tracking-tight mb-3">
        Tambah Jadwal Shift Asisten
    </h1>
    <p class="text-sm text-slate-500 mb-6">
        Isi informasi shift asisten praktikum dengan lengkap dan pastikan jam tidak saling bertabrakan.
    </p>

    <!-- FORM WRAPPER -->
    <div class="rounded-[26px] bg-gradient-to-br from-teal-100/50 via-white to-sky-100/40 p-[1px]
                shadow-[0_12px_36px_rgba(15,23,42,0.08)]">
        <form action="{{ route('laboran.jadwal.store') }}"
              method="POST"
              class="bg-white rounded-[24px] p-6 md:p-8 space-y-6">
            @csrf

            <!-- ✅ NAMA PRAKTIKUM -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">
                    Nama Praktikum
                </label>
                <input type="text" name="praktikum"
                       value="{{ old('praktikum') }}"
                       placeholder="Contoh: Praktikum Basis Data"
                       class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm
                              focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                @error('praktikum')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama shift & Kelas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Shift</label>
                    <input type="text" name="name"
                           value="{{ old('name') }}"
                           placeholder="SHIFT 1"
                           class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm
                                  focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                    @error('name')
                        <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Kelas</label>
                    <input type="text" name="class_code"
                           value="{{ old('class_code') }}"
                           placeholder="SI-46-10"
                           class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm
                                  focus:ring-2 focus:ring-teal-500 transition">
                    @error('class_code')
                        <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tanggal & Jam -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal</label>
                    <input type="date" name="date"
                           value="{{ old('date') }}"
                           class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm
                                  focus:ring-2 focus:ring-teal-500">
                    @error('date')
                        <p class="text:[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Jam Mulai</label>
                    <input type="time" name="start_time"
                           value="{{ old('start_time') }}"
                           class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm
                                  focus:ring-2 focus:ring-teal-500">
                    @error('start_time')
                        <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Jam Selesai</label>
                    <input type="time" name="end_time"
                           value="{{ old('end_time') }}"
                           class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm
                                  focus:ring-2 focus:ring-teal-500">
                    @error('end_time')
                        <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Kuota Asisten -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Kuota Asisten</label>
                <input type="number" name="capacity" min="1"
                       value="{{ old('capacity', 1) }}"
                       class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm
                              focus:ring-2 focus:ring-teal-500">
                @error('capacity')
                    <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="pt-2 flex justify-end gap-3">
                <a href="{{ route('laboran.jadwal.index') }}"
                   class="px-4 py-2 rounded-lg border border-slate-200 text-xs font-medium
                          text-slate-600 bg-white hover:bg-slate-50 transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-teal-500 text-xs font-semibold text-white
                               hover:bg-teal-600 shadow-md hover:shadow-lg transition">
                    Simpan Jadwal
                </button>
            </div>

        </form>
    </div>
</div>
</body>
</html>
