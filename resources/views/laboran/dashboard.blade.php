<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIAP - Sistem Informasi Asisten Praktikum</title>
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- Optional: font Poppins biar mirip desain welcome --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
      body { font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
  </style>
</head>
<body class="bg-[#f5f7fb] min-h-full flex flex-col">

  <!-- TOP BAR -->
  <header class="w-full bg-white border-b border-teal-50 shadow-[0_2px_6px_rgba(15,118,110,0.08)]">
    <!-- di sini: w-full, tanpa max-w & mx-auto, px-0 supaya mentok kiri-kanan -->
    <div class="w-full px-0 py-3 flex items-center justify-between gap-4">

      <!-- blok kiri hijau (logo + title) -->
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

      <!-- kanan: info user + tombol -->
      <div class="flex items-center justify-end flex-1 pr-0">
        @auth
            @php
                $initial = strtoupper(mb_substr(Auth::user()->name, 0, 1));
                $isAdmin = Auth::user()->usertype === 'admin';
                $dashUrl = $isAdmin ? url('/admin/dashboard') : url('/dashboard');
            @endphp

            {{-- DESKTOP / TABLET: kapsul lengkap --}}
            <div
                class="hidden md:flex items-center gap-4 rounded-full bg-white/80 border border-slate-200
                       px-5 py-2.5 shadow-[0_6px_18px_rgba(15,23,42,0.08)] backdrop-blur-sm
                       max-w-md mr-4">

                {{-- Nama + email --}}
                <div class="flex flex-col leading-tight">
                    <span class="font-semibold text-sm text-slate-900">
                        {{ Auth::user()->name }}
                    </span>
                    <span class="text-xs text-slate-500">
                        {{ Auth::user()->email }}
                    </span>
                </div>

                {{-- Tombol Dashboard --}}
                <a href="{{ $dashUrl }}"
                   class="inline-flex items-center justify-center text-xs md:text-sm font-medium
                          px-4 py-1.5 rounded-full border border-teal-400
                          text-teal-600 bg-teal-50
                          hover:bg-teal-500 hover:text-white hover:border-teal-500
                          transition-colors duration-150">
                    Dashboard
                </a>

                {{-- Tombol Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center justify-center text-xs md:text-sm font-medium
                                   px-4 py-1.5 rounded-full border border-slate-200
                                   text-slate-600 bg-white
                                   hover:bg-slate-50 hover:border-slate-300
                                   transition-colors duration-150">
                        Logout
                    </button>
                </form>

                {{-- Avatar inisial --}}
                <div class="relative">
                    <div
                        class="flex items-center justify-center h-9 w-9 rounded-full
                               bg-teal-500 text-white text-xs md:text-sm font-semibold shadow-sm">
                        {{ $initial }}
                    </div>
                    {{-- indikator online kecil --}}
                    <span
                        class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-400
                               border-2 border-white">
                    </span>
                </div>
            </div>

            {{-- MOBILE: versi ringkas --}}
            <div class="flex md:hidden items-center gap-2 mr-2">
                <div class="text-right leading-tight mr-1">
                    <p class="text-[11px] font-medium text-slate-900">
                        {{ \Illuminate\Support\Str::limit(Auth::user()->name, 14) }}
                    </p>
                    <p class="text-[10px] text-slate-500">
                        {{ \Illuminate\Support\Str::limit(Auth::user()->email, 18) }}
                    </p>
                </div>

                <a href="{{ $dashUrl }}"
                   class="text-[11px] font-medium px-3 py-1 rounded-full border border-teal-400
                          text-teal-600 bg-white hover:bg-teal-50 transition">
                    Dash
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-[11px] px-3 py-1 rounded-full border border-slate-300
                                   text-slate-600 bg-white hover:bg-slate-50 transition">
                        Out
                    </button>
                </form>

                <div
                    class="flex items-center justify-center h-8 w-8 rounded-full bg-teal-500 text-white
                           text-[11px] font-semibold shadow-sm">
                    {{ $initial }}
                </div>
            </div>
        @else
            <!-- Kalau belum login: seperti header welcome (Login + Daftar) -->
            <div class="flex items-center gap-3 sm:gap-4 pr-4">
                <a href="{{ route('login') }}"
                   class="text-xs sm:text-sm font-medium text-slate-800 px-3 sm:px-4 py-1.5 rounded-full
                          border border-slate-200 bg-white hover:bg-slate-50 transition">
                    Login
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="text-xs sm:text-sm font-medium text-white px-4 sm:px-5 py-1.5 rounded-full
                              bg-teal-500 shadow-[0_4px_10px_rgba(20,184,166,0.35)]
                              hover:bg-teal-600 transition">
                        Daftar Asisten
                    </a>
                @endif
            </div>
        @endauth
      </div>
    </div>
  </header>

  <main class="flex-1 flex flex-col">

    <!-- HERO IMAGE seperti banner Telkom -->
    <section
      class="relative w-full h-[360px] md:h-[460px] bg-cover bg-center bg-no-repeat overflow-hidden"
      style="background-image:url('/images/utama/navbar.png');"
    >
      <div class="absolute inset-0 bg-gradient-to-br from-teal-900/60 via-teal-800/40 to-teal-700/40 mix-blend-multiply"></div>
      <div class="relative z-10 max-w-7xl mx-auto h-full flex items-center px-6">
        <div class="max-w-xl text-white drop-shadow">
          <p class="text-xs md:text-sm tracking-[0.18em] uppercase font-medium text-teal-100">
            Telkom University · Sistem Informasi
          </p>
          <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold mt-2 leading-tight">
            Sistem Informasi Asisten Praktikum
          </h1>
          <p class="text-xs md:text-base mt-3 md:mt-4 opacity-90 max-w-md">
            Kelola jadwal, presensi, penilaian, dan laporan asisten praktikum dalam satu platform terintegrasi.
          </p>
        </div>
      </div>
    </section>

      <    <!-- MAIN MENU -->
    <section class="relative py-14 md:py-16 bg-gradient-to-b from-transparent via-[#f3fbfb] to-[#e8f7f6]">
      <!-- soft glow background -->
      <div class="pointer-events-none absolute -left-10 top-10 w-40 h-40 bg-teal-300/25 blur-3xl rounded-full"></div>
      <div class="pointer-events-none absolute -right-16 bottom-10 w-48 h-48 bg-emerald-300/20 blur-3xl rounded-full"></div>

      <div class="max-w-4xl mx-auto px-4 relative z-10">
        <!-- Title + subtitle -->
        <div class="text-center mb-10">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-medium
                       bg-teal-50 text-teal-700 border border-teal-100 shadow-sm">
            🧪 Akses Cepat Laboran
          </span>
          <h2 class="mt-3 text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">
            Main Menu Laboran
          </h2>
          <p class="mt-2 text-xs md:text-sm text-slate-500 max-w-xl mx-auto">
            Ringkasan fungsi utama laboran: pantau dashboard operasional, kelola laporan,
            serta monitor honorarium praktikum dalam satu tampilan.
          </p>
        </div>

        <!-- wrapper kartu -->
        <div class="rounded-[26px] bg-gradient-to-br from-teal-100/45 via-white to-emerald-100/60 p-[1px] shadow-[0_18px_45px_rgba(15,23,42,0.08)]">
          <div class="bg-white/95 rounded-[24px] px-4 sm:px-8 py-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-5 md:gap-6 justify-items-center">


              <!-- Dashboard -->
              <a href="#"
                 class="w-full max-w-[260px] bg-gradient-to-b from-slate-50 to-white border border-teal-50 rounded-2xl shadow-sm
                        flex flex-col items-center py-5 px-4 hover:-translate-y-1 hover:shadow-md
                        hover:border-teal-300 transition duration-150 group">
                <div class="w-11 h-11 mb-2 flex items-center justify-center rounded-2xl
                            bg-gradient-to-br from-teal-50 to-emerald-50
                            border border-teal-100 text-xl group-hover:scale-110 group-hover:bg-teal-100/70 transition">
                  📊
                </div>
                <p class="text-sm md:text-base font-semibold text-slate-800">Dashboard</p>
                <p class="mt-1.5 text-[11px] text-slate-400 text-center">
                  Lihat overview praktikum, status kelas, dan aktivitas lab secara real-time.
                </p>
              </a>

              <!-- Assignment & Submission -->
              <a href="{{ route('laboran.assignments.index') }}"
                 class="w-full max-w-[260px] bg-gradient-to-b from-slate-50 to-white border border-teal-50 rounded-2xl shadow-sm
                        flex flex-col items-center py-5 px-4 hover:-translate-y-1 hover:shadow-md
                        hover:border-teal-300 transition duration-150 group">
                <div class="w-11 h-11 mb-2 flex items-center justify-center rounded-2xl
                            bg-gradient-to-br from-teal-50 to-emerald-50
                            border border-teal-100 text-xl group-hover:scale-110 group-hover:bg-teal-100/70 transition">
                  📝
                </div>
                <p class="text-sm md:text-base font-semibold text-slate-800">Penugasan</p>
                <p class="mt-1.5 text-[11px] text-slate-400 text-center">
                  Buat penugasan untuk asprak (LPJ, RAB, Laporan, dll) dan review submission.
                </p>
              </a>

              <!-- Resource Request -->
              <a href="{{ route('laboran.resource-requests.index') }}"
                 class="w-full max-w-[260px] bg-gradient-to-b from-slate-50 to-white border border-teal-50 rounded-2xl shadow-sm
                        flex flex-col items-center py-5 px-4 hover:-translate-y-1 hover:shadow-md
                        hover:border-teal-300 transition duration-150 group">
                <div class="w-11 h-11 mb-2 flex items-center justify-center rounded-2xl
                            bg-gradient-to-br from-teal-50 to-emerald-50
                            border border-teal-100 text-xl group-hover:scale-110 group-hover:bg-teal-100/70 transition">
                  📦
                </div>
                <p class="text-sm md:text-base font-semibold text-slate-800">Review Permintaan</p>
                <p class="mt-1.5 text-[11px] text-slate-400 text-center">
                  Kelola dan review kebutuhan praktikum dari asprak.
                </p>
              </a>

              <!-- Nilai -->
              <a href="{{ route('laboran.nilai.index') }}"
                class="w-full max-w-[260px] bg-gradient-to-b from-slate-50 to-white border border-teal-50 rounded-2xl shadow-sm
                        flex flex-col items-center py-5 px-4 hover:-translate-y-1 hover:shadow-md
                        hover:border-teal-300 transition duration-150 group">
                <div class="w-11 h-11 mb-2 flex items-center justify-center rounded-2xl
                            bg-gradient-to-br from-teal-50 to-emerald-50
                            border border-teal-100 text-xl group-hover:scale-110 group-hover:bg-teal-100/70 transition">
                  🎓
                </div>
                <p class="text-sm md:text-base font-semibold text-slate-800">Nilai</p>
                <p class="mt-1.5 text-[11px] text-slate-400 text-center">
                  Kelola nilai asisten praktikum, lengkap dengan rekapan tiap kelas.
                </p>
              </a>

              <!-- Salary -->
              <a href="{{ route('laboran.salary.index') }}"
                 class="w-full max-w-[260px] bg-gradient-to-b from-slate-50 to-white border border-teal-50 rounded-2xl shadow-sm
                        flex flex-col items-center py-5 px-4 hover:-translate-y-1 hover:shadow-md
                        hover:border-teal-300 transition duration-150 group">
                <div class="w-11 h-11 mb-2 flex items-center justify-center rounded-2xl
                            bg-gradient-to-br from-teal-50 to-emerald-50
                            border border-teal-100 text-xl group-hover:scale-110 group-hover:bg-teal-100/70 transition">
                  💰
                </div>
                <p class="text-sm md:text-base font-semibold text-slate-800">Salary</p>
                <p class="mt-1.5 text-[11px] text-slate-400 text-center">
                  Pantau honor laboran, riwayat pencairan, dan status verifikasi pembayaran.
                </p>
              </a>


               <!-- Jadwal Mengajar -->
              <a href="{{ route('laboran.jadwal.index') }}"
                 class="w-full max-w-[260px] bg-gradient-to-b from-slate-50 to-white border border-teal-50 rounded-2xl shadow-sm
                        flex flex-col items-center py-5 px-4 hover:-translate-y-1 hover:shadow-md
                        hover:border-teal-300 transition duration-150 group">
                <div class="w-11 h-11 mb-2 flex items-center justify-center rounded-2xl
                            bg-gradient-to-br from-teal-50 to-emerald-50
                            border border-teal-100 text-xl group-hover:scale-110 group-hover:bg-teal-100/70 transition">
                  📅
                </div>
                <p class="text-sm md:text-base font-semibold text-slate-800">Input Shift Praktikum</p>
                <p class="mt-1.5 text-[11px] text-slate-400 text-center">
                  Lihat jadwal praktikum lengkap dengan kelas dan ruangan.
                </p>
              </a>


            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- SUBMISSION REVIEW WIDGET -->
    @if(isset($submissionStats) && $submissionStats['pending'] > 0)
    <section class="py-14 md:py-16 bg-gradient-to-b from-[#f3fbfb] via-[#e8f7f6] to-[#e0ecff]">
      <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-9">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-medium
                       bg-white/80 text-teal-700 border border-teal-100 shadow-sm">
            📋 Review Submission
          </span>
          <h2 class="mt-3 text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">
            Submission Pending Review
          </h2>
          <p class="mt-2 text-xs md:text-sm text-slate-500 max-w-xl mx-auto">
            Kelola dan review submission penugasan yang diajukan oleh asprak
          </p>
        </div>

        <!-- Submission Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
          <!-- Total Submissions -->
          <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs text-slate-500 mb-1">Total</p>
                <p class="text-2xl font-bold text-slate-900">{{ $submissionStats['total'] }}</p>
              </div>
              <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <span class="text-xl">📋</span>
              </div>
            </div>
          </div>

          <!-- Pending -->
          <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs text-slate-500 mb-1">Pending</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $submissionStats['pending'] }}</p>
              </div>
              <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <span class="text-xl">⏳</span>
              </div>
            </div>
          </div>

          <!-- Approved -->
          <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs text-slate-500 mb-1">Disetujui</p>
                <p class="text-2xl font-bold text-green-600">{{ $submissionStats['approved'] }}</p>
              </div>
              <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <span class="text-xl">✅</span>
              </div>
            </div>
          </div>

          <!-- Rejected -->
          <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-xs text-slate-500 mb-1">Ditolak</p>
                <p class="text-2xl font-bold text-red-600">{{ $submissionStats['rejected'] }}</p>
              </div>
              <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                <span class="text-xl">❌</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Pending Submissions -->
        @if(isset($recentPendingSubmissions) && $recentPendingSubmissions->count() > 0)
        <div class="rounded-[26px] bg-gradient-to-r from-teal-100/50 via-white to-sky-100/60 p-[1px] shadow-[0_18px_45px_rgba(15,23,42,0.08)] mb-6">
          <div class="bg-white/95 rounded-[24px] px-6 py-6">
            <div class="flex justify-between items-center mb-6">
              <h3 class="text-lg font-bold text-slate-900">⏳ Submission Pending (Terbaru)</h3>
              <a href="{{ route('laboran.submissions.index') }}?status=pending" 
                 class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                Lihat Semua →
              </a>
            </div>
            <div class="space-y-3">
              @foreach($recentPendingSubmissions as $submission)
              <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-yellow-50 to-white rounded-xl border border-yellow-100 hover:shadow-md transition">
                <!-- File Icon -->
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-teal-50 rounded-xl flex items-center justify-center">
                    <span class="text-lg">📄</span>
                  </div>
                </div>

                <!-- Submission Info -->
                <div class="flex-1 min-w-0">
                  <h4 class="text-sm font-semibold text-slate-900 truncate">{{ $submission->assignment->judul }}</h4>
                  <p class="text-xs text-slate-500 mt-0.5">
                    Oleh: <span class="font-medium text-slate-700">{{ $submission->asprak->name }}</span>
                  </p>
                  <p class="text-[10px] text-slate-400 mt-1">
                    Diajukan: {{ $submission->created_at->diffForHumans() }}
                  </p>
                </div>

                <!-- Assignment Type -->
                <div class="flex-shrink-0">
                  <span class="px-3 py-1 text-[10px] font-medium rounded-full bg-blue-50 text-blue-700">
                    {{ $submission->assignment->tipe }}
                  </span>
                </div>

                <!-- Action -->
                <div class="flex-shrink-0">
                  <a href="{{ route('laboran.submissions.show', $submission) }}" 
                     class="px-4 py-2 text-xs font-medium bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition">
                    Review
                  </a>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @endif

        <!-- Expired Assignments Alert -->
        @if(isset($expiredAssignments) && $expiredAssignments->count() > 0)
        <div class="rounded-[26px] bg-gradient-to-r from-red-100/50 via-white to-orange-100/60 p-[1px] shadow-[0_18px_45px_rgba(15,23,42,0.08)]">
          <div class="bg-white/95 rounded-[24px] px-6 py-6">
            <div class="flex justify-between items-center mb-6">
              <h3 class="text-lg font-bold text-red-900">⚠️ Penugasan Melewati Deadline</h3>
              <a href="{{ route('laboran.assignments.index') }}?expired=1" 
                 class="text-sm text-red-600 hover:text-red-700 font-medium">
                Lihat Semua →
              </a>
            </div>
            <div class="space-y-3">
              @foreach($expiredAssignments as $assignment)
              <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-red-50 to-white rounded-xl border border-red-100 hover:shadow-md transition">
                <!-- Warning Icon -->
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                    <span class="text-lg">⚠️</span>
                  </div>
                </div>

                <!-- Assignment Info -->
                <div class="flex-1 min-w-0">
                  <h4 class="text-sm font-semibold text-slate-900 truncate">{{ $assignment->judul }}</h4>
                  <p class="text-xs text-slate-500 mt-0.5">
                    Praktikum: <span class="font-medium text-slate-700">{{ $assignment->praktikum }}</span>
                  </p>
                  <p class="text-[10px] text-red-600 mt-1 font-medium">
                    Deadline: {{ $assignment->deadline->format('d M Y') }} ({{ $assignment->deadline->diffForHumans() }})
                  </p>
                </div>

                <!-- Type -->
                <div class="flex-shrink-0">
                  <span class="px-3 py-1 text-[10px] font-medium rounded-full bg-orange-50 text-orange-700">
                    {{ $assignment->tipe }}
                  </span>
                </div>

                <!-- Action -->
                <div class="flex-shrink-0">
                  <a href="{{ route('laboran.assignments.show', $assignment) }}" 
                     class="px-4 py-2 text-xs font-medium bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Detail
                  </a>
                </div>
              </div>
              @endforeach
            </div>

            <div class="mt-4 bg-red-50 border border-red-200 rounded-xl p-4">
              <div class="flex items-start gap-3">
                <span class="text-2xl">⚠️</span>
                <div>
                  <h4 class="text-sm font-bold text-red-800">Perhatian!</h4>
                  <p class="text-xs text-red-700 mt-1">
                    Terdapat <strong>{{ $assignmentStats['expired'] }} penugasan melewati deadline</strong>. 
                    Pertimbangkan untuk menutup penugasan atau perpanjang deadline.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif

        <!-- Pending Resource Requests -->
        @if(isset($pendingResourceRequests) && $pendingResourceRequests->count() > 0)
        <div class="rounded-[26px] bg-gradient-to-r from-teal-100/50 via-white to-emerald-100/60 p-[1px] shadow-[0_18px_45px_rgba(15,23,42,0.08)]">
          <div class="bg-white/95 rounded-[24px] px-6 py-6">
            <div class="flex justify-between items-center mb-6">
              <h3 class="text-lg font-bold text-slate-900">📦 Permintaan Resource Menunggu Review</h3>
              <a href="{{ route('laboran.resource-requests.index') }}" 
                 class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                Lihat Semua →
              </a>
            </div>
            <div class="space-y-3">
              @foreach($pendingResourceRequests as $request)
              <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-slate-50 to-white rounded-xl border border-slate-100 hover:shadow-md transition">
                <!-- Resource Icon -->
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-teal-50 rounded-xl flex items-center justify-center">
                    <span class="text-lg">{{ $request->resource_type_icon }}</span>
                  </div>
                </div>

                <!-- Request Info -->
                <div class="flex-1 min-w-0">
                  <h4 class="text-sm font-semibold text-slate-900 truncate">{{ $request->title }}</h4>
                  <p class="text-xs text-slate-500 mt-0.5">
                    Oleh: <span class="font-medium text-slate-700">{{ $request->user->name }}</span>
                  </p>
                  <p class="text-[10px] text-slate-400 mt-1">
                    {{ $request->resource_type_label }} - Dibutuhkan: {{ $request->formatted_needed_date }}
                  </p>
                </div>

                <!-- Priority -->
                <div class="flex-shrink-0">
                  <span class="px-3 py-1 text-[10px] font-medium rounded-full {{ $request->priority_color }}">
                    {{ $request->priority_label }}
                  </span>
                </div>

                <!-- Actions -->
                <div class="flex-shrink-0 flex gap-2">
                  <a href="{{ route('laboran.resource-requests.show', $request) }}" 
                     class="px-3 py-1.5 text-xs font-medium bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition">
                    Review
                  </a>
                </div>
              </div>
              @endforeach
            </div>

            @if($resourceRequestStats['pending'] > 0)
            <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
              <div class="flex items-start gap-3">
                <span class="text-2xl">⏳</span>
                <div>
                  <h4 class="text-sm font-bold text-yellow-800">Perlu Review</h4>
                  <p class="text-xs text-yellow-700 mt-1">
                    Terdapat <strong>{{ $resourceRequestStats['pending'] }} permintaan resource menunggu review</strong> Anda.
                  </p>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
        @endif

        <!-- Overdue Resource Requests Alert -->
        @if(isset($overdueResourceRequests) && $overdueResourceRequests->count() > 0)
        <div class="rounded-[26px] bg-gradient-to-r from-red-100/50 via-white to-orange-100/60 p-[1px] shadow-[0_18px_45px_rgba(15,23,42,0.08)]">
          <div class="bg-white/95 rounded-[24px] px-6 py-6">
            <div class="flex justify-between items-center mb-6">
              <h3 class="text-lg font-bold text-red-900">⚠️ Permintaan Resource Terlambat</h3>
              <a href="{{ route('laboran.resource-requests.index') }}" 
                 class="text-sm text-red-600 hover:text-red-700 font-medium">
                Lihat Semua →
              </a>
            </div>
            <div class="space-y-3">
              @foreach($overdueResourceRequests as $request)
              <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-red-50 to-white rounded-xl border border-red-100 hover:shadow-md transition">
                <!-- Warning Icon -->
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                    <span class="text-lg">⚠️</span>
                  </div>
                </div>

                <!-- Request Info -->
                <div class="flex-1 min-w-0">
                  <h4 class="text-sm font-semibold text-slate-900 truncate">{{ $request->title }}</h4>
                  <p class="text-xs text-slate-500 mt-0.5">
                    Oleh: <span class="font-medium text-slate-700">{{ $request->user->name }}</span>
                  </p>
                  <p class="text-[10px] text-red-600 mt-1 font-medium">
                    Dibutuhkan: {{ $request->formatted_needed_date }} ({{ $request->needed_date->diffForHumans() }})
                  </p>
                </div>

                <!-- Priority -->
                <div class="flex-shrink-0">
                  <span class="px-3 py-1 text-[10px] font-medium rounded-full {{ $request->priority_color }}">
                    {{ $request->priority_label }}
                  </span>
                </div>

                <!-- Action -->
                <div class="flex-shrink-0">
                  <a href="{{ route('laboran.resource-requests.show', $request) }}" 
                     class="px-4 py-2 text-xs font-medium bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Review Sekarang
                  </a>
                </div>
              </div>
              @endforeach
            </div>

            <div class="mt-4 bg-red-50 border border-red-200 rounded-xl p-4">
              <div class="flex items-start gap-3">
                <span class="text-2xl">⚠️</span>
                <div>
                  <h4 class="text-sm font-bold text-red-800">Perhatian!</h4>
                  <p class="text-xs text-red-700 mt-1">
                    Terdapat <strong>{{ $resourceRequestStats['overdue'] }} permintaan resource terlambat</strong>. 
                    Segera review karena tanggal kebutuhan sudah lewat.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </section>
    @endif


    <!-- LAB SISTEM INFORMASI -->
    <section class="py-14 md:py-16 bg-gradient-to-b from-[#e8f7f6] via-[#e5f3ff] to-[#e0ecff]">
      <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-9">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-medium
                       bg-white/80 text-teal-700 border border-teal-100 shadow-sm">
            🧪 Lingkungan Praktikum Sistem Informasi
          </span>
          <h2 class="mt-3 text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">
            Lab Sistem Informasi
          </h2>
          <p class="mt-2 text-xs md:text-sm text-slate-500 max-w-xl mx-auto">
            Ruang praktikum modern yang mendukung pembelajaran, riset,
            dan pengembangan proyek Sistem Informasi Telkom University.
          </p>
        </div>

        <!-- slider wrapper -->
        <div class="rounded-[26px] bg-gradient-to-r from-teal-100/50 via-white to-sky-100/60 p-[1px] shadow-[0_18px_45px_rgba(15,23,42,0.08)]">
          <div class="bg-white/95 rounded-[24px] px-3 sm:px-5 py-5">
            <div class="flex gap-6 overflow-x-auto pb-3">
              @for ($i = 1; $i <= 5; $i++)
                <article
                  class="min-w-[280px] md:min-w-[340px] bg-gradient-to-b from-slate-50 to-white rounded-2xl shadow-sm hover:shadow-xl
                         transition-transform hover:-translate-y-1 flex flex-col overflow-hidden border border-slate-100">
                  <div class="h-40 md:h-44 w-full overflow-hidden">
                    <img src="/images/utama/labeisd.png" alt="Lab {{ $i }}"
                         class="w-full h-full object-cover transform hover:scale-105 transition duration-300">
                  </div>
                  <div class="p-4 md:p-5 flex-1 flex flex-col">
                    <h3 class="font-semibold text-sm md:text-base text-slate-900 mb-1">
                      EISD Laboratory {{ $i }}
                    </h3>
                    <p class="text-[11px] md:text-xs text-slate-500 leading-relaxed">
                      Laboratorium yang mendukung kegiatan pembelajaran, praktikum,
                      dan pengembangan riset di bidang Sistem Informasi dengan fasilitas
                      komputer dan jaringan yang terintegrasi.
                    </p>
                    <div class="mt-3 flex items-center justify-between text-[11px] text-slate-400">
                      <span class="inline-flex items-center gap-1">
                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                        Aktif digunakan
                      </span>
                      <span class="inline-flex items-center gap-1 text-teal-600 font-medium cursor-pointer">
                        Detail
                        <svg class="w-3 h-3" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7 5L12 10L7 15" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                      </span>
                    </div>
                  </div>
                </article>
              @endfor
            </div>

            <!-- slider indicator -->
            <div class="mt-3 flex items-center justify-center gap-2 text-[10px] text-slate-400">
              <span class="inline-flex h-1.5 w-6 rounded-full bg-teal-500"></span>
              <span class="inline-flex h-1.5 w-3 rounded-full bg-teal-200"></span>
              <span class="inline-flex h-1.5 w-3 rounded-full bg-slate-200"></span>
            </div>
          </div>
        </div>
      </div>
    </section>

  <!-- FOOTER -->
  <footer class="mt-4 bg-teal-600 border-t border-teal-700 shadow-inner">
    <div class="max-w-6xl mx-auto px-4 py-4 text-center">
      <p class="text-white text-[11px] md:text-sm tracking-wide">
        Created By <span class="font-semibold">Tim The Third-Party Gang</span>
      </p>
    </div>
  </footer>
</body>
</html>
