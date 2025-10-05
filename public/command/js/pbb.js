// PBB Module
(function() {
    function init(ctx) {
        const { map, drawnItems, originalBoundary, setBoundaryVisible, calculatePolygonArea, showNotification } = ctx;

        let isDrawing = false;
        let points = [];
        let tempLayer = null;
        let kategori = null;
        let buttonsInjected = false;
        let pendingPayload = null;
        const pbbLayerById = new Map();

        const kategoriMap = { house: 'rumah', field: 'sawah', yard: 'perkarangan', other: 'lainnya' };

        const startDrawing = (key) => {
            if (isDrawing) cancelDrawing();
            isDrawing = true;
            points = [];
            kategori = kategoriMap[key] || key;
            if (tempLayer) { map.removeLayer(tempLayer); tempLayer = null; }
            setBoundaryVisible(false);
            injectButtons();
            showNotification('Mode gambar PBB aktif. Klik peta untuk menambah titik. Klik "Selesai" untuk simpan, atau "Batal".', 'info');
        };

        const cancelDrawing = () => {
            isDrawing = false;
            points = [];
            if (tempLayer) { map.removeLayer(tempLayer); tempLayer = null; }
            kategori = null;
            removeButtons();
            setBoundaryVisible(true);
            showNotification('Mode gambar PBB dibatalkan.', 'info');
        };

        const refreshTemp = () => {
            if (tempLayer) { map.removeLayer(tempLayer); tempLayer = null; }
            if (points.length >= 2) {
                tempLayer = L.polygon(points, { color: '#2563eb', weight: 2, fillOpacity: 0.2 }).addTo(map);
            } else if (points.length === 1) {
                tempLayer = L.circleMarker(points[0], { radius: 4, color: '#2563eb' }).addTo(map);
            }
        };

        const finalizePolygon = () => {
            if (points.length < 3) { showNotification('Minimal 3 titik untuk polygon.', 'error'); return; }
            const coords = points.map(p => [p.lng, p.lat]);
            if (coords.length) {
                const first = coords[0];
                const last = coords[coords.length - 1];
                if (first[0] !== last[0] || first[1] !== last[1]) coords.push(first);
            }
            const geoJson = { type: 'Feature', properties: {}, geometry: { type: 'Polygon', coordinates: [coords] } };
            openModal({ kategori, areaM2: calculatePolygonArea(points), geoJson, points: points.slice() });
        };

        const addPoint = (e) => {
            if (!isDrawing) return;
            if (e.originalEvent && typeof e.originalEvent.stopPropagation === 'function') e.originalEvent.stopPropagation();
            points.push(e.latlng);
            refreshTemp();
        };

        map.on('click', addPoint);
        if (originalBoundary && typeof originalBoundary.on === 'function') originalBoundary.on('click', addPoint);
        if (drawnItems && typeof drawnItems.on === 'function') drawnItems.on('click', addPoint);
        document.addEventListener('keydown', (e) => { if (isDrawing && e.key === 'Escape') cancelDrawing(); });

        const btnHouse = document.getElementById('draw-pbb-house');
        const btnField = document.getElementById('draw-pbb-field');
        const btnYard = document.getElementById('draw-pbb-yard');
        const btnOther = document.getElementById('draw-pbb-other');
        if (btnHouse) btnHouse.addEventListener('click', () => startDrawing('house'));
        if (btnField) btnField.addEventListener('click', () => startDrawing('field'));
        if (btnYard) btnYard.addEventListener('click', () => startDrawing('yard'));
        if (btnOther) btnOther.addEventListener('click', () => startDrawing('other'));

        function injectButtons() {
            if (buttonsInjected) return;
            const drawPanel = document.getElementById('draw-panel');
            if (!drawPanel) return;
            const houseBtn = drawPanel.querySelector('#draw-pbb-house');
            const container = houseBtn ? houseBtn.parentElement : null;
            if (!container) return;
            const wrapper = document.createElement('div');
            wrapper.className = 'col-span-4 mt-2';
            const bar = document.createElement('div');
            bar.id = 'pbb-action-bar';
            bar.className = 'flex space-x-2';
            bar.innerHTML = `
                <button id="pbb-finish-btn" class="flex-1 bg-green-600 text-white font-bold py-2 px-3 rounded-lg hover:bg-green-700 transition">Selesai</button>
                <button id="pbb-cancel-btn" class="flex-1 bg-gray-600 text-white font-bold py-2 px-3 rounded-lg hover:bg-gray-700 transition">Batal</button>
            `;
            wrapper.appendChild(bar);
            container.appendChild(wrapper);
            bar.querySelector('#pbb-finish-btn').addEventListener('click', finalizePolygon);
            bar.querySelector('#pbb-cancel-btn').addEventListener('click', cancelDrawing);
            buttonsInjected = true;
        }

        function removeButtons() {
            const bar = document.getElementById('pbb-action-bar');
            if (bar) {
                const wrapper = bar.parentElement;
                if (wrapper && wrapper.parentElement) wrapper.parentElement.removeChild(wrapper);
            }
            buttonsInjected = false;
        }

        function ensureModal() {
            let modal = document.getElementById('pbb-modal');
            if (modal) return modal;
            const html = `
                <div id="pbb-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-[80] hidden">
                    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md modal-container transform scale-95">
                        <div class="flex justify-between items-center p-4 border-b">
                            <h3 class="text-lg font-bold text-gray-800">Simpan Data PBB</h3>
                            <button id="pbb-modal-close" class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                        </div>
                        <div class="p-5 space-y-4">
                            <div>
                                <label class="block text-sm text-gray-500 mb-1">Kategori</label>
                                <div id="pbb-modal-kategori" class="text-sm font-semibold text-gray-800">-</div>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-500 mb-1">Luas Perkiraan</label>
                                <div id="pbb-modal-area" class="text-sm text-gray-700">- m²</div>
                            </div>
                            <div>
                                <label for="pbb-nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                <input type="text" id="pbb-nama" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label for="pbb-keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                <textarea id="pbb-keterangan" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan keterangan (opsional)"></textarea>
                            </div>
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block text-sm font-medium text-gray-700">Properti Tambahan</label>
                                    <button id="pbb-add-prop" class="text-xs px-2 py-1 bg-gray-100 hover:bg-gray-200 rounded border">Tambah</button>
                                </div>
                                <div id="pbb-props-container" class="space-y-2">
                                    <!-- dynamic rows: code/value -->
                                </div>
                                <template id="pbb-prop-row-template">
                                    <div class="pbb-prop-row grid grid-cols-2 gap-2">
                                        <input type="text" placeholder="Kode" class="pbb-prop-code px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <div class="flex space-x-2">
                                            <input type="text" placeholder="Nilai" class="pbb-prop-value flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <button class="pbb-prop-remove px-2 py-2 text-xs bg-red-100 hover:bg-red-200 rounded border text-red-700">Hapus</button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <div>
                                <label for="pbb-gambar" class="block text-sm font-medium text-gray-700 mb-1">Gambar (opsional)</label>
                                <input type="file" id="pbb-gambar" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="flex justify-end space-x-2 pt-2">
                                <button id="pbb-modal-cancel" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Batal</button>
                                <button id="pbb-modal-save" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>`;
            document.body.insertAdjacentHTML('beforeend', html);
            modal = document.getElementById('pbb-modal');
            modal.querySelector('#pbb-modal-close').addEventListener('click', () => closeModal());
            modal.querySelector('#pbb-modal-cancel').addEventListener('click', () => closeModal());
            modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
            // dynamic property rows handlers
            const propsContainer = modal.querySelector('#pbb-props-container');
            const template = modal.querySelector('#pbb-prop-row-template');
            const addBtn = modal.querySelector('#pbb-add-prop');
            const addRow = () => {
                const node = template.content.firstElementChild.cloneNode(true);
                node.querySelector('.pbb-prop-remove').addEventListener('click', (ev) => {
                    ev.preventDefault();
                    const row = ev.target.closest('.pbb-prop-row');
                    if (row) row.remove();
                });
                propsContainer.appendChild(node);
            };
            addBtn.addEventListener('click', (ev) => { ev.preventDefault(); addRow(); });
            // start with one empty row for convenience
            addRow();
            return modal;
        }

        function openModal(payload) {
            pendingPayload = payload;
            const modal = ensureModal();
            modal.classList.remove('hidden');
            setTimeout(() => { modal.querySelector('.modal-container').classList.remove('scale-95'); }, 10);
            modal.querySelector('#pbb-modal-kategori').textContent = (payload.kategori || '').toString();
            modal.querySelector('#pbb-modal-area').textContent = `${(payload.areaM2 || 0).toFixed(2)} m²`;
            modal.querySelector('#pbb-modal-save').onclick = () => saveData();
        }

        function closeModal() {
            const modal = document.getElementById('pbb-modal');
            if (!modal) return;
            const container = modal.querySelector('.modal-container');
            if (container) container.classList.add('scale-95');
            setTimeout(() => { modal.classList.add('hidden'); }, 150);
        }

        async function saveData() {
            if (!pendingPayload) return;
            const name = document.getElementById('pbb-nama').value.trim();
            const description = document.getElementById('pbb-keterangan').value.trim();
            const imageFile = document.getElementById('pbb-gambar').files[0];
            if (!name) { showNotification('Nama wajib diisi.', 'error'); return; }
            try {
                const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = tokenMeta ? tokenMeta.getAttribute('content') : '';
                // collect dynamic properties
                const props = { area_m2: pendingPayload.areaM2 };
                document.querySelectorAll('#pbb-props-container .pbb-prop-row').forEach(row => {
                    const code = row.querySelector('.pbb-prop-code').value.trim();
                    const val = row.querySelector('.pbb-prop-value').value.trim();
                    if (code) {
                        props[code] = val;
                    }
                });
                if (imageFile) {
                    const form = new FormData();
                    form.append('nama', name);
                    form.append('keterangan', description);
                    form.append('status', 'active');
                    form.append('kategori', pendingPayload.kategori || '');
                    form.append('gambar', imageFile);
                    form.append('geo_json', JSON.stringify(pendingPayload.geoJson));
                    form.append('properties', JSON.stringify(props));
                    const res = await fetch('/api/pbb', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken }, body: form });
                    const result = await res.json();
                    await onSaved(result, name);
                } else {
                    const res = await fetch('/api/pbb', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                        body: JSON.stringify({
                            nama: name, keterangan: description, status: 'active', kategori: pendingPayload.kategori || '',
                            geo_json: pendingPayload.geoJson, properties: props
                        })
                    });
                    const result = await res.json();
                    await onSaved(result, name);
                }
            } catch (err) {
                console.error(err);
                showNotification('Terjadi kesalahan saat menyimpan polygon PBB.', 'error');
            }
        }

        async function onSaved(result, name) {
            if (result && result.success) {
                showNotification('Polygon PBB tersimpan.', 'success');
                if (tempLayer) { map.removeLayer(tempLayer); tempLayer = null; }
                const finalLayer = L.polygon(pendingPayload.points, { color: '#16a34a', weight: 2, fillOpacity: 0.25 });
                finalLayer.addTo(drawnItems).bindPopup(`<div class="popup-title">${name}</div><div class="text-xs">${kategori || ''}</div>`);
                closeModal();
                cancelDrawing();
                // Reload PBB data after saving
                await loadPBBData();
            } else {
                showNotification((result && result.message) || 'Gagal menyimpan polygon PBB.', 'error');
            }
        }
        loadPBBData()
        // Load PBB data from API
        async function loadPBBData() {
            try {
                console.log('Loading PBB data...');
                const response = await fetch('/api/pbb');
                const result = await response.json();

                console.log('PBB API Response:', result);

                if (result.success && result.data) {
                    console.log('PBB Data loaded:', result.data.length, 'items');

                    // Clear existing PBB layers and mapping
                    drawnItems.eachLayer((layer) => {
                        if (layer.pbbData) {
                            drawnItems.removeLayer(layer);
                        }
                    });
                    pbbLayerById.clear();

                    // Add each PBB polygon to the map
                    result.data.forEach((pbbItem, index) => {
                        console.log(`Processing PBB item ${index + 1}:`, pbbItem);

                        if (pbbItem.geo_json && pbbItem.geo_json.geometry) {
                            try {

                                if (Array.isArray(pbbItem.geo_json.properties)) {
                                    pbbItem.geo_json.properties = {};
                                }

                                // Ensure we have valid coordinates
                                if (!pbbItem.geo_json.geometry.coordinates || !Array.isArray(pbbItem.geo_json.geometry.coordinates[0])) {
                                    console.warn(`PBB item ${index + 1} has invalid coordinates`);
                                    return;
                                }

                                const geoJsonLayer = L.geoJSON(pbbItem.geo_json, {
                                    style: getPBBStyle(pbbItem.kategori),
                                    onEachFeature: (feature, layer) => {
                                        layer.pbbData = pbbItem;
                                        layer.bindPopup(createPBBPopup(pbbItem));
                                        layer.on('popupopen', (e) => {
                                            const popupEl = e.popup.getElement();
                                            if (!popupEl) return;
                                            const btn = popupEl.querySelector('.pbb-open-detail');
                                            if (btn) {
                                                btn.addEventListener('click', (ev) => {
                                                    ev.preventDefault();
                                                    showPBBDetailModal(pbbItem);
                                                });
                                            }
                                        });
                                        layer.on('click', () => showPBBDetailModal(pbbItem));
                                    }
                                });
                                drawnItems.addLayer(geoJsonLayer);
                                pbbLayerById.set(pbbItem.id, geoJsonLayer);
                                console.log(`PBB polygon ${index + 1} added to map successfully`);
                                console.log(`Polygon bounds:`, geoJsonLayer.getBounds());
                            } catch (error) {
                                console.error(`Error adding PBB polygon ${index + 1}:`, error);
                            }
                        } else {
                            console.warn(`PBB item ${index + 1} has invalid geo_json:`, pbbItem.geo_json);
                        }
                    });

                    // Fit map to show all PBB polygons
                    if (drawnItems.getLayers().length > 0) {
                        map.fitBounds(drawnItems.getBounds(), { padding: [20, 20] });
                    }

                    // Render sidebar list
                    renderPBBList(result.data);

                    console.log('PBB data loading completed');
                    showNotification(`Data PBB berhasil dimuat (${result.data.length} item)`, 'success');
                } else {
                    console.warn('PBB API returned no data:', result);
                    showNotification('Tidak ada data PBB yang ditemukan.', 'info');
                }
            } catch (error) {
                console.error('Error loading PBB data:', error);
                showNotification('Gagal memuat data PBB: ' + error.message, 'error');
            }
        }

        // Render list of PBB items into sidebar and attach click handlers
        function renderPBBList(items) {
            const container = document.getElementById('data-pbb-container');
            if (!container) return;
            if (!Array.isArray(items) || items.length === 0) {
                container.innerHTML = '<p class="text-center italic text-gray-400">Belum ada data PBB.</p>';
                return;
            }
            // attach search handler (once)
            const searchInput = document.getElementById('pbb-search');
            if (searchInput && !searchInput._pbbBound) {
                searchInput._pbbBound = true;
                searchInput.addEventListener('input', () => {
                    const q = searchInput.value.toLowerCase();
                    const filtered = items.filter((it) => {
                        const name = (it.nama || '').toLowerCase();
                        const kategori = (it.kategori || '').toLowerCase();
                        const props = it.properties && typeof it.properties === 'object' ? Object.entries(it.properties) : [];
                        const propHit = props.some(([k, v]) => (k || '').toLowerCase().includes(q) || String(v || '').toLowerCase().includes(q));
                        return name.includes(q) || kategori.includes(q) || propHit;
                    });
                    renderPBBList(filtered);
                });
            }

            const html = items.map((it) => {
                const area = it.properties && typeof it.properties === 'object' && typeof it.properties.area_m2 === 'number'
                    ? `${it.properties.area_m2.toFixed(2)} m²` : 'N/A';
                const kategori = it.kategori || '-';
                return `
                    <button class="w-full text-left p-2 rounded border hover:bg-gray-50 focus:bg-gray-50 flex items-center justify-between" data-pbb-id="${it.id}">
                        <div class="mr-3 flex-1">
                            <div class="font-semibold text-gray-800 text-sm truncate">${it.nama || 'Tanpa Nama'}</div>
                            <div class="text-xs text-gray-500">${kategori} • ${area}</div>
                        </div>
                        <i class="fa-solid fa-location-crosshairs text-gray-500"></i>
                    </button>
                `;
            }).join('');
            container.innerHTML = html;
            container.querySelectorAll('[data-pbb-id]').forEach(el => {
                el.addEventListener('click', () => {
                    const id = parseInt(el.getAttribute('data-pbb-id'));
                    focusPBBOnMap(id);
                });
            });
        }

        function focusPBBOnMap(id) {
            const layerGroup = pbbLayerById.get(id);
            if (!layerGroup) return;
            try {
                const bounds = layerGroup.getBounds();
                map.fitBounds(bounds, { padding: [20, 20] });
                // open first feature popup if available
                let opened = false;
                layerGroup.eachLayer(l => {
                    if (!opened && typeof l.openPopup === 'function') {
                        // Delay slightly to ensure map has moved
                        setTimeout(() => l.openPopup(), 200);
                        opened = true;
                    }
                });
            } catch (e) {
                console.warn('Unable to focus PBB layer', e);
            }
        }

        // Get style for PBB polygon based on category
        function getPBBStyle(kategori) {
            const styles = {
                'rumah': { color: '#dc2626', fillColor: '#fef2f2', weight: 3, fillOpacity: 0.4 },
                'sawah': { color: '#16a34a', fillColor: '#f0fdf4', weight: 3, fillOpacity: 0.4 },
                'perkarangan': { color: '#d97706', fillColor: '#fffbeb', weight: 3, fillOpacity: 0.4 },
                'lainnya': { color: '#6b7280', fillColor: '#f9fafb', weight: 3, fillOpacity: 0.4 }
            };
            return styles[kategori] || styles['lainnya'];
        }

        // Create popup content for PBB polygon
        function createPBBPopup(pbbItem) {
            const area = pbbItem.properties?.area_m2 ? `${pbbItem.properties.area_m2.toFixed(2)} m²` : 'N/A';
            return `
                <div class="pbb-popup">
                    <div class="popup-title">${pbbItem.nama || 'Nama tidak tersedia'}</div>
                    <div class="text-xs text-gray-600 mt-1">Kategori: ${pbbItem.kategori || 'N/A'}</div>
                    <div class="text-xs text-gray-600">Luas: ${area}</div>
                    <button type="button" class="pbb-open-detail text-xs text-blue-600 mt-1 underline" data-pbb-id="${pbbItem.id}">Klik untuk detail →</button>
                </div>
            `;
        }

        // Show PBB detail modal
        function showPBBDetailModal(pbbItem) {
            const modal = ensureDetailModal();
            modal.currentPbbData = pbbItem; // Store current PBB data
            modal.classList.remove('hidden');
            setTimeout(() => { modal.querySelector('.modal-container').classList.remove('scale-95'); }, 10);

            // Populate modal with PBB data
            modal.querySelector('#pbb-detail-nama').textContent = pbbItem.nama || 'Nama tidak tersedia';
            modal.querySelector('#pbb-detail-kategori').textContent = pbbItem.kategori || 'N/A';
            modal.querySelector('#pbb-detail-area').textContent = pbbItem.properties?.area_m2 ? `${pbbItem.properties.area_m2.toFixed(2)} m²` : 'N/A';
            modal.querySelector('#pbb-detail-keterangan').textContent = pbbItem.keterangan || 'Tidak ada keterangan';
            modal.querySelector('#pbb-detail-status').textContent = pbbItem.status || 'N/A';
            modal.querySelector('#pbb-detail-created').textContent = pbbItem.created_at || 'N/A';

            // Handle image display
            const imageContainer = modal.querySelector('#pbb-detail-image');
            if (pbbItem.gambar_url) {
                imageContainer.innerHTML = `<img src="${pbbItem.gambar_url}" alt="${pbbItem.nama}" class="w-full h-32 object-cover rounded-md">`;
            } else {
                imageContainer.innerHTML = '<div class="w-full h-32 bg-gray-200 rounded-md flex items-center justify-center text-gray-500">Tidak ada gambar</div>';
            }

            // Populate properties list
            const propsEl = modal.querySelector('#pbb-detail-properties');
            try {
                const props = (pbbItem.properties && typeof pbbItem.properties === 'object') ? pbbItem.properties : {};
                const entries = Object.entries(props);
                if (entries.length === 0) {
                    propsEl.innerHTML = '<span class="text-gray-400">Tidak ada properti</span>';
                } else {
                    propsEl.innerHTML = entries.map(([k, v]) => {
                        const valueText = (v === null || v === undefined) ? '' : (typeof v === 'object' ? JSON.stringify(v) : String(v));
                        return `<div class="flex text-xs"><span class="w-32 text-gray-500">${k}</span><span class="flex-1 break-all">: ${valueText}</span></div>`;
                    }).join('');
                }
            } catch (e) {
                propsEl.innerHTML = '<span class="text-red-500">Gagal memuat properti</span>';
            }
        }

        // Ensure detail modal exists
        function ensureDetailModal() {
            let modal = document.getElementById('pbb-detail-modal');
            if (modal) return modal;

            const html = `
                <div id="pbb-detail-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-[90] hidden">
                    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg modal-container transform scale-95">
                        <div class="flex justify-between items-center p-4 border-b">
                            <h3 class="text-lg font-bold text-gray-800">Detail Data PBB</h3>
                            <button id="pbb-detail-close" class="text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                        </div>
                        <div class="p-5 space-y-4">
                            <div id="pbb-detail-image"></div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama</label>
                                    <div id="pbb-detail-nama" class="text-sm font-semibold text-gray-800">-</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Kategori</label>
                                    <div id="pbb-detail-kategori" class="text-sm text-gray-700">-</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Luas Area</label>
                                    <div id="pbb-detail-area" class="text-sm text-gray-700">-</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                                    <div id="pbb-detail-status" class="text-sm text-gray-700">-</div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Keterangan</label>
                                <div id="pbb-detail-keterangan" class="text-sm text-gray-700">-</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Properti</label>
                                <div id="pbb-detail-properties" class="text-sm text-gray-700 space-y-1">-</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Dibuat</label>
                                <div id="pbb-detail-created" class="text-sm text-gray-700">-</div>
                            </div>
                            <div class="flex justify-end space-x-2 pt-2">
                                <button id="pbb-detail-edit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Edit</button>
                                <button id="pbb-detail-delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus</button>
                                <button id="pbb-detail-close-btn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>`;

            document.body.insertAdjacentHTML('beforeend', html);
            modal = document.getElementById('pbb-detail-modal');

            // Add event listeners
            modal.querySelector('#pbb-detail-close').addEventListener('click', () => closeDetailModal());
            modal.querySelector('#pbb-detail-close-btn').addEventListener('click', () => closeDetailModal());
            modal.addEventListener('click', (e) => { if (e.target === modal) closeDetailModal(); });

            // Add edit and delete event listeners
            modal.querySelector('#pbb-detail-edit').addEventListener('click', () => {
                const pbbData = modal.currentPbbData;
                if (pbbData) {
                    editPBBData(pbbData);
                }
            });

            modal.querySelector('#pbb-detail-delete').addEventListener('click', () => {
                const pbbData = modal.currentPbbData;
                if (pbbData) {
                    deletePBBData(pbbData);
                }
            });

            return modal;
        }

        // Close detail modal
        function closeDetailModal() {
            const modal = document.getElementById('pbb-detail-modal');
            if (!modal) return;
            const container = modal.querySelector('.modal-container');
            if (container) container.classList.add('scale-95');
            setTimeout(() => { modal.classList.add('hidden'); }, 150);
        }

        // Edit PBB data
        function editPBBData(pbbData) {
            // Close detail modal first
            closeDetailModal();

            // For now, just show a notification that edit feature is not implemented yet
            showNotification('Fitur edit akan segera tersedia.', 'info');


            // This would involve:
            // 1. Opening the edit modal with current data
            // 2. Allowing user to modify fields
            // 3. Sending PUT request to update data
            // 4. Refreshing the map display
        }

        // Delete PBB data
        async function deletePBBData(pbbData) {
            if (!confirm(`Apakah Anda yakin ingin menghapus data PBB "${pbbData.nama}"?`)) {
                return;
            }

            try {
                const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = tokenMeta ? tokenMeta.getAttribute('content') : '';

                const response = await fetch(`/api/pbb/${pbbData.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    showNotification('Data PBB berhasil dihapus.', 'success');
                    closeDetailModal();
                    // Reload PBB data to refresh the map
                    await loadPBBData();
                } else {
                    showNotification(result.message || 'Gagal menghapus data PBB.', 'error');
                }
            } catch (error) {
                console.error('Error deleting PBB data:', error);
                showNotification('Terjadi kesalahan saat menghapus data PBB.', 'error');
            }
        }

        // Expose functions for external use
        window.PBBModule = {
            init,
            loadPBBData,
            showPBBDetailModal,
            initializePBB,
            editPBBData,
            deletePBBData
        };
    }

    // Initialize PBB module function (outside init scope)
    async function initializePBB() {
        console.log('Initializing PBB module...');
        try {
            if (window.PBBModule && typeof window.PBBModule.loadPBBData === 'function') {
                await window.PBBModule.loadPBBData();
                console.log('PBB module initialized successfully');
            } else {
                console.error('PBBModule not properly initialized');
                console.log('Available PBBModule functions:', Object.keys(window.PBBModule || {}));
            }
        } catch (error) {
            console.error('Error initializing PBB module:', error);
            if (window.showNotification) {
                window.showNotification('Gagal menginisialisasi modul PBB.', 'error');
            }
        }
    }

    // Ensure a global namespace exists and expose the real init upfront
    // so external code calls the actual initializer rather than a no-op.
    if (!window.PBBModule) {
        window.PBBModule = {};
    }
    // Expose the real init and initializer helper immediately
    window.PBBModule.init = init;
    window.PBBModule.initializePBB = initializePBB;
    // Provide safe placeholders for functions that are only available after init
    window.PBBModule.loadPBBData = window.PBBModule.loadPBBData || (() => console.log('PBBModule not initialized yet'));
    window.PBBModule.showPBBDetailModal = window.PBBModule.showPBBDetailModal || (() => console.log('PBBModule not initialized yet'));
    window.PBBModule.editPBBData = window.PBBModule.editPBBData || (() => console.log('PBBModule not initialized yet'));
    window.PBBModule.deletePBBData = window.PBBModule.deletePBBData || (() => console.log('PBBModule not initialized yet'));
})();


