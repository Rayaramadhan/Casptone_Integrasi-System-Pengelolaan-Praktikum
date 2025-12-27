<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIAP - Sistem Informasi Asisten Praktikum</title>
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- Optional: font Poppins --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
      body { font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
  </style>
</head>
<body class="bg-[#f5f7fb] min-h-full flex flex-col">

  <header class="w-full bg-white border-b border-teal-50 shadow-[0_2px_6px_rgba(15,118,110,0.08)]">
    <div class="w-full px-0 py-3 flex items-center justify-between gap-4">

      <div class="flex items-stretch">
        <div class="flex items-center bg-teal-500 text-white px-5 sm:px-7 py-3 sm:py-4 rounded-br-3xl rounded-tr-3xl shadow-sm">
          <div class="flex items-center gap-3">
            <div class="h-10 w-10 sm:h-11 sm:w-11 bg-white/20 rounded-full flex items-center justify-center shadow-inner">
              <img
                src="/images/utama/logo.png"
                alt="Logo SIAP"
                class="h-8 w-8 sm:h-9 sm:w-9 object-contain rounded-full"
              />
            </div>
            <div class="leading-tight">
              <p class="text-[10px] sm:text-[11px] uppercase tracking-[0.16em] text-teal-50/90">
                Sistem Informasi
              </p>
              <span class="font-semibold text-sm sm:text-lg tracking-wide">
                SIAP
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="flex items-center justify-end flex-1 pr-0">
        @auth
            @php
                $initial = strtoupper(mb_substr(Auth::user()->name, 0, 1));
                $isAdmin = Auth::user()->usertype === 'admin';
                $dashUrl = $isAdmin ? url('/admin/dashboard') : url('/dashboard');
            @endphp

            {{-- DESKTOP --}}
            <div
                class="hidden md:flex items-center gap-4 rounded-full bg-white/80 border border-slate-200
                       px-5 py-2.5 shadow-[0_6px_18px_rgba(15,23,42,0.08)] backdrop-blur-sm max-w-md mr-4">

                <div class="flex flex-col leading-tight">
                    <span class="font-semibold text-sm text-slate-900">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-slate-500">{{ Auth::user()->email }}</span>
                </div>

                <a href="{{ $dashUrl }}"
                   class="inline-flex items-center justify-center text-xs md:text-sm font-medium px-4 py-1.5
                          rounded-full border border-teal-400 text-teal-600 bg-teal-50
                          hover:bg-teal-500 hover:text-white transition">
                    Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center justify-center text-xs md:text-sm font-medium
                                   px-4 py-1.5 rounded-full border border-slate-200 text-slate-600 bg-white
                                   hover:bg-slate-50 transition">
                        Logout
                    </button>
                </form>

                <div class="relative">
                    <div class="flex items-center justify-center h-9 w-9 rounded-full bg-teal-500 text-white font-semibold shadow-sm">
                        {{ $initial }}
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-400 border-2 border-white"></span>
                </div>
            </div>

        @else
            <div class="flex items-center gap-3 sm:gap-4 pr-4">
                <a href="{{ route('login') }}"
                   class="text-xs sm:text-sm font-medium text-slate-800 px-3 sm:px-4 py-1.5 rounded-full border border-slate-200 bg-white hover:bg-slate-50 transition">
                    Login
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="text-xs sm:text-sm font-medium text-white px-4 sm:px-5 py-1.5 rounded-full bg-teal-500 shadow hover:bg-teal-600 transition">
                        Daftar Asisten
                    </a>
                @endif
            </div>
        @endauth
      </div>
    </div>
  </header>


  {{-- MAIN --}}
  <main class="flex-1 w-full">
    <section class="max-w-6xl mx-auto px-4 lg:px-6 py-10 space-y-10">

     {{-- Tombol Kembali --}}
      <a href="{{ url()->previous() }}" 
         class="inline-flex items-center gap-2 px-4 py-2 mb-6 rounded-full text-[13px] font-medium
                border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:border-slate-300
                shadow-sm transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali
      </a>

      {{-- FLASH --}}
      @if(session('success'))
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
          {{ session('success') }}
        </div>
      @endif

      {{-- FORM NILAI --}}
      <div>
        <h1 class="text-2xl sm:text-3xl font-semibold text-slate-900 mb-6">Form Input Nilai</h1>

        <div class="bg-white rounded-3xl shadow border border-slate-100 overflow-hidden">

          <div class="bg-sky-50 border-b border-sky-100 px-6 py-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-sky-500 text-white flex items-center justify-center shadow-sm">
              🔔
            </div>
            <p class="text-sm text-slate-700">Masukkan data nilai yang sesuai.</p>
          </div>

          <div class="px-6 lg:px-8 py-8">
            <form action="{{ route('asprak.nilai.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
              @csrf

              {{-- row 1 --}}
              <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Lab</label>
                    <select id="lab_select" name="lab" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
                      <option hidden selected value="">Pilih Lab</option>
                      <option value="Lab SAG">Lab SAG</option>
                      <option value="Lab ERP">Lab ERP</option>
                      <option value="Lab EISD">Lab EISD</option>
                      <option value="Lab EIM">Lab EIM</option>
                      <option value="Lab EDM">Lab EDM</option>
                    </select>
                  </div>

                  <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5">Praktikum</label>
                    <select id="praktikum_select" name="praktikum" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm" disabled>
                      <option hidden selected value="">Pilih Praktikum</option>
                    </select>
                  </div>
              </div>

              {{-- row 2 --}}
              <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1.5">Kelas</label>
                  <input type="text" name="kelas" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm" placeholder="IF-3B">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1.5">NIM</label>
                  <input type="text" name="nim" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1.5">Nama Lengkap</label>
                  <input type="text" name="nama" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
                </div>
              </div>

              {{-- row 3 --}}
              <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1.5">Modul</label>
                  <input type="text" name="modul" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1.5">Nilai Total</label>
                  <input type="number" step="0.01" name="nilai_total" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm">
                </div>
              </div>

              {{-- FILE --}}
              <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <label class="block text-xs font-semibold text-slate-500">Bukti Nilai Modul</label>

                <label class="inline-flex items-center gap-2 text-xs sm:text-sm font-medium px-4 py-2 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 cursor-pointer transition">
                  <span id="bukti_text">Upload Bukti</span>
                  <span id="bukti_badge" class="hidden ml-1 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-700">
                      ✔ Terpilih
                  </span>

                  <input type="file" name="bukti_modul" id="bukti_modul" class="hidden">
                </label>

                <p id="bukti_filename" class="text-[11px] text-slate-400 mt-1 sm:mt-0"></p>
              </div>

              {{-- BUTTON --}}
              <div class="mt-4 flex flex-col md:flex-row items-stretch md:items-center gap-4">
                <button type="submit" class="w-full md:flex-1 px-6 py-3 rounded-2xl bg-teal-500 text-white text-sm font-semibold hover:bg-teal-600 shadow">
                  Simpan Data
                </button>
                <button type="reset" class="w-full md:w-auto px-6 py-3 rounded-2xl border border-slate-200 bg-white text-sm font-medium text-slate-600 hover:bg-slate-50">
                  Reset
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>

      {{-- TABEL NILAI --}}
      <div>
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 gap-4">
            <h2 class="text-xl font-semibold text-slate-900">Rekap Nilai Praktikum</h2>
            
            <div class="flex flex-wrap gap-2">
                <select id="filter_lab" class="text-xs border border-slate-200 rounded-lg px-3 py-2 bg-white outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">Semua Lab</option>
                    <option value="Lab SAG">Lab SAG</option>
                    <option value="Lab ERP">Lab ERP</option>
                    <option value="Lab EISD">Lab EISD</option>
                    <option value="Lab EIM">Lab EIM</option>
                    <option value="Lab EDM">Lab EDM</option>
                </select>
                <input type="text" id="filter_praktikum" placeholder="Filter Praktikum..." class="text-xs border border-slate-200 rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-teal-500">
                <input type="text" id="filter_modul" placeholder="Filter Modul..." class="text-xs border border-slate-200 rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-teal-500">
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
          <div class="overflow-x-auto">
            <table class="min-w-full text-xs sm:text-sm text-left" id="table_nilai">
              <thead class="bg-slate-50 text-slate-600">
                <tr>
                  <th class="px-4 py-3 border-b">No</th>
                  <th class="px-4 py-3 border-b">Lab</th>
                  <th class="px-4 py-3 border-b">Praktikum</th>
                  <th class="px-4 py-3 border-b">Kelas</th>
                  <th class="px-4 py-3 border-b">NIM</th>
                  <th class="px-4 py-3 border-b">Nama</th>
                  <th class="px-4 py-3 border-b">Modul</th>
                  <th class="px-4 py-3 border-b">Nilai</th>
                  <th class="px-4 py-3 border-b">Bukti</th>
                  <th class="px-4 py-3 border-b">Tanggal</th>
                  <th class="px-4 py-3 border-b">Aksi</th>
                </tr>
              </thead>

              <tbody class="divide-y divide-slate-100">
                @forelse($nilai as $index => $row)
                  <tr class="hover:bg-slate-50/60 table-row-item">
                    <td class="px-4 py-3 row-number">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 col-lab">{{ $row->lab }}</td>
                    <td class="px-4 py-3 col-praktikum">{{ $row->praktikum }}</td>
                    <td class="px-4 py-3">{{ $row->kelas }}</td>
                    <td class="px-4 py-3 font-mono text-xs">{{ $row->nim }}</td>
                    <td class="px-4 py-3">{{ $row->nama_lengkap }}</td>
                    <td class="px-4 py-3 col-modul">{{ $row->modul }}</td>
                    <td class="px-4 py-3 font-semibold">{{ $row->nilai_total }}</td>

                    <td class="px-4 py-3">
                      @if($row->bukti_nilai_modul)
                        <a href="{{ asset($row->bukti_nilai_modul) }}" target="_blank"
                           class="text-[11px] text-teal-600 underline">
                           Lihat
                        </a>
                      @else
                        <span class="text-[11px] text-slate-400">-</span>
                      @endif
                    </td>

                    <td class="px-4 py-3 text-[11px] text-slate-500">
                      {{ $row->created_at?->format('d/m/Y H:i') }}
                    </td>

                    {{-- KOLUM AKSI --}}
                    <td class="px-4 py-3">
                      <div class="flex items-center gap-3">
                        <a href="{{ route('asprak.nilai.edit', $row->id) }}"
                           class="text-blue-600 text-xs hover:underline">
                          Edit
                        </a>

                        <form action="{{ route('asprak.nilai.destroy', $row->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 text-xs hover:underline">
                              Hapus
                            </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr id="no-data-row">
                    <td colspan="11" class="px-4 py-5 text-center text-slate-400 text-xs">
                      Belum ada data nilai.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </section>
  </main>

  {{-- FOOTER --}}
  <footer class="w-full mt-10">
    <div class="w-full bg-teal-500 text-center py-4">
      <p class="text-xs sm:text-sm font-medium text-white tracking-wide">
        Created By Tim The Third-Party Gang
      </p>
    </div>
  </footer>

  {{-- SCRIPT FILE --}}
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    // ====== 1) SCRIPT UPLOAD (punyamu) ======
    const input = document.getElementById('bukti_modul');
    const text = document.getElementById('bukti_text');
    const badge = document.getElementById('bukti_badge');
    const fileNameEl = document.getElementById('bukti_filename');

    if (input) {
      input.addEventListener('change', function () {
        if (this.files && this.files.length > 0) {
          const file = this.files[0];
          text.textContent = 'Bukti terupload';
          badge.classList.remove('hidden');

          let name = file.name;
          if (name.length > 30) name = name.substring(0, 27) + '...';
          fileNameEl.textContent = 'File: ' + name;
        } else {
          text.textContent = 'Upload Bukti';
          badge.classList.add('hidden');
          fileNameEl.textContent = '';
        }
      });
    }

    // ====== 2) SCRIPT LAB -> PRAKTIKUM (baru) ======
    const labSelect = document.getElementById('lab_select');
    const praktikumSelect = document.getElementById('praktikum_select');

    const praktikumByLab = {
      "Lab SAG": ["Enterprise Architecture", "Manajemen Layanan TI", "Pemodelan Proses Bisnis"],
      "Lab ERP": ["Supply Chain Management", "Enterprise Resource Planning", "Customer Relationship Management"],
      "Lab EISD": ["Pemrograman Dasar", "Algoritma & Struktur Data", "Pemrograman Web"],
      "Lab EIM": ["Jaringan Komputer", "Sistem Operasi"],
      "Lab EDM": ["Data Mining", "Data Warehouse", "Business Intelligence"],
    };

    function resetPraktikum() {
      praktikumSelect.innerHTML = '<option hidden selected value="">Pilih Praktikum</option>';
      praktikumSelect.disabled = true;
    }

    function fillPraktikumOptions(labValue) {
      const list = praktikumByLab[labValue] || [];
      praktikumSelect.innerHTML = '<option hidden selected value="">Pilih Praktikum</option>';

      if (list.length === 0) {
        praktikumSelect.disabled = true;
        return;
      }

      list.forEach((item) => {
        const opt = document.createElement('option');
        opt.value = item;
        opt.textContent = item;
        praktikumSelect.appendChild(opt);
      });

      praktikumSelect.disabled = false;
    }

    if (labSelect && praktikumSelect) {
      resetPraktikum();
      labSelect.addEventListener('change', function () {
        const labValue = this.value;
        if (!labValue) return resetPraktikum();
        fillPraktikumOptions(labValue);
      });
      if (labSelect.value) {
        fillPraktikumOptions(labSelect.value);
      }
    }

    // ====== 3) SCRIPT FILTER TABEL (BARU) ======
    const filterLab = document.getElementById('filter_lab');
    const filterPrak = document.getElementById('filter_praktikum');
    const filterModul = document.getElementById('filter_modul');
    const tableRows = document.querySelectorAll('.table-row-item');

    function filterTable() {
        const labValue = filterLab.value.toLowerCase();
        const prakValue = filterPrak.value.toLowerCase();
        const modulValue = filterModul.value.toLowerCase();

        tableRows.forEach(row => {
            const labText = row.querySelector('.col-lab').textContent.toLowerCase();
            const prakText = row.querySelector('.col-praktikum').textContent.toLowerCase();
            const modulText = row.querySelector('.col-modul').textContent.toLowerCase();

            const matchLab = labValue === "" || labText.includes(labValue);
            const matchPrak = prakValue === "" || prakText.includes(prakValue);
            const matchModul = modulValue === "" || modulText.includes(modulValue);

            if (matchLab && matchPrak && matchModul) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    filterLab.addEventListener('change', filterTable);
    filterPrak.addEventListener('input', filterTable);
    filterModul.addEventListener('input', filterTable);
  });
</script>

</body>
</html>