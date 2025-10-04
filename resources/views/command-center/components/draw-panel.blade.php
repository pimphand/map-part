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
