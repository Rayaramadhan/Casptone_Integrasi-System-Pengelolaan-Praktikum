<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backlog - SIAP</title>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-teal-500 rounded-xl flex items-center justify-center">
                        <span class="text-white text-lg">📋</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Backlog</h1>
                        <p class="text-xs text-slate-500">Kelola dan rencanakan tugas Anda</p>
                    </div>
                </div>
                <a href="{{ route('asprak.dashboard') }}" class="text-sm text-slate-600 hover:text-teal-600 transition">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-2xl p-4 flex items-start gap-3">
            <span class="text-2xl">✅</span>
            <div class="flex-1">
                <h3 class="font-semibold text-green-900">Berhasil!</h3>
                <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
            <!-- Total -->
            <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(15,23,42,0.08)] border border-slate-100 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center">
                        <span class="text-xl">📊</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-slate-900">{{ $stats['total'] }}</p>
                <p class="text-xs text-slate-500 mt-1">Total Backlog</p>
            </div>

            <!-- Belum Dikerjakan -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl shadow-[0_8px_30px_rgba(251,146,60,0.15)] border border-yellow-200 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-xl">⏳</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-orange-900">{{ $stats['belum_dikerjakan'] }}</p>
                <p class="text-xs text-orange-700 mt-1">Belum Dikerjakan</p>
            </div>

            <!-- On Progress -->
            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl shadow-[0_8px_30px_rgba(59,130,246,0.15)] border border-blue-200 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-xl">🔄</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-blue-900">{{ $stats['on_progress'] }}</p>
                <p class="text-xs text-blue-700 mt-1">On Progress</p>
            </div>

            <!-- Done -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl shadow-[0_8px_30px_rgba(34,197,94,0.15)] border border-green-200 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-xl">✅</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-green-900">{{ $stats['done'] }}</p>
                <p class="text-xs text-green-700 mt-1">Done</p>
            </div>

            <!-- Overdue -->
            <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl shadow-[0_8px_30px_rgba(239,68,68,0.15)] border border-red-200 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-xl">⚠️</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-red-900">{{ $stats['overdue'] }}</p>
                <p class="text-xs text-red-700 mt-1">Overdue</p>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Filters -->
                <form method="GET" action="{{ route('asprak.backlogs.index') }}" class="flex flex-wrap gap-3 flex-1">
                    <!-- Status Filter -->
                    <select name="status" class="px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">Semua Status</option>
                        <option value="belum_dikerjakan" {{ request('status') == 'belum_dikerjakan' ? 'selected' : '' }}>Belum Dikerjakan</option>
                        <option value="on_progress" {{ request('status') == 'on_progress' ? 'selected' : '' }}>On Progress</option>
                        <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
                    </select>

                    <!-- Assign To Filter -->
                    <input type="text" name="assign_to" value="{{ request('assign_to') }}" 
                           placeholder="Filter by Assign To..." 
                           class="px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">

                    <!-- Sort By -->
                    <select name="sort_by" class="px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="deadline" {{ request('sort_by') == 'deadline' ? 'selected' : '' }}>Sort by Deadline</option>
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Sort by Created</option>
                        <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Sort by Status</option>
                    </select>

                    <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded-xl text-sm font-medium hover:bg-teal-600 transition">
                        Filter
                    </button>

                    @if(request()->hasAny(['status', 'assign_to', 'sort_by']))
                    <a href="{{ route('asprak.backlogs.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-xl text-sm font-medium hover:bg-slate-300 transition">
                        Reset
                    </a>
                    @endif
                </form>

                <!-- Add Button -->
                <a href="{{ route('asprak.backlogs.create') }}" 
                   class="px-6 py-2 bg-gradient-to-r from-teal-500 to-cyan-500 text-white rounded-xl font-medium hover:from-teal-600 hover:to-cyan-600 transition shadow-lg hover:shadow-xl flex items-center gap-2 whitespace-nowrap">
                    <span class="text-lg">➕</span>
                    Tambah Backlog
                </a>
            </div>
        </div>

        <!-- Backlog List -->
        @if($backlogs->count() > 0)
        <div class="grid grid-cols-1 gap-4">
            @foreach($backlogs as $backlog)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-lg transition-all">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <!-- Title & Status -->
                        <div class="flex items-start gap-3 mb-3">
                            <h3 class="text-lg font-bold text-slate-900 flex-1">{{ $backlog->title }}</h3>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($backlog->status == 'belum_dikerjakan') bg-yellow-100 text-yellow-800
                                @elseif($backlog->status == 'on_progress') bg-blue-100 text-blue-800
                                @else bg-green-100 text-green-800
                                @endif">
                                {{ $backlog->status_label }}
                            </span>
                        </div>

                        <!-- Description -->
                        <p class="text-sm text-slate-600 mb-3 line-clamp-2">{{ $backlog->description }}</p>

                        <!-- Meta Info -->
                        <div class="flex flex-wrap gap-4 text-xs text-slate-500">
                            <div class="flex items-center gap-1">
                                <span>📅</span>
                                <span>Deadline: {{ $backlog->deadline->format('d M Y') }}</span>
                                @if($backlog->is_overdue)
                                <span class="text-red-600 font-semibold">(Overdue!)</span>
                                @endif
                            </div>

                            @if($backlog->assign_to)
                            <div class="flex items-center gap-1">
                                <span>👤</span>
                                <span>Assign to: {{ $backlog->assign_to }}</span>
                            </div>
                            @endif

                            @if($backlog->progress_file)
                            <div class="flex items-center gap-1">
                                <span>📎</span>
                                <span>File terlampir</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <a href="{{ route('asprak.backlogs.show', $backlog) }}" 
                           class="px-3 py-2 bg-teal-50 text-teal-700 rounded-lg text-sm font-medium hover:bg-teal-100 transition">
                            Detail
                        </a>
                        <a href="{{ route('asprak.backlogs.edit', $backlog) }}" 
                           class="px-3 py-2 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $backlogs->links() }}
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-4xl">📋</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Belum Ada Backlog</h3>
            <p class="text-sm text-slate-500 mb-6">Mulai tambahkan backlog untuk merencanakan tugas Anda</p>
            <a href="{{ route('asprak.backlogs.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-500 text-white rounded-xl font-medium hover:from-teal-600 hover:to-cyan-600 transition shadow-lg">
                <span class="text-lg">➕</span>
                Tambah Backlog Pertama
            </a>
        </div>
        @endif
    </main>
</body>
</html>
