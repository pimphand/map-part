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
