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
