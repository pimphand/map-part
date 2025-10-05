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
            window.lastClickedCoordinates = e.latlng;
            tempCoordinates = e.latlng;
            // Don't prevent default to allow other click handlers to work
        });

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

            // Check if modal is open and fill coordinates automatically
            const modal = document.getElementById('point-modal');
            if (modal && !modal.classList.contains('hidden')) {
                setTimeout(() => {
                    const latInput = document.getElementById('point-latitude');
                    const lngInput = document.getElementById('point-longitude');

                    if (latInput && lngInput) {
                        latInput.value = e.latlng.lat.toFixed(13);
                        lngInput.value = e.latlng.lng.toFixed(13);
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
                        }
                    }, 100);
                } else {
                }

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
                        'cctv': { icon: 'fa-solid fa-video', color: '#4b5563' }
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

                            showModal(item.judul, contentHtml, item.gambar_url, item);
                        });

                        // Tambahkan ke legenda jika belum ada
                        if (item.kategori && !legendItems[item.kategori]) {
                            legendItems[item.kategori] = categoryMapping[item.kategori];
                        }
                    });

                    // Jika perlu, tambahkan data hardcoded
                    // loadHardcodedData(map, legendItems);

                } else {
                    console.error('Failed to load API data:', result.message);
                    // loadHardcodedData(map, legendItems);
                }
            } catch (error) {
                console.error('Error loading API data:', error);
                // loadHardcodedData(map, legendItems);
            }
        }


        // Function to load hardcoded data as fallback

        // Load data from API
        loadMapDataFromAPI(map, legendItems);

        const cctvIcon = L.divIcon({
            html: `<i class="fa-solid fa-video fa-lg" style="color: #4b5563;"></i>`,
            className: 'bg-white rounded-full p-1 shadow',
            iconSize: [24, 24],
            iconAnchor: [12, 12]
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
                // Generate road condition description based on percentages
                let conditionDescription = '';
                if (goodPercentage >= 70) {
                    conditionDescription = 'Kondisi jalan desa sangat baik dengan mayoritas jalan dalam kondisi bagus.';
                } else if (goodPercentage >= 50) {
                    conditionDescription = 'Kondisi jalan desa cukup baik dengan sebagian besar jalan dalam kondisi layak.';
                } else if (goodPercentage >= 30) {
                    conditionDescription = 'Kondisi jalan desa memerlukan perhatian dengan banyak jalan yang perlu diperbaiki.';
                } else {
                    conditionDescription = 'Kondisi jalan desa memerlukan perbaikan segera dengan mayoritas jalan dalam kondisi rusak.';
                }

                // Add specific notes based on road types
                let specificNotes = [];
                if (badKm > 0) {
                    specificNotes.push(`${badKm.toFixed(2)} km jalan rusak perlu diperbaiki`);
                }
                if (alleyKm > 0) {
                    specificNotes.push(`${alleyKm.toFixed(2)} km jalan gang memerlukan perhatian khusus`);
                }
                if (goodKm > 0) {
                    specificNotes.push(`${goodKm.toFixed(2)} km jalan dalam kondisi baik`);
                }

                jalanContainer.innerHTML = `
                    <ul class="space-y-3">
                        <!-- Total Road Length -->


                        <!-- Road Condition Description -->
                        <li class="p-3 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                            <div class="flex items-start">
                                <i class="fa-solid fa-info-circle text-blue-500 mt-1 mr-2"></i>
                                <div>
                                    <p class="text-sm text-blue-800 font-medium mb-1">Analisis Kondisi Jalan:</p>
                                    <p class="text-sm text-blue-700">${conditionDescription}</p>
                                </div>
                            </div>
                        </li>

                        <!-- Road Statistics -->
                        <li class="p-2 bg-green-50 rounded-lg">
                            <div class="mb-1 flex justify-between">
                                <span class="text-green-600 font-semibold flex items-center">
                                    <i class="fa-solid fa-road mr-2"></i>Jalan Bagus
                                </span>
                                <span>${goodKm.toFixed(2)} km (${goodPercentage}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-500 h-2.5 rounded-full" style="width: ${goodPercentage}%"></div>
                            </div>
                        </li>

                        <li class="p-2 bg-red-50 rounded-lg">
                            <div class="mb-1 flex justify-between">
                                <span class="text-red-600 font-semibold flex items-center">
                                    <i class="fa-solid fa-road-circle-exclamation mr-2"></i>Jalan Rusak
                                </span>
                                <span>${badKm.toFixed(2)} km (${badPercentage}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-red-500 h-2.5 rounded-full" style="width: ${badPercentage}%"></div>
                            </div>
                        </li>

                        <li class="p-2 bg-orange-50 rounded-lg">
                            <div class="mb-1 flex justify-between">
                                <span class="text-orange-500 font-semibold flex items-center">
                                    <i class="fa-solid fa-road-lane mr-2"></i>Jalan Gang
                                </span>
                                <span>${alleyKm.toFixed(2)} km (${alleyPercentage}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-orange-500 h-2.5 rounded-full" style="width: ${alleyPercentage}%"></div>
                            </div>
                        </li>

                        <!-- Specific Notes -->
                        ${specificNotes.length > 0 ? `
                        <li class="p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-600 font-medium mb-2 flex items-center">
                                <i class="fa-solid fa-clipboard-list mr-2"></i>Catatan Khusus:
                            </p>
                            <ul class="text-xs text-gray-600 space-y-1">
                                ${specificNotes.map(note => `
                                    <li class="flex items-center p-1 hover:bg-gray-100 rounded">
                                        <i class="fa-solid fa-circle text-gray-400 mr-2" style="font-size: 4px;"></i>
                                        <span>${note}</span>
                                    </li>
                                `).join('')}
                            </ul>
                        </li>
                        ` : ''}
                    </ul>
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

        // Initialize basic UI listeners (non-drawing)
        setTimeout(() => {
            initializeEventListeners(map, drawnItems, originalBoundary, updateAreaFromGeoJSON);
        }, 100);

        // Initialize draw panel manager
        setTimeout(() => {
            if (window.drawPanelManager) {
                try {
                    // Check if populateDashboard function is available
                    const populateDashboardFunc = typeof populateDashboard === 'function' ? populateDashboard : function() {
                    };

                    window.drawPanelManager.init(map, drawnItems, originalBoundary, updateAreaFromGeoJSON, updateRoadStats, calculatePolygonArea, populateDashboardFunc);
                } catch (error) {
                    console.error('Error initializing Draw Panel Manager:', error);
                }
            } else {
                // Retry after a short delay
                setTimeout(() => {
                    if (window.drawPanelManager) {
                        try {
                            // Check if populateDashboard function is available
                            const populateDashboardFunc = typeof populateDashboard === 'function' ? populateDashboard : function() {
                            };

                            window.drawPanelManager.init(map, drawnItems, originalBoundary, updateAreaFromGeoJSON, updateRoadStats, calculatePolygonArea, populateDashboardFunc);
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

        // Load PBB module and initialize
        const setBoundaryVisible = (() => {
            let boundaryVisible = true;
            return (visible) => {
                if (visible && !boundaryVisible) {
                    try { originalBoundary.addTo(map); } catch (e) {}
                    boundaryVisible = true;
                } else if (!visible && boundaryVisible) {
                    try { map.removeLayer(originalBoundary); } catch (e) {}
                    boundaryVisible = false;
                }
            };
        })();

        function loadScript(src) {
            return new Promise((resolve, reject) => {
                const s = document.createElement('script');
                s.src = src;
                s.async = true;
                s.onload = resolve;
                s.onerror = reject;
                document.body.appendChild(s);
            });
        }

        loadScript('/command/js/pbb.js').then(() => {
            console.log('PBB script loaded successfully');
            if (window.PBBModule && typeof window.PBBModule.init === 'function') {
                console.log('Initializing PBB module...');
                window.PBBModule.init({
                    map,
                    drawnItems,
                    originalBoundary,
                    setBoundaryVisible,
                    calculatePolygonArea,
                    showNotification,
                });

                // Initialize PBB data loading
                if (typeof window.PBBModule.initializePBB === 'function') {
                    console.log('Calling PBB initializePBB...');
                    window.PBBModule.initializePBB();
                } else {
                    console.error('PBBModule.initializePBB function not found');
                }
            } else {
                console.error('PBBModule not found or init function missing');
            }
        }).catch((err) => {
            console.error('Failed to load PBB module', err);
        });

        // Check if data stack is available and has data, otherwise use default data
        if (window.dataStack && window.dataStack.stack.length > 0) {
            // Data will be populated by the stack
        } else {
            // Use default data
            populateDashboard();
        }

        const logoutButton = document.getElementById('logout-button');
        logoutButton.addEventListener('click', () => {
            window.location.reload();
        });

        // Add PBB reload button event listener
        const reloadPbbButton = document.getElementById('reload-pbb-data-button');
        if (reloadPbbButton) {
            reloadPbbButton.addEventListener('click', () => {
                console.log('Manual PBB reload requested');
                if (window.PBBModule && typeof window.PBBModule.loadPBBData === 'function') {
                    window.PBBModule.loadPBBData();
                } else {
                    console.error('PBBModule.loadPBBData not available');
                    showNotification('Modul PBB belum dimuat. Silakan refresh halaman.', 'error');
                }
            });
        }
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
    }


    // Modal functions

    function showModal(title, content, imageUrl, itemData = null) {
        const modal = document.getElementById('detail-modal');
        const modalTitle = document.getElementById('modal-title');
        const modalContent = document.getElementById('modal-content');
        const modalActions = document.getElementById('modal-actions');

        modalTitle.textContent = title;
        let fullContent = '';
        if (imageUrl) {
            fullContent += `<img src="${imageUrl}" alt="${title}" class="w-full h-48 object-cover rounded-lg mb-4">`;
        }
        fullContent += content;
        modalContent.innerHTML = fullContent;

        // Show/hide action buttons based on whether we have item data
        if (itemData) {
            modalActions.classList.remove('hidden');
            modal.dataset.itemId = itemData.id;
            modal.dataset.itemType = 'point'; // or 'road' depending on context
        } else {
            modalActions.classList.add('hidden');
        }

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
    const closeModalBtnFooter = document.getElementById('modal-close-btn');
    const editBtn = document.getElementById('modal-edit-btn');
    const deleteBtn = document.getElementById('modal-delete-btn');

    closeModalBtn.addEventListener('click', hideModal);
    if (closeModalBtnFooter) {
        closeModalBtnFooter.addEventListener('click', hideModal);
    }
    modal.addEventListener('click', (e) => {
        if (e.target === modal) hideModal();
    });

    // Edit and Delete button event listeners
    if (editBtn) {
        editBtn.addEventListener('click', () => {
            const itemId = modal.dataset.itemId;
            const itemType = modal.dataset.itemType;
            if (itemId && itemType === 'point') {
                showEditPointModal(itemId);
            }
        });
    }

    if (deleteBtn) {
        deleteBtn.addEventListener('click', () => {
            const itemId = modal.dataset.itemId;
            const itemType = modal.dataset.itemType;
            if (itemId && itemType === 'point') {
                const itemTitle = document.getElementById('modal-title').textContent;
                confirmDeletePoint(itemId, itemTitle);
            }
        });
    }

    // Point edit and delete functions
    async function showEditPointModal(pointId) {
        try {
            // Fetch point data
            const response = await fetch(`/api/data-maps`);
            const result = await response.json();

            if (result.success && result.data) {
                const point = result.data.find(p => p.id == pointId);
                if (point) {
                    // Close current modal
                    hideModal();

                    // Create edit modal if it doesn't exist
                    let editModal = document.getElementById('edit-point-modal');
                    if (!editModal) {
                        editModal = createEditPointModal();
                    }

                    // Populate form with current data
                    document.getElementById('edit-point-name').value = point.judul || '';
                    document.getElementById('edit-point-type').value = point.kategori || '';
                    document.getElementById('edit-point-description').value = point.keterangan || '';
                    document.getElementById('edit-point-status').value = point.status || 'active';
                    document.getElementById('edit-point-latitude').value = point.lat || '';
                    document.getElementById('edit-point-longitude').value = point.lng || '';

                    // Store point ID for update
                    editModal.dataset.pointId = point.id;

                    // Show modal
                    editModal.classList.remove('hidden');
                    setTimeout(() => {
                        editModal.querySelector('.modal-container').classList.remove('scale-95');
                        editModal.querySelector('.modal-container').classList.add('scale-100');
                    }, 10);
                }
            }
        } catch (error) {
            console.error('Error loading point data:', error);
            showNotification('Terjadi kesalahan saat memuat data titik', 'error');
        }
    }

    function createEditPointModal() {
        const modalHTML = `
            <div id="edit-point-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-[70] hidden modal-overlay">
                <div class="bg-white rounded-xl shadow-2xl w-full max-w-md modal-container transform scale-95">
                    <div class="flex justify-between items-center p-4 border-b">
                        <h3 class="text-lg font-bold text-gray-800">Edit Data Titik</h3>
                        <button id="edit-point-modal-close" class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <label for="edit-point-name" class="block text-sm font-medium text-gray-700 mb-1">Nama Titik</label>
                            <input type="text" id="edit-point-name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label for="edit-point-type" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select id="edit-point-type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Pilih Kategori</option>
                                <option value="pemerintahan">Pemerintahan</option>
                                <option value="pendidikan">Pendidikan</option>
                                <option value="kesehatan">Kesehatan</option>
                                <option value="ibadah">Ibadah</option>
                                <option value="wisata">Wisata</option>
                                <option value="stunting">Stunting</option>
                                <option value="rumah_tdk_layak">Rumah Tdk Layak</option>
                                <option value="lansia">Lansia</option>
                                <option value="anak_yatim">Anak Yatim</option>
                                <option value="cctv">CCTV</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="edit-point-latitude" class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                                <input type="number" id="edit-point-latitude" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label for="edit-point-longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                                <input type="number" id="edit-point-longitude" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                        </div>
                        <div>
                            <label for="edit-point-status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="edit-point-status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                        <div>
                            <label for="edit-point-description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea id="edit-point-description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan deskripsi titik..."></textarea>
                        </div>
                        <div>
                            <label for="edit-point-gambar" class="block text-sm font-medium text-gray-700 mb-1">Gambar Titik (Opsional)</label>
                            <input type="file" id="edit-point-gambar" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF, WebP (Max: 10MB)</p>
                        </div>
                        <div class="flex justify-end space-x-2 pt-4">
                            <button id="edit-point-cancel" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Batal</button>
                            <button id="edit-point-save" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHTML);
        attachEditPointModalListeners();
        return document.getElementById('edit-point-modal');
    }

    function attachEditPointModalListeners() {
        const modal = document.getElementById('edit-point-modal');
        const closeBtn = document.getElementById('edit-point-modal-close');
        const cancelBtn = document.getElementById('edit-point-cancel');
        const saveBtn = document.getElementById('edit-point-save');

        const closeModal = () => {
            modal.querySelector('.modal-container').classList.remove('scale-100');
            modal.querySelector('.modal-container').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        };

        closeBtn.onclick = closeModal;
        cancelBtn.onclick = closeModal;

        // Close modal when clicking outside
        modal.onclick = (e) => {
            if (e.target === modal) {
                closeModal();
            }
        };

        // Save button functionality
        saveBtn.onclick = () => saveEditedPoint();
    }

    async function saveEditedPoint() {
        const modal = document.getElementById('edit-point-modal');
        const pointId = modal.dataset.pointId;

        if (!pointId) {
            showNotification('ID titik tidak ditemukan!', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('name', document.getElementById('edit-point-name').value);
        formData.append('type', document.getElementById('edit-point-type').value);
        formData.append('latitude', document.getElementById('edit-point-latitude').value);
        formData.append('longitude', document.getElementById('edit-point-longitude').value);
        formData.append('description', document.getElementById('edit-point-description').value);
        formData.append('status', document.getElementById('edit-point-status').value);

        const imageFile = document.getElementById('edit-point-gambar').files[0];
        if (imageFile) {
            formData.append('gambar', imageFile);
        }

        try {
            const response = await fetch(`/api/data-maps/${pointId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const result = await response.json();

            if (result.success) {
                showNotification(result.message, 'success');
                closeEditPointModal();
                // Reload the page to refresh the map data
                window.location.reload();
            } else {
                showNotification(result.message || 'Terjadi kesalahan saat menyimpan data', 'error');
            }
        } catch (error) {
            console.error('Error updating point:', error);
            showNotification('Terjadi kesalahan saat menyimpan data', 'error');
        }
    }

    function closeEditPointModal() {
        const modal = document.getElementById('edit-point-modal');
        if (modal) {
            modal.querySelector('.modal-container').classList.remove('scale-100');
            modal.querySelector('.modal-container').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }
    }

    function confirmDeletePoint(pointId, pointName) {
        if (confirm(`Apakah Anda yakin ingin menghapus titik "${pointName}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
            deletePoint(pointId);
        }
    }

    async function deletePoint(pointId) {
        try {
            const response = await fetch(`/api/data-maps/${pointId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const result = await response.json();

            if (result.success) {
                showNotification(result.message, 'success');
                hideModal();
                // Reload the page to refresh the map data
                window.location.reload();
            } else {
                showNotification(result.message || 'Terjadi kesalahan saat menghapus data', 'error');
            }
        } catch (error) {
            console.error('Error deleting point:', error);
            showNotification('Terjadi kesalahan saat menghapus data', 'error');
        }
    }

    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-[80] px-6 py-3 rounded-lg shadow-lg text-white ${
            type === 'success' ? 'bg-green-500' :
            type === 'error' ? 'bg-red-500' :
            'bg-blue-500'
        }`;
        notification.textContent = message;

        document.body.appendChild(notification);

        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
    // Expose for modules
    window.showNotification = showNotification;

});
