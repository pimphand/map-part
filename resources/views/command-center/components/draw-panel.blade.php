<!-- Drawing Tools Panel -->
<div id="draw-panel"
    class="absolute top-4 left-20 z-20 bg-white/80 backdrop-blur-sm p-5 rounded-xl shadow-2xl w-full max-w-sm hidden">

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            <i class="fa-solid fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <i class="fa-solid fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <i class="fa-solid fa-exclamation-circle mr-2"></i>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
    <div class="space-y-2">
        <button id="refresh-data-maps-button"
            class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center shadow-md text-sm">
            <i class="fa-solid fa-refresh mr-2"></i> Muat Ulang Data Peta
        </button>
        <button id="clear-draw-button"
            class="w-full bg-gray-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-300 flex items-center justify-center shadow-md text-sm">
            <i class="fa-solid fa-trash mr-2"></i> Bersihkan Semua Gambar
        </button>
    </div>
</div>

<!-- Point Creation Modal -->
<div id="point-modal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-700">Tambah Titik Baru</h3>
            <button id="close-point-modal" class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
        </div>

        <!-- Legend Peta -->
        <div class="mb-4">
            <h4 class="text-sm font-semibold text-gray-600 mb-2">Legenda Peta</h4>
            <div id="legenda-peta" class="space-y-2 text-sm bg-gray-50 p-3 rounded-lg">
                <div class="flex items-center"><i class="fa-solid fa-landmark w-5 text-center "
                        style="color:blue"></i><span class="icon-label">Pemerintahan</span></div>
                <div class="flex items-center"><i class="fa-solid fa-school w-5 text-center "
                        style="color:orange"></i><span class="icon-label">Pendidikan</span></div>
                <div class="flex items-center"><i class="fa-solid fa-briefcase-medical w-5 text-center "
                        style="color:red"></i><span class="icon-label">Kesehatan</span></div>
                <div class="flex items-center"><i class="fa-solid fa-mosque w-5 text-center "
                        style="color:green"></i><span class="icon-label">Ibadah</span></div>
                <div class="flex items-center"><i class="fa-solid fa-water w-5 text-center "
                        style="color:purple"></i><span class="icon-label">Wisata</span></div>
                <div class="flex items-center"><i class="fa-solid fa-child-reaching w-5 text-center "
                        style="color:var(--color-amber-500)"></i><span class="icon-label">Stunting</span></div>
                <div class="flex items-center"><i class="fa-solid fa-house-crack w-5 text-center "
                        style="color:var(--color-stone-500)"></i><span class="icon-label">Rumah Tdk Layak</span></div>
                <div class="flex items-center"><i class="fa-solid fa-person-cane w-5 text-center "
                        style="color:var(--color-sky-500)"></i><span class="icon-label">Lansia</span></div>
                <div class="flex items-center"><i class="fa-solid fa-hands-holding-child w-5 text-center "
                        style="color:var(--color-teal-500)"></i><span class="icon-label">Anak Yatim</span></div>
                <div class="flex items-center"><i class="fa-solid fa-video w-5 text-center "
                        style="color:#4b5563"></i><span class="icon-label">CCTV</span></div>
            </div>
        </div>

        <!-- Dynamic Input Form -->
        <form id="point-form" class="space-y-4" action="/api/data-maps" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Hidden fields for coordinates -->
            <input type="hidden" id="point-lat" name="lat" value="">
            <input type="hidden" id="point-lng" name="lng" value="">
            <input type="hidden" id="point-judul" name="judul" value="">

            <div>
                <label for="point-type" class="block text-sm font-medium text-gray-700 mb-2">Type:</label>
                <select id="point-type" name="type"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required>
                    <option value="">Pilih Type</option>
                    <option value="pemerintahan" data-icon="fa-landmark" data-color="blue">Pemerintahan</option>
                    <option value="pendidikan" data-icon="fa-school" data-color="orange">Pendidikan</option>
                    <option value="kesehatan" data-icon="fa-briefcase-medical" data-color="red">Kesehatan</option>
                    <option value="ibadah" data-icon="fa-mosque" data-color="green">Ibadah</option>
                    <option value="wisata" data-icon="fa-water" data-color="purple">Wisata</option>
                    <option value="stunting" data-icon="fa-child-reaching" data-color="var(--color-amber-500)">Stunting
                    </option>
                    <option value="rumah_tdk_layak" data-icon="fa-house-crack" data-color="var(--color-stone-500)">Rumah
                        Tdk Layak</option>
                    <option value="lansia" data-icon="fa-person-cane" data-color="var(--color-sky-500)">Lansia</option>
                    <option value="anak_yatim" data-icon="fa-hands-holding-child" data-color="var(--color-teal-500)">
                        Anak Yatim</option>
                    <option value="cctv" data-icon="fa-video" data-color="#4b5563">CCTV</option>
                </select>
            </div>

            <div>
                <label for="point-name" class="block text-sm font-medium text-gray-700 mb-2">Nama:</label>
                <input type="text" id="point-name" name="name"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan nama titik" required>
            </div>

            <div>
                <label for="point-name" class="block text-sm font-medium text-gray-700 mb-2">Gambar:</label>
                <input type="file" id="point-image" name="gambar"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan gambar titik" required>
            </div>

            <div>
                <label for="point-description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi:</label>
                <textarea id="point-description" name="description" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan deskripsi (opsional)"></textarea>
            </div>

            {{-- Dynamic Code-Value Inputs --}}
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-medium text-gray-700">Data Tambahan:</label>
                    <button type="button" id="add-code-value-btn"
                        class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                        <i class="fa-solid fa-plus mr-1"></i> Tambah Data
                    </button>
                </div>
                <div id="code-value-container" class="space-y-2">
                    <!-- Dynamic inputs will be added here -->
                </div>
            </div>

            <div class="flex space-x-2 pt-4">
                <button type="submit"
                    class="flex-1 bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
                    <i class="fa-solid fa-map-pin mr-2"></i> Tambah Titik
                </button>
                <button type="button" id="cancel-point-btn"
                    class="flex-1 bg-gray-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-600 transition duration-300">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        // Toggle draw panel button
        document.addEventListener('DOMContentLoaded', function () {
            const toggleDrawPanelBtn = document.getElementById('toggle-draw-panel-button');
            if (toggleDrawPanelBtn) {
                toggleDrawPanelBtn.addEventListener('click', () => {
                    const drawPanel = document.getElementById('draw-panel');
                    if (drawPanel) {
                        drawPanel.classList.toggle('hidden');
                    }
                });
            }
        });
    </script>
@endpush
