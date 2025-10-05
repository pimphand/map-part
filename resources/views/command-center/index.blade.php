@extends('command-center.layouts.app')

@section('title', 'Command Center - Dashboard Peta Desa Jeringo')

@section('content')
    <!-- Login Page -->
    @include('command-center.components.login')

    <div id="app-container" class="hidden h-screen flex flex-col">
        <!-- Header -->
        @include('command-center.components.header')

        <!-- Main Content -->
        <main class="flex-1 relative">
            <!-- Map Section -->
            <div class="absolute inset-0 z-0 w-full h-full" id="map"></div>

            <!-- Control Buttons -->
            @include('command-center.components.control-buttons')

            <!-- Panels -->
            @include('command-center.components.analysis-panel')
            @include('command-center.components.draw-panel')
            @include('command-center.components.cctv-panel')
            @include('command-center.components.livestream-panel')
            @include('command-center.components.disaster-panel')
            @include('command-center.components.food-price-panel')
            @include('command-center.components.ai-lab-panel')

            <!-- Dashboard Sidebar -->
            @include('command-center.components.dashboard-sidebar')
        </main>
    </div>

    <!-- Modals -->
    @include('command-center.components.modals')
@endsection

@push('scripts')
    <script>
        // --- DATA DESA JERINGO (Data dari API) ---
        let villageData = {
            profile: { kepalaDesa: "Sahril, SH", luasWilayah: "Menghitung...", fotoUrl: "https://awsimages.detik.net.id/community/media/visual/2024/05/04/ketua-papdesi-ntb_169.jpeg?w=500&q=90" },
            demography: {
                total: 0,
                pria: 0,
                wanita: 0
            },
            unemployment: {
                totalWorkforce: 1743,
                unemployed: 140
            },
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

        // Function to load data from API and update villageData

        // Data stack for managing data updates
        const dataStack = {
            stack: [],
            isInitialized: false,
            push: function (data) {
                this.stack.push(data);
                this.processStack();
            },
            processStack: function () {
                if (this.stack.length > 0) {
                    const data = this.stack.pop();
                    this.updateDashboard(data);
                }
            },
            updateDashboard: function (data) {
                // Update the global villageData with new data
                Object.assign(villageData, data);

                // Call the existing populateDashboard function if it exists
                if (typeof populateDashboard === 'function') {
                    populateDashboard();
                } else {
                    // Fallback: wait for the function to be available
                    this.waitForPopulateDashboard();
                }
            },
            waitForPopulateDashboard: function () {
                const self = this;
                const checkInterval = setInterval(() => {
                    if (typeof populateDashboard === 'function') {
                        clearInterval(checkInterval);
                        populateDashboard();
                    }
                }, 100);

                // Timeout after 5 seconds
                setTimeout(() => {
                    clearInterval(checkInterval);
                }, 1000);
            }
        };

        // Function to push data to stack
        function pushDataToStack() {
            const updatedData = {
                demography: villageData.demography
            };
            dataStack.push(updatedData);
        }

        // Helper functions for styling
        function getGenerationColor(label) {
            const colors = {
                'Gen Z & Alpha (0-28 th)': 'bg-teal-500',
                'Milenial (29-44 th)': 'bg-sky-500',
                'Gen X (45-60 th)': 'bg-indigo-500',
                'Baby Boomer (61-79 th)': 'bg-purple-500',
                'Pre-Boomer (80+ th)': 'bg-slate-500'
            };
            return colors[label] || 'bg-gray-500';
        }

        function getGenerationIcon(label) {
            const icons = {
                'Gen Z & Alpha (0-28 th)': 'fa-solid fa-child',
                'Milenial (29-44 th)': 'fa-solid fa-mobile-screen-button',
                'Gen X (45-60 th)': 'fa-solid fa-user-tie',
                'Baby Boomer (61-79 th)': 'fa-solid fa-person-cane',
                'Pre-Boomer (80+ th)': 'fa-solid fa-person-walking-with-cane'
            };
            return icons[label] || 'fa-solid fa-user';
        }

        function getEducationColor(label) {
            const colors = {
                'Tidak/Belum Sekolah': 'bg-red-500',
                'SD/Sederajat': 'bg-orange-500',
                'SMP/Sederajat': 'bg-yellow-500',
                'SMA/Sederajat': 'bg-green-500',
                'Perguruan Tinggi': 'bg-blue-500'
            };
            return colors[label] || 'bg-gray-500';
        }

        function getReligionColor(label) {
            const colors = {
                'Islam': 'text-green-500',
                'Hindu': 'text-orange-500',
                'Kristen': 'text-blue-500',
                'Katolik': 'text-blue-500',
                'Buddha': 'text-yellow-500',
                'Konghucu': 'text-red-500',
                'Lainnya': 'text-gray-500'
            };
            return colors[label] || 'text-gray-500';
        }

        function getReligionBgColor(label) {
            const colors = {
                'Islam': 'bg-green-50',
                'Hindu': 'bg-orange-50',
                'Kristen': 'bg-blue-50',
                'Katolik': 'bg-blue-50',
                'Buddha': 'bg-yellow-50',
                'Konghucu': 'bg-red-50',
                'Lainnya': 'bg-gray-50'
            };
            return colors[label] || 'bg-gray-50';
        }

        function getOccupationColor(label) {
            const colors = {
                'Petani': 'text-green-600',
                'Pedagang': 'text-blue-600',
                'PNS/TNI/Polri': 'text-indigo-600',
                'Karyawan Swasta': 'text-purple-600',
                'Wiraswasta': 'text-orange-600',
                'Guru': 'text-pink-600',
                'Dokter': 'text-red-600',
                'Perawat': 'text-red-500',
                'Sopir': 'text-cyan-600',
                'Tukang': 'text-amber-600',
                'Buruh': 'text-slate-600',
                'Lainnya': 'text-gray-600'
            };
            return colors[label] || 'text-gray-600';
        }

        function getOccupationBgColor(label) {
            const colors = {
                'Petani': 'bg-green-50',
                'Pedagang': 'bg-blue-50',
                'PNS/TNI/Polri': 'bg-indigo-50',
                'Karyawan Swasta': 'bg-purple-50',
                'Wiraswasta': 'bg-orange-50',
                'Guru': 'bg-pink-50',
                'Dokter': 'bg-red-50',
                'Perawat': 'bg-red-50',
                'Sopir': 'bg-cyan-50',
                'Tukang': 'bg-amber-50',
                'Buruh': 'bg-slate-50',
                'Lainnya': 'bg-gray-50'
            };
            return colors[label] || 'bg-gray-50';
        }

        // Load data when page loads and initialize stack
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize data stack globally
            window.dataStack = dataStack;

            // Load data from API
            // loadVillageData();
        });
    </script>
    <script src="{{ asset('command/js/command-center.js') }}"></script>
    <script src="{{ asset('command/js/draw-panel.js') }}"></script>
@endpush
