<!-- Information Dashboard Section -->
<aside
    class="absolute top-0 right-0 h-full z-10 w-full md:w-1/3 max-w-lg bg-white/90 backdrop-blur-sm p-4 flex flex-col gap-4 overflow-y-auto shadow-lg">
    <!-- Profil Desa -->
    <div class="bg-white p-5 rounded-xl shadow-lg">
        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Profil Desa</h2>
        <div class="flex items-center space-x-4">
            <img id="foto-kades" src="" alt="Foto Kepala Desa"
                class="w-20 h-20 rounded-full object-cover border-2 border-blue-200 shadow-md">
            <div class="flex-1 space-y-2 text-sm text-gray-600">
                <div class="flex justify-between"><span>Kepala Desa:</span> <strong id="nama-kades"
                        class="text-gray-800"></strong></div>
                <div class="flex justify-between"><span>Luas Wilayah:</span> <strong id="luas-wilayah"
                        class="text-gray-800"></strong></div>
                <div class="flex justify-between"><span>Kecamatan:</span> <strong id="kecamatan"
                        class="text-gray-800">Gunungsari</strong></div>
                <div class="flex justify-between"><span>Kabupaten:</span> <strong id="kabupaten"
                        class="text-gray-800">Lombok
                        Barat</strong></div>
            </div>
        </div>
    </div>

    <!-- Demografi -->
    <div class="bg-white p-5 rounded-xl shadow-lg">
        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Demografi</h2>
        <div class="space-y-2 text-sm">
            <div class="flex items-center justify-between p-2 bg-blue-50 rounded-lg">
                <div class="flex items-center"><i class="fas fa-users text-blue-500 w-5 text-center"></i><span
                        class="ml-2">Total
                        Penduduk</span></div>
                <strong id="total-penduduk" class="text-blue-800 bg-blue-200 px-2 py-1 rounded"></strong>
            </div>
            <div class="flex items-center justify-between p-2 bg-green-50 rounded-lg">
                <div class="flex items-center"><i class="fas fa-male text-green-500 w-5 text-center"></i><span
                        class="ml-2">Laki-laki</span></div>
                <strong id="jumlah-pria" class="text-green-800 bg-green-200 px-2 py-1 rounded"></strong>
            </div>
            <div class="flex items-center justify-between p-2 bg-pink-50 rounded-lg">
                <div class="flex items-center"><i class="fas fa-female text-pink-500 w-5 text-center"></i><span
                        class="ml-2">Perempuan</span></div>
                <strong id="jumlah-wanita" class="text-pink-800 bg-pink-200 px-2 py-1 rounded"></strong>
            </div>
        </div>
    </div>

    <!-- Komposisi Generasi -->
    <div class="bg-white p-5 rounded-xl shadow-lg">
        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Komposisi Generasi</h2>
        <div id="data-generasi-container" class="space-y-3 text-sm">
            <!-- Data Generasi akan dimasukkan oleh JavaScript -->
        </div>
    </div>

    <!-- Komposisi Agama -->
    <div class="bg-white p-5 rounded-xl shadow-lg">
        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Komposisi Agama</h2>
        <div id="data-agama-container" class="space-y-2 text-sm">
            <!-- Data Agama akan dimasukkan oleh JavaScript -->
        </div>
    </div>

    <!-- Tingkat Pendidikan -->
    <div class="bg-white p-5 rounded-xl shadow-lg">
        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Tingkat Pendidikan</h2>
        <div id="data-pendidikan-container" class="space-y-3 text-sm">
            <!-- Data Pendidikan akan dimasukkan oleh JavaScript -->
        </div>
    </div>

    <!-- Struktur Pekerjaan -->
    <div class="bg-white p-5 rounded-xl shadow-lg">
        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Struktur Pekerjaan</h2>
        <div id="data-pekerjaan-container" class="space-y-2 text-sm">
            <!-- Data Pekerjaan akan dimasukkan oleh JavaScript -->
        </div>
    </div>

    <!-- Pengangguran -->
    <div class="bg-white p-5 rounded-xl shadow-lg">
        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Tingkat Pengangguran</h2>
        <div id="data-pengangguran-container" class="space-y-3 text-sm">
            <!-- Data Pengangguran akan dimasukkan oleh JavaScript -->
        </div>
    </div>

    <!-- APBDes -->
    <div class="bg-white p-5 rounded-xl shadow-lg">
        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Anggaran Desa (APBDes)</h2>
        <div id="apbdes-container" class="space-y-4 text-sm">
            <!-- Data APBDes akan dimasukkan oleh JavaScript -->
        </div>
    </div>

    <!-- Pajak Bumi & Bangunan (PBB) -->
    <div class="bg-white p-5 rounded-xl shadow-lg">
        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Pajak Bumi & Bangunan (PBB)</h2>
        <div class="mb-2">
            <input id="pbb-search" type="text" placeholder="Cari PBB (nama/kategori/kode)"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
        </div>
        <div id="data-pbb-container" class="space-y-2 text-sm max-h-72 overflow-y-auto pr-1">
            <!-- List data PBB diisi oleh JavaScript -->
        </div>
    </div>

    <!-- Data Sosial -->
    <div class="bg-white p-5 rounded-xl shadow-lg">
        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Data Sosial</h2>
        <div id="data-sosial-container" class="space-y-2 text-sm">
            <!-- Data sosial akan dimasukkan oleh JavaScript -->
        </div>
    </div>

    <!-- Kondisi Jalan -->
    <div class="bg-white p-5 rounded-xl shadow-lg">
        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Kondisi Jalan Desa</h2>
        <div id="data-jalan-container" class="space-y-3 text-sm">
            <ul class="space-y-3">
                <!-- Total Road Length -->
                <li class="flex justify-between items-center p-2 bg-gray-50 rounded-lg hidden">
                    <span class="text-sm font-medium text-gray-700">Total Panjang Jalan (Digambar):</span>
                    <strong class="text-gray-800" id="total-road-length">0.00 km</strong>
                </li>

                <!-- Road Condition Description -->
                <li class="p-3 bg-blue-50 rounded-lg border-l-4 border-blue-400 hidden">
                    <div class="flex items-start">
                        <i class="fa-solid fa-info-circle text-blue-500 mt-1 mr-2"></i>
                        <div>
                            <p class="text-sm text-blue-800 font-medium mb-1">Analisis Kondisi Jalan:</p>
                            <p class="text-sm text-blue-700" id="road-analysis">Belum ada data jalan tersedia.</p>
                        </div>
                    </div>
                </li>

                <!-- Road Statistics -->
                <li class="p-2 bg-green-50 rounded-lg">
                    <div class="mb-1 flex justify-between">
                        <span class="text-green-600 font-semibold flex items-center">
                            <i class="fa-solid fa-road mr-2"></i>Jalan Bagus
                        </span>
                        <span id="good-road-stats">0.00 km (0%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-green-500 h-2.5 rounded-full" id="good-road-progress" style="width: 0%"></div>
                    </div>
                </li>

                <li class="p-2 bg-red-50 rounded-lg">
                    <div class="mb-1 flex justify-between">
                        <span class="text-red-600 font-semibold flex items-center">
                            <i class="fa-solid fa-road-circle-exclamation mr-2"></i>Jalan Rusak
                        </span>
                        <span id="bad-road-stats">0.00 km (0%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-red-500 h-2.5 rounded-full" id="bad-road-progress" style="width: 0%"></div>
                    </div>
                </li>

                <li class="p-2 bg-orange-50 rounded-lg">
                    <div class="mb-1 flex justify-between">
                        <span class="text-orange-500 font-semibold flex items-center">
                            <i class="fa-solid fa-road-lane mr-2"></i>Jalan Gang
                        </span>
                        <span id="alley-road-stats">0.00 km (0%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-orange-500 h-2.5 rounded-full" id="alley-road-progress" style="width: 0%"></div>
                    </div>
                </li>

                <!-- Specific Notes -->
                <li class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-600 font-medium mb-2 flex items-center">
                        <i class="fa-solid fa-clipboard-list mr-2"></i>Catatan Khusus:
                    </p>
                    <ul class="text-xs text-gray-600 space-y-1" id="road-notes">
                        <li class="flex items-center p-1 hover:bg-gray-100 rounded">
                            <i class="fa-solid fa-circle text-gray-400 mr-2" style="font-size: 4px;"></i>
                            <span>Belum ada data jalan tersedia</span>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <!-- Legenda Peta -->
    <div class="bg-white p-5 rounded-xl shadow-lg">
        <h2 class="text-lg font-bold text-gray-700 border-b pb-2 mb-3">Legenda Peta</h2>
        <div id="legenda-peta" class="space-y-2 text-sm">
            <div class="flex items-center"><i class="fa-solid fa-landmark w-5 text-center " style="color:blue"></i><span
                    class="icon-label">Pemerintahan</span></div>
            <div class="flex items-center"><i class="fa-solid fa-school w-5 text-center " style="color:orange"></i><span
                    class="icon-label">Pendidikan</span></div>
            <div class="flex items-center"><i class="fa-solid fa-briefcase-medical w-5 text-center "
                    style="color:red"></i><span class="icon-label">Kesehatan</span></div>
            <div class="flex items-center"><i class="fa-solid fa-mosque w-5 text-center " style="color:green"></i><span
                    class="icon-label">Ibadah</span></div>
            <div class="flex items-center"><i class="fa-solid fa-water w-5 text-center " style="color:purple"></i><span
                    class="icon-label">Wisata</span></div>
            <div class="flex items-center"><i class="fa-solid fa-child-reaching w-5 text-center "
                    style="color:var(--color-amber-500)"></i><span class="icon-label">Stunting</span></div>
            <div class="flex items-center"><i class="fa-solid fa-house-crack w-5 text-center "
                    style="color:var(--color-stone-500)"></i><span class="icon-label">Rumah Tdk Layak</span></div>
            <div class="flex items-center"><i class="fa-solid fa-person-cane w-5 text-center "
                    style="color:var(--color-sky-500)"></i><span class="icon-label">Lansia</span></div>
            <div class="flex items-center"><i class="fa-solid fa-hands-holding-child w-5 text-center "
                    style="color:var(--color-teal-500)"></i><span class="icon-label">Anak Yatim</span></div>
            <div class="flex items-center"><i class="fa-solid fa-video w-5 text-center " style="color:#4b5563"></i><span
                    class="icon-label">CCTV</span></div>
        </div>
    </div>
</aside>


@push('scripts')
    <script>
        function populateDashboard() {
            // Update profile data
            document.getElementById('foto-kades').src = villageData.profile.fotoUrl;
            document.getElementById('nama-kades').textContent = villageData.profile.kepalaDesa;
            document.getElementById('luas-wilayah').textContent = villageData.profile.luasWilayah;

            // Update demography data
            const { demography } = villageData;
            if (demography) {
                document.getElementById('total-penduduk').textContent = demography.total.toLocaleString('id-ID');
                document.getElementById('jumlah-pria').textContent = demography.pria.toLocaleString('id-ID');
                document.getElementById('jumlah-wanita').textContent = demography.wanita.toLocaleString('id-ID');

                // Update agama container
                const agamaContainer = document.getElementById('data-agama-container');
                agamaContainer.innerHTML = '';
                if (demography.religion) {
                    demography.religion.forEach(item => {
                        const percentage = ((item.total / demography.total) * 100).toFixed(2);
                        const div = document.createElement('div');
                        div.className = 'flex items-center justify-between p-2 ' + item.bgColor + ' rounded-lg';
                        div.innerHTML = '<div class="flex items-center">' +
                            '<i class="' + item.icon + ' ' + item.color + ' w-5 text-center"></i>' +
                            '<span class="ml-2">' + item.name + '</span>' +
                            '</div>' +
                            '<div class="text-right">' +
                            '<strong class="text-gray-800">' + item.total.toLocaleString('id-ID') + '</strong>' +
                            '<small class="block text-gray-500 text-xs">' + percentage + '%</small>' +
                            '</div>';
                        agamaContainer.appendChild(div);
                    });
                }

                // Update generasi container
                const generasiContainer = document.getElementById('data-generasi-container');
                generasiContainer.innerHTML = '';
                if (demography.generations) {
                    demography.generations.forEach(item => {
                        const percentage = ((item.total / demography.total) * 100).toFixed(1);
                        const div = document.createElement('div');
                        div.innerHTML = '<div>' +
                            '<div class="mb-1 flex justify-between items-center">' +
                            '<span class="font-semibold text-gray-700 flex items-center"><i class="' + item.icon + ' w-5 text-center mr-2 ' + item.color.replace('bg-', 'text-') + '"></i> ' + item.name + '</span>' +
                            '<span>' + item.total.toLocaleString('id-ID') + ' (' + percentage + '%)</span>' +
                            '</div>' +
                            '<div class="w-full bg-gray-200 rounded-full h-2.5">' +
                            '<div class="' + item.color + ' h-2.5 rounded-full" style="width: ' + percentage + '%"></div>' +
                            '</div>' +
                            '</div>';
                        generasiContainer.appendChild(div);
                    });
                }

                // Update pendidikan container
                const pendidikanContainer = document.getElementById('data-pendidikan-container');
                pendidikanContainer.innerHTML = '';
                if (demography.education) {
                    demography.education.forEach(item => {
                        const percentage = ((item.total / demography.total) * 100).toFixed(1);
                        const div = document.createElement('div');
                        div.innerHTML = '<div>' +
                            '<div class="mb-1 flex justify-between">' +
                            '<span class="font-semibold text-gray-700">' + item.name + '</span>' +
                            '<span>' + item.total.toLocaleString('id-ID') + ' (' + percentage + '%)</span>' +
                            '</div>' +
                            '<div class="w-full bg-gray-200 rounded-full h-2.5">' +
                            '<div class="' + item.color + ' h-2.5 rounded-full" style="width: ' + percentage + '%"></div>' +
                            '</div>' +
                            '</div>';
                        pendidikanContainer.appendChild(div);
                    });
                }

                // Update pekerjaan container
                const pekerjaanContainer = document.getElementById('data-pekerjaan-container');
                pekerjaanContainer.innerHTML = '';
                if (demography.occupation) {
                    const totalPekerja = demography.occupation.reduce((sum, item) => sum + item.total, 0);
                    demography.occupation.forEach(item => {
                        const percentage = ((item.total / totalPekerja) * 100).toFixed(1);
                        const div = document.createElement('div');
                        div.className = 'flex items-center justify-between p-2 ' + item.bgColor + ' rounded-lg';
                        div.innerHTML = '<div class="flex items-center">' +
                            '<i class="' + item.icon + ' ' + item.color + ' w-5 text-center"></i>' +
                            '<span class="ml-2">' + item.name + '</span>' +
                            '</div>' +
                            '<div class="text-right">' +
                            '<strong class="text-gray-800">' + item.total.toLocaleString('id-ID') + '</strong>' +
                            '<small class="block text-gray-500 text-xs">' + percentage + '%</small>' +
                            '</div>';
                        pekerjaanContainer.appendChild(div);
                    });
                }
            }
        }
        async function loadVillageData() {
            try {
                const response = await fetch('/data-penduduk');
                const data = await response.json();

                // Update profile data
                if (data.dataDesa) {
                    villageData.profile = {
                        namaDesa: data.dataDesa.namaDesa,
                        kepalaDesa: data.dataDesa.kepalaDesa,
                        luasWilayah: data.dataDesa.luasWilayah,
                        fotoUrl: data.dataDesa.fotoUrl,
                        kecamatan: data.dataDesa.kecamatan,
                        kabupaten: data.dataDesa.kabupaten
                    };

                    // Update profile data in the DOM
                    const fotoKades = document.getElementById('foto-kades');
                    const namaKades = document.getElementById('nama-kades');
                    const luasWilayah = document.getElementById('luas-wilayah');
                    const kecamatan = document.getElementById('kecamatan');
                    const kabupaten = document.getElementById('kabupaten');

                    if (fotoKades && data.dataDesa.fotoUrl) {
                        fotoKades.src = data.dataDesa.fotoUrl;
                    }
                    if (namaKades && data.dataDesa.kepalaDesa) {
                        namaKades.textContent = data.dataDesa.kepalaDesa;
                    }
                    if (luasWilayah && data.dataDesa.luasWilayah) {
                        luasWilayah.textContent = data.dataDesa.luasWilayah;
                    }
                    if (kecamatan && data.dataDesa.kecamatan) {
                        kecamatan.textContent = data.dataDesa.kecamatan;
                    }
                    if (kabupaten && data.dataDesa.kabupaten) {
                        kabupaten.textContent = data.dataDesa.kabupaten;
                    }
                }

                // Update demography data
                villageData.demography = {
                    total: data.demografi.totalPenduduk,
                    pria: data.demografi.totalPria,
                    wanita: data.demografi.totalWanita
                };

                // Update generation composition
                villageData.demography.generations = Object.values(data.komposisiGenerasi).map(gen => ({
                    name: gen.label,
                    total: gen.count,
                    percentage: gen.percentage,
                    color: getGenerationColor(gen.label),
                    icon: getGenerationIcon(gen.label)
                }));

                // Update education data
                villageData.demography.education = Object.values(data.tingkatPendidikan).map(edu => ({
                    name: edu.label,
                    total: edu.count,
                    percentage: edu.percentage,
                    color: getEducationColor(edu.label)
                }));

                // Update religion data
                villageData.demography.religion = Object.values(data.komposisiAgama).map(rel => ({
                    name: rel.label,
                    total: rel.count,
                    percentage: rel.percentage,
                    icon: `fa-solid fa-${rel.icon}`,
                    color: getReligionColor(rel.label),
                    bgColor: getReligionBgColor(rel.label)
                }));

                // Update occupation data
                villageData.demography.occupation = Object.values(data.strukturPekerjaan).map(occ => ({
                    name: occ.label,
                    total: occ.count,
                    percentage: occ.percentage,
                    icon: `fa-solid ${occ.icon}`,
                    color: getOccupationColor(occ.label),
                    bgColor: getOccupationBgColor(occ.label)
                }));


                // Update dashboard with loaded data
                populateDashboard();

                // Push data to stack and trigger dashboard update
                pushDataToStack();

            } catch (error) {
                console.error('Error loading village data:', error);
            }
        }

        // Helper functions for colors and icons
        function getGenerationColor(label) {
            const colors = {
                'Gen Z': 'bg-blue-500',
                'Millennial': 'bg-green-500',
                'Gen X': 'bg-yellow-500',
                'Boomer': 'bg-red-500',
                'Silent': 'bg-purple-500'
            };
            return colors[label] || 'bg-gray-500';
        }

        function getGenerationIcon(label) {
            const icons = {
                'Gen Z': 'fa-solid fa-baby',
                'Millennial': 'fa-solid fa-user-graduate',
                'Gen X': 'fa-solid fa-briefcase',
                'Boomer': 'fa-solid fa-home',
                'Silent': 'fa-solid fa-walking-cane'
            };
            return icons[label] || 'fa-solid fa-user';
        }

        function getEducationColor(label) {
            const colors = {
                'Tidak/Belum Sekolah': 'bg-red-500',
                'Tidak Tamat SD': 'bg-orange-500',
                'SD': 'bg-yellow-500',
                'SMP': 'bg-blue-500',
                'SMA': 'bg-green-500',
                'Diploma': 'bg-purple-500',
                'S1': 'bg-indigo-500',
                'S2': 'bg-pink-500',
                'S3': 'bg-gray-500'
            };
            return colors[label] || 'bg-gray-500';
        }

        function getReligionColor(label) {
            const colors = {
                'Islam': 'text-green-600',
                'Kristen': 'text-blue-600',
                'Katolik': 'text-purple-600',
                'Hindu': 'text-orange-600',
                'Buddha': 'text-yellow-600',
                'Konghucu': 'text-red-600'
            };
            return colors[label] || 'text-gray-600';
        }

        function getReligionBgColor(label) {
            const colors = {
                'Islam': 'bg-green-50',
                'Kristen': 'bg-blue-50',
                'Katolik': 'bg-purple-50',
                'Hindu': 'bg-orange-50',
                'Buddha': 'bg-yellow-50',
                'Konghucu': 'bg-red-50'
            };
            return colors[label] || 'bg-gray-50';
        }

        function getOccupationColor(label) {
            const colors = {
                'Petani': 'text-green-600',
                'Nelayan': 'text-blue-600',
                'Pedagang': 'text-orange-600',
                'PNS': 'text-purple-600',
                'Karyawan Swasta': 'text-indigo-600',
                'Wiraswasta': 'text-yellow-600',
                'Lainnya': 'text-gray-600'
            };
            return colors[label] || 'text-gray-600';
        }

        function getOccupationBgColor(label) {
            const colors = {
                'Petani': 'bg-green-50',
                'Nelayan': 'bg-blue-50',
                'Pedagang': 'bg-orange-50',
                'PNS': 'bg-purple-50',
                'Karyawan Swasta': 'bg-indigo-50',
                'Wiraswasta': 'bg-yellow-50',
                'Lainnya': 'bg-gray-50'
            };
            return colors[label] || 'bg-gray-50';
        }

        // Function to update road condition data
        function updateRoadConditionData(roadData, statistics = null) {

            if (!roadData || !Array.isArray(roadData)) {
                console.warn('Invalid road data:', roadData);
                return;
            }

            let goodKm = 0;
            let badKm = 0;
            let alleyKm = 0;
            let totalKm = 0;
            let goodPercentage = 0;
            let badPercentage = 0;
            let alleyPercentage = 0;

            // Use statistics from API if available, otherwise calculate from road data
            if (statistics && statistics.percentages) {


                // Use API statistics
                goodPercentage = parseFloat(statistics.percentages.good_percentage || 0);
                badPercentage = parseFloat(statistics.percentages.damaged_percentage || 0);
                alleyPercentage = parseFloat(statistics.percentages.gang_percentage || 0);

                // Calculate km values from percentages (approximate)
                roadData.forEach(road => {
                    const length = parseFloat(road.length || 0);
                    totalKm += length;
                });

                goodKm = (totalKm * goodPercentage / 100);
                badKm = (totalKm * badPercentage / 100);
                alleyKm = (totalKm * alleyPercentage / 100);
            } else {
                // Fallback: Calculate from road data


                roadData.forEach(road => {
                    // Get length from the API response (now calculated from GeoJSON)
                    const length = parseFloat(road.length || 0);
                    totalKm += length;

                    // Get road type from the API response
                    const roadType = (road.type || '').toString();
                    // Categorize roads based on type
                    if (roadType === 'Bagus') {
                        goodKm += length;
                    } else if (roadType === 'Rusak') {
                        badKm += length;
                    } else if (roadType === 'Gang') {
                        alleyKm += length;
                    } else {
                        // Default to bad roads if type is unclear
                        badKm += length;
                    }
                });

                // Calculate percentages
                goodPercentage = totalKm > 0 ? parseFloat((goodKm / totalKm * 100).toFixed(1)) : 0;
                badPercentage = totalKm > 0 ? parseFloat((badKm / totalKm * 100).toFixed(1)) : 0;
                alleyPercentage = totalKm > 0 ? parseFloat((alleyKm / totalKm * 100).toFixed(1)) : 0;
            }

            // Update total road length
            document.getElementById('total-road-length').textContent = totalKm.toFixed(2) + ' km';


            // Update road statistics
            document.getElementById('good-road-stats').textContent = `${goodKm.toFixed(2)} km (${goodPercentage}%)`;
            document.getElementById('bad-road-stats').textContent = `${badKm.toFixed(2)} km (${badPercentage}%)`;
            document.getElementById('alley-road-stats').textContent = `${alleyKm.toFixed(2)} km (${alleyPercentage}%)`;



            // Update progress bars
            document.getElementById('good-road-progress').style.width = goodPercentage + '%';
            document.getElementById('bad-road-progress').style.width = badPercentage + '%';
            document.getElementById('alley-road-progress').style.width = alleyPercentage + '%';

            // Update analysis text
            let analysisText = 'Kondisi jalan desa ';
            if (totalKm === 0) {
                analysisText = 'Belum ada data jalan tersedia.';
            } else if (badPercentage > 70) {
                analysisText += 'memerlukan perbaikan segera dengan mayoritas jalan dalam kondisi rusak.';
            } else if (badPercentage > 40) {
                analysisText += 'memerlukan perhatian khusus dengan sebagian jalan dalam kondisi rusak.';
            } else if (goodPercentage > 70) {
                analysisText += 'dalam kondisi baik dengan mayoritas jalan layak pakai.';
            } else {
                analysisText += 'bervariasi dengan kondisi jalan yang berbeda-beda.';
            }
            document.getElementById('road-analysis').textContent = analysisText;

            // Update road notes
            const notesContainer = document.getElementById('road-notes');
            notesContainer.innerHTML = '';

            if (totalKm > 0) {
                if (badKm > 0) {
                    const badNote = document.createElement('li');
                    badNote.className = 'flex items-center p-1 hover:bg-gray-100 rounded';
                    badNote.innerHTML = '<i class="fa-solid fa-circle text-gray-400 mr-2" style="font-size: 4px;"></i><span>' + badKm.toFixed(2) + ' km jalan rusak perlu diperbaiki (' + badPercentage + '%)</span>';
                    notesContainer.appendChild(badNote);
                }

                if (goodKm > 0) {
                    const goodNote = document.createElement('li');
                    goodNote.className = 'flex items-center p-1 hover:bg-gray-100 rounded';
                    goodNote.innerHTML = '<i class="fa-solid fa-circle text-gray-400 mr-2" style="font-size: 4px;"></i><span>' + goodKm.toFixed(2) + ' km jalan dalam kondisi baik (' + goodPercentage + '%)</span>';
                    notesContainer.appendChild(goodNote);
                }

                if (alleyKm > 0) {
                    const alleyNote = document.createElement('li');
                    alleyNote.className = 'flex items-center p-1 hover:bg-gray-100 rounded';
                    alleyNote.innerHTML = '<i class="fa-solid fa-circle text-gray-400 mr-2" style="font-size: 4px;"></i><span>' + alleyKm.toFixed(2) + ' km jalan gang tersedia (' + alleyPercentage + '%)</span>';
                    notesContainer.appendChild(alleyNote);
                }
            } else {
                const noDataNote = document.createElement('li');
                noDataNote.className = 'flex items-center p-1 hover:bg-gray-100 rounded';
                noDataNote.innerHTML = '<i class="fa-solid fa-circle text-gray-400 mr-2" style="font-size: 4px;"></i><span>Belum ada data jalan tersedia</span>';
                notesContainer.appendChild(noDataNote);
            }
        }

        // Load data when page is ready
        document.addEventListener('DOMContentLoaded', function () {
            loadVillageData();

            // Load road data
            fetch('/api/jalans')
                .then(response => {
                    console.log('Road API response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Road API data received:', data);
                    if (data.success && data.data) {
                        updateRoadConditionData(data.data, data.statistics);
                    } else {
                        console.warn('Road API returned no data or error:', data);
                        // Show default state when no data
                        updateRoadConditionData([]);
                    }
                })
                .catch(error => {
                    console.error('Error loading road data:', error);
                    // Show default state on error
                    updateRoadConditionData([]);
                });
        });

    </script>
@endpush
