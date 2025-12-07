<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Salary Asprak</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: "Poppins", sans-serif; } </style>
</head>

<body class="bg-[#f5f7fb] min-h-screen flex flex-col">

<main class="flex-1 py-10">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow p-8 border border-slate-200">

        <h1 class="text-2xl font-bold text-slate-800 mb-1">Edit Salary Asprak</h1>
        <p class="text-sm text-slate-500 mb-6">Perbarui informasi salary asisten praktikum.</p>

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-2 text-sm text-emerald-700">
                ✔ {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('laboran.salary.update', $salary->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div class="mb-4">
                <label class="text-sm font-medium text-slate-700">Nama Mahasiswa</label>
                <input type="text" name="nama_mahasiswa" value="{{ old('nama_mahasiswa', $salary->nama_mahasiswa) }}"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-teal-500">
            </div>

            <!-- NIM -->
            <div class="mb-4">
                <label class="text-sm font-medium text-slate-700">NIM</label>
                <input type="text" name="nim" value="{{ old('nim', $salary->nim) }}"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-teal-500">
            </div>

            <!-- Kelas -->
            <div class="mb-4">
                <label class="text-sm font-medium text-slate-700">Kelas</label>
                <input type="text" name="kelas" value="{{ old('kelas', $salary->kelas) }}"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-teal-500">
            </div>

            <!-- Jumlah Shift -->
            <div class="mb-4">
                <label class="text-sm font-medium text-slate-700">Jumlah Shift</label>
                <input type="number" name="jumlah_shift" value="{{ old('jumlah_shift', $salary->jumlah_shift) }}"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-teal-500">
            </div>

            <!-- Slip Gaji -->
            <div class="mb-4">
                <label class="text-sm font-medium text-slate-700">Slip Gaji</label>
                <input type="number" name="slip_gaji" value="{{ old('slip_gaji', $salary->slip_gaji) }}"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-teal-500">
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="text-sm font-medium text-slate-700">Status</label>
                <select name="status" class="w-full border border-slate-300 rounded-lg px-3 py-2 mt-1">
                    <option value="success" {{ $salary->status === 'success' ? 'selected' : '' }}>Success</option>
                    <option value="pending" {{ $salary->status === 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>

            <!-- Foto Bukti -->
            <div class="mb-5">
                <label class="text-sm font-medium text-slate-700">Bukti Foto (Opsional)</label>
                <input type="file" name="bukti_foto"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 mt-1">

                @if($salary->bukti_foto)
                    <p class="text-xs text-slate-500 mt-2 mb-1">Bukti saat ini:</p>
                    <img src="{{ asset($salary->bukti_foto) }}" class="h-20 rounded-lg border shadow">
                @endif
            </div>

            <!-- Button -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('laboran.salary.index') }}"
                   class="px-5 py-2 rounded-lg bg-slate-200 text-slate-700 hover:bg-slate-300 text-sm">
                    Kembali
                </a>

                <button type="submit"
                        class="px-5 py-2 rounded-lg bg-teal-500 text-white hover:bg-teal-600 text-sm shadow">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</main>

</body>
</html>
