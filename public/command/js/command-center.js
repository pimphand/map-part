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

        let originalBoundary = L.geoJSON(villageData.boundary, { style: f => f.properties.style }).bindPopup("<h3>Batas Wilayah Desa Jeringo</h3> <button id='add-pointer-popup-btn' class='bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded shadow-lg text-xs' title='Tambah Titik'><i class='fa-solid fa-plus mr-1'></i> Tambah Titik</button>").addTo(map);

        // Add click handler to original boundary polygon to capture coordinates
        originalBoundary.on('click', (e) => {
            console.log('Original boundary polygon clicked, coordinates:', e.latlng);
            window.lastClickedCoordinates = e.latlng;
            tempCoordinates = e.latlng;
            // Don't prevent default to allow other click handlers to work
        });
        console.log('originalBoundary :' + originalBoundary);

        let drawnItems = new L.FeatureGroup().addTo(map);

        // Add pointer functionality
        let addPointerMode = false;
        let tempCoordinates = null;
        // Add pointer button event listener
        document.addEventListener('click', (e) => {
            if (e.target.closest('#add-pointer-btn') || e.target.closest('#add-pointer-popup-btn')) {
                e.preventDefault();
                e.stopPropagation();
                // Langsung buka modal tanpa mode klik peta
                showPointModal();
            }
        });

        // Unified click handler to ensure coordinates are captured in all scenarios
        map.on('click', (e) => {
            // Always store coordinates globally for any modal that might need them
            window.lastClickedCoordinates = e.latlng;
            tempCoordinates = e.latlng;
            console.log('Unified click handler - coordinates stored:', e.latlng);

            // Check if modal is open and fill coordinates automatically
            const modal = document.getElementById('point-modal');
            if (modal && !modal.classList.contains('hidden')) {
                setTimeout(() => {
                    const latInput = document.getElementById('point-latitude');
                    const lngInput = document.getElementById('point-longitude');

                    if (latInput && lngInput) {
                        latInput.value = e.latlng.lat.toFixed(13);
                        lngInput.value = e.latlng.lng.toFixed(13);
                        console.log('Coordinates auto-filled in modal:', e.latlng.lat, e.latlng.lng);
                    }
                }, 50);
            }
        });

        function enableAddPointerMode() {
            addPointerMode = true;
            const button = document.getElementById('add-pointer-btn');
            if (button) {
                button.style.background = '#10b981';
                button.innerHTML = '<i class="fa-solid fa-crosshairs" style="margin-right: 5px;"></i> Click on Map';
            }

            // Close any open popups
            map.closePopup();

        }


        function showPointModal() {
            const modal = document.getElementById('point-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                // Tambahkan input koordinat manual jika belum ada
                addCoordinateInputs();

                // Isi koordinat jika ada tempCoordinates atau global coordinates
                const coordinates = tempCoordinates || window.lastClickedCoordinates;
                if (coordinates) {
                    setTimeout(() => {
                        const latInput = document.getElementById('point-latitude');
                        const lngInput = document.getElementById('point-longitude');

                        if (latInput && lngInput) {
                            latInput.value = coordinates.lat.toFixed(13);
                            lngInput.value = coordinates.lng.toFixed(13);
                            console.log('Coordinates auto-filled from map click:', coordinates);
                        }
                    }, 100);
                } else {
                    console.log('No coordinates available to auto-fill');
                }

                console.log('Point modal shown');
            } else {
                console.error('Point modal not found');
            }
        }

        function addCoordinateInputs() {
            // Cek apakah input koordinat sudah ada
            let latInput = document.getElementById('point-latitude');
            let lngInput = document.getElementById('point-longitude');

            if (!latInput || !lngInput) {
                // Tambahkan input koordinat ke form
                const form = document.getElementById('point-form');
                if (form) {
                    // Cari elemen terakhir sebelum tombol
                    const buttonContainer = form.querySelector('.flex.space-x-2.pt-4');
                    if (buttonContainer) {
                        // Buat container untuk input koordinat
                        const coordContainer = document.createElement('div');
                        coordContainer.className = 'grid grid-cols-2 gap-4';
                        coordContainer.innerHTML = `
                            <div class="hidden">
                                <label for="point-latitude" class="block text-sm font-medium text-gray-700 mb-2">Latitude:</label>
                                <input type="number" id="point-latitude" name="latitude" step="any"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Masukkan latitude">
                            </div>
                            <div class="hidden">
                                <label for="point-longitude" class="block text-sm font-medium text-gray-700 mb-2">Longitude:</label>
                                <input type="number" id="point-longitude" name="longitude" step="any"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Masukkan longitude">
                            </div>
                        `;

                        // Insert sebelum button container
                        buttonContainer.parentNode.insertBefore(coordContainer, buttonContainer);
                        console.log('Coordinate inputs added to form');
                    }
                }
            }
        }

        function hidePointModal() {
            const modal = document.getElementById('point-modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                // Reset form
                const form = document.getElementById('point-form');
                if (form) {
                    form.reset();
                }
            }
            // Reset button state
            const button = document.getElementById('add-pointer-btn');
            if (button) {
                button.style.background = '#3b82f6';
                button.innerHTML = '<i class="fa-solid fa-plus" style="margin-right: 5px;"></i> Tambah Titik';
            }
            addPointerMode = false;
            tempCoordinates = null;
        }

        // Point modal event listeners
        document.addEventListener('click', (e) => {
            // Close modal button
            if (e.target.closest('#close-point-modal')) {
                e.preventDefault();
                hidePointModal();
            }

            // Cancel button
            if (e.target.closest('#cancel-point-btn')) {
                e.preventDefault();
                hidePointModal();
            }
        });


        const legendItems = {};

        const createCustomIcon = (iconClass, markerColor) => L.divIcon({ html: `<i class="${iconClass} fa-2x" style="color: ${markerColor};"></i>`, className: 'bg-transparent border-0', iconSize: [24, 24], iconAnchor: [12, 24], popupAnchor: [0, -24] });

        // Function to load map data from API
        async function loadMapDataFromAPI(map, legendItems) {
            try {
                const response = await fetch('/api/data-maps');
                const result = await response.json();

                if (result.success && result.data) {
                    console.log('API data loaded:', result.data);

                    // Peta kategori ke ikon dan warna (sesuai dengan legenda HTML)
                    const categoryMapping = {
                        'pemerintahan': { icon: 'fa-solid fa-landmark', color: 'blue' },
                        'pendidikan': { icon: 'fa-solid fa-school', color: 'orange' },
                        'kesehatan': { icon: 'fa-solid fa-briefcase-medical', color: 'red' },
                        'ibadah': { icon: 'fa-solid fa-mosque', color: 'green' },
                        'wisata': { icon: 'fa-solid fa-water', color: 'purple' },
                        'stunting': { icon: 'fa-solid fa-child-reaching', color: 'var(--color-amber-500)' },
                        'rumah_tdk_layak': { icon: 'fa-solid fa-house-crack', color: 'var(--color-stone-500)' },
                        'lansia': { icon: 'fa-solid fa-person-cane', color: 'var(--color-sky-500)' },
                        'anak_yatim': { icon: 'fa-solid fa-hands-holding-child', color: 'var(--color-teal-500)' },
                        'CCTV': { icon: 'fa-solid fa-video', color: '#4b5563' }
                    };

                    // Buat marker berdasarkan data API
                    result.data.forEach(item => {
                        let iconClass = 'fa-solid fa-map-marker-alt';
                        let markerColor = '#3b82f6'; // Default jika tidak cocok kategori

                        if (item.kategori && categoryMapping[item.kategori]) {
                            iconClass = categoryMapping[item.kategori].icon;
                            markerColor = categoryMapping[item.kategori].color;
                        }

                        const customIcon = createCustomIcon(iconClass, markerColor);
                        const marker = L.marker([parseFloat(item.lat), parseFloat(item.lng)], { icon: customIcon }).addTo(map);

                        // Popup sederhana
                        let popupContent = `<div class="popup-title">${item.judul}</div>`;
                        if (item.kategori) {
                            popupContent += `<span class="popup-category" style="background-color:${markerColor};">${item.kategori}</span>`;
                        }
                        if (item.keterangan) {
                            popupContent += `<div class="mt-2 text-sm text-gray-600">${item.keterangan}</div>`;
                        }
                        if (item.gambar_url) {
                            popupContent += `<div class="mt-2"><img src="${item.gambar_url}" alt="${item.judul}" class="w-full h-32 object-cover rounded"></div>`;
                        }

                        marker.bindPopup(popupContent);

                        // Klik marker → tampilkan modal detail
                        marker.on('click', () => {
                            let contentHtml = '<div class="space-y-2">';
                            contentHtml += `<div class="flex border-b pb-1"><strong class="w-1/3 text-gray-500">Judul</strong><span class="w-2/3">${item.judul}</span></div>`;

                            if (item.kategori) {
                                // Ubah kategori jadi huruf besar di awal tiap kata
                                const formattedKategori = item.kategori
                                    .replace(/_/g, ' ') // ubah underscore jadi spasi
                                    .replace(/\b\w/g, char => char.toUpperCase()); // kapital tiap kata

                                contentHtml += `<div class="flex border-b pb-1">
                                    <strong class="w-1/3 text-gray-500">Kategori</strong>
                                    <span class="w-2/3">${formattedKategori}</span>
                                </div>`;
                            }

                            if (item.keterangan) {
                                contentHtml += `<div class="flex border-b pb-1"><strong class="w-1/3 text-gray-500">Keterangan</strong><span class="w-2/3">${item.keterangan}</span></div>`;
                            }

                            // contentHtml += `<div class="flex border-b pb-1"><strong class="w-1/3 text-gray-500">Latitude</strong><span class="w-2/3">${item.lat}</span></div>`;
                            // contentHtml += `<div class="flex border-b pb-1"><strong class="w-1/3 text-gray-500">Longitude</strong><span class="w-2/3">${item.lng}</span></div>`;
                            contentHtml += `<div class="flex border-b pb-1"><strong class="w-1/3 text-gray-500">Status</strong><span class="w-2/3">${item.status}</span></div>`;
                            contentHtml += `<div class="flex border-b pb-1"><strong class="w-1/3 text-gray-500">Dibuat</strong><span class="w-2/3">${new Date(item.created_at).toLocaleDateString('id-ID')}</span></div>`;
                            contentHtml += '</div>';

                            showModal(item.judul, contentHtml, item.gambar_url);
                        });

                        // Tambahkan ke legenda jika belum ada
                        if (item.kategori && !legendItems[item.kategori]) {
                            legendItems[item.kategori] = categoryMapping[item.kategori];
                        }
                    });

                    // Jika perlu, tambahkan data hardcoded
                    loadHardcodedData(map, legendItems);

                } else {
                    console.error('Failed to load API data:', result.message);
                    loadHardcodedData(map, legendItems);
                }
            } catch (error) {
                console.error('Error loading API data:', error);
                loadHardcodedData(map, legendItems);
            }
        }


        // Function to load hardcoded data as fallback
        function loadHardcodedData(map, legendItems) {
            // Load hardcoded locations
            villageData.locations.forEach(loc => {
                const customIcon = createCustomIcon(loc.icon, loc.color);
                L.marker([loc.lat, loc.lng], { icon: customIcon }).addTo(map).bindPopup(`<div class="popup-title">${loc.name}</div><span class="popup-category" style="background-color:${loc.color};">${loc.category}</span>`);
                if (!legendItems[loc.category]) legendItems[loc.category] = { icon: loc.icon, color: loc.color };
            });

            // Load social markers
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
        }

        // Load data from API
        loadMapDataFromAPI(map, legendItems);

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
        // Use setTimeout to ensure DOM is fully loaded
        setTimeout(() => {
            initializeEventListeners(map, drawnItems, originalBoundary, updateAreaFromGeoJSON);
        }, 100);

        // Initialize draw panel manager
        setTimeout(() => {
            console.log('Checking for drawPanelManager...', window.drawPanelManager);
            if (window.drawPanelManager) {
                try {
                    // Check if populateDashboard function is available
                    const populateDashboardFunc = typeof populateDashboard === 'function' ? populateDashboard : function() {
                        console.log('populateDashboard function not available, using fallback');
                    };

                    window.drawPanelManager.init(map, drawnItems, originalBoundary, updateAreaFromGeoJSON, updateRoadStats, calculatePolygonArea, populateDashboardFunc);
                    console.log('Draw Panel Manager initialized successfully');
                } catch (error) {
                    console.error('Error initializing Draw Panel Manager:', error);
                }
            } else {
                console.log('DrawPanelManager not available yet, retrying...');
                // Retry after a short delay
                setTimeout(() => {
                    console.log('Retry: Checking for drawPanelManager...', window.drawPanelManager);
                    if (window.drawPanelManager) {
                        try {
                            // Check if populateDashboard function is available
                            const populateDashboardFunc = typeof populateDashboard === 'function' ? populateDashboard : function() {
                                console.log('populateDashboard function not available, using fallback');
                            };

                            window.drawPanelManager.init(map, drawnItems, originalBoundary, updateAreaFromGeoJSON, updateRoadStats, calculatePolygonArea, populateDashboardFunc);
                            console.log('Draw Panel Manager initialized successfully (retry)');
                        } catch (error) {
                            console.error('Error initializing Draw Panel Manager (retry):', error);
                        }
                    } else {
                        console.error('DrawPanelManager failed to load after retry');
                    }
                }, 500);
            }
        }, 200);

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

        // Draw panel manager initialization moved to initializeApp() function

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
