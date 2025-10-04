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
        <div id="data-pbb-container" class="space-y-3 text-sm">
            <!-- Data PBB akan dimasukkan oleh JavaScript -->
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
            <!-- Data jalan akan dimasukkan oleh JavaScript -->
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
                console.log('Loading village data from API...');
                const response = await fetch('/data-penduduk');
                const data = await response.json();
                console.log('API data received:', data);

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

                console.log('Updated villageData:', villageData.demography);

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

        // Load data when page is ready
        document.addEventListener('DOMContentLoaded', function () {
            loadVillageData();
        });

    </script>
@endpush
