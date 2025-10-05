<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CommandCenter\DataMap;
use App\Models\Jalan;

class CommandCenterController extends Controller
{
    /**
     * Display the command center dashboard
     */
    public function index()
    {
        return view('command-center.index');
    }

    /**
     * Get village data (API endpoint)
     */
    public function getVillageData()
    {
        // Fetch data from profile_desas table
        $profileDesa = DB::table('profile_desas')->first();

        if (!$profileDesa) {
            return response()->json([
                'error' => 'Profile desa tidak ditemukan'
            ], 404);
        }

        // Parse JSON fields
        $batasWilayah = json_decode($profileDesa->batas_wilayah, true);
        $alamatLengkap = json_decode($profileDesa->alamat_lengkap, true);

        // Format luas wilayah
        $luasWilayah = 'Menghitung...';
        if (isset($batasWilayah['luas']) && $batasWilayah['luas']) {
            $luas = floatval($batasWilayah['luas']);
            $luasWilayah = number_format($luas, 2) . ' km² / ' . number_format($luas * 100, 2) . ' Ha';
        }

        // Get kepala desa name from sambutan_image filename or use default
        $kepalaDesa = 'Sahril, SH'; // Default fallback
        if ($profileDesa->sambutan_image) {
            // You might want to store kepala desa name in a separate field
            // For now, using the default value
        }

        // Build foto URL
        $fotoUrl = $profileDesa->sambutan_image
            ?  env('APP_URL') . '/storage/' . $profileDesa->sambutan_image
            : 'https://awsimages.detik.net.id/community/media/visual/2024/05/04/ketua-papdesi-ntb_169.jpeg?w=500&q=90';

        $villageData = [
            'namaDesa' => $profileDesa->nama,
            'kepalaDesa' => $kepalaDesa,
            'luasWilayah' => $luasWilayah,
            'fotoUrl' => $fotoUrl,
            'kecamatan' => $alamatLengkap['kecamatan'] ?? 'Gunungsari',
            'kabupaten' => $alamatLengkap['kabupaten'] ?? 'Lombok Barat'
        ];

        return $villageData;
    }

    /**
     * Update village data
     */
    public function updateVillageData(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'data' => 'required|array',
            // Add more validation rules as needed
        ]);

        // Here you would typically save to database
        // For now, just return success

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui'
        ]);
    }

    /**
     * Get basic demographic data
     */
    private function getDemografiData()
    {
        $totalPenduduk = DB::table('anggota_keluargas')->count();
        $totalPria = DB::table('anggota_keluargas')->where('jenis_kelamin', 'Laki-laki')->count();
        $totalWanita = DB::table('anggota_keluargas')->where('jenis_kelamin', 'Perempuan')->count();

        return [
            'totalPenduduk' => $totalPenduduk,
            'totalPria' => $totalPria,
            'totalWanita' => $totalWanita,
        ];
    }

    /**
     * Get generation composition data
     */
    private function getKomposisiGenerasi($totalPenduduk)
    {
        $currentYear = date('Y');

        // Gen Z & Alpha (0-28 tahun) - born from 1996 to current year
        $genZAlpha = DB::table('anggota_keluargas')
            ->whereRaw("EXTRACT(YEAR FROM tanggal_lahir) >= ?", [$currentYear - 28])
            ->count();

        // Milenial (29-44 tahun) - born from 1980 to 1995
        $milenial = DB::table('anggota_keluargas')
            ->whereRaw("EXTRACT(YEAR FROM tanggal_lahir) BETWEEN ? AND ?", [$currentYear - 44, $currentYear - 29])
            ->count();

        // Gen X (45-60 tahun) - born from 1964 to 1979
        $genX = DB::table('anggota_keluargas')
            ->whereRaw("EXTRACT(YEAR FROM tanggal_lahir) BETWEEN ? AND ?", [$currentYear - 60, $currentYear - 45])
            ->count();

        // Baby Boomer (61-79 tahun) - born from 1945 to 1963
        $babyBoomer = DB::table('anggota_keluargas')
            ->whereRaw("EXTRACT(YEAR FROM tanggal_lahir) BETWEEN ? AND ?", [$currentYear - 79, $currentYear - 61])
            ->count();

        // Pre-Boomer (80+ tahun) - born before 1945
        $preBoomer = DB::table('anggota_keluargas')
            ->whereRaw("EXTRACT(YEAR FROM tanggal_lahir) < ?", [$currentYear - 80])
            ->count();

        // Calculate percentages
        $genZAlphaPercent = $totalPenduduk > 0 ? round(($genZAlpha / $totalPenduduk) * 100, 1) : 0;
        $milenialPercent = $totalPenduduk > 0 ? round(($milenial / $totalPenduduk) * 100, 1) : 0;
        $genXPercent = $totalPenduduk > 0 ? round(($genX / $totalPenduduk) * 100, 1) : 0;
        $babyBoomerPercent = $totalPenduduk > 0 ? round(($babyBoomer / $totalPenduduk) * 100, 1) : 0;
        $preBoomerPercent = $totalPenduduk > 0 ? round(($preBoomer / $totalPenduduk) * 100, 1) : 0;

        return [
            'genZAlpha' => [
                'label' => 'Gen Z & Alpha (0-28 th)',
                'count' => $genZAlpha,
                'percentage' => $genZAlphaPercent,
                'formatted' => number_format($genZAlpha) . ' (' . $genZAlphaPercent . '%)'
            ],
            'milenial' => [
                'label' => 'Milenial (29-44 th)',
                'count' => $milenial,
                'percentage' => $milenialPercent,
                'formatted' => number_format($milenial) . ' (' . $milenialPercent . '%)'
            ],
            'genX' => [
                'label' => 'Gen X (45-60 th)',
                'count' => $genX,
                'percentage' => $genXPercent,
                'formatted' => number_format($genX) . ' (' . $genXPercent . '%)'
            ],
            'babyBoomer' => [
                'label' => 'Baby Boomer (61-79 th)',
                'count' => $babyBoomer,
                'percentage' => $babyBoomerPercent,
                'formatted' => number_format($babyBoomer) . ' (' . $babyBoomerPercent . '%)'
            ],
            'preBoomer' => [
                'label' => 'Pre-Boomer (80+ th)',
                'count' => $preBoomer,
                'percentage' => $preBoomerPercent,
                'formatted' => number_format($preBoomer) . ' (' . $preBoomerPercent . '%)'
            ]
        ];
    }

    /**
     * Get education level data
     */
    private function getTingkatPendidikan($totalPenduduk)
    {
        // Tingkat Pendidikan
        $tidakBelumSekolah = DB::table('anggota_keluargas')
            ->whereIn('pendidikan_terakhir', ['Tidak/Belum Sekolah', 'Tidak Sekolah', 'Belum Sekolah'])
            ->count();

        $sdSederajat = DB::table('anggota_keluargas')
            ->whereIn('pendidikan_terakhir', ['SD', 'SD/MI', 'Sederajat SD'])
            ->count();

        $smpSederajat = DB::table('anggota_keluargas')
            ->whereIn('pendidikan_terakhir', ['SMP', 'SMP/MTs', 'Sederajat SMP'])
            ->count();

        $smaSederajat = DB::table('anggota_keluargas')
            ->whereIn('pendidikan_terakhir', ['SMA', 'SMA/MA', 'SMK', 'SMA/SMK', 'Sederajat SMA'])
            ->count();

        $perguruanTinggi = DB::table('anggota_keluargas')
            ->whereIn('pendidikan_terakhir', ['Diploma', 'S1', 'S2', 'S3', 'Perguruan Tinggi', 'Universitas'])
            ->count();

        // Calculate education percentages
        $tidakBelumSekolahPercent = $totalPenduduk > 0 ? round(($tidakBelumSekolah / $totalPenduduk) * 100, 1) : 0;
        $sdSederajatPercent = $totalPenduduk > 0 ? round(($sdSederajat / $totalPenduduk) * 100, 1) : 0;
        $smpSederajatPercent = $totalPenduduk > 0 ? round(($smpSederajat / $totalPenduduk) * 100, 1) : 0;
        $smaSederajatPercent = $totalPenduduk > 0 ? round(($smaSederajat / $totalPenduduk) * 100, 1) : 0;
        $perguruanTinggiPercent = $totalPenduduk > 0 ? round(($perguruanTinggi / $totalPenduduk) * 100, 1) : 0;

        return [
            'tidakBelumSekolah' => [
                'label' => 'Tidak/Belum Sekolah',
                'count' => $tidakBelumSekolah,
                'percentage' => $tidakBelumSekolahPercent,
                'formatted' => number_format($tidakBelumSekolah) . ' (' . $tidakBelumSekolahPercent . '%)'
            ],
            'sdSederajat' => [
                'label' => 'SD/Sederajat',
                'count' => $sdSederajat,
                'percentage' => $sdSederajatPercent,
                'formatted' => number_format($sdSederajat) . ' (' . $sdSederajatPercent . '%)'
            ],
            'smpSederajat' => [
                'label' => 'SMP/Sederajat',
                'count' => $smpSederajat,
                'percentage' => $smpSederajatPercent,
                'formatted' => number_format($smpSederajat) . ' (' . $smpSederajatPercent . '%)'
            ],
            'smaSederajat' => [
                'label' => 'SMA/Sederajat',
                'count' => $smaSederajat,
                'percentage' => $smaSederajatPercent,
                'formatted' => number_format($smaSederajat) . ' (' . $smaSederajatPercent . '%)'
            ],
            'perguruanTinggi' => [
                'label' => 'Perguruan Tinggi',
                'count' => $perguruanTinggi,
                'percentage' => $perguruanTinggiPercent,
                'formatted' => number_format($perguruanTinggi) . ' (' . $perguruanTinggiPercent . '%)'
            ]
        ];
    }

    /**
     * Get religious composition data
     */
    private function getKomposisiAgama($totalPenduduk)
    {
        // Define major religions with their icons
        $majorReligions = [
            'Islam' => 'star-and-crescent',
            'Hindu' => 'om',
            'Kristen' => 'cross',
            'Katolik' => 'cross',
            'Konghucu' => 'torii-gate',
            'Buddha' => 'yin-yang'
        ];

        // Get all unique religions from the database
        $religions = DB::table('anggota_keluargas')
            ->select('agama', DB::raw('COUNT(*) as count'))
            ->whereNotNull('agama')
            ->where('agama', '!=', '')
            ->groupBy('agama')
            ->orderBy('count', 'desc')
            ->get();

        $komposisiAgama = [];
        $totalOthers = 0;

        foreach ($religions as $religion) {
            $count = $religion->count;
            $percentage = $totalPenduduk > 0 ? round(($count / $totalPenduduk) * 100, 2) : 0;
            $religionName = $religion->agama;

            // Check if it's a major religion
            if (isset($majorReligions[$religionName])) {
                $key = strtolower(str_replace([' ', '/'], '_', $religionName));
                $komposisiAgama[$key] = [
                    'label' => $religionName,
                    'count' => $count,
                    'percentage' => $percentage,
                    'formatted' => number_format($count) . ' (' . $percentage . '%)',
                    'icon' => $majorReligions[$religionName]
                ];
            } else {
                // Add to "Lainnya" category
                $totalOthers += $count;
            }
        }

        // Add "Lainnya" category if there are other religions
        if ($totalOthers > 0) {
            $othersPercentage = $totalPenduduk > 0 ? round(($totalOthers / $totalPenduduk) * 100, 2) : 0;
            $komposisiAgama['lainnya'] = [
                'label' => 'Lainnya',
                'count' => $totalOthers,
                'percentage' => $othersPercentage,
                'formatted' => number_format($totalOthers) . ' (' . $othersPercentage . '%)',
                'icon' => 'fa-question-circle'
            ];
        }

        // Sort by count (descending) while maintaining major religions order
        uasort($komposisiAgama, function ($a, $b) {
            return $b['count'] - $a['count'];
        });

        return $komposisiAgama;
    }

    /**
     * Get job structure data
     */
    private function getStrukturPekerjaan($totalPenduduk)
    {
        // Define major job categories with their icons
        $majorJobs = [
            'Petani' => 'fa-seedling',
            'Pedagang' => 'fa-store',
            'PNS' => 'fa-building',
            'TNI' => 'fa-shield-alt',
            'Polri' => 'fa-shield-alt',
            'PNS/TNI/Polri' => 'fa-building',
            'Karyawan Swasta' => 'fa-briefcase',
            'Karyawan' => 'fa-briefcase',
            'Swasta' => 'fa-briefcase',
            'Wiraswasta' => 'fa-handshake',
            'Guru' => 'fa-chalkboard-teacher',
            'Dokter' => 'fa-user-md',
            'Perawat' => 'fa-user-nurse',
            'Sopir' => 'fa-car',
            'Tukang' => 'fa-hammer',
            'Buruh' => 'fa-hard-hat'
        ];

        // Get all unique jobs from the database
        $jobs = DB::table('anggota_keluargas')
            ->select('pekerjaan', DB::raw('COUNT(*) as count'))
            ->whereNotNull('pekerjaan')
            ->where('pekerjaan', '!=', '')
            ->groupBy('pekerjaan')
            ->orderBy('count', 'desc')
            ->get();

        $strukturPekerjaan = [];
        $totalOthers = 0;

        foreach ($jobs as $job) {
            $count = $job->count;
            $percentage = $totalPenduduk > 0 ? round(($count / $totalPenduduk) * 100, 1) : 0;
            $jobName = $job->pekerjaan;

            // Check if it's a major job category or matches a pattern
            $matchedJob = null;
            $matchedIcon = null;

            // Direct match first
            if (isset($majorJobs[$jobName])) {
                $matchedJob = $jobName;
                $matchedIcon = $majorJobs[$jobName];
            } else {
                // Pattern matching for variations
                foreach ($majorJobs as $pattern => $icon) {
                    if (stripos($jobName, $pattern) !== false || stripos($pattern, $jobName) !== false) {
                        $matchedJob = $pattern;
                        $matchedIcon = $icon;
                        break;
                    }
                }

                // Special handling for PNS/TNI/Polri
                if (!$matchedJob && (
                    stripos($jobName, 'PNS') !== false ||
                    stripos($jobName, 'TNI') !== false ||
                    stripos($jobName, 'Polri') !== false ||
                    stripos($jobName, 'ASN') !== false
                )) {
                    $matchedJob = 'PNS/TNI/Polri';
                    $matchedIcon = 'fa-building';
                }
            }

            if ($matchedJob && $matchedIcon) {
                $key = strtolower(str_replace([' ', '/', '\\'], '_', $matchedJob));

                if (isset($strukturPekerjaan[$key])) {
                    // Merge counts for same category
                    $strukturPekerjaan[$key]['count'] += $count;
                    $newPercentage = $totalPenduduk > 0 ? round(($strukturPekerjaan[$key]['count'] / $totalPenduduk) * 100, 1) : 0;
                    $strukturPekerjaan[$key]['percentage'] = $newPercentage;
                    $strukturPekerjaan[$key]['formatted'] = number_format($strukturPekerjaan[$key]['count']) . ' (' . $newPercentage . '%)';
                } else {
                    $strukturPekerjaan[$key] = [
                        'label' => $matchedJob,
                        'count' => $count,
                        'percentage' => $percentage,
                        'formatted' => number_format($count) . ' (' . $percentage . '%)',
                        'icon' => $matchedIcon
                    ];
                }
            } else {
                // Add to "Lainnya" category
                $totalOthers += $count;
            }
        }

        // Add "Lainnya" category if there are other jobs
        if ($totalOthers > 0) {
            $othersPercentage = $totalPenduduk > 0 ? round(($totalOthers / $totalPenduduk) * 100, 1) : 0;
            $strukturPekerjaan['lainnya'] = [
                'label' => 'Lainnya',
                'count' => $totalOthers,
                'percentage' => $othersPercentage,
                'formatted' => number_format($totalOthers) . ' (' . $othersPercentage . '%)',
                'icon' => 'fa-question-circle'
            ];
        }

        // Sort by count (descending)
        uasort($strukturPekerjaan, function ($a, $b) {
            return $b['count'] - $a['count'];
        });

        return $strukturPekerjaan;
    }

    /**
     * Get comprehensive population data
     */
    public function dataPenduduk()
    {
        $demografi = $this->getDemografiData();
        $komposisiGenerasi = $this->getKomposisiGenerasi($demografi['totalPenduduk']);
        $tingkatPendidikan = $this->getTingkatPendidikan($demografi['totalPenduduk']);
        $komposisiAgama = $this->getKomposisiAgama($demografi['totalPenduduk']);
        $strukturPekerjaan = $this->getStrukturPekerjaan($demografi['totalPenduduk']);
        $dataDesa = $this->getVillageData();
        return [
            'demografi' => $demografi,
            'komposisiGenerasi' => $komposisiGenerasi,
            'tingkatPendidikan' => $tingkatPendidikan,
            'komposisiAgama' => $komposisiAgama,
            'strukturPekerjaan' => $strukturPekerjaan,
            'dataDesa' => $dataDesa
        ];
    }

    //simpan data map
    public function simpanDataMap(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
                'type' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'data' => 'nullable|array',
                'status' => 'nullable|string|max:255'
            ]);

            // Create new DataMap instance
            $dataMap = new DataMap();
            $dataMap->judul = $validated['name'];
            $dataMap->lat = $validated['latitude'];
            $dataMap->lng = $validated['longitude'];
            $dataMap->kategori = $validated['type'] ?? null;
            $dataMap->keterangan = $validated['description'] ?? null;
            $dataMap->data = $validated['data'] ?? [];
            $dataMap->status = $validated['status'] ?? 'active';

            // Handle image upload and convert to WebP
            if ($request->hasFile('gambar')) {
                $imagePath = $dataMap->uploadImage($request->file('gambar'));
                $dataMap->gambar = $imagePath;
            }

            $dataMap->save();

            return redirect()->back()->with('success', 'Data map berhasil disimpan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Get all data maps
     */
    public function getDataMaps()
    {
        try {
            $dataMaps = DataMap::select('id', 'judul', 'gambar', 'lat', 'lng', 'kategori', 'keterangan', 'status', 'created_at')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'judul' => $item->judul,
                        'gambar_url' => $item->image_url,
                        'lat' => $item->lat,
                        'lng' => $item->lng,
                        'kategori' => $item->kategori,
                        'keterangan' => $item->keterangan,
                        'status' => $item->status,
                        'created_at' => $item->created_at->format('Y-m-d H:i:s')
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $dataMaps
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save road data to database
     */
    public function saveRoadData(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'type' => 'required|string|in:Bagus,Rusak,Gang',
                'keterangan' => 'nullable|string',
                'status' => 'nullable|string|max:255',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
                'kategori' => 'nullable|string|max:255'
            ]);

            // Create new Jalan instance
            $jalan = new Jalan();
            $jalan->nama = $validated['nama'];
            $jalan->type = $validated['type'];
            $jalan->keterangan = $validated['keterangan'] ?? null;
            $jalan->status = $validated['status'] ?? 'active';
            $jalan->geo_json = $request->geo_json;
            $jalan->kategori = $validated['kategori'] ?? null;

            // Handle image upload
            if ($request->hasFile('gambar')) {
                $image = $request->file('gambar');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('jalans', $imageName, 'public');
                $jalan->gambar = $imagePath;
            }

            $jalan->save();

            return response()->json([
                'success' => true,
                'message' => 'Data jalan berhasil disimpan!',
                'data' => [
                    'id' => $jalan->id,
                    'nama' => $jalan->nama,
                    'type' => $jalan->type,
                    'formatted_type' => $jalan->formatted_type,
                    'gambar_url' => $jalan->image_url
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all road data
     */
    public function getRoadData()
    {
        try {
            $jalans = Jalan::select('id', 'nama', 'gambar', 'type', 'keterangan', 'status', 'geo_json', 'kategori', 'created_at')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    // Calculate length from GeoJSON coordinates

                    return [
                        'id' => $item->id,
                        'nama' => $item->nama,
                        'gambar_url' => $item->image_url,
                        'type' => $item->type,
                        'formatted_type' => $item->formatted_type,
                        'keterangan' => $item->keterangan,
                        'status' => $item->status,
                        'geo_json' => $item->geo_json,
                        'kategori' => $item->kategori,
                        'created_at' => $item->created_at->format('Y-m-d H:i:s')
                    ];
                });

            // Calculate road statistics
            $totalRoads = Jalan::count();
            $damagedRoads = Jalan::where('type', 'Rusak')->count();
            $goodRoads = Jalan::where('type', 'Bagus')->count();
            $gangRoads = Jalan::where('type', 'Gang')->count();

            // Calculate percentages
            $damagedPercentage = $totalRoads > 0 ? round(($damagedRoads / $totalRoads) * 100, 2) : 0;
            $goodPercentage = $totalRoads > 0 ? round(($goodRoads / $totalRoads) * 100, 2) : 0;
            $gangPercentage = $totalRoads > 0 ? round(($gangRoads / $totalRoads) * 100, 2) : 0;

            return response()->json([
                'success' => true,
                'data' => $jalans,
                'statistics' => [
                    'total_roads' => $totalRoads,
                    'damaged_roads' => $damagedRoads,
                    'good_roads' => $goodRoads,
                    'gang_roads' => $gangRoads,
                    'percentages' => [
                        'damaged_percentage' => $damagedPercentage,
                        'good_percentage' => $goodPercentage,
                        'gang_percentage' => $gangPercentage
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * Calculate distance between two points using Haversine formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Earth's radius in meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Delete road data
     */
    public function deleteRoadData(Request $request, $id)
    {
        try {
            $jalan = Jalan::findOrFail($id);
            $jalan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data jalan berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
