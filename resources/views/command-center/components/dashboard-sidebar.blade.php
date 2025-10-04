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
                <div class="flex justify-between"><span>Kecamatan:</span> <strong
                        class="text-gray-800">Gunungsari</strong></div>
                <div class="flex justify-between"><span>Kabupaten:</span> <strong class="text-gray-800">Lombok
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
            <!-- Legenda akan dimasukkan oleh JavaScript -->
        </div>
    </div>
</aside>


@push('js')
    <script>
        function populateDashboard() {
            document.getElementById('foto-kades').src = villageData.profile.fotoUrl;
            document.getElementById('nama-kades').textContent = villageData.profile.kepalaDesa;
            document.getElementById('luas-wilayah').textContent = villageData.profile.luasWilayah;

            const { demography } = villageData;
            document.getElementById('total-penduduk').textContent = demography.total.toLocaleString('id-ID');
            document.getElementById('jumlah-pria').textContent = demography.pria.toLocaleString('id-ID');
            document.getElementById('jumlah-wanita').textContent = demography.wanita.toLocaleString('id-ID');

            const agamaContainer = document.getElementById('data-agama-container');
            agamaContainer.innerHTML = '';
            if (demography.religion) {
                demography.religion.forEach(item => {
                    const percentage = ((item.total / demography.total) * 100).toFixed(2);
                    const div = document.createElement('div');
                    div.className = `flex items-center justify-between p-2 ${item.bgColor} rounded-lg`;
                    div.innerHTML = `
                                        <div class="flex items-center">
                                            <i class="${item.icon} ${item.color} w-5 text-center"></i>
                                            <span class="ml-2">${item.name}</span>
                                        </div>
                                        <div class="text-right">
                                            <strong class="text-gray-800">${item.total.toLocaleString('id-ID')}</strong>
                                            <small class="block text-gray-500 text-xs">${percentage}%</small>
                                        </div>`;
                    agamaContainer.appendChild(div);
                });
            }

            const generasiContainer = document.getElementById('data-generasi-container');
            generasiContainer.innerHTML = '';
            if (demography.generations) {
                demography.generations.forEach(item => {
                    const percentage = ((item.total / demography.total) * 100).toFixed(1);
                    const div = document.createElement('div');
                    div.innerHTML = `
                                        <div>
                                            <div class="mb-1 flex justify-between items-center">
                                                <span class="font-semibold text-gray-700 flex items-center"><i class="${item.icon} w-5 text-center mr-2 ${item.color.replace('bg-', 'text-')}"></i> ${item.name}</span>
                                                <span>${item.total.toLocaleString('id-ID')} (${percentage}%)</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="${item.color} h-2.5 rounded-full" style="width: ${percentage}%"></div>
                                            </div>
                                        </div>`;
                    generasiContainer.appendChild(div);
                });
            }

            const pendidikanContainer = document.getElementById('data-pendidikan-container');
            pendidikanContainer.innerHTML = '';
            if (demography.education) {
                demography.education.forEach(item => {
                    const percentage = ((item.total / demography.total) * 100).toFixed(1);
                    const div = document.createElement('div');
                    div.innerHTML = `
                                        <div>
                                            <div class="mb-1 flex justify-between">
                                                <span class="font-semibold text-gray-700">${item.name}</span>
                                                <span>${item.total.toLocaleString('id-ID')} (${percentage}%)</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="${item.color} h-2.5 rounded-full" style="width: ${percentage}%"></div>
                                            </div>
                                        </div>`;
                    pendidikanContainer.appendChild(div);
                });
            }

            const pekerjaanContainer = document.getElementById('data-pekerjaan-container');
            pekerjaanContainer.innerHTML = '';
            if (demography.occupation) {
                const totalPekerja = demography.occupation.reduce((sum, item) => sum + item.total, 0);
                demography.occupation.forEach(item => {
                    const percentage = ((item.total / totalPekerja) * 100).toFixed(1);
                    const div = document.createElement('div');
                    div.className = `flex items-center justify-between p-2 ${item.bgColor} rounded-lg`;
                    div.innerHTML = `
                                        <div class="flex items-center">
                                            <i class="${item.icon} ${item.color} w-5 text-center"></i>
                                            <span class="ml-2">${item.name}</span>
                                        </div>
                                        <div class="text-right">
                                            <strong class="text-gray-800">${item.total.toLocaleString('id-ID')}</strong>
                                            <small class="block text-gray-500 text-xs">${percentage}%</small>
                                        </div>`;
                    pekerjaanContainer.appendChild(div);
                });
            }


            const pengangguranContainer = document.getElementById('data-pengangguran-container');
            pengangguranContainer.innerHTML = '';
            if (villageData.unemployment) {
                const { totalWorkforce, unemployed } = villageData.unemployment;
                const percentage = ((unemployed / totalWorkforce) * 100).toFixed(1);

                pengangguranContainer.innerHTML = `
                                    <div class="flex justify-between items-center">
                                        <span>Angkatan Kerja:</span>
                                        <strong class="text-gray-800">${totalWorkforce.toLocaleString('id-ID')}</strong>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span>Jumlah Pengangguran:</span>
                                        <strong class="text-red-600">${unemployed.toLocaleString('id-ID')}</strong>
                                    </div>
                                    <div>
                                        <div class="mb-1 flex justify-between">
                                            <span class="text-yellow-600 font-semibold">Tingkat Pengangguran</span>
                                            <span>${percentage}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-4">
                                            <div class="bg-yellow-500 h-4 rounded-full text-center text-white text-xs font-bold flex items-center justify-center" style="width: ${percentage}%">
                                                ${percentage}%
                                            </div>
                                        </div>
                                    </div>
                                `;
            }

            const apbdesContainer = document.getElementById('apbdes-container');
            apbdesContainer.innerHTML = '';
            if (villageData.apbdes) {
                const { pendapatan, belanja } = villageData.apbdes;
                const sisaAnggaran = pendapatan.total - belanja.total;

                let apbdesHTML = `
                                    <div class="bg-green-50 p-3 rounded-lg">
                                        <div class="flex justify-between items-center">
                                            <span class="font-semibold text-green-800">Total Pendapatan</span>
                                            <strong class="text-green-800">${formatter.format(pendapatan.total)}</strong>
                                        </div>
                                        <div class="mt-2 space-y-2">`;
                pendapatan.sumber.forEach(s => {
                    const percentage = ((s.jumlah / pendapatan.total) * 100).toFixed(1);
                    apbdesHTML += `
                                            <div class="text-xs">
                                                <div class="flex justify-between mb-1">
                                                    <span>${s.nama}</span>
                                                    <span>${formatter.format(s.jumlah)}</span>
                                                </div>
                                                <div class="w-full bg-green-200 rounded-full h-1.5"><div class="bg-green-500 h-1.5 rounded-full" style="width: ${percentage}%"></div></div>
                                            </div>`;
                });
                apbdesHTML += `</div></div>`;

                apbdesHTML += `
                                    <div class="bg-red-50 p-3 rounded-lg">
                                        <div class="flex justify-between items-center">
                                            <span class="font-semibold text-red-800">Total Belanja</span>
                                            <strong class="text-red-800">${formatter.format(belanja.total)}</strong>
                                        </div>
                                        <div class="mt-2 space-y-2">`;
                belanja.bidang.forEach(b => {
                    const percentage = ((b.jumlah / belanja.total) * 100).toFixed(1);
                    apbdesHTML += `
                                            <div class="text-xs">
                                                <div class="flex justify-between mb-1">
                                                    <span>${b.nama}</span>
                                                    <span>${formatter.format(b.jumlah)}</span>
                                                </div>
                                                <div class="w-full bg-red-200 rounded-full h-1.5"><div class="bg-red-500 h-1.5 rounded-full" style="width: ${percentage}%"></div></div>
                                            </div>`;
                });
                apbdesHTML += `</div></div>`;

                apbdesHTML += `
                                    <div class="flex justify-between items-center p-3 rounded-lg ${sisaAnggaran >= 0 ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800'}">
                                        <span class="font-bold">Sisa Anggaran (SILPA)</span>
                                        <strong class="text-lg">${formatter.format(sisaAnggaran)}</strong>
                                    </div>
                                `;
                apbdesContainer.innerHTML = apbdesHTML;
            }


            const pbbContainer = document.getElementById('data-pbb-container');
            pbbContainer.innerHTML = '';
            if (villageData.pbb) {
                const { target, realisasi } = villageData.pbb;
                const percentage = ((realisasi / target) * 100).toFixed(0);

                pbbContainer.innerHTML = `
                                    <div class="flex justify-between items-center">
                                        <span>Target PBB:</span>
                                        <strong class="text-gray-800">${formatter.format(target)}</strong>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span>Realisasi:</span>
                                        <strong class="text-green-600">${formatter.format(realisasi)}</strong>
                                    </div>
                                    <div>
                                        <div class="mb-1 flex justify-between">
                                            <span class="text-blue-600 font-semibold">Capaian Lunas</span>
                                            <span>${percentage}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-4">
                                            <div class="bg-blue-500 h-4 rounded-full text-center text-white text-xs font-bold flex items-center justify-center" style="width: ${percentage}%">
                                                ${percentage}%
                                            </div>
                                        </div>
                                    </div>
                                `;
            }

            const socialContainer = document.getElementById('data-sosial-container');
            socialContainer.innerHTML = '';
            villageData.socialData.forEach(item => {
                const percentage = ((item.total / demography.total) * 100).toFixed(1);
                const div = document.createElement('div');
                div.className = `flex items-center justify-between p-2 ${item.bgColor} rounded-lg`;
                div.innerHTML = `
                                    <div class="flex items-center">
                                        <i class="${item.icon} ${item.textColor} w-5 text-center"></i>
                                        <span class="ml-2">${item.name}</span>
                                    </div>
                                    <div class="text-right">
                                        <strong class="${item.countTextColor} ${item.countBgColor} px-2 py-1 rounded">${item.total.toLocaleString('id-ID')}</strong>
                                        <small class="block text-gray-500 text-xs">${percentage}% dari populasi</small>
                                    </div>`;
                socialContainer.appendChild(div);
            });

            updateRoadStats();

            const legendaContainer = document.getElementById('legenda-peta');
            legendaContainer.innerHTML = '';
            const colorMap = { 'amber': 'text-amber-500', 'stone': 'text-stone-500', 'sky': 'text-sky-500', 'teal': 'text-teal-500' };
            for (const category in legendItems) {
                const item = legendItems[category];
                let colorClass = colorMap[item.color] || '';
                let styleAttr = !colorClass ? `style="color:${item.color}"` : '';
                const div = document.createElement('div');
                div.className = 'flex items-center';
                div.innerHTML = `<i class="${item.icon} w-5 text-center ${colorClass}" ${styleAttr}></i><span class="icon-label">${category}</span>`;
                legendaContainer.appendChild(div);
            }
        }

    </script>
@endpush
