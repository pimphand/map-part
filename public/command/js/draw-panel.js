// Draw Panel Manager
window.drawPanelManager = {
    map: null,
    drawnItems: null,
    originalBoundary: null,
    currentDrawer: null,
    updateAreaFromGeoJSON: null,
    updateRoadStats: null,
    calculatePolygonArea: null,
    populateDashboard: null,

    init: function(map, drawnItems, originalBoundary, updateAreaFromGeoJSON, updateRoadStats, calculatePolygonArea, populateDashboard) {

        this.map = map;
        this.drawnItems = drawnItems;
        this.originalBoundary = originalBoundary;
        this.updateAreaFromGeoJSON = updateAreaFromGeoJSON;
        this.updateRoadStats = updateRoadStats;
        this.calculatePolygonArea = calculatePolygonArea;
        this.populateDashboard = populateDashboard;

        this.initializeDrawControls();
        this.attachEventListeners();
        this.attachPointModalListeners();
        this.initializeDynamicInputs();

        // Load existing data after a short delay to ensure map is fully initialized
        setTimeout(() => {
            console.log('Initializing draw panel manager and loading existing data...'); // Debug log
            this.loadExistingDataMaps();
        }, 1000);
    },

    initializeDrawControls: function() {
        // Initialize Leaflet.draw with custom options
        this.drawControl = new L.Control.Draw({
            position: 'topright',
            draw: {
                polygon: {
                    allowIntersection: false,
                    drawError: {
                        color: '#e1e100',
                        message: '<strong>Error:</strong> Shape edges cannot cross!'
                    },
                    shapeOptions: {
                        color: '#bada55',
                        fillColor: '#bada55',
                        fillOpacity: 0.2
                    }
                },
                polyline: {
                    shapeOptions: {
                        color: '#f357a1',
                        weight: 4
                    }
                },
                rectangle: false,
                circle: false,
                marker: false,
                circlemarker: false
            },
            edit: {
                featureGroup: this.drawnItems,
                remove: true
            }
        });
    },

    attachEventListeners: function() {

        // Use event delegation for better reliability
        document.addEventListener('click', (e) => {
            // Skip if clicking on map elements (let Leaflet handle them)
            if (e.target.closest('.leaflet-popup') ||
                e.target.closest('.leaflet-popup-content') ||
                e.target.closest('.leaflet-popup-content-wrapper') ||
                e.target.closest('.leaflet-popup-tip') ||
                e.target.closest('.leaflet-popup-close-button') ||
                e.target.closest('svg') ||
                e.target.closest('path') ||
                e.target.closest('.leaflet-interactive')) {
                return; // Let Leaflet handle popup and map element events
            }

            // Draw Boundary Icon - Village Boundary
            if (e.target.closest('#draw-boundary-icon')) {
                e.preventDefault();
                this.startPolygonDrawing('village');
            }

            // Draw Dusun Boundary Icon
            if (e.target.closest('#draw-dusun-boundary-icon')) {
                e.preventDefault();
                this.startPolygonDrawing('dusun');
            }

            // Road Drawing Buttons
            if (e.target.closest('#draw-good-road-icon')) {
                e.preventDefault();
                this.startPolylineDrawing('Bagus');
            }

            if (e.target.closest('#draw-bad-road-icon')) {
                e.preventDefault();
                this.startPolylineDrawing('Rusak');
            }

            if (e.target.closest('#draw-alley-road-icon')) {
                e.preventDefault();
                this.startPolylineDrawing('Gang');
            }

            // Draw Point Icon
            if (e.target.closest('#draw-point-icon')) {
                e.preventDefault();
                this.enablePointPlacement();
            }

            // Refresh data maps button
            if (e.target.closest('#refresh-data-maps-button')) {
                e.preventDefault();
                this.refreshDataMaps();
            }

            // Clear all drawings button
            if (e.target.closest('#clear-draw-button')) {
                e.preventDefault();
                this.clearAllDrawings();
            }

            // Close draw panel button
            if (e.target.closest('#close-draw-panel-button')) {
                e.preventDefault();
                this.hideDrawPanel();
            }
        });

        // Map events for draw created
        this.map.on(L.Draw.Event.CREATED, (event) => {
            this.handleDrawCreated(event);
        });

        // Global map click handler for point placement
        this.map.on('click', (e) => {
            // Always store coordinates globally for other functionalities
            window.lastClickedCoordinates = e.latlng;

            if (window.pointPlacementMode) {
                this.handleMapClickForPoint(e);
            }
        });

        // Handle clicks on existing road polylines to ensure popups work
        this.map.on('click', (e) => {
            // Check if the click is on a polyline (road)
            const target = e.originalEvent.target;
            if (target && (target.tagName === 'path' || target.classList.contains('leaflet-interactive'))) {
                // Let Leaflet handle the popup naturally
                return;
            }
        });

    },

    startPolygonDrawing: function(boundaryType) {

        // Check if map is available
        if (!this.map) {
            console.error('Map is not available!');
            return;
        }

        // Disable any existing drawer
        if (this.currentDrawer) {
            this.currentDrawer.disable();
        }

        // Create polygon drawer with custom options
        const polygonOptions = {
            allowIntersection: false,
            drawError: {
                color: '#e1e100',
                message: '<strong>Error:</strong> Shape edges cannot cross!'
            },
            shapeOptions: {
                color: boundaryType === 'village' ? '#3b82f6' : '#8b5cf6',
                fillColor: boundaryType === 'village' ? '#3b82f6' : '#8b5cf6',
                fillOpacity: 0.2,
                weight: 3
            },
            boundaryType: boundaryType
        };

        try {
            // Check if Leaflet.draw is available
            if (typeof L === 'undefined' || typeof L.Draw === 'undefined' || typeof L.Draw.Polygon === 'undefined') {
                console.error('Leaflet.draw is not available. Please check if the library is loaded.');
                alert('Drawing functionality is not available. Please refresh the page.');
                return;
            }

            this.currentDrawer = new L.Draw.Polygon(this.map, polygonOptions);

            this.currentDrawer.enable();

            // Update button appearance
            this.updateButtonState('draw-boundary-icon', boundaryType === 'village');
            this.updateButtonState('draw-dusun-boundary-icon', boundaryType === 'dusun');


            // Show instruction to user
            alert('Mode drawing polygon aktif! Klik di peta untuk membuat titik-titik polygon, double-click untuk menyelesaikan.');
        } catch (error) {
            console.error('Error creating polygon drawer:', error);
            alert('Error: ' + error.message);
        }
    },

    startPolylineDrawing: function(roadStatus) {
        // Disable any existing drawer
        if (this.currentDrawer) {
            this.currentDrawer.disable();
        }

        // Create polyline drawer with custom options
        const polylineOptions = {
            shapeOptions: {
                color: roadStatus === 'Bagus' ? '#10b981' :
                       roadStatus === 'Rusak' ? '#ef4444' : '#f59e0b',
                weight: 4
            },
            roadStatus: roadStatus
        };

        this.currentDrawer = new L.Draw.Polyline(this.map, polylineOptions);
        this.currentDrawer.enable();

        // Update button appearance
        this.updateButtonState('draw-good-road-icon', roadStatus === 'Bagus');
        this.updateButtonState('draw-bad-road-icon', roadStatus === 'Rusak');
        this.updateButtonState('draw-alley-road-icon', roadStatus === 'Gang');

    },

    updateButtonState: function(buttonId, isActive) {
        const button = document.getElementById(buttonId);
        if (button) {
            if (isActive) {
                button.classList.add('bg-blue-100', 'ring-2', 'ring-blue-500');
                button.classList.remove('hover:bg-gray-200');
            } else {
                button.classList.remove('bg-blue-100', 'ring-2', 'ring-blue-500');
                button.classList.add('hover:bg-gray-200');
            }
        }
    },

    handleDrawCreated: function(event) {
        const layer = event.layer;
        const type = event.layerType;
        const isDusunBoundary = this.currentDrawer && this.currentDrawer.options.boundaryType === 'dusun';

        if (type === 'polygon' && isDusunBoundary) {
            // Handle dusun boundary
            const latlngs = layer.toGeoJSON().geometry.coordinates[0].map(coord => ({ lat: coord[1], lng: coord[0] }));
            const areaM2 = this.calculatePolygonArea(latlngs);
            const areaInfoText = `${(areaM2 / 1000000).toFixed(3)} km² / ${(areaM2 / 10000).toFixed(2)} Ha`;

            // Add click handler to dusun polygon to capture coordinates
            layer.on('click', (e) => {
                window.lastClickedCoordinates = e.latlng;
                // Don't prevent default to allow other click handlers to work
            });

            // Store temporarily for modal
            window.tempDusunLayer = layer;
            this.showDusunModal(areaInfoText);
        } else if (type === 'polygon' && !isDusunBoundary) {
            // Handle village boundary
            if (this.originalBoundary) this.map.removeLayer(this.originalBoundary);
            const newGeoJSON = layer.toGeoJSON();
            this.updateAreaFromGeoJSON(newGeoJSON);
            layer.bindPopup(`<b>Batas Wilayah Baru</b><br>Luas Terukur: ${villageData.profile.luasWilayah.split(' ')[0]} km²`);
            this.originalBoundary = layer.addTo(this.map);

            // Add click handler to polygon to capture coordinates
            layer.on('click', (e) => {
                window.lastClickedCoordinates = e.latlng;
                // Don't prevent default to allow other click handlers to work
            });

            if (typeof this.populateDashboard === 'function') {
                this.populateDashboard();
            }
        } else if (type === 'polyline') {
            // Handle road drawing
            const latlngs = layer.getLatLngs();
            let totalDistance = 0;
            for (let i = 0; i < latlngs.length - 1; i++) {
                totalDistance += latlngs[i].distanceTo(latlngs[i + 1]);
            }
            layer.options.lengthKm = totalDistance / 1000;
            layer.options.roadStatus = this.currentDrawer.options.roadStatus;

            // Store temporarily for modal
            window.tempRoadLayer = layer;
            this.showNewRoadModal(layer.options.roadStatus, layer.options.lengthKm, layer.toGeoJSON());
        }

        this.resetDrawPanel();
    },

    resetDrawPanel: function() {
        if (this.currentDrawer) {
            this.currentDrawer.disable();
        }
        this.currentDrawer = null;

        // Clear point placement mode flag
        window.pointPlacementMode = false;

        // Clear any temporary point data
        window.tempPointData = null;
        window.tempPointCoordinates = null;

        // Reset all button states
        const buttons = [
            'draw-boundary-icon',
            'draw-dusun-boundary-icon',
            'draw-good-road-icon',
            'draw-bad-road-icon',
            'draw-alley-road-icon',
            'draw-point-icon'
        ];

        buttons.forEach(buttonId => {
            this.updateButtonState(buttonId, false);
        });

        this.hideDrawPanel();
    },

    clearAllDrawings: function() {
        this.drawnItems.clearLayers();
        this.resetDrawPanel();

        // Reset road stats
        if (typeof this.updateRoadStats === 'function') {
            this.updateRoadStats();
        }

    },

    hideDrawPanel: function() {
        const drawPanel = document.getElementById('draw-panel');
        if (drawPanel) {
            drawPanel.classList.add('hidden');
        }
    },

    showDrawPanel: function() {
        const drawPanel = document.getElementById('draw-panel');
        if (drawPanel) {
            drawPanel.classList.remove('hidden');
        }
    },

    showDusunModal: function(areaInfoText) {
        // Create a simple modal for dusun boundary
        const modalHtml = `
            <div id="dusun-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                    <h3 class="text-lg font-bold mb-4">Informasi Batas Dusun</h3>
                    <p class="mb-4">Luas Area: <strong>${areaInfoText}</strong></p>
                    <div class="flex space-x-2">
                        <button id="save-dusun-btn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Simpan
                        </button>
                        <button id="cancel-dusun-btn" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Add event listeners for modal buttons
        document.getElementById('save-dusun-btn').addEventListener('click', () => {
            if (window.tempDusunLayer) {
                this.drawnItems.addLayer(window.tempDusunLayer);
                window.tempDusunLayer = null;
            }
            document.getElementById('dusun-modal').remove();
        });

        document.getElementById('cancel-dusun-btn').addEventListener('click', () => {
            if (window.tempDusunLayer) {
                this.map.removeLayer(window.tempDusunLayer);
                window.tempDusunLayer = null;
            }
            document.getElementById('dusun-modal').remove();
        });
    },

    showNewRoadModal: function(roadStatus, lengthKm, geoJson) {
        // Create a modal for road data entry
        const modalHtml = `
            <div id="road-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
                    <h3 class="text-lg font-bold mb-4">Informasi Jalan</h3>
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Status: <strong>${roadStatus}</strong></p>
                        <p class="text-sm text-gray-600">Panjang: <strong>${lengthKm.toFixed(2)} km</strong></p>
                    </div>

                    <form id="road-form" class="space-y-4">
                        <div>
                            <label for="road-name" class="block text-sm font-medium text-gray-700 mb-2">Nama Jalan:</label>
                            <input type="text" id="road-name" name="nama"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Masukkan nama jalan" required>
                        </div>

                        <div>
                            <label for="road-description" class="block text-sm font-medium text-gray-700 mb-2">Keterangan:</label>
                            <textarea id="road-description" name="keterangan" rows="3"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Masukkan keterangan (opsional)"></textarea>
                        </div>

                        <div>
                            <label for="road-image" class="block text-sm font-medium text-gray-700 mb-2">Gambar:</label>
                            <input type="file" id="road-image" name="gambar" accept="image/*"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <input type="hidden" id="road-type" name="type" value="${roadStatus}">
                        <input type="hidden" id="road-geo-json" name="geo_json" value="">

                        <div class="flex space-x-2 pt-4">
                            <button type="submit" id="save-road-btn"
                                    class="flex-1 bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
                                <i class="fa-solid fa-save mr-2"></i> Simpan Jalan
                            </button>
                            <button type="button" id="cancel-road-btn"
                                    class="flex-1 bg-gray-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-600 transition duration-300">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Set the geo_json value
        document.getElementById('road-geo-json').value = JSON.stringify(geoJson);

        // Add event listeners for modal buttons
        document.getElementById('save-road-btn').addEventListener('click', (e) => {
            e.preventDefault();
            this.saveRoadData();
        });

        document.getElementById('cancel-road-btn').addEventListener('click', () => {
            if (window.tempRoadLayer) {
                this.map.removeLayer(window.tempRoadLayer);
                window.tempRoadLayer = null;
            }
            document.getElementById('road-modal').remove();
            this.resetDrawPanel();
        });

        // Close modal when clicking outside
        document.getElementById('road-modal').addEventListener('click', (e) => {
            if (e.target.id === 'road-modal') {
                if (window.tempRoadLayer) {
                    this.map.removeLayer(window.tempRoadLayer);
                    window.tempRoadLayer = null;
                }
                document.getElementById('road-modal').remove();
                this.resetDrawPanel();
            }
        });
    },

    saveRoadData: function() {
        const form = document.getElementById('road-form');
        const formData = new FormData(form);

        // Get the geo_json data
        const geoJson = JSON.parse(document.getElementById('road-geo-json').value);
        formData.append('geo_json', JSON.stringify(geoJson));

        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrfToken) {
            formData.append('_token', csrfToken);
        }

        // Show loading state
        const saveBtn = document.getElementById('save-road-btn');
        const originalText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Menyimpan...';
        saveBtn.disabled = true;

        // Send data to server
        fetch('/api/jalans', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add the road layer to the map
                if (window.tempRoadLayer) {
                    const layer = window.tempRoadLayer;
                    layer.bindPopup(`<b>${data.data.formatted_type}:</b> ${data.data.nama}<br><b>Panjang:</b> ${layer.options.lengthKm.toFixed(2)} km`);
                    this.drawnItems.addLayer(layer);
                    window.tempRoadLayer = null;
                }

                // Update road stats
                if (typeof this.updateRoadStats === 'function') {
                    this.updateRoadStats();
                }

                // Reload road data to update dashboard
                this.loadExistingRoadData();

                // Show success message
                this.showNotification(data.message, 'success');

                // Close modal
                document.getElementById('road-modal').remove();
                this.resetDrawPanel();
            } else {
                // Show error message
                this.showNotification(data.message || 'Terjadi kesalahan saat menyimpan data jalan', 'error');

                // Reset button state
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error saving road data:', error);
            this.showNotification('Terjadi kesalahan saat menyimpan data jalan', 'error');

            // Reset button state
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
        });
    },

    showPointModal: function() {
        const modal = document.getElementById('point-modal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Add event listeners for modal interactions
            this.attachPointModalListeners();
        } else {
            console.error('Point modal not found in DOM');
        }
    },

    hidePointModal: function() {
        const modal = document.getElementById('point-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            // Reset form
            document.getElementById('point-form').reset();
            // Clear dynamic inputs
            this.clearCodeValueInputs();
        }
    },

    attachPointModalListeners: function() {

        // Close modal button
        const closeBtn = document.getElementById('close-point-modal');
        if (closeBtn) {
            closeBtn.onclick = () => {
                // Clear temporary coordinates and reset state
                window.tempPointCoordinates = null;
                window.pointPlacementMode = false;
                this.updateButtonState('draw-point-icon', false);
                this.hidePointModal();
            };
        } else {
            console.warn('Close button not found');
        }

        // Cancel button
        const cancelBtn = document.getElementById('cancel-point-btn');
        if (cancelBtn) {
            cancelBtn.onclick = () => {
                // Clear temporary coordinates and reset state
                window.tempPointCoordinates = null;
                window.pointPlacementMode = false;
                this.updateButtonState('draw-point-icon', false);
                this.hidePointModal();
            };
        } else {
            console.warn('Cancel button not found');
        }


        // Close modal when clicking outside
        const modal = document.getElementById('point-modal');
        if (modal) {
            modal.onclick = (e) => {
                if (e.target === modal) {
                    // Clear temporary coordinates and reset state
                    window.tempPointCoordinates = null;
                    window.pointPlacementMode = false;
                    this.updateButtonState('draw-point-icon', false);
                    this.hidePointModal();
                }
            };
        } else {
            console.warn('Modal not found');
        }

    },



    enablePointPlacement: function() {
        if (!this.map) {
            console.error('Map is not available!');
            return;
        }

        // Disable any existing drawer
        if (this.currentDrawer) {
            this.currentDrawer.disable();
        }

        // Set flag to indicate point placement mode is active
        window.pointPlacementMode = true;

        // Update button state
        this.updateButtonState('draw-point-icon', true);

        // Hide draw panel and show instruction
        this.hideDrawPanel();

    },

    handleMapClickForPoint: function(e) {

        const latlng = e.latlng;

        // Store the clicked coordinates for later use
        window.tempPointCoordinates = latlng;

        // Clear the point placement mode flag
        window.pointPlacementMode = false;

        // Show the point modal
        this.showPointModal();
    },



    // Dynamic Code-Value Input Functions
    initializeDynamicInputs: function() {

        // Add event listener for the add button
        const addBtn = document.getElementById('add-code-value-btn');
        if (addBtn) {
            addBtn.addEventListener('click', () => {
                this.addCodeValueInput();
            });
        }

        // Add event listener for container to handle remove buttons
        const container = document.getElementById('code-value-container');
        if (container) {
            container.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-code-value-btn')) {
                    this.removeCodeValueInput(e.target);
                }
            });
        }
    },

    addCodeValueInput: function() {
        const container = document.getElementById('code-value-container');
        if (!container) return;

        const inputGroup = document.createElement('div');
        inputGroup.className = 'flex items-center space-x-2 p-2 border border-gray-200 rounded-lg bg-gray-50';

        const inputId = 'code-value-' + Date.now();

        inputGroup.innerHTML = `
            <div class="flex-1">
                <input type="text"
                       name="code[]"
                       placeholder="Kode"
                       class="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>
            <div class="flex-1">
                <input type="text"
                       name="value[]"
                       placeholder="Nilai"
                       class="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>
            <button type="button"
                    class="remove-code-value-btn text-red-500 hover:text-red-700 p-1"
                    title="Hapus">
                <i class="fa-solid fa-trash text-sm"></i>
            </button>
        `;

        container.appendChild(inputGroup);
    },

    removeCodeValueInput: function(button) {
        const inputGroup = button.closest('.flex.items-center.space-x-2');
        if (inputGroup) {
            inputGroup.remove();
        }
    },

    getCodeValueData: function() {
        const container = document.getElementById('code-value-container');
        if (!container) return [];

        const codeInputs = container.querySelectorAll('input[name="code[]"]');
        const valueInputs = container.querySelectorAll('input[name="value[]"]');

        const data = [];
        for (let i = 0; i < codeInputs.length; i++) {
            const code = codeInputs[i].value.trim();
            const value = valueInputs[i].value.trim();

            if (code && value) {
                data.push({ code, value });
            }
        }

        return data;
    },

    clearCodeValueInputs: function() {
        const container = document.getElementById('code-value-container');
        if (container) {
            container.innerHTML = '';
        }
    },

    // Helper methods for better UX

    showNotification: function(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full`;

        // Set colors based on type
        const colors = {
            success: 'bg-green-500 text-white',
            error: 'bg-red-500 text-white',
            warning: 'bg-yellow-500 text-black',
            info: 'bg-blue-500 text-white'
        };

        notification.className += ` ${colors[type] || colors.info}`;

        // Add icon based on type
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };

        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fa-solid ${icons[type] || icons.info} mr-2"></i>
                <span>${message}</span>
                <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 300);
            }
        }, 5000);
    },

    showValidationErrors: function(errors) {
        // Clear existing error messages
        const existingErrors = document.querySelectorAll('.field-error');
        existingErrors.forEach(error => error.remove());

        // Show validation errors
        Object.keys(errors).forEach(field => {
            const fieldElement = document.querySelector(`[name="${field}"]`);
            if (fieldElement) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'field-error text-red-500 text-sm mt-1';
                errorDiv.textContent = errors[field][0]; // Show first error message

                fieldElement.parentNode.appendChild(errorDiv);
                fieldElement.classList.add('border-red-500');
            }
        });
    },

    // resetFormAndClose: function() {
    //     // Clean up coordinates and state
    //     window.tempPointCoordinates = null;
    //     window.pointPlacementMode = false;

    //     // Reset form
    //     const form = document.getElementById('point-form');
    //     if (form) {
    //         form.reset();
    //     }

    //     // Clear dynamic inputs
    //     this.clearCodeValueInputs();

    //     // Clear validation errors
    //     const existingErrors = document.querySelectorAll('.field-error');
    //     existingErrors.forEach(error => error.remove());

    //     // Remove error styling from inputs
    //     const inputs = document.querySelectorAll('#point-form input, #point-form select, #point-form textarea');
    //     inputs.forEach(input => input.classList.remove('border-red-500'));

    //     // Close modal and reset button state
    //     this.hidePointModal();
    //     this.updateButtonState('draw-point-icon', false);
    // },

    // Load existing data maps from server
    loadExistingDataMaps: function() {
        this.loadExistingRoadData();
    },

    // Load existing road data from server
    loadExistingRoadData: function() {

        fetch('/api/jalans')
        .then(response => {
            return response.json();
        })
        .then(data => {
            console.log('Draw panel - Road data received:', data);

            if (data.success && data.data) {

                this.renderExistingRoads(data.data);

                // Update road condition data in dashboard
                if (typeof updateRoadConditionData === 'function') {
                    console.log('Calling updateRoadConditionData from draw panel');
                    updateRoadConditionData(data.data, data.statistics);
                } else {
                    console.warn('updateRoadConditionData function not found');
                }
            } else {
                console.warn('No road data received or API returned error:', data);
                // Update with empty data to show default state
                if (typeof updateRoadConditionData === 'function') {
                    updateRoadConditionData([]);
                }
            }
        })
        .catch(error => {
            console.error('Error loading road data:', error);
        });
    },

    // Render existing roads on the map
    renderExistingRoads: function(roadData) {
        roadData.forEach(road => {
            try {
                // Parse geo_json if it's a string
                let geoJsonData = road.geo_json;
                if (typeof geoJsonData === 'string') {
                    geoJsonData = JSON.parse(geoJsonData);
                }

                if (geoJsonData && geoJsonData.geometry) {
                    // Create polyline from GeoJSON
                    const polyline = L.geoJSON(geoJsonData, {
                        style: {
                            color: road.type === 'Bagus' ? '#10b981' :
                                   road.type === 'Rusak' ? '#ef4444' :
                                   road.type === 'Gang' ? '#f59e0b' : '#6b7280',
                            weight: 4
                        }
                    });

                    // Calculate length if not available
                    const layers = polyline.getLayers();
                    if (layers.length > 0) {
                        const latlngs = layers[0].getLatLngs();
                        let totalDistance = 0;
                        for (let i = 0; i < latlngs.length - 1; i++) {
                            totalDistance += latlngs[i].distanceTo(latlngs[i + 1]);
                        }
                        const lengthKm = totalDistance / 1000;

                        // Add click handler to show modal instead of popup
                        polyline.on('click', (e) => {
                            window.lastClickedCoordinates = e.latlng;
                            this.showRoadModal(road, lengthKm);
                        });

                        this.drawnItems.addLayer(polyline);
                        console.log('Road added to map:', road.nama); // Debug log
                    }
                } else {
                    console.warn('Invalid geo_json for road:', road.nama, geoJsonData);
                }
            } catch (error) {
                console.error('Error rendering road:', road.nama, error);
            }
        });
    },

    getIconForCategory: function(category) {
        const iconMap = {
            'pemerintahan': 'fa-landmark',
            'pendidikan': 'fa-school',
            'kesehatan': 'fa-briefcase-medical',
            'ibadah': 'fa-mosque',
            'wisata': 'fa-water',
            'stunting': 'fa-child-reaching',
            'rumah_tdk_layak': 'fa-house-crack',
            'lansia': 'fa-person-cane',
            'anak_yatim': 'fa-hands-holding-child',
            'cctv': 'fa-video'
        };
        return iconMap[category] || 'fa-map-pin';
    },

    getColorForCategory: function(category) {
        const colorMap = {
            'pemerintahan': 'blue',
            'pendidikan': 'orange',
            'kesehatan': 'red',
            'ibadah': 'green',
            'wisata': 'purple',
            'stunting': 'var(--color-amber-500)',
            'rumah_tdk_layak': 'var(--color-stone-500)',
            'lansia': 'var(--color-sky-500)',
            'anak_yatim': 'var(--color-teal-500)',
            'cctv': '#4b5563'
        };
        return colorMap[category] || '#6b7280';
    },

    // Refresh data maps (clear existing and reload)
    refreshDataMaps: function() {

        // Clear existing markers and roads
        this.drawnItems.clearLayers();

        // Reload existing data
        this.loadExistingDataMaps();

        // Show notification
        this.showNotification('Data peta berhasil dimuat ulang', 'success');
    },

    // Show road detail modal
    showRoadModal: function(road, lengthKm) {
        const modal = document.getElementById('road-detail-modal');
        if (!modal) return;

        // Get road type icon and color
        const roadTypeIcons = {
            'Bagus': 'fa-road',
            'Rusak': 'fa-road-circle-exclamation',
            'Gang': 'fa-road-lane'
        };

        const roadTypeColors = {
            'Bagus': 'text-green-600',
            'Rusak': 'text-red-600',
            'Gang': 'text-orange-500'
        };

        // Set modal content
        document.getElementById('road-modal-name').textContent = road.nama;
        document.getElementById('road-modal-type').textContent = road.formatted_type;
        document.getElementById('road-modal-length').textContent = `${lengthKm.toFixed(2)} km`;
        document.getElementById('road-modal-status').textContent = road.formatted_type;

        // Set icon and color
        const iconElement = document.getElementById('road-modal-icon');
        iconElement.className = `fa-solid ${roadTypeIcons[road.type] || 'fa-road'} text-2xl ${roadTypeColors[road.type] || 'text-gray-600'}`;

        // Show image if available
        const imageSection = document.getElementById('road-modal-image-section');
        const imageElement = document.getElementById('road-modal-image');
        if (road.gambar_url && road.gambar_url.trim()) {
            imageElement.src = road.gambar_url;
            imageElement.alt = `Gambar ${road.nama}`;
            imageSection.classList.remove('hidden');
        } else {
            imageSection.classList.add('hidden');
        }

        // Show description if available
        const descriptionDiv = document.getElementById('road-modal-description');
        const keteranganElement = document.getElementById('road-modal-keterangan');
        if (road.keterangan && road.keterangan.trim()) {
            keteranganElement.textContent = road.keterangan;
            descriptionDiv.classList.remove('hidden');
        } else {
            descriptionDiv.classList.add('hidden');
        }

        // Show modal with animation
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.modal-container').classList.remove('scale-95');
            modal.querySelector('.modal-container').classList.add('scale-100');
        }, 10);

        // Add event listeners for closing modal
        const closeModal = () => {
            modal.querySelector('.modal-container').classList.remove('scale-100');
            modal.querySelector('.modal-container').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        };

        // Remove existing listeners to prevent duplicates
        document.getElementById('road-modal-close').removeEventListener('click', closeModal);
        document.getElementById('road-modal-close-btn').removeEventListener('click', closeModal);
        modal.removeEventListener('click', closeModal);

        // Add new listeners
        document.getElementById('road-modal-close').addEventListener('click', closeModal);
        document.getElementById('road-modal-close-btn').addEventListener('click', closeModal);

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    }
};

// Make functions available globally for backward compatibility
window.handleDrawCreated = window.drawPanelManager.handleDrawCreated.bind(window.drawPanelManager);
window.resetDrawPanel = window.drawPanelManager.resetDrawPanel.bind(window.drawPanelManager);
window.clearAllDrawings = window.drawPanelManager.clearAllDrawings.bind(window.drawPanelManager);
