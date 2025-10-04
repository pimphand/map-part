<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard Peta Desa Jeringo</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Leaflet CSS & JS for Interactive Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha26-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Leaflet.draw Plugin -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- jsPDF for PDF Generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>


    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .leaflet-popup-content {
            margin: 12px 20px;
            font-size: 14px;
            line-height: 1.6;
        }

        .leaflet-popup-tip {
            box-shadow: none;
        }

        .popup-title {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 5px;
            color: #1e3a8a;
        }

        .popup-category {
            font-size: 12px;
            font-weight: 500;
            padding: 2px 6px;
            border-radius: 4px;
            color: white;
        }

        .icon-label {
            margin-left: 8px;
            font-weight: 500;
        }

        /* Modal Styles */
        .modal-overlay {
            transition: opacity 0.3s ease;
        }

        .modal-container {
            transition: transform 0.3s ease;
        }

        /* Custom scrollbar for analysis result */
        #analysis-result::-webkit-scrollbar,
        #cctv-grid::-webkit-scrollbar,
        #disaster-mitigation-panel .overflow-y-auto::-webkit-scrollbar,
        #food-price-panel .overflow-y-auto::-webkit-scrollbar {
            width: 5px;
        }

        #analysis-result::-webkit-scrollbar-track,
        #cctv-grid::-webkit-scrollbar-track,
        #disaster-mitigation-panel .overflow-y-auto::-webkit-scrollbar-track,
        #food-price-panel .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #analysis-result::-webkit-scrollbar-thumb,
        #cctv-grid::-webkit-scrollbar-thumb,
        #disaster-mitigation-panel .overflow-y-auto::-webkit-scrollbar-thumb,
        #food-price-panel .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        #analysis-result::-webkit-scrollbar-thumb:hover,
        #cctv-grid::-webkit-scrollbar-thumb:hover,
        #disaster-mitigation-panel .overflow-y-auto::-webkit-scrollbar-thumb:hover,
        #food-price-panel .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .rab-table {
            width: 100%;
            margin-top: 8px;
            font-size: 11px;
            border-collapse: collapse;
        }

        .rab-table th,
        .rab-table td {
            border: 1px solid #e5e7eb;
            padding: 4px 6px;
            text-align: left;
        }

        .rab-table th {
            background-color: #f3f4f6;
            font-weight: 600;
        }

        .rab-table .text-right {
            text-align: right;
        }

        .rab-table tfoot td {
            font-weight: 700;
            background-color: #e5e7eb;
        }

        .leaflet-draw-toolbar a {
            background-image: none !important;
            -webkit-background-size: initial !important;
            background-size: initial !important;
        }

        .leaflet-draw-actions a {
            font-size: 14px;
            line-height: 26px;
        }

        .weather-forecast-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 0.75rem;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.1);
                opacity: 0.0;
            }

            50% {
                opacity: 0.8;
            }

            100% {
                transform: scale(2);
                opacity: 0.0;
            }
        }

        .earthquake-pulse-container {
            width: 30px;
            height: 30px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .earthquake-pulse {
            background-color: rgba(255, 0, 0, 0.5);
            width: 15px;
            height: 15px;
            border-radius: 50%;
            border: 2px solid red;
            position: absolute;
        }

        .earthquake-pulse::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 30px;
            height: 30px;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            border: 2px solid red;
            animation: pulse 2s infinite;
        }
    </style>
</head>

<body class="flex flex-col h-screen">

    <!-- Login Page -->
    <div id="login-page" class="bg-gray-100 flex items-center justify-center h-screen w-screen fixed top-0 left-0 z-50">
        <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-sm">
            <div class="text-center mb-6">
                <img src="https://placehold.co/80x80/3B82F6/FFFFFF?text=L B" alt="Logo"
                    class="mx-auto mb-3 rounded-full">
                <h1 class="text-2xl font-bold text-gray-800">Sistem Informasi Desa</h1>
                <p class="text-gray-500">Desa Jeringo</p>
            </div>
            <form id="login-form">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Nama Pengguna</label>
                    <input type="text" id="username" value="Admin"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan nama pengguna" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" id="password" value="jeringo2024"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan kata sandi" required>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 shadow-md">
                    Masuk
                </button>
                <p id="login-error" class="text-red-500 text-sm mt-4 text-center hidden">Nama pengguna atau kata sandi
                    salah.</p>
            </form>
        </div>
    </div>

    <div id="app-container" class="hidden h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-md w-full p-4 z-30">
            <div class="container mx-auto flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <img src="https://placehold.co/40x40/3B82F6/FFFFFF?text=L B" alt="Logo Lombok Barat"
                        class="rounded-full">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-800">Dashboard Informasi Desa Jeringo</h1>
                        <p class="text-sm text-gray-500">Kecamatan Gunungsari, Kabupaten Lombok Barat</p>
                    </div>
                </div>
                <button id="logout-button"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 flex items-center shadow-md">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i>
                    Keluar
                </button>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 relative">

            <!-- Map Section -->
            <div class="absolute inset-0 z-0 w-full h-full" id="map"></div>

            <!-- Left Side Buttons -->
            <div class="absolute top-4 left-4 z-20 flex flex-col space-y-2">
                <button id="toggle-analysis-panel-button" title="Buka Analisa & Rekomendasi"
                    class="bg-white text-gray-700 font-bold p-3 rounded-full shadow-lg hover:bg-gray-100 transition duration-300 flex items-center justify-center h-12 w-12">
                    <i class="fa-solid fa-brain fa-lg"></i>
                </button>
                <button id="toggle-draw-panel-button" title="Buka Alat Gambar"
                    class="bg-white text-gray-700 font-bold p-3 rounded-full shadow-lg hover:bg-gray-100 transition duration-300 flex items-center justify-center h-12 w-12">
                    <i class="fa-solid fa-pen-ruler fa-lg"></i>
                </button>
                <button id="toggle-cctv-panel-button" title="Pantau CCTV"
                    class="bg-white text-gray-700 font-bold p-3 rounded-full shadow-lg hover:bg-gray-100 transition duration-300 flex items-center justify-center h-12 w-12">
                    <i class="fa-solid fa-video fa-lg"></i>
                </button>
                <button id="toggle-livestream-panel-button" title="Siaran Langsung"
                    class="bg-white text-gray-700 font-bold p-3 rounded-full shadow-lg hover:bg-gray-100 transition duration-300 flex items-center justify-center h-12 w-12">
                    <i class="fa-solid fa-broadcast-tower fa-lg"></i>
                </button>
                <button id="toggle-disaster-panel-button" title="Mitigasi Bencana"
                    class="relative bg-white text-gray-700 font-bold p-3 rounded-full shadow-lg hover:bg-gray-100 transition duration-300 flex items-center justify-center h-12 w-12">
                    <i class="fa-solid fa-house-flood-water fa-lg"></i>
                </button>
                <button id="toggle-food-price-panel-button" title="Harga Pangan"
                    class="bg-white text-gray-700 font-bold p-3 rounded-full shadow-lg hover:bg-gray-100 transition duration-300 flex items-center justify-center h-12 w-12">
                    <i class="fa-solid fa-cart-shopping fa-lg"></i>
                </button>
                <button id="toggle-ai-lab-panel-button" title="LAB AI Anti-Hoax"
                    class="bg-white text-gray-700 font-bold p-3 rounded-full shadow-lg hover:bg-gray-100 transition duration-300 flex items-center justify-center h-12 w-12">
                    <i class="fa-solid fa-flask-vial fa-lg"></i>
                </button>
            </div>

            <!-- Analisa & Rekomendasi Card (Overlay) -->
            <div id="analysis-panel"
                class="absolute top-4 left-20 z-20 bg-white/80 backdrop-blur-sm p-5 rounded-xl shadow-2xl w-full max-w-sm md:max-w-md hidden">
                <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-3">
                    <h2 class="text-lg font-bold text-gray-700">Analisa & Rekomendasi</h2>
                    <button id="close-analysis-panel-button"
                        class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                </div>
                <div class="flex gap-2">
                    <button id="analyze-button"
                        class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-brain mr-2"></i>
                        Jalankan Analisa AI
                    </button>
                    <button id="download-button"
                        class="w-auto bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300 flex items-center justify-center shadow-md hidden">
                        <i class="fa-solid fa-download"></i>
                    </button>
                </div>
                <div id="analysis-result" class="mt-4 text-sm text-gray-600 max-h-[70vh] overflow-y-auto pr-2">
                    <p class="text-center italic">Klik tombol untuk melihat hasil analisa dan rekomendasi.</p>
                </div>
            </div>

            <!-- Drawing Tools Panel -->
            <div id="draw-panel"
                class="absolute top-4 left-20 z-20 bg-white/80 backdrop-blur-sm p-5 rounded-xl shadow-2xl w-full max-w-sm hidden">
                <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-3">
                    <h2 class="text-lg font-bold text-gray-700">Alat Gambar Peta</h2>
                    <button id="close-draw-panel-button"
                        class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                </div>
                <div class="space-y-4 mb-4">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 mb-2 border-b pb-1">Batas Wilayah</h3>
                        <div class="flex space-x-2 justify-center">
                            <button id="draw-boundary-icon"
                                class="flex flex-col items-center justify-center p-2 rounded-lg hover:bg-gray-200 transition-colors w-20"
                                title="Gambar Batas Desa">
                                <i class="fa-solid fa-draw-polygon fa-2x text-indigo-600"></i>
                                <span class="text-xs mt-1 text-gray-700">Batas Desa</span>
                            </button>
                            <button id="draw-dusun-boundary-icon"
                                class="flex flex-col items-center justify-center p-2 rounded-lg hover:bg-gray-200 transition-colors w-20"
                                title="Gambar Batas Dusun">
                                <i class="fa-solid fa-vector-square fa-2x text-blue-600"></i>
                                <span class="text-xs mt-1 text-gray-700">Batas Dusun</span>
                            </button>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 mb-2 border-b pb-1">Infrastruktur Jalan</h3>
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <button id="draw-good-road-icon"
                                class="flex flex-col items-center justify-center p-2 rounded-lg hover:bg-gray-200 transition-colors"
                                title="Gambar Jalan Bagus">
                                <i class="fa-solid fa-road fa-2x text-green-600"></i>
                                <span class="text-xs mt-1 text-gray-700">Jalan Bagus</span>
                            </button>
                            <button id="draw-bad-road-icon"
                                class="flex flex-col items-center justify-center p-2 rounded-lg hover:bg-gray-200 transition-colors"
                                title="Gambar Jalan Rusak">
                                <i class="fa-solid fa-road-circle-exclamation fa-2x text-red-600"></i>
                                <span class="text-xs mt-1 text-gray-700">Jalan Rusak</span>
                            </button>
                            <button id="draw-alley-road-icon"
                                class="flex flex-col items-center justify-center p-2 rounded-lg hover:bg-gray-200 transition-colors"
                                title="Gambar Jalan Gang">
                                <i class="fa-solid fa-road-lane fa-2x text-orange-500"></i>
                                <span class="text-xs mt-1 text-gray-700">Jalan Gang</span>
                            </button>
                        </div>
                    </div>
                </div>
                <button id="clear-draw-button"
                    class="w-full bg-gray-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-300 flex items-center justify-center shadow-md text-sm">
                    <i class="fa-solid fa-trash mr-2"></i> Bersihkan Semua Gambar
                </button>
            </div>

            <!-- CCTV Panel -->
            <div id="cctv-panel"
                class="absolute top-4 left-20 z-20 bg-white/80 backdrop-blur-sm p-5 rounded-xl shadow-2xl w-full max-w-4xl hidden">
                <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-3">
                    <h2 class="text-lg font-bold text-gray-700">Pantauan CCTV</h2>
                    <button id="close-cctv-panel-button"
                        class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                </div>
                <div id="cctv-grid" class="grid grid-cols-2 gap-4 max-h-[70vh] overflow-y-auto p-1">
                    <!-- CCTV feeds will be injected here by JS -->
                </div>
            </div>

            <!-- Live Stream Panel -->
            <div id="livestream-panel"
                class="absolute top-4 left-20 z-20 bg-white/80 backdrop-blur-sm p-5 rounded-xl shadow-2xl w-full max-w-2xl hidden">
                <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-3">
                    <h2 class="text-lg font-bold text-gray-700">Siaran Langsung Desa</h2>
                    <button id="close-livestream-panel-button"
                        class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                </div>
                <div class="aspect-w-16 aspect-h-9">
                    <iframe src="https://www.youtube.com/embed/jfKfPfyJRdk?autoplay=1&mute=1" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen class="w-full h-full rounded-lg"></iframe>
                </div>
                <p class="text-sm text-gray-600 mt-2">Contoh siaran langsung dari YouTube. Ini dapat diganti dengan
                    sumber siaran langsung acara desa.</p>
            </div>

            <!-- Disaster Mitigation Panel -->
            <div id="disaster-mitigation-panel"
                class="absolute top-4 left-20 z-20 bg-white/80 backdrop-blur-sm p-5 rounded-xl shadow-2xl w-full max-w-sm md:max-w-md hidden">
                <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-3">
                    <h2 class="text-lg font-bold text-gray-700">Mitigasi Bencana (BMKG)</h2>
                    <button id="close-disaster-panel-button"
                        class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                </div>
                <div class="space-y-4 max-h-[80vh] overflow-y-auto pr-2">
                    <!-- Earthquake Info -->
                    <div id="earthquake-info-container">
                        <h3 class="font-bold text-gray-800 mb-2">Info Gempa Terkini</h3>
                        <div id="earthquake-info" class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm">
                            <p class="text-center italic">Memuat data...</p>
                        </div>
                    </div>
                    <!-- Weather Info -->
                    <div id="weather-info-container">
                        <h3 class="font-bold text-gray-800 mb-2">Prakiraan Cuaca</h3>
                        <div id="weather-info" class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm">
                            <p class="text-center italic">Memuat data...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Food Price Panel -->
            <div id="food-price-panel"
                class="absolute top-4 left-20 z-20 bg-white/80 backdrop-blur-sm p-5 rounded-xl shadow-2xl w-full max-w-sm md:max-w-md hidden">
                <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-3">
                    <h2 class="text-lg font-bold text-gray-700">Informasi Harga Pangan</h2>
                    <button id="close-food-price-panel-button"
                        class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                </div>
                <div class="space-y-4 max-h-[80vh] overflow-y-auto pr-2">
                    <div>
                        <h3 class="font-bold text-gray-800 mb-2">Harga Bahan Pokok</h3>
                        <div id="staple-food-prices" class="space-y-2"></div>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 mb-2">Harga Sayuran</h3>
                        <div id="vegetable-prices" class="space-y-2"></div>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3 italic">Data harga adalah representasi pasar lokal dan dapat
                    diintegrasikan dengan API dinas terkait.</p>
                <p class="text-xs text-gray-500 mt-1 italic">Data diperbarui setiap hari pada pukul 06:00 WITA.</p>
            </div>

            <!-- AI LAB Anti-Hoax Panel -->
            <div id="ai-lab-panel"
                class="absolute top-4 left-20 z-20 bg-white/80 backdrop-blur-sm p-5 rounded-xl shadow-2xl w-full max-w-sm md:max-w-md hidden">
                <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-3">
                    <h2 class="text-lg font-bold text-gray-700">LAB AI Anti-Hoax</h2>
                    <button id="close-ai-lab-panel-button"
                        class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label for="media-upload" class="block text-sm font-medium text-gray-700 mb-2">Unggah Gambar
                            atau Video:</label>
                        <input type="file" id="media-upload" accept="image/*,video/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div id="media-preview-container"
                        class="mt-4 hidden bg-gray-100 rounded-lg p-2 flex justify-center items-center h-48">
                        <!-- Preview will be shown here -->
                    </div>
                    <button id="analyze-media-button"
                        class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center shadow-md disabled:bg-gray-400"
                        disabled>
                        <i class="fa-solid fa-microchip mr-2"></i>
                        Analisa Media
                    </button>

                    <div class="relative flex py-2 items-center">
                        <div class="flex-grow border-t border-gray-300"></div>
                        <span class="flex-shrink mx-4 text-gray-500 text-sm">ATAU</span>
                        <div class="flex-grow border-t border-gray-300"></div>
                    </div>

                    <div>
                        <label for="link-input" class="block text-sm font-medium text-gray-700 mb-2">Masukkan Tautan
                            Berita:</label>
                        <input type="url" id="link-input"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="https://contoh-berita.com/artikel">
                    </div>
                    <button id="analyze-link-button"
                        class="w-full bg-purple-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-700 transition duration-300 flex items-center justify-center shadow-md disabled:bg-gray-400"
                        disabled>
                        <i class="fa-solid fa-link mr-2"></i>
                        Analisa Tautan
                    </button>
                </div>
                <div id="ai-lab-result" class="mt-4 text-sm text-gray-600">
                    <p class="text-center italic">Unggah media atau masukkan tautan untuk memulai analisis.</p>
                </div>
            </div>


            <!-- Information Dashboard Section -->
            <aside
                class="absolute top-0 right-0 h-full z-10 w-full md:w-1/3 max-w-lg bg-white/90 backdrop-blur-sm p-4 flex flex-col gap-4 overflow-y-auto shadow-lg">
                <!-- Profil Desa -->
                <div class="bg-white p-5 rounded-xl shadow-lg">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Profil Desa</h2>
                    <div class="flex items-center space-x-4">
                        <img id="foto-kades" src="" alt="Foto Kepala Desa"
                            class="w-20 h-20 rounded-full object-cover border-2 border-blue-200 shadow-md">
                        <div class="flex-1 space-y-2 text-sm text-gray-600">
                            <div class="flex justify-between"><span>Kepala Desa:</span> <strong id="nama-kades"
                                    class="text-gray-800"></strong></div>
                            <div class="flex justify-between"><span>Luas Wilayah:</span> <strong id="luas-wilayah"
                                    class="text-gray-800"></strong></div>
                            <div class="flex justify-between"><span>Kecamatan:</span> <strong
                                    class="text-gray-800">Gunungsari</strong></div>
                            <div class="flex justify-between"><span>Kabupaten:</span> <strong
                                    class="text-gray-800">Lombok Barat</strong></div>
                        </div>
                    </div>
                </div>

                <!-- Demografi -->
                <div class="bg-white p-5 rounded-xl shadow-lg">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Demografi</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center justify-between p-2 bg-blue-50 rounded-lg">
                            <div class="flex items-center"><i
                                    class="fas fa-users text-blue-500 w-5 text-center"></i><span class="ml-2">Total
                                    Penduduk</span></div>
                            <strong id="total-penduduk" class="text-blue-800 bg-blue-200 px-2 py-1 rounded"></strong>
                        </div>
                        <div class="flex items-center justify-between p-2 bg-green-50 rounded-lg">
                            <div class="flex items-center"><i
                                    class="fas fa-male text-green-500 w-5 text-center"></i><span
                                    class="ml-2">Laki-laki</span></div>
                            <strong id="jumlah-pria" class="text-green-800 bg-green-200 px-2 py-1 rounded"></strong>
                        </div>
                        <div class="flex items-center justify-between p-2 bg-pink-50 rounded-lg">
                            <div class="flex items-center"><i
                                    class="fas fa-female text-pink-500 w-5 text-center"></i><span
                                    class="ml-2">Perempuan</span></div>
                            <strong id="jumlah-wanita" class="text-pink-800 bg-pink-200 px-2 py-1 rounded"></strong>
                        </div>
                    </div>
                </div>

                <!-- Komposisi Generasi -->
                <div class="bg-white p-5 rounded-xl shadow-lg">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Komposisi Generasi</h2>
                    <div id="data-generasi-container" class="space-y-3 text-sm">
                        <!-- Data Generasi akan dimasukkan oleh JavaScript -->
                    </div>
                </div>

                <!-- Komposisi Agama -->
                <div class="bg-white p-5 rounded-xl shadow-lg">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Komposisi Agama</h2>
                    <div id="data-agama-container" class="space-y-2 text-sm">
                        <!-- Data Agama akan dimasukkan oleh JavaScript -->
                    </div>
                </div>

                <!-- Tingkat Pendidikan -->
                <div class="bg-white p-5 rounded-xl shadow-lg">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Tingkat Pendidikan</h2>
                    <div id="data-pendidikan-container" class="space-y-3 text-sm">
                        <!-- Data Pendidikan akan dimasukkan oleh JavaScript -->
                    </div>
                </div>

                <!-- Struktur Pekerjaan -->
                <div class="bg-white p-5 rounded-xl shadow-lg">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Struktur Pekerjaan</h2>
                    <div id="data-pekerjaan-container" class="space-y-2 text-sm">
                        <!-- Data Pekerjaan akan dimasukkan oleh JavaScript -->
                    </div>
                </div>

                <!-- Pengangguran -->
                <div class="bg-white p-5 rounded-xl shadow-lg">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Tingkat Pengangguran</h2>
                    <div id="data-pengangguran-container" class="space-y-3 text-sm">
                        <!-- Data Pengangguran akan dimasukkan oleh JavaScript -->
                    </div>
                </div>

                <!-- APBDes -->
                <div class="bg-white p-5 rounded-xl shadow-lg">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Anggaran Desa (APBDes)</h2>
                    <div id="apbdes-container" class="space-y-4 text-sm">
                        <!-- Data APBDes akan dimasukkan oleh JavaScript -->
                    </div>
                </div>

                <!-- Pajak Bumi & Bangunan (PBB) -->
                <div class="bg-white p-5 rounded-xl shadow-lg">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Pajak Bumi & Bangunan (PBB)</h2>
                    <div id="data-pbb-container" class="space-y-3 text-sm">
                        <!-- Data PBB akan dimasukkan oleh JavaScript -->
                    </div>
                </div>

                <!-- Data Sosial -->
                <div class="bg-white p-5 rounded-xl shadow-lg">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Data Sosial</h2>
                    <div id="data-sosial-container" class="space-y-2 text-sm">
                        <!-- Data sosial akan dimasukkan oleh JavaScript -->
                    </div>
                </div>

                <!-- Kondisi Jalan -->
                <div class="bg-white p-5 rounded-xl shadow-lg">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Kondisi Jalan Desa</h2>
                    <div id="data-jalan-container" class="space-y-3 text-sm">
                        <!-- Data jalan akan dimasukkan oleh JavaScript -->
                    </div>
                </div>

                <!-- Legenda Peta -->
                <div class="bg-white p-5 rounded-xl shadow-lg">
                    <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Legenda Peta</h2>
                    <div id="legenda-peta" class="space-y-2 text-sm">
                        <!-- Legenda akan dimasukkan oleh JavaScript -->
                    </div>
                </div>

            </aside>
        </main>
    </div>

    <!-- Modal Umum -->
    <div id="detail-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden modal-overlay">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md modal-container transform scale-95">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 id="modal-title" class="text-lg font-bold text-gray-800"></h3>
                <button id="modal-close" class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
            </div>
            <div id="modal-content" class="p-5 text-sm text-gray-700">
                <!-- Konten modal akan diisi oleh JavaScript -->
            </div>
        </div>
    </div>

    <!-- Modal Input Dusun -->
    <div id="dusun-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-[60] hidden modal-overlay">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm modal-container transform scale-95">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 id="dusun-modal-title" class="text-lg font-bold text-gray-800">Detail Batas Dusun</h3>
                <button id="dusun-modal-close"
                    class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
            </div>
            <div id="dusun-modal-content" class="p-5 space-y-4">
                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Informasi Umum</h4>
                <div>
                    <label for="dusun-name-input" class="block text-sm font-medium text-gray-700">Nama Dusun</label>
                    <select id="dusun-name-input"
                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <!-- Options populated by JS -->
                    </select>
                </div>
                <div>
                    <label for="kadus-name-input" class="block text-sm font-medium text-gray-700">Nama Kepala
                        Dusun</label>
                    <input type="text" id="kadus-name-input"
                        class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none sm:text-sm"
                        readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Luas Wilayah</label>
                    <p id="dusun-area-info" class="mt-1 text-sm text-gray-900 font-semibold bg-gray-100 p-2 rounded-md">
                    </p>
                </div>
                <div class="flex justify-end space-x-2 pt-4">
                    <button id="dusun-modal-cancel"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Batal</button>
                    <button id="dusun-modal-save"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- CCTV Fullscreen Modal -->
    <div id="cctv-fullscreen-modal"
        class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center p-4 z-[70] hidden modal-overlay">
        <div class="relative w-full h-full modal-container">
            <h3 id="fullscreen-cctv-title"
                class="absolute top-5 left-5 text-white text-xl font-bold bg-black bg-opacity-50 p-2 rounded"></h3>
            <button id="close-fullscreen-cctv"
                class="absolute top-5 right-5 text-white text-4xl font-bold hover:text-gray-300">&times;</button>
            <div class="w-full h-full flex items-center justify-center">
                <img id="fullscreen-cctv-image" src="" class="max-w-full max-h-full object-contain">
            </div>
        </div>
    </div>

    <script>
        // --- DATA DESA JERINGO (Contoh Data) ---
        const villageData = {
            profile: { kepalaDesa: "Sahril, SH", luasWilayah: "Menghitung...", fotoUrl: "https://awsimages.detik.net.id/community/media/visual/2024/05/04/ketua-papdesi-ntb_169.jpeg?w=500&q=90" },
            demography: {
                total: 2905,
                pria: 1399,
                wanita: 1506,
                religion: [
                    { name: "Islam", total: 2873, icon: "fa-solid fa-mosque", color: "text-green-500", bgColor: "bg-green-50" },
                    { name: "Hindu", total: 19, icon: "fa-solid fa-om", color: "text-orange-500", bgColor: "bg-orange-50" },
                    { name: "Kristen", total: 10, icon: "fa-solid fa-cross", color: "text-blue-500", bgColor: "bg-blue-50" },
                    { name: "Lainnya", total: 3, icon: "fa-solid fa-hands-praying", color: "text-gray-500", bgColor: "bg-gray-50" }
                ],
                generations: [
                    { name: "Gen Z & Alpha (0-28 th)", total: 1017, color: "bg-teal-500", icon: "fa-solid fa-child" },
                    { name: "Milenial (29-44 th)", total: 872, color: "bg-sky-500", icon: "fa-solid fa-mobile-screen-button" },
                    { name: "Gen X (45-60 th)", total: 581, color: "bg-indigo-500", icon: "fa-solid fa-user-tie" },
                    { name: "Baby Boomer (61-79 th)", total: 291, color: "bg-purple-500", icon: "fa-solid fa-person-cane" },
                    { name: "Pre-Boomer (80+ th)", total: 144, color: "bg-slate-500", icon: "fa-solid fa-person-walking-with-cane" }
                ],
                education: [
                    { name: "Tidak/Belum Sekolah", total: 290, color: "bg-red-500" },
                    { name: "SD/Sederajat", total: 969, color: "bg-orange-500" },
                    { name: "SMP/Sederajat", total: 775, color: "bg-yellow-500" },
                    { name: "SMA/Sederajat", total: 710, color: "bg-green-500" },
                    { name: "Perguruan Tinggi", total: 161, color: "bg-blue-500" }
                ],
                occupation: [
                    { name: "Petani", total: 775, icon: "fa-solid fa-seedling", color: "text-green-600", bgColor: "bg-green-50" },
                    { name: "Pedagang", total: 387, icon: "fa-solid fa-store", color: "text-blue-600", bgColor: "bg-blue-50" },
                    { name: "PNS/TNI/Polri", total: 97, icon: "fa-solid fa-user-tie", color: "text-indigo-600", bgColor: "bg-indigo-50" },
                    { name: "Karyawan Swasta", total: 290, icon: "fa-solid fa-briefcase", color: "text-purple-600", bgColor: "bg-purple-50" },
                    { name: "Lainnya", total: 194, icon: "fa-solid fa-users-gear", color: "text-gray-600", bgColor: "bg-gray-50" }
                ]
            },
            unemployment: {
                totalWorkforce: 1743,
                unemployed: 140
            },
            locations: [
                { name: "Kantor Desa Jeringo", category: "Pemerintahan", lat: -8.53686, lng: 116.13239, icon: "fa-solid fa-landmark", color: "blue" },
                { name: "SDN 1 Jeringo", category: "Pendidikan", lat: -8.5352, lng: 116.1315, icon: "fa-solid fa-school", color: "orange" },
                { name: "Puskesmas Pembantu", category: "Kesehatan", lat: -8.5380, lng: 116.1340, icon: "fa-solid fa-briefcase-medical", color: "red" },
                { name: "Masjid Jami' Nurul Huda", category: "Ibadah", lat: -8.5365, lng: 116.1300, icon: "fa-solid fa-mosque", color: "green" },
                { name: "Air Terjun Tibu Atas", category: "Wisata", lat: -8.5300, lng: 116.1380, icon: "fa-solid fa-water", color: "purple" },
                { name: "Mata Air Limbungan", category: "Wisata", lat: -8.5290, lng: 116.1350, icon: "fa-solid fa-fountain", color: "cyan" }
            ],
            socialData: [
                { id: "stunting", name: "Stunting", total: 15, icon: "fa-solid fa-child-reaching", color: "amber", bgColor: "bg-amber-50", textColor: "text-amber-500", countBgColor: "bg-amber-200", countTextColor: "text-amber-800" },
                { id: "rumah", name: "Rumah Tdk Layak", total: 25, icon: "fa-solid fa-house-crack", color: "stone", bgColor: "bg-stone-50", textColor: "text-stone-500", countBgColor: "bg-stone-200", countTextColor: "text-stone-800" },
                { id: "gizi", name: "Kurang Gizi", total: 10, icon: "fa-solid fa-heart-crack", color: "yellow", bgColor: "bg-yellow-50", textColor: "text-yellow-500", countBgColor: "bg-yellow-200", countTextColor: "text-yellow-800" },
                { id: "lansia", name: "Lansia", total: 150, icon: "fa-solid fa-person-cane", color: "sky", bgColor: "bg-sky-50", textColor: "text-sky-500", countBgColor: "bg-sky-200", countTextColor: "text-sky-800" },
                { id: "yatim", name: "Anak Yatim", total: 40, icon: "fa-solid fa-hands-holding-child", color: "teal", bgColor: "bg-teal-50", textColor: "text-teal-500", countBgColor: "bg-teal-200", countTextColor: "text-teal-800" }
            ],
            socialMarkers: [
                { name: "Kasus Stunting A", category: "Stunting", lat: -8.5375, lng: 116.1310, icon: "fa-solid fa-child-reaching", color: "amber", details: { "Inisial": "A.R.", "Usia": "3 tahun", "Kondisi": "Tinggi badan tidak sesuai usia.", "Tindakan": "Pemberian makanan tambahan." }, imageUrl: "https://placehold.co/400x250/FBBF24/FFFFFF?text=Foto+Anak" },
                { name: "Rumah Keluarga S.", category: "Rumah Tdk Layak", lat: -8.5385, lng: 116.1325, icon: "fa-solid fa-house-crack", color: "stone", details: { "Kepala Keluarga": "Bapak S.", "Jumlah Anggota": 5, "Kondisi": "Dinding bambu, lantai tanah.", "Bantuan": "Diusulkan program bedah rumah." }, imageUrl: "https://placehold.co/400x250/78716C/FFFFFF?text=Foto+Rumah" },
                { name: "Lansia Ibu T.", category: "Lansia", lat: -8.5360, lng: 116.1335, icon: "fa-solid fa-person-cane", color: "sky", details: { "Nama": "Ibu T.", "Usia": "78 tahun", "Kondisi": "Membutuhkan pemeriksaan kesehatan rutin." }, imageUrl: "https://placehold.co/400x250/38BDF8/FFFFFF?text=Foto+Lansia" },
                { name: "Anak Yatim R.", category: "Anak Yatim", lat: -8.5350, lng: 116.1345, icon: "fa-solid fa-hands-holding-child", color: "teal", details: { "Inisial": "R.S.", "Usia": "10 tahun", "Status": "Yatim Piatu", "Bantuan": "Menerima santunan rutin." }, imageUrl: "https://placehold.co/400x250/2DD4BF/FFFFFF?text=Foto+Anak+Yatim" }
            ],
            cctvLocations: [
                { name: "Gerbang Selamat Datang", lat: -8.5445, lng: 116.132, streamUrl: "https://placehold.co/800x450/000000/FFFFFF?text=CCTV+1+-+Gerbang+Desa" },
                { name: "Pertigaan Utama", lat: -8.5361, lng: 116.1312, streamUrl: "https://placehold.co/800x450/000000/FFFFFF?text=CCTV+2+-+Pertigaan" },
                { name: "Area Kantor Desa", lat: -8.5369, lng: 116.1325, streamUrl: "https://placehold.co/800x450/000000/FFFFFF?text=CCTV+3+-+Kantor+Desa" },
                { name: "Area Wisata Air Terjun", lat: -8.5305, lng: 116.1381, streamUrl: "https://placehold.co/800x450/000000/FFFFFF?text=CCTV+4+-+Air+Terjun" }
            ],
            foodPriceData: {
                staples: [
                    { name: "Beras Medium", price: 14500, unit: "kg" },
                    { name: "Gula Pasir", price: 18000, unit: "kg" },
                    { name: "Minyak Goreng Curah", price: 16000, unit: "liter" },
                    { name: "Daging Sapi", price: 125000, unit: "kg" },
                    { name: "Daging Ayam", price: 40000, unit: "kg" },
                    { name: "Telur Ayam", price: 28000, unit: "kg" }
                ],
                vegetables: [
                    { name: "Bawang Merah", price: 45000, unit: "kg" },
                    { name: "Bawang Putih", price: 42000, unit: "kg" },
                    { name: "Cabai Merah Besar", price: 55000, unit: "kg" },
                    { name: "Cabai Rawit Merah", price: 60000, unit: "kg" },
                    { name: "Tomat", price: 20000, unit: "kg" },
                    { name: "Kentang", price: 18000, unit: "kg" }
                ]
            },
            boundary: {
                "type": "Feature", "properties": { "name": "Batas Wilayah Desa Jeringo", "style": { "color": "#1e3a8a", "weight": 3, "opacity": 0.7, "fillColor": "#3b82f6", "fillOpacity": 0.2 } },
                "geometry": {
                    "type": "Polygon", "coordinates": [
                        [
                            [116.13107, -8.54496], [116.13253, -8.54539], [116.13263, -8.54460], [116.13267, -8.54408], [116.13277, -8.54380], [116.13286, -8.54342], [116.13288, -8.54329], [116.13299, -8.54297], [116.13340, -8.54154], [116.13332, -8.54141], [116.13329, -8.54123], [116.13351, -8.54059], [116.13352, -8.54033], [116.13364, -8.54028], [116.13363, -8.54008], [116.13360, -8.53990], [116.13355, -8.53987], [116.13357, -8.53961], [116.13402, -8.53908], [116.13411, -8.53867], [116.13358, -8.53710], [116.13376, -8.53615], [116.13410, -8.53581], [116.13509, -8.53363], [116.13608, -8.53230], [116.13614, -8.53176], [116.13583, -8.53163], [116.13555, -8.53188], [116.13505, -8.53167], [116.13473, -8.53181], [116.13436, -8.53164], [116.13419, -8.53162], [116.13391, -8.53179], [116.13370, -8.53256], [116.13341, -8.53258], [116.13330, -8.53267], [116.13318, -8.53246], [116.13306, -8.53244], [116.13290, -8.53255], [116.13287, -8.53258], [116.13277, -8.53215], [116.13244, -8.53229], [116.13233, -8.53232], [116.13229, -8.53239], [116.13219, -8.53242], [116.13210, -8.53201], [116.13200, -8.53169], [116.13187, -8.53152], [116.13198, -8.53147], [116.13202, -8.53145], [116.13222, -8.53141], [116.13211, -8.53110], [116.13199, -8.53099], [116.13189, -8.53077], [116.13168, -8.53050], [116.13080, -8.53028], [116.13048, -8.53035], [116.12959, -8.53028], [116.12949, -8.53005], [116.12936, -8.52936], [116.12899, -8.52874], [116.12875, -8.52844], [116.12852, -8.52790], [116.12805, -8.52757], [116.12805, -8.52810], [116.12803, -8.52833], [116.12811, -8.52872], [116.12805, -8.52895], [116.12802, -8.52918], [116.12796, -8.52945], [116.12772, -8.53019], [116.12741, -8.53090], [116.12711, -8.53148], [116.12694, -8.53166], [116.12705, -8.53220], [116.12701, -8.53250], [116.12703, -8.53282], [116.12725, -8.53335], [116.12753, -8.53403], [116.12748, -8.53499], [116.12767, -8.53552], [116.12774, -8.53575], [116.12811, -8.53619], [116.12833, -8.53691], [116.12827, -8.53836], [116.12866, -8.54019], [116.12869, -8.54050], [116.12859, -8.54073], [116.12858, -8.54114], [116.12845, -8.54136], [116.12848, -8.54170], [116.12845, -8.54190], [116.12843, -8.54202], [116.12838, -8.54212], [116.12837, -8.54228], [116.12842, -8.54251], [116.12842, -8.54297], [116.12919, -8.54296], [116.12929, -8.54290], [116.12933, -8.54311], [116.12952, -8.54309], [116.12964, -8.54313], [116.12987, -8.54301], [116.13031, -8.54311], [116.13065, -8.54313], [116.13080, -8.54327], [116.13082, -8.54356], [116.13106, -8.54355],
                            [116.13107, -8.54496] // Menutup poligon
                        ]
                    ]
                }
            },
            roadData: {
                goodKm: 0,
                badKm: 0,
                alleyKm: 0
            },
            pbb: {
                target: 150000000, // Rp 150.000.000
                realisasi: 112500000 // Rp 112.500.000 (75%)
            },
            apbdes: {
                pendapatan: {
                    total: 1200000000,
                    sumber: [
                        { nama: "Pendapatan Asli Desa (PADes)", jumlah: 150000000 },
                        { nama: "Dana Desa (DD)", jumlah: 800000000 },
                        { nama: "Alokasi Dana Desa (ADD)", jumlah: 200000000 },
                        { nama: "Bagi Hasil Pajak & Retribusi", jumlah: 50000000 }
                    ]
                },
                belanja: {
                    total: 950000000, // Disesuaikan untuk contoh SILPA tinggi
                    bidang: [
                        { nama: "Penyelenggaraan Pemerintahan", jumlah: 300000000 },
                        { nama: "Pelaksanaan Pembangunan", jumlah: 400000000 },
                        { nama: "Pembinaan Kemasyarakatan", jumlah: 120000000 },
                        { nama: "Pemberdayaan Masyarakat", jumlah: 80000000 },
                        { nama: "Belanja Tak Terduga", jumlah: 50000000 }
                    ]
                }
            }
        };

        const dusunHeadData = {
            "Jeringo Daye": "Kamardan",
            "Jeringo Lauq": "Ishak",
            "Jeringo Barat": "Mujiburahman,S.Pd",
            "Jeringo Limbungan": "Ahmad Zahiruddin S.IP",
            "Jeringo Timur": "Munawir"
        };

        const dusunDemoData = {
            "Jeringo Daye": { penduduk: { total: 639, pria: 308, wanita: 331 }, agama: { islam: 632, hindu: 4, kristen: 3 }, pbb: { target: 33000000, realisasi: 24750000 }, jalan: { bagus: 1.1, rusak: 0.4 } },
            "Jeringo Lauq": { penduduk: { total: 523, pria: 252, wanita: 271 }, agama: { islam: 518, hindu: 3, kristen: 2 }, pbb: { target: 27000000, realisasi: 20250000 }, jalan: { bagus: 0.9, rusak: 0.3 } },
            "Jeringo Barat": { penduduk: { total: 581, pria: 280, wanita: 301 }, agama: { islam: 575, hindu: 4, kristen: 2 }, pbb: { target: 30000000, realisasi: 22500000 }, jalan: { bagus: 1.0, rusak: 0.5 } },
            "Jeringo Limbungan": { penduduk: { total: 726, pria: 350, wanita: 376 }, agama: { islam: 718, hindu: 5, kristen: 3 }, pbb: { target: 37500000, realisasi: 28125000 }, jalan: { bagus: 1.5, rusak: 0.6 } },
            "Jeringo Timur": { penduduk: { total: 436, pria: 210, wanita: 226 }, agama: { islam: 430, hindu: 3, kristen: 3 }, pbb: { target: 22500000, realisasi: 16875000 }, jalan: { bagus: 0.8, rusak: 0.2 } }
        };

        document.addEventListener('DOMContentLoaded', () => {

            const loginPage = document.getElementById('login-page');
            const appContainer = document.getElementById('app-container');
            const loginForm = document.getElementById('login-form');
            const loginError = document.getElementById('login-error');

            loginForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const username = document.getElementById('username').value;
                const password = document.getElementById('password').value;

                // Simple hardcoded authentication
                if (username === 'admin' && password === 'jeringo2024') {
                    loginPage.classList.add('hidden');
                    appContainer.classList.remove('hidden');
                    document.title = "Dashboard Peta Desa Jeringo";
                    initializeApp();
                } else {
                    loginError.classList.remove('hidden');
                }
            });

            function initializeApp() {
                const map = L.map('map', { zoomControl: false }).setView([-8.53686, 116.13239], 16);
                L.control.zoom({ position: 'bottomright' }).addTo(map);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '© OpenStreetMap' }).addTo(map);

                let originalBoundary = L.geoJSON(villageData.boundary, { style: f => f.properties.style }).bindPopup("<h3>Batas Wilayah Desa Jeringo</h3>").addTo(map);

                let drawnItems = new L.FeatureGroup().addTo(map);

                const legendItems = {};

                const createCustomIcon = (iconClass, markerColor) => L.divIcon({ html: `<i class="${iconClass} fa-2x" style="color: ${markerColor};"></i>`, className: 'bg-transparent border-0', iconSize: [24, 24], iconAnchor: [12, 24], popupAnchor: [0, -24] });

                villageData.locations.forEach(loc => {
                    const customIcon = createCustomIcon(loc.icon, loc.color);
                    L.marker([loc.lat, loc.lng], { icon: customIcon }).addTo(map).bindPopup(`<div class="popup-title">${loc.name}</div><span class="popup-category" style="background-color:${loc.color};">${loc.category}</span>`);
                    if (!legendItems[loc.category]) legendItems[loc.category] = { icon: loc.icon, color: loc.color };
                });

                villageData.socialMarkers.forEach(loc => {
                    const dataDefinition = villageData.socialData.find(d => d.name === loc.category);
                    const markerColor = dataDefinition ? `var(--color-${dataDefinition.color}-500)` : 'gray';
                    const customIcon = createCustomIcon(loc.icon, markerColor);
                    const marker = L.marker([loc.lat, loc.lng], { icon: customIcon }).addTo(map);
                    marker.on('click', () => {
                        let contentHtml = '<div class="space-y-2">';
                        for (const [key, value] of Object.entries(loc.details)) {
                            contentHtml += `<div class="flex border-b pb-1"><strong class="w-1/3 text-gray-500">${key}</strong><span class="w-2/3">${value}</span></div>`;
                        }
                        contentHtml += '</div>';
                        showModal(loc.name, contentHtml, loc.imageUrl);
                    });
                    if (!legendItems[loc.category]) legendItems[loc.category] = { icon: loc.icon, color: markerColor };
                });

                const cctvIcon = L.divIcon({
                    html: `<i class="fa-solid fa-video fa-lg" style="color: #4b5563;"></i>`,
                    className: 'bg-white rounded-full p-1 shadow',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });

                villageData.cctvLocations.forEach(cctv => {
                    const marker = L.marker([cctv.lat, cctv.lng], { icon: cctvIcon }).addTo(map);
                    marker.bindPopup(`<b>CCTV: ${cctv.name}</b><br><button class="view-cctv-btn mt-2 p-1 bg-blue-500 text-white rounded text-xs" data-name="${cctv.name}">Lihat Pantauan</button>`);

                    if (!legendItems['CCTV']) {
                        legendItems['CCTV'] = { icon: 'fa-solid fa-video', color: '#4b5563' };
                    }
                });

                function updateRoadStats() {
                    let goodKm = 0;
                    let badKm = 0;
                    let alleyKm = 0;

                    drawnItems.eachLayer(layer => {
                        if (layer.options && layer.options.roadStatus) {
                            if (layer.options.roadStatus === 'Bagus') {
                                goodKm += layer.options.lengthKm;
                            } else if (layer.options.roadStatus === 'Rusak') {
                                badKm += layer.options.lengthKm;
                            } else if (layer.options.roadStatus === 'Gang') {
                                alleyKm += layer.options.lengthKm;
                            }
                        }
                    });

                    villageData.roadData.goodKm = goodKm;
                    villageData.roadData.badKm = badKm;
                    villageData.roadData.alleyKm = alleyKm;

                    const jalanContainer = document.getElementById('data-jalan-container');
                    const totalLengthKm = goodKm + badKm + alleyKm;
                    const goodPercentage = totalLengthKm > 0 ? ((goodKm / totalLengthKm) * 100).toFixed(0) : 0;
                    const badPercentage = totalLengthKm > 0 ? ((badKm / totalLengthKm) * 100).toFixed(0) : 0;
                    const alleyPercentage = totalLengthKm > 0 ? ((alleyKm / totalLengthKm) * 100).toFixed(0) : 0;

                    if (totalLengthKm > 0) {
                        jalanContainer.innerHTML = `
                            <div class="flex justify-between items-center mb-2">
                                <span>Total Panjang Jalan (Digambar):</span>
                                <strong class="text-gray-800">${totalLengthKm.toFixed(2)} km</strong>
                            </div>
                            <div>
                                <div class="mb-1 flex justify-between">
                                    <span class="text-green-600 font-semibold">Jalan Bagus</span>
                                    <span>${goodKm.toFixed(2)} km (${goodPercentage}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-green-500 h-2.5 rounded-full" style="width: ${goodPercentage}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="mb-1 flex justify-between">
                                    <span class="text-red-600 font-semibold">Jalan Rusak</span>
                                    <span>${badKm.toFixed(2)} km (${badPercentage}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-red-500 h-2.5 rounded-full" style="width: ${badPercentage}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="mb-1 flex justify-between">
                                    <span class="text-orange-500 font-semibold">Jalan Gang</span>
                                    <span>${alleyKm.toFixed(2)} km (${alleyPercentage}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-orange-500 h-2.5 rounded-full" style="width: ${alleyPercentage}%"></div>
                                </div>
                            </div>
                        `;
                    } else {
                        jalanContainer.innerHTML = `<p class="text-center italic text-sm text-gray-500">Belum ada data jalan yang digambar.</p>`;
                    }
                }



                const formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                });

                function calculatePolygonArea(latlngs) {
                    if (!latlngs || latlngs.length < 3) return 0;
                    const avgLat = latlngs.reduce((sum, p) => sum + p.lat, 0) / latlngs.length;
                    const cosAvgLat = Math.cos(avgLat * Math.PI / 180);
                    let area = 0;
                    for (let i = 0; i < latlngs.length; i++) {
                        const p1 = latlngs[i];
                        const p2 = latlngs[(i + 1) % latlngs.length];
                        const x1 = p1.lng * 111320 * cosAvgLat;
                        const y1 = p1.lat * 111320;
                        const x2 = p2.lng * 111320 * cosAvgLat;
                        const y2 = p2.lat * 111320;
                        area += (x1 * y2 - x2 * y1);
                    }
                    return Math.abs(area / 2);
                }

                function updateAreaFromGeoJSON(feature) {
                    const coordinates = feature.geometry.coordinates[0];
                    const latlngs = coordinates.map(coord => ({ lat: coord[1], lng: coord[0] }));
                    const areaM2 = calculatePolygonArea(latlngs);
                    const areaKm2 = areaM2 / 1000000;
                    const areaHa = areaM2 / 10000;
                    villageData.profile.luasWilayah = `${areaKm2.toFixed(2)} km² / ${areaHa.toFixed(2)} Ha`;
                }


                function runOfflineAIAnalysis(data) {
                    const { demography, socialData, roadData, pbb, apbdes, unemployment, profile } = data;
                    const problems = [];

                    const thresholds = {
                        stunting: 0.003,
                        rumah: 0.005,
                        badRoads: 0.20,
                        pbb: 0.85,
                        silpa: 0.15,
                        unemployment: 0.075
                    };

                    const problemDefinitions = {
                        stunting: {
                            name: "Tingkat Stunting Cukup Tinggi",
                            priority: 10,
                            impact: "Stunting pada anak dapat menghambat perkembangan kognitif dan fisik, mempengaruhi kualitas SDM desa di masa depan.",
                            shortTermAction: "1. Validasi ulang data stunting door-to-door. 2. Distribusi PMT (Pemberian Makanan Tambahan) tinggi protein selama 90 hari. 3. Adakan kelas gizi bulanan untuk ibu hamil/menyusui.",
                            longTermAction: "1. Kembangkan program 'Kebun Gizi Desa' untuk ketahanan pangan. 2. Buat Perdes tentang alokasi dana desa untuk penanganan stunting. 3. Integrasikan data Posyandu dengan sistem informasi desa.",
                            stakeholders: "Kader Posyandu, Bidan Desa, Pemerintah Desa, Dinas Kesehatan, PKK.",
                            indicator: "Penurunan prevalensi stunting sebesar 5% dalam 6 bulan.",
                            rab: [
                                { item: "PMT (Biskuit & Susu) 90 Hari", qty: 15, unit: "Anak", price: 450000, total: 6750000 },
                                { item: "Honor Kader Gizi (3 Bulan)", qty: 3, unit: "Orang", price: 300000, total: 900000 },
                                { item: "Cetak Materi Edukasi", qty: 1, unit: "Paket", price: 500000, total: 500000 }
                            ]
                        },
                        rumah: {
                            name: "Rumah Tidak Layak Huni (RTLH)",
                            priority: 8,
                            impact: "Kondisi rumah yang tidak layak dapat menurunkan kualitas kesehatan dan kesejahteraan penghuninya, serta rentan terhadap risiko bencana.",
                            shortTermAction: "1. Bentuk tim verifikasi RTLH. 2. Prioritaskan perbaikan untuk keluarga dengan balita/lansia. 3. Ajak pengusaha lokal untuk donasi material (CSR).",
                            longTermAction: "1. Ajukan proposal BSPS (Bantuan Stimulan Perumahan Swadaya) ke Kementerian PUPR. 2. Buat program 'Arisan Bedah Rumah' berbasis komunitas. 3. Latih warga keterampilan pertukangan dasar.",
                            stakeholders: "Pemerintah Desa, BPD, Dinas Perkim, Komunitas Lokal, Pengusaha.",
                            indicator: "Minimal 5 rumah berhasil direnovasi atau mendapat bantuan dalam 1 tahun.",
                            rab: [
                                { item: "Material Bangunan (Semen, Pasir, Bata)", qty: 5, unit: "Rumah", price: 12000000, total: 60000000 },
                                { item: "Upah Tukang", qty: 5, unit: "Rumah", price: 3000000, total: 15000000 },
                                { item: "Konsumsi Kerja Bakti", qty: 10, unit: "Kegiatan", price: 250000, total: 2500000 }
                            ]
                        },
                        badRoads: {
                            name: "Infrastruktur Jalan Rusak",
                            priority: 7,
                            impact: "Jalan rusak menghambat akses ekonomi, pendidikan, dan layanan kesehatan, serta meningkatkan risiko kecelakaan.",
                            shortTermAction: "1. Lakukan perbaikan darurat (tambal sulam) di titik paling kritis. 2. Pasang rambu peringatan di area jalan rusak. 3. Adakan kerja bakti rutin pembersihan drainase jalan.",
                            longTermAction: "1. Masukkan perbaikan jalan utama dalam Musrenbangdes. 2. Buat proposal pengajuan bantuan perbaikan jalan ke Dinas PU Kabupaten. 3. Petakan jalan desa untuk prioritas perbaikan bertahap.",
                            stakeholders: "Pemerintah Desa, Dinas PU, LPM, Kepala Dusun, Warga.",
                            indicator: "Penurunan persentase jalan rusak sebesar 10% dalam 1 tahun anggaran.",
                            rab: [
                                { item: "Aspal Hotmix", qty: 10, unit: "Ton", price: 1500000, total: 15000000 },
                                { item: "Sewa Mesin Gilas", qty: 5, unit: "Hari", price: 800000, total: 4000000 },
                                { item: "Upah Pekerja", qty: 1, unit: "Paket", price: 8500000, total: 8500000 }
                            ]
                        },
                        gizi: {
                            name: "Kasus Gizi Kurang pada Anak",
                            priority: 9,
                            impact: "Gizi kurang membuat anak rentan terhadap penyakit dan dapat mengganggu pertumbuhan, berisiko tinggi menjadi stunting.",
                            shortTermAction: "1. Kunjungan rumah oleh ahli gizi/bidan desa ke kasus teridentifikasi. 2. Berikan paket gizi darurat. 3. Pastikan keluarga terdaftar dalam program bantuan sosial (PKH/BPNT).",
                            longTermAction: "1. Kampanyekan 'Isi Piringku' di seluruh dusun. 2. Adakan demo masak makanan bergizi dengan bahan lokal. 3. Monitor berat dan tinggi badan anak secara ketat setiap bulan.",
                            stakeholders: "Puskesmas, Ahli Gizi, Kader Posyandu, Dinsos, PKK.",
                            indicator: "Seluruh kasus gizi kurang tertangani dan menunjukkan perbaikan status gizi dalam 3 bulan.",
                            rab: [
                                { item: "Paket Gizi Darurat (Susu, Vitamin)", qty: 10, unit: "Anak", price: 200000, total: 2000000 },
                                { item: "Transport Petugas (Kunjungan Rumah)", qty: 3, unit: "Bulan", price: 300000, total: 900000 },
                                { item: "Bahan Demo Masak", qty: 5, unit: "Kegiatan", price: 400000, total: 2000000 }
                            ]
                        },
                        pbb: {
                            name: "Capaian Realisasi PBB Rendah",
                            priority: 6,
                            impact: "Realisasi PBB yang rendah mengurangi Pendapatan Asli Desa (PADes), yang dapat menghambat pendanaan program pembangunan dan pelayanan masyarakat.",
                            shortTermAction: "1. Identifikasi dan petakan wajib pajak yang menunggak. 2. Lakukan sosialisasi 'Jemput Bola' pembayaran PBB di tingkat dusun. 3. Berikan insentif sederhana bagi dusun dengan tingkat pelunasan tertinggi.",
                            longTermAction: "1. Digitalisasi data PBB untuk mempermudah monitoring dan pembayaran. 2. Buat program 'PBB Lunas, Pembangunan Lancar' untuk meningkatkan kesadaran warga. 3. Integrasikan pembayaran PBB dengan layanan administrasi desa lainnya.",
                            stakeholders: "Pemerintah Desa, BKD (Badan Keuangan Daerah), Kepala Dusun, Warga/Wajib Pajak.",
                            indicator: "Peningkatan realisasi PBB mencapai 90% dari target pada akhir tahun berjalan.",
                            rab: [
                                { item: "Cetak Spanduk & Leaflet", qty: 1, unit: "Paket", price: 750000, total: 750000 },
                                { item: "Konsumsi Sosialisasi Dusun", qty: 5, unit: "Kegiatan", price: 300000, total: 1500000 },
                                { item: "Insentif Kolektor PBB", qty: 3, unit: "Orang", price: 500000, total: 1500000 }
                            ]
                        },
                        apbdes: {
                            name: "Penyerapan Anggaran Rendah (SILPA Tinggi)",
                            priority: 5,
                            impact: "SILPA yang tinggi menunjukkan program/kegiatan yang direncanakan tidak berjalan optimal. Hal ini menghambat laju pembangunan dan realisasi manfaat bagi masyarakat.",
                            shortTermAction: "1. Lakukan evaluasi triwulanan realisasi anggaran. 2. Identifikasi kendala di setiap kegiatan yang penyerapannya rendah. 3. Percepat proses administrasi dan pencairan untuk program yang sedang berjalan.",
                            longTermAction: "1. Tingkatkan kualitas perencanaan dalam Musrenbangdes agar lebih realistis. 2. Adakan pelatihan manajemen & pelaporan keuangan bagi perangkat desa. 3. Kembangkan sistem monitoring realisasi anggaran berbasis digital.",
                            stakeholders: "Pemerintah Desa (Kades, TPK), BPD, Pendamping Desa.",
                            indicator: "Penyerapan anggaran mencapai minimal 95% pada tahun anggaran berikutnya.",
                            rab: [
                                { item: "Pelatihan Manajemen Keuangan", qty: 1, unit: "Paket", price: 5000000, total: 5000000 },
                                { item: "Workshop Perencanaan Partisipatif", qty: 2, unit: "Kegiatan", price: 2500000, total: 5000000 },
                                { item: "Langganan Software Keuangan Desa", qty: 1, unit: "Tahun", price: 2000000, total: 2000000 }
                            ]
                        },
                        unemployment: {
                            name: "Tingkat Pengangguran Terbuka Tinggi",
                            priority: 8,
                            impact: "Pengangguran yang tinggi dapat memicu masalah sosial seperti kemiskinan dan kriminalitas, serta menurunkan daya beli masyarakat dan potensi ekonomi desa.",
                            shortTermAction: "1. Adakan 'Job Fair Mini' tingkat desa bekerjasama dengan perusahaan terdekat. 2. Lakukan pendataan minat dan bakat pemuda pengangguran. 3. Berikan pelatihan soft skill (CV, wawancara).",
                            longTermAction: "1. Kembangkan BUMDes dengan unit usaha padat karya (misal: wisata, agribisnis). 2. Fasilitasi pelatihan wirausaha dan akses permodalan. 3. Jalin kemitraan dengan Balai Latihan Kerja (BLK) untuk program sertifikasi.",
                            stakeholders: "Pemerintah Desa, BUMDes, Dinas Tenaga Kerja, Karang Taruna, Pelaku Usaha.",
                            indicator: "Penurunan tingkat pengangguran sebesar 2% dalam satu tahun.",
                            rab: [
                                { item: "Pelatihan Wirausaha (UMKM)", qty: 2, unit: "Kelas", price: 4000000, total: 8000000 },
                                { item: "Bantuan Modal Awal BUMDes", qty: 1, unit: "Paket", price: 25000000, total: 25000000 },
                                { item: "Sosialisasi & Job Fair Mini", qty: 1, unit: "Kegiatan", price: 3500000, total: 3500000 }
                            ]
                        }
                    };

                    const stuntingData = socialData.find(d => d.id === 'stunting');
                    if ((stuntingData.total / demography.total) > thresholds.stunting) {
                        problems.push({ ...problemDefinitions.stunting, id: 'stunting' });
                    }
                    const rumahData = socialData.find(d => d.id === 'rumah');
                    if ((rumahData.total / demography.total) > thresholds.rumah) {
                        problems.push({ ...problemDefinitions.rumah, id: 'rumah' });
                    }
                    const giziData = socialData.find(d => d.id === 'gizi');
                    if ((giziData.total / demography.total) > 0) {
                        problems.push({ ...problemDefinitions.gizi, id: 'gizi' });
                    }

                    if (roadData) {
                        const totalRoads = roadData.goodKm + roadData.badKm;
                        if (totalRoads > 0 && (roadData.badKm / totalRoads) > thresholds.badRoads) {
                            problems.push({ ...problemDefinitions.badRoads, id: 'badRoads' });
                        }
                    }

                    if (pbb && (pbb.realisasi / pbb.target) < thresholds.pbb) {
                        problems.push({ ...problemDefinitions.pbb, id: 'pbb' });
                    }

                    if (apbdes) {
                        const sisaAnggaran = apbdes.pendapatan.total - apbdes.belanja.total;
                        const silpaPercentage = sisaAnggaran / apbdes.pendapatan.total;
                        if (silpaPercentage > thresholds.silpa) {
                            problems.push({ ...problemDefinitions.apbdes, id: 'apbdes' });
                        }
                    }

                    if (unemployment) {
                        const unemploymentRate = unemployment.unemployed / unemployment.totalWorkforce;
                        if (unemploymentRate > thresholds.unemployment) {
                            problems.push({ ...problemDefinitions.unemployment, id: 'unemployment' });
                        }
                    }

                    let summaryHtml = `<div class="mb-5">
                        <h3 class="font-bold text-gray-800 text-base border-b pb-2 mb-2">Ringkasan Umum Kondisi Desa</h3>
                        <div class="text-xs space-y-2">
                            <p><strong><i class="fa-solid fa-user-tie w-4"></i> Kepala Desa:</strong> ${profile.kepalaDesa}</p>
                            <p><strong><i class="fa-solid fa-map-marked-alt w-4"></i> Luas Wilayah:</strong> ${profile.luasWilayah}</p>
                            <p><strong><i class="fa-solid fa-users w-4"></i> Total Penduduk:</strong> ${demography.total.toLocaleString('id-ID')} jiwa</p>
                            <p><strong><i class="fa-solid fa-chart-pie w-4"></i> Tingkat Pengangguran:</strong> ${((unemployment.unemployed / unemployment.totalWorkforce) * 100).toFixed(1)}%</p>
                            <p><strong><i class="fa-solid fa-money-bill-wave w-4"></i> Realisasi PBB:</strong> ${((pbb.realisasi / pbb.target) * 100).toFixed(0)}% dari target</p>
                            <p><strong><i class="fa-solid fa-wallet w-4"></i> Sisa Anggaran (SILPA):</strong> ${formatter.format(apbdes.pendapatan.total - apbdes.belanja.total)}</p>
                        </div>
                    </div>`;

                    if (problems.length === 0) {
                        const noProblemHtml = '<p class="text-green-600 font-semibold">Analisa tidak menemukan masalah kritis berdasarkan ambang batas yang ditentukan. Kondisi desa terpantau baik.</p>';
                        return { problemsHtml: noProblemHtml, summaryHtml: summaryHtml, problems: [] };
                    }

                    problems.sort((a, b) => b.priority - a.priority);

                    let problemsHtml = '<div class="space-y-5">';
                    problemsHtml += `
                        <div>
                            <h3 class="font-bold text-gray-800 text-base">Identifikasi Masalah & Rekomendasi</h3>
                            <p class="text-xs text-gray-600">Teridentifikasi ${problems.length} area utama yang memerlukan perhatian dan intervensi.</p>
                        </div>`;

                    problems.forEach(p => {
                        problemsHtml += `
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <h4 class="font-bold text-blue-700">${p.name}</h4>
                            <p class="text-xs italic text-gray-500 mt-1 mb-2"><strong>Dampak:</strong> ${p.impact}</p>

                            <div class="text-xs space-y-2">
                                <p><strong><i class="fa-solid fa-forward-fast text-green-600 w-4"></i> Rencana Jangka Pendek:</strong> ${p.shortTermAction}</p>
                                <p><strong><i class="fa-solid fa-hourglass-half text-orange-600 w-4"></i> Rencana Jangka Panjang:</strong> ${p.longTermAction}</p>
                                <p><strong><i class="fa-solid fa-users text-purple-600 w-4"></i> Pihak Terkait:</strong> ${p.stakeholders}</p>
                                <p><strong><i class="fa-solid fa-bullseye text-red-600 w-4"></i> Indikator Keberhasilan:</strong> ${p.indicator}</p>
                            </div>`;

                        if (p.rab && p.rab.length > 0) {
                            let totalRab = 0;
                            problemsHtml += `
                                <p class="text-xs mt-3 font-bold text-gray-700"><i class="fa-solid fa-wallet text-indigo-600 w-4"></i> Rencana Anggaran Biaya (RAB):</p>
                                <table class="rab-table">
                                    <thead>
                                        <tr>
                                            <th>Uraian</th>
                                            <th class="text-right">Jumlah</th>
                                            <th class="text-right">Harga Satuan</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                            p.rab.forEach(item => {
                                totalRab += item.total;
                                problemsHtml += `
                                        <tr>
                                            <td>${item.item}</td>
                                            <td class="text-right">${item.qty} ${item.unit}</td>
                                            <td class="text-right">${formatter.format(item.price)}</td>
                                            <td class="text-right">${formatter.format(item.total)}</td>
                                        </tr>`;
                            });
                            problemsHtml += `
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right">TOTAL ESTIMASI BIAYA</td>
                                            <td class="text-right">${formatter.format(totalRab)}</td>
                                        </tr>
                                    </tfoot>
                                </table>`;
                        }

                        problemsHtml += `</div>`;
                    });

                    problemsHtml += '</div>';

                    // --- Predictive Analysis Section ---
                    let predictiveHtml = `<div class="mt-6">
                        <h3 class="font-bold text-gray-800 text-base border-t pt-4 mt-4">Analisis Prediktif (Proyeksi 5 Tahun)</h3>
                        <div class="text-xs space-y-3 mt-2">`;

                    // Population Prediction
                    const growthRate = 0.015; // 1.5% annual growth
                    const futurePopulation = Math.round(demography.total * Math.pow((1 + growthRate), 5));
                    predictiveHtml += `
                        <div class="bg-blue-50 p-2 rounded-lg">
                            <p><strong><i class="fa-solid fa-arrow-trend-up text-blue-600 w-4"></i> Proyeksi Populasi:</strong> Dengan laju pertumbuhan 1.5% per tahun, penduduk desa diperkirakan akan mencapai <strong>${futurePopulation.toLocaleString('id-ID')} jiwa</strong> dalam 5 tahun, menuntut peningkatan layanan dasar.</p>
                        </div>`;

                    // Predictive insights based on identified problems
                    if (problems.some(p => p.id === 'stunting')) {
                        predictiveHtml += `
                         <div class="bg-amber-50 p-2 rounded-lg">
                             <p><strong><i class="fa-solid fa-triangle-exclamation text-amber-600 w-4"></i> Prediksi Risiko Stunting:</strong> Tanpa intervensi sesuai rekomendasi, jumlah kasus stunting berpotensi meningkat 10-15% per tahun. Implementasi program PMT dapat menekan angka hingga di bawah 10 kasus dalam 1 tahun.</p>
                         </div>`;
                    }
                    if (problems.some(p => p.id === 'badRoads')) {
                        predictiveHtml += `
                         <div class="bg-red-50 p-2 rounded-lg">
                              <p><strong><i class="fa-solid fa-road-circle-exclamation text-red-600 w-4"></i> Dampak Ekonomi Infrastruktur:</strong> Jika jalan rusak tidak ditangani, biaya perbaikan dalam 5 tahun bisa meningkat hingga 50% karena kerusakan lebih parah, dan dapat menghambat pertumbuhan ekonomi lokal sebesar 2-3% per tahun.</p>
                         </div>`;
                    }
                    if (problems.some(p => p.id === 'apbdes')) {
                        const potentialLoss = (apbdes.pendapatan.total - apbdes.belanja.total) * 5;
                        predictiveHtml += `
                         <div class="bg-yellow-50 p-2 rounded-lg">
                             <p><strong><i class="fa-solid fa-wallet text-yellow-600 w-4"></i> Potensi Keuangan Desa:</strong> SILPA yang tinggi secara konsisten berpotensi menghilangkan kesempatan akselerasi pembangunan senilai ~<strong>${formatter.format(potentialLoss)}</strong> dalam 5 tahun ke depan.</p>
                         </div>`;
                    }
                    if (problems.some(p => p.id === 'pbb')) {
                        const potentialLoss = (pbb.target - pbb.realisasi) * 5;
                        predictiveHtml += `
                         <div class="bg-indigo-50 p-2 rounded-lg">
                             <p><strong><i class="fa-solid fa-money-bill-trend-up text-indigo-600 w-4"></i> Proyeksi PADes:</strong> Jika tren realisasi PBB tidak membaik, desa berisiko kehilangan potensi pendapatan hingga <strong>${formatter.format(potentialLoss)}</strong> dalam 5 tahun, membatasi kemampuan untuk program mandiri.</p>
                         </div>`;
                    }

                    predictiveHtml += `</div></div>`;

                    return { problemsHtml: problemsHtml + predictiveHtml, summaryHtml: summaryHtml, problems: problems };
                }

                function downloadAnalysisReport(problems, data) {
                    const { jsPDF } = window.jspdf;
                    const doc = new jsPDF();
                    const pageWidth = doc.internal.pageSize.getWidth();
                    const margin = 15;
                    let y = 20;

                    doc.setFont("helvetica", "bold");
                    doc.setFontSize(16);
                    doc.text("LAPORAN ANALISA KOMPREHENSIF DESA JERINGO", pageWidth / 2, y, { align: "center" });
                    y += 10;
                    const analysisDate = `Tanggal Laporan: ${new Date().toLocaleString('id-ID', { dateStyle: 'full', timeStyle: 'long' })}`;
                    doc.setFontSize(10);
                    doc.setFont("helvetica", "normal");
                    doc.text(analysisDate, pageWidth / 2, y, { align: "center" });
                    y += 15;

                    doc.setFont("helvetica", "bold");
                    doc.setFontSize(14);
                    doc.text("RINGKASAN KONDISI UMUM DESA", margin, y);
                    y += 8;

                    const addSummaryLine = (label, value) => {
                        doc.setFont("helvetica", "bold");
                        doc.setFontSize(9);
                        doc.text(label, margin, y);
                        doc.setFont("helvetica", "normal");
                        doc.text(value, margin + 60, y);
                        y += 6;
                    };

                    addSummaryLine("Kepala Desa:", data.profile.kepalaDesa);
                    addSummaryLine("Luas Wilayah:", data.profile.luasWilayah);
                    addSummaryLine("Total Penduduk:", `${data.demography.total.toLocaleString('id-ID')} Jiwa`);
                    addSummaryLine("Angkatan Kerja:", `${data.unemployment.totalWorkforce.toLocaleString('id-ID')} Orang`);
                    addSummaryLine("Tingkat Pengangguran:", `${((data.unemployment.unemployed / data.unemployment.totalWorkforce) * 100).toFixed(1)}%`);
                    y += 4;

                    doc.autoTable({
                        startY: y,
                        head: [['Anggaran Desa (APBDes)', '']],
                        body: [
                            ['Total Pendapatan', formatter.format(data.apbdes.pendapatan.total)],
                            ['Total Belanja', formatter.format(data.apbdes.belanja.total)],
                            ['Sisa Anggaran (SILPA)', formatter.format(data.apbdes.pendapatan.total - data.apbdes.belanja.total)]
                        ],
                        theme: 'grid', styles: { fontSize: 9 }, headStyles: { fillColor: [75, 85, 99], fontStyle: 'bold' },
                    });
                    y = doc.autoTable.previous.finalY + 5;

                    doc.autoTable({
                        startY: y,
                        head: [['Pajak Bumi & Bangunan (PBB)', '']],
                        body: [
                            ['Target', formatter.format(data.pbb.target)],
                            ['Realisasi', formatter.format(data.pbb.realisasi)],
                            ['Capaian', `${((data.pbb.realisasi / data.pbb.target) * 100).toFixed(0)}%`]
                        ],
                        theme: 'grid', styles: { fontSize: 9 }, headStyles: { fillColor: [75, 85, 99], fontStyle: 'bold' },
                    });
                    y = doc.autoTable.previous.finalY + 10;

                    const createTable = (title, head, bodyData) => {
                        if (y > 220) { doc.addPage(); y = 20; }
                        doc.setFont("helvetica", "bold");
                        doc.setFontSize(11);
                        doc.text(title, margin, y);
                        y += 6;
                        doc.autoTable({
                            startY: y, head: [head], body: bodyData, theme: 'striped',
                            headStyles: { fillColor: [75, 85, 99] }, styles: { fontSize: 8 }
                        });
                        y = doc.autoTable.previous.finalY + 10;
                    };

                    const religionBody = data.demography.religion.map(item => [item.name, item.total.toLocaleString('id-ID'), `${((item.total / data.demography.total) * 100).toFixed(2)}%`]);
                    createTable("Komposisi Agama", ["Agama", "Jumlah", "Persentase"], religionBody);

                    const educationBody = data.demography.education.map(item => [item.name, item.total.toLocaleString('id-ID'), `${((item.total / data.demography.total) * 100).toFixed(1)}%`]);
                    createTable("Tingkat Pendidikan", ["Tingkat", "Jumlah", "Persentase"], educationBody);

                    const totalPekerja = data.demography.occupation.reduce((sum, item) => sum + item.total, 0);
                    const occupationBody = data.demography.occupation.map(item => [item.name, item.total.toLocaleString('id-ID'), `${((item.total / totalPekerja) * 100).toFixed(1)}%`]);
                    createTable("Struktur Pekerjaan", ["Pekerjaan", "Jumlah", "Persentase"], occupationBody);

                    doc.addPage();
                    y = 20;

                    doc.setFont("helvetica", "bold");
                    doc.setFontSize(14);
                    doc.text("IDENTIFIKASI MASALAH & REKOMENDASI", margin, y);
                    y += 15;

                    problems.forEach((p, index) => {
                        if (y > 250) { doc.addPage(); y = 20; }

                        doc.setLineWidth(0.5);
                        doc.line(margin, y - 2, pageWidth - margin, y - 2);
                        y += 5;

                        doc.setFont("helvetica", "bold");
                        doc.setFontSize(12);
                        doc.text(`MASALAH #${index + 1}: ${p.name.toUpperCase()}`, margin, y);
                        y += 8;

                        const addSection = (title, text) => {
                            if (y > 270) { doc.addPage(); y = 20; }
                            doc.setFont("helvetica", "bold");
                            doc.setFontSize(10);
                            doc.text(title, margin, y);
                            doc.setFont("helvetica", "normal");
                            const lines = doc.splitTextToSize(text.replace(/(\d\.\s)/g, '- '), pageWidth - margin * 2);
                            doc.text(lines, margin, y + 5);
                            y += lines.length * 5 + 8;
                        };

                        addSection("Dampak:", p.impact);
                        addSection("Rencana Jangka Pendek:", p.shortTermAction);
                        addSection("Rencana Jangka Panjang:", p.longTermAction);
                        addSection("Pihak Terkait:", p.stakeholders);
                        addSection("Indikator Keberhasilan:", p.indicator);

                        if (p.rab && p.rab.length > 0) {
                            if (y > 220) { doc.addPage(); y = 20; }
                            doc.setFont("helvetica", "bold");
                            doc.text("Rencana Anggaran Biaya (RAB):", margin, y);
                            y += 6;

                            const tableBody = [];
                            let totalRab = 0;
                            p.rab.forEach(item => {
                                totalRab += item.total;
                                tableBody.push([
                                    item.item,
                                    `${item.qty} ${item.unit}`,
                                    formatter.format(item.price),
                                    formatter.format(item.total)
                                ]);
                            });
                            tableBody.push([
                                { content: 'TOTAL ESTIMASI BIAYA', colSpan: 3, styles: { halign: 'right', fontStyle: 'bold' } },
                                { content: formatter.format(totalRab), styles: { halign: 'right', fontStyle: 'bold' } }
                            ]);

                            doc.autoTable({
                                startY: y,
                                head: [['Uraian', 'Jumlah', 'Harga Satuan', 'Total']],
                                body: tableBody,
                                theme: 'grid',
                                headStyles: { fillColor: [22, 160, 133] },
                                footStyles: { fontStyle: 'bold', fillColor: [240, 240, 240] },
                                styles: { fontSize: 8 },
                                columnStyles: {
                                    2: { halign: 'right' },
                                    3: { halign: 'right' }
                                }
                            });
                            y = doc.autoTable.previous.finalY + 10;
                        }
                        y += 5;
                    });

                    doc.save(`analisa-komprehensif-desa-jeringo-${Date.now()}.pdf`);
                }

                const modal = document.getElementById('detail-modal');
                const modalTitle = document.getElementById('modal-title');
                const modalContent = document.getElementById('modal-content');
                const closeModalBtn = document.getElementById('modal-close');

                const dusunModal = document.getElementById('dusun-modal');
                const dusunModalClose = document.getElementById('dusun-modal-close');
                const dusunModalCancel = document.getElementById('dusun-modal-cancel');
                const dusunModalSave = document.getElementById('dusun-modal-save');
                const dusunAreaInfo = document.getElementById('dusun-area-info');
                const dusunNameSelect = document.getElementById('dusun-name-input');
                const kadusNameInput = document.getElementById('kadus-name-input');

                let tempLayer = null;
                let editingLayer = null;

                function showModal(title, content, imageUrl) {
                    modalTitle.textContent = title;
                    let fullContent = '';
                    if (imageUrl) {
                        fullContent += `<img src="${imageUrl}" alt="${title}" class="w-full h-48 object-cover rounded-lg mb-4">`;
                    }
                    fullContent += content;
                    modalContent.innerHTML = fullContent;
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modal.querySelector('.modal-container').classList.remove('scale-95');
                        modal.classList.remove('opacity-0');
                    }, 10);
                }

                function hideModal() {
                    modal.querySelector('.modal-container').classList.add('scale-95');
                    modal.classList.add('opacity-0');
                    setTimeout(() => modal.classList.add('hidden'), 300);
                }

                function showDusunModal(area, info = {}) {
                    const usedDusun = [];
                    drawnItems.eachLayer(layer => {
                        if (layer.options && layer.options.dusunInfo) {
                            if (editingLayer && layer._leaflet_id === editingLayer._leaflet_id) {
                                return;
                            }
                            usedDusun.push(layer.options.dusunInfo.dusunName);
                        }
                    });

                    dusunNameSelect.innerHTML = '';
                    Object.keys(dusunHeadData).forEach(dusunName => {
                        const option = document.createElement('option');
                        option.value = dusunName;
                        option.textContent = dusunName;
                        if (usedDusun.includes(dusunName)) {
                            option.disabled = true;
                        }
                        dusunNameSelect.appendChild(option);
                    });

                    dusunAreaInfo.textContent = area;
                    dusunNameSelect.value = info.dusunName || dusunNameSelect.querySelector('option:not(:disabled)')?.value || '';
                    kadusNameInput.value = info.kadusName || dusunHeadData[dusunNameSelect.value] || '';

                    dusunModal.classList.remove('hidden');
                    setTimeout(() => {
                        dusunModal.querySelector('.modal-container').classList.remove('scale-95');
                        dusunModal.classList.remove('opacity-0');
                    }, 10);
                }

                function hideDusunModal() {
                    dusunModal.querySelector('.modal-container').classList.add('scale-95');
                    dusunModal.classList.add('opacity-0');
                    setTimeout(() => {
                        dusunModal.classList.add('hidden');
                        tempLayer = null;
                        editingLayer = null;
                    }, 300);
                }

                dusunModalSave.addEventListener('click', () => {
                    if (tempLayer) {
                        const selectedDusunName = dusunNameSelect.value;
                        const demoData = dusunDemoData[selectedDusunName] || {
                            penduduk: { total: 0, pria: 0, wanita: 0 },
                            agama: { islam: 0, hindu: 0, kristen: 0 },
                            pbb: { target: 0, realisasi: 0 },
                            jalan: { bagus: 0, rusak: 0 }
                        };

                        const dusunInfo = {
                            dusunName: selectedDusunName,
                            kadusName: kadusNameInput.value,
                            areaInfo: dusunAreaInfo.textContent,
                            penduduk: demoData.penduduk,
                            agama: demoData.agama,
                            pbb: demoData.pbb,
                            jalan: demoData.jalan
                        };

                        tempLayer.options.dusunInfo = dusunInfo;
                        tempLayer.bindPopup(generateDusunPopupContent(tempLayer));
                        drawnItems.addLayer(tempLayer);

                        hideDusunModal();
                    }
                });

                // --- Consolidated Event Listeners & Modals ---
                closeModalBtn.addEventListener('click', hideModal);
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) hideModal();
                });

                dusunModalClose.addEventListener('click', hideDusunModal);
                dusunModalCancel.addEventListener('click', hideDusunModal);
                dusunNameSelect.addEventListener('change', () => {
                    const selectedDusun = dusunNameSelect.value;
                    kadusNameInput.value = dusunHeadData[selectedDusun] || '';
                });

                let lastAnalysisProblems = [];
                const analyzeBtn = document.getElementById('analyze-button');
                const analysisResultContainer = document.getElementById('analysis-result');
                const downloadBtn = document.getElementById('download-button');
                const toggleDrawPanelBtn = document.getElementById('toggle-draw-panel-button');
                const drawPanel = document.getElementById('draw-panel');
                const closeDrawPanelBtn = document.getElementById('close-draw-panel-button');
                const drawBoundaryBtn = document.getElementById('draw-boundary-icon');
                const drawDusunBoundaryBtn = document.getElementById('draw-dusun-boundary-icon');
                const drawGoodRoadBtn = document.getElementById('draw-good-road-icon');
                const drawBadRoadBtn = document.getElementById('draw-bad-road-icon');
                const drawAlleyRoadBtn = document.getElementById('draw-alley-road-icon');
                const clearDrawBtn = document.getElementById('clear-draw-button');
                const toggleAnalysisPanelBtn = document.getElementById('toggle-analysis-panel-button');
                const analysisPanel = document.getElementById('analysis-panel');
                const closeAnalysisPanelBtn = document.getElementById('close-analysis-panel-button');
                const toggleCctvBtn = document.getElementById('toggle-cctv-panel-button');
                const cctvPanel = document.getElementById('cctv-panel');
                const closeCctvPanelBtn = document.getElementById('close-cctv-panel-button');
                const cctvGrid = document.getElementById('cctv-grid');
                const toggleLivestreamBtn = document.getElementById('toggle-livestream-panel-button');
                const livestreamPanel = document.getElementById('livestream-panel');
                const closeLivestreamPanelBtn = document.getElementById('close-livestream-panel-button');
                const toggleFoodPriceBtn = document.getElementById('toggle-food-price-panel-button');
                const foodPricePanel = document.getElementById('food-price-panel');
                const closeFoodPricePanelBtn = document.getElementById('close-food-price-panel-button');
                const toggleAiLabBtn = document.getElementById('toggle-ai-lab-panel-button');
                const aiLabPanel = document.getElementById('ai-lab-panel');
                const closeAiLabBtn = document.getElementById('close-ai-lab-panel-button');
                const mediaUpload = document.getElementById('media-upload');
                const mediaPreviewContainer = document.getElementById('media-preview-container');
                const analyzeMediaBtn = document.getElementById('analyze-media-button');
                const aiLabResult = document.getElementById('ai-lab-result');
                const linkInput = document.getElementById('link-input');
                const analyzeLinkBtn = document.getElementById('analyze-link-button');


                const cctvFullscreenModal = document.getElementById('cctv-fullscreen-modal');
                const closeFullscreenCctvBtn = document.getElementById('close-fullscreen-cctv');
                const fullscreenCctvImage = document.getElementById('fullscreen-cctv-image');
                const fullscreenCctvTitle = document.getElementById('fullscreen-cctv-title');

                const toggleDisasterPanelBtn = document.getElementById('toggle-disaster-panel-button');
                const disasterPanel = document.getElementById('disaster-mitigation-panel');
                const closeDisasterPanelBtn = document.getElementById('close-disaster-panel-button');
                let earthquakeMarker = null;
                let lastEarthquakeTimestamp = null;


                let currentDrawer = null;

                function resetDrawPanel() {
                    if (currentDrawer) currentDrawer.disable();
                    currentDrawer = null;
                    drawPanel.classList.add('hidden');
                }

                function populateCctvPanel() {
                    cctvGrid.innerHTML = '';
                    villageData.cctvLocations.forEach(cctv => {
                        const feedHtml = `
                            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg flex flex-col relative group">
                                <img src="${cctv.streamUrl}" alt="CCTV ${cctv.name}" class="w-full h-auto object-cover">
                                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 p-2 transition-opacity duration-300">
                                    <p class="text-white text-sm font-semibold truncate">${cctv.name}</p>
                                </div>
                                <button class="fullscreen-cctv-btn absolute top-2 right-2 bg-black bg-opacity-50 text-white rounded-full h-8 w-8 flex items-center justify-center hover:bg-opacity-75 transition-all opacity-0 group-hover:opacity-100"
                                        data-stream-url="${cctv.streamUrl}"
                                        data-stream-name="${cctv.name}"
                                        title="Perbesar Layar">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                        `;
                        cctvGrid.insertAdjacentHTML('beforeend', feedHtml);
                    });
                }

                function populateFoodPrices() {
                    const stapleContainer = document.getElementById('staple-food-prices');
                    const vegetableContainer = document.getElementById('vegetable-prices');
                    stapleContainer.innerHTML = '';
                    vegetableContainer.innerHTML = '';

                    const createPriceRow = (item) => {
                        return `
                            <div class="flex justify-between items-center text-sm p-2 rounded-lg bg-gray-50">
                                <span>${item.name}</span>
                                <strong class="text-gray-800">${formatter.format(item.price)}<span class="text-xs font-normal text-gray-500">/${item.unit}</span></strong>
                            </div>
                        `;
                    };

                    villageData.foodPriceData.staples.forEach(item => {
                        stapleContainer.innerHTML += createPriceRow(item);
                    });

                    villageData.foodPriceData.vegetables.forEach(item => {
                        vegetableContainer.innerHTML += createPriceRow(item);
                    });
                }

                function openFullscreenCctv(url, name) {
                    fullscreenCctvImage.src = url;
                    fullscreenCctvTitle.textContent = name;
                    cctvFullscreenModal.classList.remove('hidden');
                    setTimeout(() => {
                        cctvFullscreenModal.querySelector('.modal-container').classList.remove('scale-95');
                        cctvFullscreenModal.classList.remove('opacity-0');
                    }, 10);
                }

                function closeFullscreenCctv() {
                    cctvFullscreenModal.querySelector('.modal-container').classList.add('scale-95');
                    cctvFullscreenModal.classList.add('opacity-0');
                    setTimeout(() => {
                        cctvFullscreenModal.classList.add('hidden');
                        fullscreenCctvImage.src = ""; // Clear src to stop loading
                    }, 300);
                }

                cctvGrid.addEventListener('click', function (e) {
                    const button = e.target.closest('.fullscreen-cctv-btn');
                    if (button) {
                        const url = button.dataset.streamUrl;
                        const name = button.dataset.streamName;
                        openFullscreenCctv(url, name);
                    }
                });

                closeFullscreenCctvBtn.addEventListener('click', closeFullscreenCctv);
                cctvFullscreenModal.addEventListener('click', (e) => {
                    if (e.target === cctvFullscreenModal) {
                        closeFullscreenCctv();
                    }
                });


                toggleAnalysisPanelBtn.addEventListener('click', () => {
                    analysisPanel.classList.toggle('hidden');
                    drawPanel.classList.add('hidden');
                    cctvPanel.classList.add('hidden');
                    livestreamPanel.classList.add('hidden');
                    disasterPanel.classList.add('hidden');
                    foodPricePanel.classList.add('hidden');
                    aiLabPanel.classList.add('hidden');
                });

                closeAnalysisPanelBtn.addEventListener('click', () => {
                    analysisPanel.classList.add('hidden');
                });

                toggleDrawPanelBtn.addEventListener('click', () => {
                    drawPanel.classList.toggle('hidden');
                    analysisPanel.classList.add('hidden');
                    cctvPanel.classList.add('hidden');
                    livestreamPanel.classList.add('hidden');
                    disasterPanel.classList.add('hidden');
                    foodPricePanel.classList.add('hidden');
                    aiLabPanel.classList.add('hidden');
                });

                closeDrawPanelBtn.addEventListener('click', () => {
                    drawPanel.classList.add('hidden');
                });

                toggleCctvBtn.addEventListener('click', () => {
                    cctvPanel.classList.toggle('hidden');
                    analysisPanel.classList.add('hidden');
                    drawPanel.classList.add('hidden');
                    livestreamPanel.classList.add('hidden');
                    disasterPanel.classList.add('hidden');
                    foodPricePanel.classList.add('hidden');
                    aiLabPanel.classList.add('hidden');
                    if (!cctvPanel.classList.contains('hidden')) {
                        populateCctvPanel();
                    }
                });

                closeCctvPanelBtn.addEventListener('click', () => {
                    cctvPanel.classList.add('hidden');
                });

                toggleLivestreamBtn.addEventListener('click', () => {
                    livestreamPanel.classList.toggle('hidden');
                    analysisPanel.classList.add('hidden');
                    drawPanel.classList.add('hidden');
                    cctvPanel.classList.add('hidden');
                    disasterPanel.classList.add('hidden');
                    foodPricePanel.classList.add('hidden');
                    aiLabPanel.classList.add('hidden');
                });
                closeLivestreamPanelBtn.addEventListener('click', () => {
                    livestreamPanel.classList.add('hidden');
                });

                toggleDisasterPanelBtn.addEventListener('click', () => {
                    disasterPanel.classList.toggle('hidden');
                    analysisPanel.classList.add('hidden');
                    drawPanel.classList.add('hidden');
                    cctvPanel.classList.add('hidden');
                    livestreamPanel.classList.add('hidden');
                    foodPricePanel.classList.add('hidden');
                    aiLabPanel.classList.add('hidden');
                    if (!disasterPanel.classList.contains('hidden')) {
                        toggleDisasterPanelBtn.classList.remove('animate-ping', 'bg-red-500', 'text-white');
                        toggleDisasterPanelBtn.classList.add('bg-white', 'text-gray-700');
                        fetchWeatherData();
                    }
                });
                closeDisasterPanelBtn.addEventListener('click', () => {
                    disasterPanel.classList.add('hidden');
                });

                toggleFoodPriceBtn.addEventListener('click', () => {
                    foodPricePanel.classList.toggle('hidden');
                    analysisPanel.classList.add('hidden');
                    drawPanel.classList.add('hidden');
                    cctvPanel.classList.add('hidden');
                    livestreamPanel.classList.add('hidden');
                    disasterPanel.classList.add('hidden');
                    aiLabPanel.classList.add('hidden');
                    if (!foodPricePanel.classList.contains('hidden')) {
                        populateFoodPrices();
                    }
                });
                closeFoodPricePanelBtn.addEventListener('click', () => {
                    foodPricePanel.classList.add('hidden');
                });

                toggleAiLabBtn.addEventListener('click', () => {
                    aiLabPanel.classList.toggle('hidden');
                    analysisPanel.classList.add('hidden');
                    drawPanel.classList.add('hidden');
                    cctvPanel.classList.add('hidden');
                    livestreamPanel.classList.add('hidden');
                    disasterPanel.classList.add('hidden');
                    foodPricePanel.classList.add('hidden');
                });
                closeAiLabBtn.addEventListener('click', () => {
                    aiLabPanel.classList.add('hidden');
                });


                map.on('popupopen', function (e) {
                    const btn = e.popup._container.querySelector('.view-cctv-btn');
                    if (btn) {
                        btn.addEventListener('click', () => {
                            cctvPanel.classList.remove('hidden');
                            analysisPanel.classList.add('hidden');
                            drawPanel.classList.add('hidden');
                            livestreamPanel.classList.add('hidden');
                            disasterPanel.classList.add('hidden');
                            foodPricePanel.classList.add('hidden');
                            aiLabPanel.classList.add('hidden');
                            populateCctvPanel();
                        });
                    }
                });

                mediaUpload.addEventListener('change', (event) => {
                    const file = event.target.files[0];
                    if (!file) {
                        mediaPreviewContainer.classList.add('hidden');
                        analyzeMediaBtn.disabled = true;
                        return;
                    }
                    linkInput.value = ''; // Clear link input
                    analyzeLinkBtn.disabled = true;
                    mediaPreviewContainer.innerHTML = ''; // Clear previous preview
                    mediaPreviewContainer.classList.remove('hidden');
                    analyzeMediaBtn.disabled = false;
                    aiLabResult.innerHTML = `<p class="text-center italic">Media siap untuk dianalisis.</p>`;


                    const reader = new FileReader();
                    reader.onload = function (e) {
                        if (file.type.startsWith('image/')) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'max-h-full max-w-full object-contain rounded';
                            mediaPreviewContainer.appendChild(img);
                        } else if (file.type.startsWith('video/')) {
                            const video = document.createElement('video');
                            video.src = e.target.result;
                            video.className = 'max-h-full max-w-full object-contain rounded';
                            video.controls = true;
                            mediaPreviewContainer.appendChild(video);
                        }
                    };
                    reader.readAsDataURL(file);
                });

                linkInput.addEventListener('input', () => {
                    if (linkInput.value.trim() !== '') {
                        analyzeLinkBtn.disabled = false;
                        mediaUpload.value = '';
                        mediaPreviewContainer.classList.add('hidden');
                        mediaPreviewContainer.innerHTML = '';
                        analyzeMediaBtn.disabled = true;
                        aiLabResult.innerHTML = `<p class="text-center italic">Tautan siap untuk dianalisis.</p>`;
                    } else {
                        analyzeLinkBtn.disabled = true;
                    }
                });


                analyzeMediaBtn.addEventListener('click', () => {
                    analyzeMediaBtn.disabled = true;
                    analyzeLinkBtn.disabled = true;
                    analyzeMediaBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin mr-2"></i> Menganalisa...`;
                    aiLabResult.innerHTML = `<p class="text-center italic text-blue-600">AI sedang memproses, mohon tunggu...</p>`;

                    setTimeout(() => {
                        const isHoax = Math.random() > 0.5; // 50% chance of being a hoax
                        const confidence = (Math.random() * (99 - 75) + 75).toFixed(2); // Confidence between 75% and 99%

                        let resultHtml = '';
                        if (isHoax) {
                            resultHtml = `
                                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                                  <p class="font-bold">Terdeteksi Potensi Manipulasi (Hoax)</p>
                                  <p>AI mendeteksi anomali pada metadata dan struktur piksel yang tidak konsisten. Tingkat keyakinan: <strong>${confidence}%</strong>.</p>
                                </div>
                            `;
                        } else {
                            resultHtml = `
                                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                                  <p class="font-bold">Media Tampak Asli</p>
                                  <p>AI tidak menemukan jejak manipulasi digital yang signifikan. Tingkat keyakinan: <strong>${confidence}%</strong>.</p>
                                </div>
                            `;
                        }
                        aiLabResult.innerHTML = resultHtml;
                        analyzeLinkBtn.disabled = linkInput.value.trim() === '';
                        analyzeMediaBtn.disabled = false;
                        analyzeMediaBtn.innerHTML = `<i class="fa-solid fa-microchip mr-2"></i> Analisa Ulang`;
                    }, 2500); // Simulate 2.5 seconds of analysis
                });

                analyzeLinkBtn.addEventListener('click', () => {
                    analyzeMediaBtn.disabled = true;
                    analyzeLinkBtn.disabled = true;
                    analyzeLinkBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin mr-2"></i> Menganalisa Tautan...`;
                    aiLabResult.innerHTML = `<p class="text-center italic text-blue-600">AI sedang memproses tautan, mohon tunggu...</p>`;

                    setTimeout(() => {
                        const isHoax = Math.random() > 0.5;
                        const confidence = (Math.random() * (98 - 70) + 70).toFixed(2);

                        let resultHtml = '';
                        if (isHoax) {
                            resultHtml = `
                                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                                  <p class="font-bold">Potensi Disinformasi Tinggi (Hoax)</p>
                                  <ul class="list-disc list-inside mt-2 text-sm">
                                    <li>Sumber tidak memiliki reputasi terverifikasi.</li>
                                    <li>Judul terindikasi clickbait.</li>
                                    <li>Gaya penulisan provokatif.</li>
                                  </ul>
                                   <p class="mt-2">Tingkat keyakinan: <strong>${confidence}%</strong>.</p>
                                </div>
                            `;
                        } else {
                            resultHtml = `
                                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                                  <p class="font-bold">Tautan Terpercaya</p>
                                  <ul class="list-disc list-inside mt-2 text-sm">
                                    <li>Sumber berasal dari media terverifikasi.</li>
                                    <li>Gaya penulisan netral dan berbasis data.</li>
                                  </ul>
                                   <p class="mt-2">Tingkat keyakinan: <strong>${confidence}%</strong>.</p>
                                </div>
                            `;
                        }
                        aiLabResult.innerHTML = resultHtml;

                        analyzeLinkBtn.disabled = false;
                        analyzeLinkBtn.innerHTML = `<i class="fa-solid fa-link mr-2"></i> Analisa Ulang Tautan`;
                        analyzeMediaBtn.disabled = mediaUpload.files.length === 0;
                    }, 2800); // Simulate 2.8 seconds of analysis
                });

                analyzeBtn.addEventListener('click', () => {
                    analyzeBtn.disabled = true;
                    analyzeBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin mr-2"></i> Menganalisa...`;
                    downloadBtn.classList.add('hidden');

                    setTimeout(() => {
                        const analysisResult = runOfflineAIAnalysis(villageData);
                        analysisResultContainer.innerHTML = analysisResult.summaryHtml + analysisResult.problemsHtml;
                        lastAnalysisProblems = analysisResult.problems;

                        analyzeBtn.disabled = false;
                        analyzeBtn.innerHTML = `<i class="fa-solid fa-brain mr-2"></i> Jalankan Analisa Ulang`;

                        if (lastAnalysisProblems.length > 0) {
                            downloadBtn.classList.remove('hidden');
                        }
                    }, 1500);
                });

                downloadBtn.addEventListener('click', () => {
                    downloadAnalysisReport(lastAnalysisProblems, villageData);
                });

                drawBoundaryBtn.addEventListener('click', () => {
                    if (currentDrawer) currentDrawer.disable();
                    currentDrawer = new L.Draw.Polygon(map, { shapeOptions: { color: '#1e3a8a', weight: 3, opacity: 0.7, fillColor: '#3b82f6', fillOpacity: 0.2 } });
                    currentDrawer.enable();
                });

                drawDusunBoundaryBtn.addEventListener('click', () => {
                    if (currentDrawer) currentDrawer.disable();
                    currentDrawer = new L.Draw.Polygon(map, { shapeOptions: { color: '#2563eb', fillColor: '#60a5fa', weight: 2, opacity: 0.8, fillOpacity: 0.2, dashArray: '5, 5' } });
                    currentDrawer.options.boundaryType = 'Dusun';
                    currentDrawer.enable();
                });

                drawGoodRoadBtn.addEventListener('click', () => {
                    if (currentDrawer) currentDrawer.disable();
                    currentDrawer = new L.Draw.Polyline(map, { shapeOptions: { color: '#22c55e', weight: 4, opacity: 0.8 } });
                    currentDrawer.options.roadStatus = 'Bagus';
                    currentDrawer.enable();
                });

                drawBadRoadBtn.addEventListener('click', () => {
                    if (currentDrawer) currentDrawer.disable();
                    currentDrawer = new L.Draw.Polyline(map, { shapeOptions: { color: '#ef4444', weight: 4, opacity: 0.8 } });
                    currentDrawer.options.roadStatus = 'Rusak';
                    currentDrawer.enable();
                });

                drawAlleyRoadBtn.addEventListener('click', () => {
                    if (currentDrawer) currentDrawer.disable();
                    currentDrawer = new L.Draw.Polyline(map, { shapeOptions: { color: '#f97316', weight: 3, opacity: 0.8, dashArray: '5, 5' } });
                    currentDrawer.options.roadStatus = 'Gang';
                    currentDrawer.enable();
                });

                clearDrawBtn.addEventListener('click', () => {
                    drawnItems.clearLayers();
                    updateRoadStats();
                });

                map.on(L.Draw.Event.CREATED, function (event) {
                    const layer = event.layer;
                    const type = event.layerType;
                    const isDusunBoundary = currentDrawer && currentDrawer.options.boundaryType === 'Dusun';

                    if (type === 'polygon' && isDusunBoundary) {
                        tempLayer = layer;
                        const latlngs = layer.toGeoJSON().geometry.coordinates[0].map(coord => ({ lat: coord[1], lng: coord[0] }));
                        const areaM2 = calculatePolygonArea(latlngs);
                        const areaInfoText = `${(areaM2 / 1000000).toFixed(3)} km² / ${(areaM2 / 10000).toFixed(2)} Ha`;
                        showDusunModal(areaInfoText);
                    } else if (type === 'polygon' && !isDusunBoundary) {
                        if (originalBoundary) map.removeLayer(originalBoundary);
                        const newGeoJSON = layer.toGeoJSON();
                        updateAreaFromGeoJSON(newGeoJSON);
                        layer.bindPopup(`<b>Batas Wilayah Baru</b><br>Luas Terukur: ${villageData.profile.luasWilayah.split(' ')[0]} km²`);
                        originalBoundary = layer.addTo(map);
                        populateDashboard();
                    } else if (type === 'polyline') {
                        const latlngs = layer.getLatLngs();
                        let totalDistance = 0;
                        for (let i = 0; i < latlngs.length - 1; i++) {
                            totalDistance += latlngs[i].distanceTo(latlngs[i + 1]);
                        }
                        layer.options.lengthKm = totalDistance / 1000;
                        layer.options.roadStatus = currentDrawer.options.roadStatus;
                        layer.bindPopup(`<b>Status Jalan:</b> ${layer.options.roadStatus}<br><b>Panjang:</b> ${layer.options.lengthKm.toFixed(2)} km`);
                        drawnItems.addLayer(layer);
                        updateRoadStats();
                    }
                    resetDrawPanel();
                });

                map.on('draw:drawstop', function () {
                    if (currentDrawer) currentDrawer.disable();
                });

                updateAreaFromGeoJSON(villageData.boundary);
                populateDashboard();
                const logoutButton = document.getElementById('logout-button');
                logoutButton.addEventListener('click', () => {
                    window.location.reload();
                });

                function getDistance(lat1, lon1, lat2, lon2) {
                    const R = 6371; // Radius of the Earth in km
                    const dLat = (lat2 - lat1) * Math.PI / 180;
                    const dLon = (lon2 - lon1) * Math.PI / 180;
                    const a =
                        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                        Math.sin(dLon / 2) * Math.sin(dLon / 2);
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                    const d = R * c; // Distance in km
                    return d.toFixed(1); // Return distance with one decimal place
                }

                async function fetchEarthquakeData() {
                    const earthquakeContainer = document.getElementById('earthquake-info');
                    const desaJeringoCoords = { lat: -8.53686, lon: 116.13239 };

                    try {
                        const response = await fetch('https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json');
                        const data = await response.json();
                        const eq = data.Infogempa.gempa;
                        const eqTimestamp = eq.DateTime;
                        const eqTime = new Date(eq.DateTime);
                        const now = new Date();
                        const timeDiff = now - eqTime;

                        if (timeDiff > 3600000) { // 1 hour in ms
                            earthquakeContainer.innerHTML = `<p class="text-center italic">Tidak ada gempa signifikan yang terdeteksi baru-baru ini.</p>`;
                            if (earthquakeMarker) {
                                map.removeLayer(earthquakeMarker);
                                earthquakeMarker = null;
                            }
                            toggleDisasterPanelBtn.classList.remove('animate-ping', 'bg-red-500', 'text-white');
                            toggleDisasterPanelBtn.classList.add('bg-white', 'text-gray-700');
                            lastEarthquakeTimestamp = null;
                            return;
                        }

                        const [lat, lon] = eq.Coordinates.split(',').map(Number);
                        const distance = getDistance(desaJeringoCoords.lat, desaJeringoCoords.lon, lat, lon);
                        const tsunamiPotential = eq.Potensi;
                        const tsunamiClass = tsunamiPotential.toLowerCase().includes('tidak') ? 'text-green-600' : 'text-red-600 animate-pulse';

                        earthquakeContainer.innerHTML = `
                            <div class="flex items-start space-x-3">
                                <div class="text-red-500 mt-1"><i class="fa-solid fa-house-crack fa-2x"></i></div>
                                <div>
                                    <p class="font-bold text-lg">${eq.Magnitude} SR</p>
                                    <p class="text-xs text-gray-600">${eq.Tanggal}, ${eq.Jam}</p>
                                    <p class="mt-2">${eq.Wilayah}</p>
                                    <p class="text-xs text-gray-500">Kedalaman: ${eq.Kedalaman}</p>
                                    <p class="text-xs text-gray-500">Jarak: <strong>${distance} km</strong> dari Desa Jeringo</p>
                                    <p class="text-sm font-bold mt-2 ${tsunamiClass}">${tsunamiPotential}</p>
                                    <button id="show-earthquake-btn" class="text-xs text-blue-600 hover:underline mt-1">Lihat di Peta</button>
                                </div>
                            </div>
                        `;

                        // Check if it's a new earthquake
                        if (lastEarthquakeTimestamp !== eqTimestamp) {
                            lastEarthquakeTimestamp = eqTimestamp;

                            toggleDisasterPanelBtn.classList.remove('bg-white', 'text-gray-700');
                            toggleDisasterPanelBtn.classList.add('animate-ping', 'bg-red-500', 'text-white');

                            const bounds = L.latLngBounds([
                                [desaJeringoCoords.lat, desaJeringoCoords.lon],
                                [lat, lon]
                            ]);
                            map.flyToBounds(bounds, { padding: [50, 50] });

                            if (earthquakeMarker) map.removeLayer(earthquakeMarker);
                            const eqIcon = L.divIcon({
                                html: `<div class="earthquake-pulse-container"><div class="earthquake-pulse"></div></div>`,
                                className: 'bg-transparent border-0',
                                iconSize: [30, 30],
                            });
                            earthquakeMarker = L.marker([lat, lon], { icon: eqIcon }).addTo(map)
                                .bindPopup(`<b>Gempa ${eq.Magnitude} SR</b><br>${eq.Wilayah}`).openPopup();
                        }

                        document.getElementById('show-earthquake-btn').addEventListener('click', () => {
                            const bounds = L.latLngBounds([
                                [desaJeringoCoords.lat, desaJeringoCoords.lon],
                                [lat, lon]
                            ]);
                            map.flyToBounds(bounds, { padding: [50, 50] });
                        });

                    } catch (error) {
                        earthquakeContainer.innerHTML = `<p class="text-center text-red-500">Gagal memuat data gempa.</p>`;
                        console.error("Error fetching earthquake data:", error);
                    }
                }

                async function fetchWeatherDataXMLFallback() {
                    const weatherContainer = document.getElementById('weather-info');
                    const weatherLocationTitle = document.querySelector('#weather-info-container h3');
                    try {
                        const response = await fetch('https://data.bmkg.go.id/DataMKG/DigitalForecast/DigitalForecast-NusaTenggaraBarat.xml');
                        const xmlString = await response.text();
                        const parser = new DOMParser();
                        const xmlDoc = parser.parseFromString(xmlString, "application/xml");
                        const areas = xmlDoc.getElementsByTagName('area');

                        let targetArea = null;
                        const areaDescriptions = ["Lombok Barat", "Mataram"];

                        for (const desc of areaDescriptions) {
                            for (let area of areas) {
                                if (area.getAttribute('description') === desc) {
                                    targetArea = area;
                                    break;
                                }
                            }
                            if (targetArea) break;
                        }

                        weatherLocationTitle.textContent = `Prakiraan Cuaca - ${targetArea ? targetArea.getAttribute('description') : 'Data Tidak Tersedia'}`;

                        const weatherIconMap = {
                            '0': { icon: 'fa-sun', color: 'text-yellow-500' }, '100': { icon: 'fa-sun', color: 'text-yellow-500' },
                            '1': { icon: 'fa-cloud-sun', color: 'text-gray-500' }, '101': { icon: 'fa-cloud-sun', color: 'text-gray-500' },
                            '2': { icon: 'fa-cloud-sun', color: 'text-gray-500' }, '102': { icon: 'fa-cloud-sun', color: 'text-gray-500' },
                            '3': { icon: 'fa-cloud', color: 'text-gray-400' }, '103': { icon: 'fa-cloud', color: 'text-gray-400' },
                            '4': { icon: 'fa-cloud', color: 'text-gray-500' }, '104': { icon: 'fa-cloud', color: 'text-gray-500' },
                            '45': { icon: 'fa-smog', color: 'text-gray-500' },
                            '60': { icon: 'fa-cloud-rain', color: 'text-blue-400' },
                            '61': { icon: 'fa-cloud-showers-heavy', color: 'text-blue-500' },
                            '63': { icon: 'fa-cloud-bolt', color: 'text-yellow-400' },
                            '95': { icon: 'fa-cloud-bolt', color: 'text-yellow-400' }, '97': { icon: 'fa-cloud-bolt', color: 'text-yellow-400' }
                        };

                        if (targetArea) {
                            const weatherParam = targetArea.querySelector('parameter[id="weather"]');
                            const tempParam = targetArea.querySelector('parameter[id="t"]');
                            const timeRanges = weatherParam.querySelectorAll('timerange');

                            let forecastHTML = '';

                            const current = timeRanges[0];
                            const weatherCode = current.querySelector('value').textContent;
                            const weatherInfo = weatherIconMap[weatherCode] || { icon: 'fa-question-circle', color: 'text-gray-500' };
                            const currentTemp = tempParam.querySelectorAll('timerange')[0].querySelector('value[unit="C"]').textContent;

                            forecastHTML += `
                                <div class="text-center mb-4">
                                    <i class="fa-solid ${weatherInfo.icon} ${weatherInfo.color} text-6xl"></i>
                                    <p class="text-4xl font-bold mt-2">${currentTemp}°C</p>
                                    <p class="text-gray-600">${current.getAttribute('h')} jam mendatang</p>
                                </div>
                                <h4 class="font-semibold text-sm mb-2 text-gray-700">Prakiraan Berikutnya:</h4>
                                <div class="weather-forecast-grid">
                            `;

                            for (let i = 1; i < 5 && i < timeRanges.length; i++) {
                                const fr = timeRanges[i];
                                const frTime = new Date(fr.getAttribute('datetime')).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                                const frCode = fr.querySelector('value').textContent;
                                const frWeather = weatherIconMap[frCode] || { icon: 'fa-question-circle', color: 'text-gray-500' };
                                const frTemp = tempParam.querySelectorAll('timerange')[i].querySelector('value[unit="C"]').textContent;

                                forecastHTML += `
                                    <div class="text-center bg-white p-2 rounded-lg">
                                        <p class="font-bold text-xs">${frTime}</p>
                                        <i class="fa-solid ${frWeather.icon} ${frWeather.color} text-2xl my-1"></i>
                                        <p class="text-sm font-semibold">${frTemp}°C</p>
                                    </div>
                                `;
                            }
                            forecastHTML += '</div>';
                            weatherContainer.innerHTML = forecastHTML;

                        } else {
                            weatherContainer.innerHTML = `<p class="text-center text-red-500">Data cuaca untuk Lombok Barat/Mataram tidak ditemukan.</p>`;
                        }

                    } catch (error) {
                        weatherContainer.innerHTML = `<p class="text-center text-red-500">Gagal memuat data cuaca.</p>`;
                        console.error("Error fetching weather data:", error);
                    }
                }

                async function fetchWeatherData() {
                    const weatherContainer = document.getElementById('weather-info');
                    const weatherLocationTitle = document.querySelector('#weather-info-container h3');
                    try {
                        // Using a CORS proxy
                        const response = await fetch(`https://api.allorigins.win/get?url=${encodeURIComponent('https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=52.01.09.2009')}`);
                        if (!response.ok) throw new Error('Network response was not ok.');

                        const jsonData = await response.json();
                        if (!jsonData.contents) throw new Error('Proxy could not fetch content.');

                        const data = JSON.parse(jsonData.contents);

                        if (!data || !Array.isArray(data) || data.length === 0 || !data[0].kodeCuaca) {
                            console.warn("Specific weather API failed or returned invalid data, using fallback.");
                            await fetchWeatherDataXMLFallback();
                            return;
                        }

                        weatherLocationTitle.textContent = 'Prakiraan Cuaca - Desa Jeringo';

                        const weatherIconMap = {
                            '0': { icon: 'fa-sun', color: 'text-yellow-500' }, '100': { icon: 'fa-sun', color: 'text-yellow-500' },
                            '1': { icon: 'fa-cloud-sun', color: 'text-gray-500' }, '101': { icon: 'fa-cloud-sun', color: 'text-gray-500' },
                            '2': { icon: 'fa-cloud-sun', color: 'text-gray-500' }, '102': { icon: 'fa-cloud-sun', color: 'text-gray-500' },
                            '3': { icon: 'fa-cloud', color: 'text-gray-400' }, '103': { icon: 'fa-cloud', color: 'text-gray-400' },
                            '4': { icon: 'fa-cloud', color: 'text-gray-500' }, '104': { icon: 'fa-cloud', color: 'text-gray-500' },
                            '45': { icon: 'fa-smog', color: 'text-gray-500' },
                            '60': { icon: 'fa-cloud-rain', color: 'text-blue-400' },
                            '61': { icon: 'fa-cloud-showers-heavy', color: 'text-blue-500' },
                            '63': { icon: 'fa-cloud-bolt', color: 'text-yellow-400' },
                            '95': { icon: 'fa-cloud-bolt', color: 'text-yellow-400' }, '97': { icon: 'fa-cloud-bolt', color: 'text-yellow-400' }
                        };

                        let forecastHTML = '';
                        const current = data[0];
                        const weatherCode = current.kodeCuaca;
                        const weatherInfo = weatherIconMap[weatherCode] || { icon: 'fa-question-circle', color: 'text-gray-500' };
                        const currentTemp = current.suhu.celsius;

                        const forecastTime = new Date(current.waktu);
                        const now = new Date();
                        const timeDiffHours = Math.round((forecastTime - now) / (1000 * 60 * 60));

                        forecastHTML += `
                            <div class="text-center mb-4">
                                <i class="fa-solid ${weatherInfo.icon} ${weatherInfo.color} text-6xl"></i>
                                <p class="text-4xl font-bold mt-2">${currentTemp}°C</p>
                                <p class="text-gray-600">${timeDiffHours <= 0 ? 'Saat Ini' : `${timeDiffHours} jam mendatang`}</p>
                            </div>
                            <h4 class="font-semibold text-sm mb-2 text-gray-700">Prakiraan Berikutnya:</h4>
                            <div class="weather-forecast-grid">
                        `;

                        for (let i = 1; i < 5 && i < data.length; i++) {
                            const fr = data[i];
                            const frTime = new Date(fr.waktu).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                            const frCode = fr.kodeCuaca;
                            const frWeather = weatherIconMap[frCode] || { icon: 'fa-question-circle', color: 'text-gray-500' };
                            const frTemp = fr.suhu.celsius;

                            forecastHTML += `
                                <div class="text-center bg-white p-2 rounded-lg">
                                    <p class="font-bold text-xs">${frTime}</p>
                                    <i class="fa-solid ${frWeather.icon} ${frWeather.color} text-2xl my-1"></i>
                                    <p class="text-sm font-semibold">${frTemp}°C</p>
                                </div>
                            `;
                        }
                        forecastHTML += '</div>';
                        weatherContainer.innerHTML = forecastHTML;

                    } catch (error) {
                        console.error("Error fetching specific weather data, trying fallback:", error);
                        await fetchWeatherDataXMLFallback();
                    }
                }


                // Initial data fetch
                fetchEarthquakeData();
                setInterval(fetchEarthquakeData, 60000); // Check for new earthquakes every 60 seconds
            }
        });

    </script>
</body>

</html>
