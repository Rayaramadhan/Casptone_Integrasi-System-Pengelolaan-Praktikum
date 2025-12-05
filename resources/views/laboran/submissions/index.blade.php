<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Submission - SIAP</title>
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
                        <span class="text-white text-lg">📥</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Review Submission</h1>
                        <p class="text-xs text-slate-500">Kelola dan review submission dari Asprak</p>
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
                <p class="text-xs text-slate-500 mt-1">Total Submission</p>
            </div>

            <!-- Pending -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl shadow-[0_8px_30px_rgba(251,146,60,0.15)] border border-yellow-200 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-xl">⏳</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-orange-900">{{ $stats['pending'] }}</p>
                <p class="text-xs text-orange-700 mt-1">Pending Review</p>
            </div>

            <!-- Approved -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl shadow-[0_8px_30px_rgba(16,185,129,0.15)] border border-green-200 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-xl">✅</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-green-900">{{ $stats['approved'] }}</p>
                <p class="text-xs text-green-700 mt-1">Disetujui</p>
            </div>

            <!-- Rejected -->
            <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl shadow-[0_8px_30px_rgba(239,68,68,0.15)] border border-red-200 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-xl">❌</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-red-900">{{ $stats['rejected'] }}</p>
                <p class="text-xs text-red-700 mt-1">Ditolak</p>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
            <form method="GET" action="{{ route('laboran.submissions.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-2">Status</label>
                    <select name="status" class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-2">Penugasan</label>
                    <select name="assignment" class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <option value="">Semua Penugasan</option>
                        @foreach($assignments as $assignment)
                            <option value="{{ $assignment->id }}" {{ request('assignment') == $assignment->id ? 'selected' : '' }}>
                                {{ $assignment->judul }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-teal-500 hover:bg-teal-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition">
                        🔍 Filter
                    </button>
                    <a href="{{ route('laboran.submissions.index') }}" class="px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Submissions Table -->
        @if($submissions->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase">Asprak</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase">Penugasan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase">File</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase">Submitted</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($submissions as $submission)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-900">{{ $submission->asprak->name }}</div>
                                <div class="text-xs text-slate-500">{{ $submission->asprak->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $submission->assignment->judul }}</div>
                                <div class="text-xs text-slate-500">{{ $submission->assignment->tipe }} - {{ $submission->assignment->praktikum }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ $submission->file_url }}" target="_blank" class="text-teal-600 hover:text-teal-700 text-sm flex items-center gap-1">
                                    📎 {{ basename($submission->file_path) }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-700">{{ $submission->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-slate-500">{{ $submission->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $submission->status_color }}">
                                    {{ $submission->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('laboran.submissions.show', $submission) }}" 
                                       class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded-lg transition">
                                        Detail
                                    </a>
                                    @if($submission->status == 'pending')
                                        <a href="{{ route('laboran.submissions.approveForm', $submission) }}" 
                                           class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs rounded-lg transition">
                                            ✅ Approve
                                        </a>
                                        <a href="{{ route('laboran.submissions.rejectForm', $submission) }}" 
                                           class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs rounded-lg transition">
                                            ❌ Reject
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($submissions->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $submissions->links() }}
            </div>
            @endif
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
            <div class="text-6xl mb-4">📭</div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Belum Ada Submission</h3>
            <p class="text-sm text-slate-500">Submission dari asprak akan muncul di sini</p>
        </div>
        @endif

    </main>

</body>
</html>
