<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test PBB Display</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        #map {
            height: 400px;
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
    <h1>Test PBB Data Display</h1>

    <div class="info">
        <p><strong>Status:</strong> <span id="status">Loading...</span></p>
        <p><strong>Data Count:</strong> <span id="dataCount">-</span></p>
    </div>

    <button onclick="loadPBBData()">Load PBB Data</button>
    <button onclick="clearMap()">Clear Map</button>

    <div id="map"></div>

    <div id="console"
        style="margin-top: 20px; padding: 10px; background: #f8f9fa; border-radius: 5px; font-family: monospace; font-size: 12px; max-height: 200px; overflow-y: auto;">
        <strong>Console Log:</strong><br>
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
            const console = document.getElementById('console');
            console.innerHTML += new Date().toLocaleTimeString() + ': ' + message + '<br>';
            console.scrollTop = console.scrollHeight;
            console.log(message);
        }

        function updateStatus(status, count = null) {
            document.getElementById('status').textContent = status;
            if (count !== null) {
                document.getElementById('dataCount').textContent = count;
            }
        }

        async function loadPBBData() {
            try {
                updateStatus('Loading...');
                log('Starting PBB data load...');

                const response = await fetch('/api/pbb');
                log('API Response received: ' + response.status);

                const result = await response.json();
                log('JSON parsed: ' + JSON.stringify(result).substring(0, 200) + '...');

                if (result.success && result.data) {
                    log('Data found: ' + result.data.length + ' items');

                    // Clear existing layers
                    drawnItems.clearLayers();

                    // Add each PBB polygon to the map
                    result.data.forEach((pbbItem, index) => {
                        log(`Processing item ${index + 1}: ${pbbItem.nama}`);

                        if (pbbItem.geo_json && pbbItem.geo_json.geometry) {
                            try {
                                // Fix geo_json structure if properties is empty array
                                if (Array.isArray(pbbItem.geo_json.properties)) {
                                    pbbItem.geo_json.properties = {};
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
                                            </div>
                                        `);
                                    }
                                });
                                drawnItems.addLayer(geoJsonLayer);
                                log(`Polygon ${index + 1} added successfully`);
                            } catch (error) {
                                log(`Error adding polygon ${index + 1}: ${error.message}`);
                            }
                        } else {
                            log(`Item ${index + 1} has invalid geo_json`);
                        }
                    });

                    updateStatus('Loaded successfully', result.data.length);
                    log('PBB data loading completed');
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

        // Auto-load on page load
        window.addEventListener('load', () => {
            log('Page loaded, starting auto-load...');
            setTimeout(loadPBBData, 1000);
        });
    </script>
</body>

</html>
