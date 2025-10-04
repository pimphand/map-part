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

        // Initialize all event listeners and functionality
        initializeEventListeners(map, drawnItems, originalBoundary, updateAreaFromGeoJSON);

        updateAreaFromGeoJSON(villageData.boundary);

        // Check if data stack is available and has data, otherwise use default data
        if (window.dataStack && window.dataStack.stack.length > 0) {
            // Data will be populated by the stack
            console.log('Data stack initialized, waiting for API data...');
        } else {
            // Use default data
            populateDashboard();
        }

        const logoutButton = document.getElementById('logout-button');
        logoutButton.addEventListener('click', () => {
            window.location.reload();
        });
    }

    function initializeEventListeners(map, drawnItems, originalBoundary, updateAreaFromGeoJSON) {
        // This function contains all the event listeners and panel functionality
        // It's a simplified version - you can expand this with the full functionality from the original file

        const toggleAnalysisPanelBtn = document.getElementById('toggle-analysis-panel-button');
        const analysisPanel = document.getElementById('analysis-panel');
        const closeAnalysisPanelBtn = document.getElementById('close-analysis-panel-button');

        toggleAnalysisPanelBtn.addEventListener('click', () => {
            analysisPanel.classList.toggle('hidden');
        });

        closeAnalysisPanelBtn.addEventListener('click', () => {
            analysisPanel.classList.add('hidden');
        });

        // Add other event listeners here...
        // This is a simplified version - you would include all the functionality from the original file
    }

    // Modal functions
    function showModal(title, content, imageUrl) {
        const modal = document.getElementById('detail-modal');
        const modalTitle = document.getElementById('modal-title');
        const modalContent = document.getElementById('modal-content');

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
        const modal = document.getElementById('detail-modal');
        modal.querySelector('.modal-container').classList.add('scale-95');
        modal.classList.add('opacity-0');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    // Modal event listeners
    const modal = document.getElementById('detail-modal');
    const closeModalBtn = document.getElementById('modal-close');

    closeModalBtn.addEventListener('click', hideModal);
    modal.addEventListener('click', (e) => {
        if (e.target === modal) hideModal();
    });
});
