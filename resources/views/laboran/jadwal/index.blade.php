<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Shift Asisten Praktikum - Laboran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>

<body class="bg-[#f5f7fb] min-h-screen flex flex-col">

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
  <main class="flex-1">
    <div class="max-w-6xl mx-auto py-10 px-4">

        <a href="{{ url()->previous() }}"
           class="inline-flex items-center gap-2 px-4 py-2 mb-4 rounded-full bg-white border border-slate-200 
                  text-slate-600 text-sm font-medium shadow-sm hover:bg-slate-50 hover:border-slate-300 
                  transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                    Jadwal Shift Asisten Praktikum
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola jadwal shift untuk setiap praktikum dan kelas.
                </p>
            </div>

            <a href="{{ route('laboran.jadwal.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-emerald-500 text-white text-sm font-semibold
                      shadow-md hover:bg-emerald-600">
                <span class="text-lg">＋</span> Buat Jadwal Baru
            </a>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('laboran.jadwal.index') }}" class="flex gap-2 mb-4">
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Cari lab / praktikum / shift / kelas..."
                   class="flex-1 rounded-full border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
            <button type="submit"
                    class="px-4 py-2 rounded-full bg-teal-500 text-white text-sm font-medium hover:bg-teal-600 transition">
                Cari
            </button>
        </form>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 text-sm border border-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-6 py-3 text-left">Lab</th> {{-- Kolom Baru --}}
                    <th class="px-6 py-3 text-left">Praktikum</th>
                    <th class="px-6 py-3 text-left">Shift</th>
                    <th class="px-6 py-3 text-left">Kelas</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-left">Jam</th>
                    <th class="px-6 py-3 text-center">Kuota</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($slots as $slot)
                    <tr class="border-t border-slate-100 hover:bg-slate-50/60 transition">
                        <td class="px-6 py-3 font-medium text-teal-600">{{ $slot->lab }}</td> {{-- Isi Kolom Lab --}}
                        <td class="px-6 py-3">{{ $slot->praktikum }}</td>
                        <td class="px-6 py-3">{{ $slot->name }}</td>
                        <td class="px-6 py-3">{{ $slot->class_code }}</td>
                        <td class="px-6 py-3">
                            {{ \Carbon\Carbon::parse($slot->date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-3">
                            {{ $slot->start_time }} – {{ $slot->end_time }}
                        </td>
                        <td class="px-6 py-3 text-center">
                            {{ $slot->capacity }}
                        </td>
                        <td class="px-6 py-3 text-center">
                            <div class="inline-flex gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('laboran.jadwal.edit', $slot) }}"
                                   class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 text-xs font-medium
                                          hover:bg-blue-100 transition">
                                    Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('laboran.jadwal.destroy', $slot) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus jadwal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-xs font-medium
                                                   hover:bg-red-100 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-slate-400 text-sm"> {{-- Colspan diubah ke 8 --}}
                            Belum ada jadwal.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
  </main>

  <footer class="mt-4 bg-teal-600 border-t border-teal-700 shadow-inner">
    <div class="max-w-6xl mx-auto px-4 py-4 text-center">
      <p class="text-white text-[11px] md:text-sm tracking-wide">
        Created By <span class="font-semibold">Tim The Third-Party Gang</span>
      </p>
    </div>
  </footer>

</body>
</html>