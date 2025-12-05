<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Kebutuhan Praktikum - SIAP</title>
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
                        <h1 class="text-xl font-bold text-slate-900">Review Kebutuhan Praktikum</h1>
                        <p class="text-xs text-slate-500">Kelola permintaan kebutuhan dari Asisten Praktikum</p>
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

        <!-- Error Message -->
        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4 flex items-start gap-3">
            <span class="text-2xl">❌</span>
            <div class="flex-1">
                <h3 class="font-semibold text-red-900">Gagal!</h3>
                <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
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
                <p class="text-2xl font-bold text-slate-900">{{ $statistics['total'] }}</p>
                <p class="text-xs text-slate-500 mt-1">Total Permintaan</p>
            </div>

            <!-- Pending -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl shadow-[0_8px_30px_rgba(251,146,60,0.15)] border border-yellow-200 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-xl">⏳</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-orange-900">{{ $statistics['pending'] }}</p>
                <p class="text-xs text-orange-700 mt-1">Menunggu Review</p>
            </div>

            <!-- Approved -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl shadow-[0_8px_30px_rgba(16,185,129,0.15)] border border-green-200 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-xl">✅</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-green-900">{{ $statistics['approved'] }}</p>
                <p class="text-xs text-green-700 mt-1">Disetujui</p>
            </div>

            <!-- Rejected -->
            <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl shadow-[0_8px_30px_rgba(239,68,68,0.15)] border border-red-200 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-xl">❌</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-red-900">{{ $statistics['rejected'] }}</p>
                <p class="text-xs text-red-700 mt-1">Ditolak</p>
            </div>

            <!-- Overdue -->
            <div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-2xl shadow-[0_8px_30px_rgba(139,92,246,0.15)] border border-purple-200 p-5 hover:shadow-xl transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-xl">⚠️</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-purple-900">{{ $statistics['overdue'] }}</p>
                <p class="text-xs text-purple-700 mt-1">Terlambat</p>
            </div>
        </div>

        <!-- Filter & Table Card -->
        <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 p-8">
            
            <!-- Filter Form -->
            <form method="GET" action="{{ route('laboran.resource-requests.index') }}" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="filter_status" class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                        <select name="status" id="filter_status" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                        </select>
                    </div>
                    <div>
                        <label for="filter_resource_type" class="block text-sm font-semibold text-slate-700 mb-2">Tipe Resource</label>
                        <select name="resource_type" id="filter_resource_type" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <option value="">Semua Tipe</option>
                            <option value="room" {{ request('resource_type') == 'room' ? 'selected' : '' }}>🏢 Ruangan</option>
                            <option value="tool_account" {{ request('resource_type') == 'tool_account' ? 'selected' : '' }}>🔑 Akun Tools</option>
                            <option value="hardware" {{ request('resource_type') == 'hardware' ? 'selected' : '' }}>💻 Hardware</option>
                            <option value="software" {{ request('resource_type') == 'software' ? 'selected' : '' }}>💿 Software</option>
                            <option value="other" {{ request('resource_type') == 'other' ? 'selected' : '' }}>📦 Lainnya</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full px-6 py-2.5 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition font-medium">
                            🔍 Filter
                        </button>
                    </div>
                </div>
            </form>

            <!-- Data Table -->
            @if($requests->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="text-left py-4 px-4 text-xs font-bold text-slate-600 uppercase tracking-wider">Permintaan</th>
                            <th class="text-left py-4 px-4 text-xs font-bold text-slate-600 uppercase tracking-wider">Pengaju</th>
                            <th class="text-left py-4 px-4 text-xs font-bold text-slate-600 uppercase tracking-wider">Lab & Praktikum</th>
                            <th class="text-left py-4 px-4 text-xs font-bold text-slate-600 uppercase tracking-wider">Tanggal</th>
                            <th class="text-left py-4 px-4 text-xs font-bold text-slate-600 uppercase tracking-wider">Status</th>
                            <th class="text-left py-4 px-4 text-xs font-bold text-slate-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($requests as $request)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <!-- Request Title & Type -->
                            <td class="py-4 px-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <span>{{ $request->resource_type_icon }}</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900 text-sm">{{ Str::limit($request->title, 40) }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $request->resource_type_label }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Submitter -->
                            <td class="py-4 px-4">
                                <p class="text-sm text-slate-900 font-medium">{{ $request->user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $request->created_at->diffForHumans() }}</p>
                            </td>

                            <!-- Lab & Praktikum Details -->
                            <td class="py-4 px-4">
                                <p class="text-sm text-slate-900 font-medium">{{ $request->laboratorium }}</p>
                                <p class="text-xs text-slate-500">{{ $request->nama_praktikum }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">Qty: {{ $request->quantity }}</p>
                            </td>

                            <!-- Needed Date -->
                            <td class="py-4 px-4">
                                <p class="text-sm text-slate-900">{{ $request->formatted_needed_date }}</p>
                                @if($request->needed_time)
                                <p class="text-xs text-slate-500">{{ $request->formatted_needed_time }}</p>
                                @endif
                                @if($request->isOverdue())
                                <p class="text-xs text-red-600 font-semibold mt-1">⚠️ Terlambat</p>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4">
                                <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full {{ $request->status_color }}">
                                    {{ $request->status_label }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('laboran.resource-requests.show', $request) }}" class="px-3 py-1.5 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition text-xs font-medium">
                                        Detail
                                    </a>
                                    @if($request->status === 'pending')
                                    <a href="{{ route('laboran.resource-requests.approveForm', $request) }}" class="px-3 py-1.5 bg-green-500 text-white rounded-lg hover:bg-green-600 transition text-xs font-medium">
                                        ✓
                                    </a>
                                    <a href="{{ route('laboran.resource-requests.rejectForm', $request) }}" class="px-3 py-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-xs font-medium">
                                        ✗
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
            <div class="mt-6 pt-6 border-t border-slate-100">
                {{ $requests->links() }}
            </div>

            @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">📭</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Belum Ada Permintaan</h3>
                <p class="text-sm text-slate-500">
                    @if(request('status') || request('resource_type'))
                    Tidak ada permintaan yang sesuai dengan filter.
                    @else
                    Belum ada permintaan resource dari Asisten Praktikum.
                    @endif
                </p>
            </div>
            @endif

        </div>

    </main>

</body>
</html>
