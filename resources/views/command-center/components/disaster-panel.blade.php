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
