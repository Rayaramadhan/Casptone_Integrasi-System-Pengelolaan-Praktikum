<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Direktorat Utama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-card {
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .custom-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 20px -4px rgba(0, 0, 0, 0.1), 0 6px 8px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-gray-100 font-sans h-full flex flex-col">

    <header class="flex justify-between items-center bg-white shadow px-8 py-4 sticky top-0 z-50">
        <div class="flex items-center gap-4">
            <img src="/images/logoDanantara.png" alt="LogoDanantara" class="h-12">
            <img src="/images/logoPTPN.png" alt="Logo" class="h-12">
        </div>
        <div class="flex items-center gap-4">
            <button class="p-2 rounded-full hover:bg-gray-200 transition">☀️</button>
            
            <a href="#" class="flex items-center gap-2 border border-gray-400 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3H7.5A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H9" />
                </svg>
                <span>Logout</span>
            </a>
            <img src="https://i.pravatar.cc/150?u=PTPN_user" class="h-10 w-10 rounded-full border-2 border-green-600" alt="User Profile">
        </div>
    </header>

    <main class="flex-1 flex flex-col">
        <section class="relative w-full h-[30vh] bg-cover bg-center" style="background-image: url('/images/Holding/direktoratbisnis/headerBisnis.png');">
            <div class="absolute inset-0 bg-green-900 opacity-60"></div>
            <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center px-4">
                <h2 class="text-4xl font-extrabold drop-shadow-md">Dashboard Analitik Direktorat Bisnis</h2>
            </div>
        </section>

        <section class="flex-1 p-8">
            <div class="w-full max-w-7xl mx-auto flex justify-between items-center mb-6">
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-bold text-gray-800">Direktorat SDM & Umum</h1>
                    <img src="/images/Holding/direktoratsdm/DirektoratSDM.png" alt="Logo Direktorat" class="h-8 w-8">
                </div>
                <a href="/menu_holding" class="flex items-center gap-2 text-blue-600 hover:text-blue-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>

            <div class="w-full max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div class="custom-card flex flex-col items-center p-6">
                    <img src="/images/holding/direktoratsdm/SummrySDM.png" alt="Summary Kinerja Icon" class="h-20 w-20 mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">Summary Kinerja Direktorat SDM & Umum</h2>
                </div>

                <div class="custom-card flex flex-col items-center p-6">
                    <img src="/images/holding/direktoratsdm/sdm.png" alt="Sumber Daya Manusia" class="h-20 w-20 mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">Sumber Daya Manusia</h2>
                </div>

                <div class="custom-card flex flex-col items-center p-6">
                    <img src="/images/holding/direktoratsdm/culture.png" alt="transformasi Icon" class="h-20 w-20 mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">Culture Transformation Office</h2>
                </div>

                <div class="custom-card flex flex-col items-center p-6">
                    <img src="/images/holding/direktoratsdm/pengadaan.png" alt="digital Icon" class="h-20 w-20 mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">Pengadaan & TI</h2>
                </div>
            </div>

        </section>
    </main>
    
    <footer class="bg-gray-100 py-4 text-center text-gray-600 text-sm">
        © 2025 PTPN - Dashboard Analitik | All Rights Reserved
    </footer>
</body>
</html>