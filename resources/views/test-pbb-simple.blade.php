<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test PBB Simple</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        #map {
            height: 500px;
            width: 100%;
            border: 1px solid #ccc;
        }

        .info {
            margin: 10px 0;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            margin: 5px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Test PBB Data Display - Simple</h1>

    <div class="info">
        <p><strong>Status:</strong> <span id="status">Ready to load...</span></p>
        <p><strong>Data Count:</strong> <span id="dataCount">-</span></p>
        <p><strong>Map Center:</strong> <span id="mapCenter">-</span></p>
    </div>

    <button onclick="loadPBBData()">Load PBB Data</button>
    <button onclick="clearMap()">Clear Map</button>
    <button onclick="fitToPBB()">Fit to PBB</button>

    <div id="map"></div>

    <div id="log"
        style="margin-top: 20px; padding: 10px; background: #f8f9fa; border-radius: 5px; font-family: monospace; font-size: 12px; max-height: 300px; overflow-y: auto;">
        <strong>Log:</strong><br>
    </div>

    <script>
        // Initialize map
        const map = L.map('map').setView([-8.53686, 116.13239], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const drawnItems = new L.FeatureGroup().addTo(map);

        function log(message) {
            const logDiv = document.getElementById('log');
            const timestamp = new Date().toLocaleTimeString();
            logDiv.innerHTML += `${timestamp}: ${message}<br>`;
            logDiv.scrollTop = logDiv.scrollHeight;
            console.log(message);
        }

        function updateStatus(status, count = null) {
            document.getElementById('status').textContent = status;
            if (count !== null) {
                document.getElementById('dataCount').textContent = count;
            }
            document.getElementById('mapCenter').textContent = `${map.getCenter().lat.toFixed(6)}, ${map.getCenter().lng.toFixed(6)}`;
        }

        async function loadPBBData() {
            try {
                updateStatus('Loading...');
                log('Starting PBB data load...');

                const response = await fetch('/api/pbb');
                log(`API Response: ${response.status} ${response.statusText}`);

                const result = await response.json();
                log(`JSON parsed successfully`);

                if (result.success && result.data) {
                    log(`Data found: ${result.data.length} items`);

                    // Clear existing layers
                    drawnItems.clearLayers();

                    // Add each PBB polygon to the map
                    result.data.forEach((pbbItem, index) => {
                        log(`Processing item ${index + 1}: ${pbbItem.nama} (${pbbItem.kategori})`);

                        if (pbbItem.geo_json && pbbItem.geo_json.geometry) {
                            try {
                                // Fix geo_json structure if properties is empty array
                                if (Array.isArray(pbbItem.geo_json.properties)) {
                                    pbbItem.geo_json.properties = {};
                                    log(`Fixed properties structure for item ${index + 1}`);
                                }

                                const geoJsonLayer = L.geoJSON(pbbItem.geo_json, {
                                    style: getPBBStyle(pbbItem.kategori),
                                    onEachFeature: (feature, layer) => {
                                        layer.bindPopup(`
                                            <div>
                                                <h3>${pbbItem.nama}</h3>
                                                <p><strong>Kategori:</strong> ${pbbItem.kategori}</p>
                                                <p><strong>Luas:</strong> ${pbbItem.properties?.area_m2 ? pbbItem.properties.area_m2.toFixed(2) + ' m²' : 'N/A'}</p>
                                                <p><strong>Status:</strong> ${pbbItem.status}</p>
                                                <p><strong>Koordinat:</strong> ${pbbItem.geo_json.geometry.coordinates[0].length} titik</p>
                                            </div>
                                        `);
                                    }
                                });
                                drawnItems.addLayer(geoJsonLayer);
                                log(`✓ Polygon ${index + 1} added successfully`);

                                // Log coordinates for debugging
                                const coords = pbbItem.geo_json.geometry.coordinates[0];
                                log(`  Coordinates: ${coords.length} points`);
                                log(`  First point: [${coords[0][0]}, ${coords[0][1]}]`);
                                log(`  Last point: [${coords[coords.length - 1][0]}, ${coords[coords.length - 1][1]}]`);

                            } catch (error) {
                                log(`✗ Error adding polygon ${index + 1}: ${error.message}`);
                            }
                        } else {
                            log(`✗ Item ${index + 1} has invalid geo_json`);
                        }
                    });

                    updateStatus('Loaded successfully', result.data.length);
                    log('PBB data loading completed');

                    // Auto-fit to show all polygons
                    if (drawnItems.getLayers().length > 0) {
                        map.fitBounds(drawnItems.getBounds(), { padding: [20, 20] });
                        log('Map fitted to show all PBB polygons');
                    }

                } else {
                    updateStatus('No data found', 0);
                    log('No PBB data found in response');
                }
            } catch (error) {
                updateStatus('Error: ' + error.message);
                log('Error loading PBB data: ' + error.message);
            }
        }

        function getPBBStyle(kategori) {
            const styles = {
                'rumah': { color: '#dc2626', fillColor: '#fef2f2', weight: 3, fillOpacity: 0.4 },
                'sawah': { color: '#16a34a', fillColor: '#f0fdf4', weight: 3, fillOpacity: 0.4 },
                'perkarangan': { color: '#d97706', fillColor: '#fffbeb', weight: 3, fillOpacity: 0.4 },
                'lainnya': { color: '#6b7280', fillColor: '#f9fafb', weight: 3, fillOpacity: 0.4 }
            };
            return styles[kategori] || styles['lainnya'];
        }

        function clearMap() {
            drawnItems.clearLayers();
            updateStatus('Map cleared', 0);
            log('Map cleared');
        }

        function fitToPBB() {
            if (drawnItems.getLayers().length > 0) {
                map.fitBounds(drawnItems.getBounds(), { padding: [20, 20] });
                log('Map fitted to PBB polygons');
            } else {
                log('No PBB polygons to fit to');
            }
        }

        // Auto-load on page load
        window.addEventListener('load', () => {
            log('Page loaded');
            updateStatus('Ready');
            setTimeout(() => {
                log('Auto-loading PBB data...');
                loadPBBData();
            }, 1000);
        });
    </script>
</body>

</html>
