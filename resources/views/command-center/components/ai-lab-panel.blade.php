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
