<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Penugasan - SIAP</title>
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
                        <span class="text-white text-lg">📝</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Kelola Penugasan</h1>
                        <p class="text-xs text-slate-500">Buat dan kelola penugasan untuk Asisten Praktikum</p>
                    </div>
                </div>
                <a href="{{ route('laboran.dashboard') }}" class="text-sm text-slate-600 hover:text-teal-600 transition">
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

        <!-- Action Button -->
        <div class="mb-6">
            <a href="{{ route('laboran.assignments.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-teal-600 hover:to-teal-700 transition-all">
                <span class="text-xl">➕</span>
                Buat Penugasan Baru
            </a>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <!-- Total -->
            <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(15,23,42,0.08)] border border-slate-100 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <span class="text-xl">📊</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-slate-900">{{ $stats['total'] }}</p>
                <p class="text-xs text-slate-500 mt-1">Total Penugasan</p>
            </div>

            <!-- Active -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl shadow-[0_8px_30px_rgba(16,185,129,0.15)] border border-green-200 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-xl">✅</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-green-900">{{ $stats['active'] }}</p>
                <p class="text-xs text-green-700 mt-1">Aktif</p>
            </div>

            <!-- Closed -->
            <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(15,23,42,0.08)] border border-slate-100 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center">
                        <span class="text-xl">🔒</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-slate-900">{{ $stats['closed'] }}</p>
                <p class="text-xs text-slate-500 mt-1">Ditutup</p>
            </div>

            <!-- Pending Submissions -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl shadow-[0_8px_30px_rgba(251,146,60,0.15)] border border-yellow-200 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-xl">⏳</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-orange-900">{{ $stats['pending_submissions'] }}</p>
                <p class="text-xs text-orange-700 mt-1">Submission Pending</p>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
            <form method="GET" action="{{ route('laboran.assignments.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-2">Status</label>
                    <select name="status" class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-2">Tipe</label>
                    <select name="tipe" class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <option value="">Semua Tipe</option>
                        <option value="LPJ" {{ request('tipe') == 'LPJ' ? 'selected' : '' }}>LPJ</option>
                        <option value="RAB" {{ request('tipe') == 'RAB' ? 'selected' : '' }}>RAB</option>
                        <option value="Laporan" {{ request('tipe') == 'Laporan' ? 'selected' : '' }}>Laporan</option>
                        <option value="Proposal" {{ request('tipe') == 'Proposal' ? 'selected' : '' }}>Proposal</option>
                        <option value="Lainnya" {{ request('tipe') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-2">Praktikum</label>
                    <input type="text" name="praktikum" value="{{ request('praktikum') }}" placeholder="Cari praktikum..." 
                           class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-teal-500 hover:bg-teal-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition">
                        🔍 Filter
                    </button>
                    <a href="{{ route('laboran.assignments.index') }}" class="px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Assignments Table -->
        @if($assignments->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Penugasan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Praktikum</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Deadline</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Submissions</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($assignments as $assignment)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-900">{{ $assignment->judul }}</div>
                                <div class="text-xs text-slate-500 mt-1 line-clamp-1">{{ Str::limit($assignment->deskripsi, 50) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                    {{ $assignment->tipe }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-700">{{ $assignment->praktikum }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-700">{{ $assignment->deadline->format('d M Y') }}</div>
                                <div class="text-xs {{ $assignment->is_expired ? 'text-red-600' : 'text-slate-500' }}">
                                    {{ $assignment->deadline->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $assignment->status_color }}">
                                    {{ $assignment->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <span class="text-green-600 font-semibold">{{ $assignment->approved_count }}</span> /
                                    <span class="text-yellow-600">{{ $assignment->pending_count }}</span> /
                                    <span class="text-red-600">{{ $assignment->rejected_count }}</span>
                                </div>
                                <div class="text-xs text-slate-500">Approved / Pending / Rejected</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('laboran.assignments.show', $assignment) }}" 
                                       class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded-lg transition">
                                        Detail
                                    </a>
                                    <a href="{{ route('laboran.assignments.edit', $assignment) }}" 
                                       class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs rounded-lg transition">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($assignments->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $assignments->links() }}
            </div>
            @endif
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
            <div class="text-6xl mb-4">📝</div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Belum Ada Penugasan</h3>
            <p class="text-sm text-slate-500 mb-6">Mulai buat penugasan pertama Anda untuk asisten praktikum</p>
            <a href="{{ route('laboran.assignments.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-teal-500 hover:bg-teal-600 text-white font-semibold rounded-xl transition">
                <span>➕</span>
                Buat Penugasan Baru
            </a>
        </div>
        @endif

    </main>

</body>
</html>
