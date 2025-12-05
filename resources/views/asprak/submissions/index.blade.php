<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penugasan - SIAP</title>
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
                        <span class="text-white text-lg">📚</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Penugasan</h1>
                        <p class="text-xs text-slate-500">Lihat penugasan & submission Anda</p>
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

        <!-- Tabs -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-2 inline-flex gap-2">
                <a href="{{ route('asprak.submissions.index', ['tab' => 'available']) }}" 
                   class="px-6 py-2.5 rounded-xl font-semibold text-sm transition {{ request('tab', 'available') == 'available' ? 'bg-gradient-to-r from-teal-500 to-teal-600 text-white shadow-md' : 'text-slate-600 hover:text-teal-600' }}">
                    📝 Penugasan Tersedia
                </a>
                <a href="{{ route('asprak.submissions.index', ['tab' => 'submissions']) }}" 
                   class="px-6 py-2.5 rounded-xl font-semibold text-sm transition {{ request('tab') == 'submissions' ? 'bg-gradient-to-r from-teal-500 to-teal-600 text-white shadow-md' : 'text-slate-600 hover:text-teal-600' }}">
                    📥 Submission Saya
                </a>
            </div>
        </div>

        @if(request('tab', 'available') == 'available')
            <!-- Available Assignments Tab -->
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <!-- Total Penugasan = Semua assignment aktif -->
                <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(15,23,42,0.08)] border border-slate-100 p-5 hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <span class="text-xl">📊</span>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-slate-900">{{ $stats['total'] ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-1">Total Penugasan</p>
                </div>

                <!-- Aktif = Assignment aktif yang belum disubmit -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl shadow-[0_8px_30px_rgba(16,185,129,0.15)] border border-green-200 p-5 hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                            <span class="text-xl">✅</span>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-green-900">{{ $stats['active'] ?? 0 }}</p>
                    <p class="text-xs text-green-700 mt-1">Belum Dikumpulkan</p>
                </div>

                <!-- Sudah Dikumpulkan = Total submission dari asprak -->
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl shadow-[0_8px_30px_rgba(59,130,246,0.15)] border border-blue-200 p-5 hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                            <span class="text-xl">📤</span>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-blue-900">{{ $stats['submitted'] ?? 0 }}</p>
                    <p class="text-xs text-blue-700 mt-1">Sudah Dikumpulkan</p>
                </div>

                <!-- Pending Review = Submission yang masih pending -->
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl shadow-[0_8px_30px_rgba(251,146,60,0.15)] border border-yellow-200 p-5 hover:shadow-xl transition-all">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                            <span class="text-xl">⏰</span>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-orange-900">{{ $stats['pending'] ?? 0 }}</p>
                    <p class="text-xs text-orange-700 mt-1">Pending Review</p>
                </div>
            </div>

            <!-- Filter -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
                <form method="GET" action="{{ route('asprak.submissions.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="hidden" name="tab" value="available">
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
                        <input type="text" name="praktikum" value="{{ request('praktikum') }}" 
                               placeholder="Cari praktikum..."
                               class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-teal-500 hover:bg-teal-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition">
                            🔍 Filter
                        </button>
                        <a href="{{ route('asprak.submissions.index', ['tab' => 'available']) }}" class="px-4 py-2.5 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Assignments Grid -->
            @if(is_object($assignments) && $assignments->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                @foreach($assignments as $assignment)
                @if(is_object($assignment))
                <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgba(15,23,42,0.08)] border border-slate-100 hover:shadow-xl transition-all overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-teal-50 to-blue-50 p-5 border-b border-slate-100">
                        <div class="flex items-start justify-between mb-3">
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                {{ $assignment->tipe }}
                            </span>
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $assignment->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ ucfirst($assignment->status) }}
                            </span>
                        </div>
                        <h3 class="font-bold text-slate-900 text-lg mb-2">{{ $assignment->judul }}</h3>
                        <p class="text-xs text-slate-600">📚 {{ $assignment->praktikum }}</p>
                    </div>

                    <!-- Body -->
                    <div class="p-5">
                        <p class="text-sm text-slate-600 mb-4 line-clamp-3">{{ $assignment->deskripsi }}</p>
                        
                        <!-- Deadline -->
                        <div class="flex items-center gap-2 text-sm mb-4 pb-4 border-b border-slate-100">
                            <span class="text-lg">📅</span>
                            <div>
                                <p class="text-xs text-slate-500">Deadline</p>
                                <p class="font-semibold {{ $assignment->deadline->isPast() ? 'text-red-600' : 'text-slate-900' }}">
                                    {{ $assignment->deadline->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>

                        <!-- Status & Action -->
                        @php
                            $submission = $assignment->submissions->where('asprak_id', auth()->id())->first();
                        @endphp
                        
                        @if($submission)
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 mb-3">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-lg">{{ $submission->status == 'approved' ? '✅' : ($submission->status == 'rejected' ? '❌' : '⏳') }}</span>
                                    <span class="text-xs font-semibold {{ $submission->status == 'approved' ? 'text-green-700' : ($submission->status == 'rejected' ? 'text-red-700' : 'text-yellow-700') }}">
                                        {{ $submission->status == 'approved' ? 'APPROVED' : ($submission->status == 'rejected' ? 'REJECTED' : 'PENDING') }}
                                    </span>
                                </div>
                                @if($submission->feedback)
                                    <p class="text-xs text-slate-600 mb-2">{{ Str::limit($submission->feedback, 50) }}</p>
                                @endif
                                <a href="{{ route('asprak.submissions.show', $submission) }}" 
                                   class="block text-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition">
                                    Lihat Detail
                                </a>
                            </div>
                        @else
                            <a href="{{ route('asprak.submissions.create', $assignment) }}" 
                               class="block text-center px-4 py-2 bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition">
                                📤 Submit Sekarang
                            </a>
                        @endif
                    </div>
                </div>
                @endif
                @endforeach
            </div>

            <!-- Pagination -->
            @if(is_object($assignments) && method_exists($assignments, 'hasPages') && $assignments->hasPages())
            <div class="flex justify-center">
                {{ $assignments->links() }}
            </div>
            @endif
            @else
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
                <div class="text-6xl mb-4">📭</div>
                <h3 class="text-lg font-semibold text-slate-900 mb-2">Belum Ada Penugasan</h3>
                <p class="text-sm text-slate-500">Penugasan dari laboran akan muncul di sini</p>
            </div>
            @endif

        @else
            <!-- My Submissions Tab -->
            
            <!-- My Submissions Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase">Penugasan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase">File</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase">Submitted</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase">Feedback</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($mySubmissions as $submission)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ optional($submission->assignment)->judul ?? 'N/A' }}</div>
                                    <div class="text-xs text-slate-500">{{ optional($submission->assignment)->tipe ?? '' }} - {{ optional($submission->assignment)->praktikum ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if(isset($submission->file_url) && $submission->file_url)
                                    <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="text-teal-600 hover:text-teal-700 text-sm flex items-center gap-1">
                                        📎 {{ Str::limit(basename($submission->file_path ?? 'file'), 20) }}
                                    </a>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-700">{{ optional($submission->created_at)->format('d M Y') ?? 'N/A' }}</div>
                                    <div class="text-xs text-slate-500">{{ optional($submission->created_at)->diffForHumans() ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'approved' => 'bg-green-100 text-green-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Pending Review',
                                            'approved' => 'Disetujui',
                                            'rejected' => 'Ditolak',
                                        ];
                                        $status = $submission->status ?? 'pending';
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $statusLabels[$status] ?? ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if(isset($submission->feedback) && $submission->feedback)
                                        <p class="text-sm text-slate-700">{{ Str::limit($submission->feedback, 40) }}</p>
                                    @else
                                        <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('asprak.submissions.show', $submission->id) }}" 
                                           class="px-3 py-1.5 bg-teal-500 hover:bg-teal-600 text-white text-xs rounded-lg transition">
                                            Detail
                                        </a>
                                        @if($submission->status === 'pending')
                                        <a href="{{ route('asprak.submissions.edit', $submission->id) }}" 
                                           class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs rounded-lg transition"
                                           title="Edit Submission">
                                            ✏️
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-4xl mb-2">📭</div>
                                    <p class="text-sm text-slate-500">Belum ada submission</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($mySubmissions->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $mySubmissions->links() }}
                </div>
                @endif
            </div>
        @endif

    </main>

</body>
</html>
