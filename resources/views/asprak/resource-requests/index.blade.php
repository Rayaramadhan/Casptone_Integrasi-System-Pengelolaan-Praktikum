<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebutuhan Praktikum - SIAP</title>
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
                    <a href="{{ route('asprak.dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-teal-500 rounded-xl flex items-center justify-center group-hover:bg-teal-600 transition">
                            <span class="text-white text-lg">🏢</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-slate-900">Kebutuhan Praktikum</h1>
                            <p class="text-xs text-slate-500">Manajemen Kebutuhan Praktikum</p>
                        </div>
                    </a>
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

        <!-- Error Message -->
        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4 flex items-start gap-3">
            <span class="text-2xl">❌</span>
            <div class="flex-1">
                <h3 class="font-semibold text-red-900">Error!</h3>
                <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <!-- Total -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Total Permintaan</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $stats['total'] }}</p>
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
                        <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
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
                        <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</p>
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
                        <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                        <span class="text-xl">❌</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions & Filters -->
        <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Filter Form -->
                <form method="GET" class="flex flex-col sm:flex-row gap-3 flex-1">
                    <select name="status" class="px-4 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>

                    <select name="resource_type" class="px-4 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">Semua Tipe</option>
                        <option value="room" {{ request('resource_type') == 'room' ? 'selected' : '' }}>🏢 Ruangan</option>
                        <option value="tool_account" {{ request('resource_type') == 'tool_account' ? 'selected' : '' }}>🔑 Akun Tools</option>
                        <option value="hardware" {{ request('resource_type') == 'hardware' ? 'selected' : '' }}>💻 Perangkat Keras</option>
                        <option value="software" {{ request('resource_type') == 'software' ? 'selected' : '' }}>💿 Software</option>
                        <option value="other" {{ request('resource_type') == 'other' ? 'selected' : '' }}>📦 Lainnya</option>
                    </select>

                    <button type="submit" class="px-6 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition text-sm font-medium">
                        Filter
                    </button>

                    @if(request()->hasAny(['status', 'resource_type']))
                    <a href="{{ route('asprak.resource-requests.index') }}" class="px-6 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition text-sm font-medium text-center">
                        Reset
                    </a>
                    @endif
                </form>

                <!-- Submit Button -->
                <a href="{{ route('asprak.resource-requests.create') }}" class="px-6 py-2.5 bg-gradient-to-r from-teal-500 to-emerald-500 text-white rounded-lg hover:from-teal-600 hover:to-emerald-600 transition text-sm font-semibold shadow-lg shadow-teal-500/30 flex items-center gap-2 justify-center whitespace-nowrap">
                    <span class="text-lg">➕</span>
                    Ajukan Kebutuhan
                </a>
            </div>
        </div>

        <!-- Resource Requests Table -->
        <div class="bg-white rounded-3xl shadow-[0_14px_40px_rgba(15,23,42,0.08)] border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-teal-50 to-emerald-50 border-b border-teal-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Judul & Tipe</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Lab & Praktikum</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Tanggal Dibutuhkan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($requests as $request)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    <span class="text-2xl mt-1">{{ $request->resource_type_icon }}</span>
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $request->title }}</p>
                                        <p class="text-xs text-slate-500 mt-1">{{ $request->resource_type_label }} (Qty: {{ $request->quantity }})</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-700 font-medium">{{ $request->laboratorium }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ $request->nama_praktikum }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-700">{{ $request->formatted_needed_date }}</p>
                                @if($request->needed_time)
                                <p class="text-xs text-slate-500 mt-1">{{ $request->formatted_needed_time }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full {{ $request->status_color }}">
                                    {{ $request->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('asprak.resource-requests.show', $request) }}" class="text-teal-600 hover:text-teal-700 text-sm font-medium">
                                        Detail
                                    </a>
                                    @if($request->status === 'pending')
                                    <form action="{{ route('asprak.resource-requests.destroy', $request) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus permintaan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="text-6xl">📭</span>
                                    <p class="text-slate-500 text-sm">Belum ada kebutuhan praktikum</p>
                                    <a href="{{ route('asprak.resource-requests.create') }}" class="mt-2 px-6 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition text-sm font-medium">
                                        Ajukan Kebutuhan Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($requests->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $requests->links() }}
            </div>
            @endif
        </div>

    </main>

</body>
</html>
