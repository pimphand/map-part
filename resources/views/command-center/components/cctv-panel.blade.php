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
