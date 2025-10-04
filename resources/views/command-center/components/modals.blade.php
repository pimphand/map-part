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
            <button id="dusun-modal-close" class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
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
