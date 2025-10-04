<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // This could be replaced with actual database queries
        $villageData = [
            'profile' => [
                'kepalaDesa' => 'Sahril, SH',
                'luasWilayah' => 'Menghitung...',
                'fotoUrl' => 'https://awsimages.detik.net.id/community/media/visual/2024/05/04/ketua-papdesi-ntb_169.jpeg?w=500&q=90'
            ],
            'demography' => [
                'total' => 2905,
                'pria' => 1399,
                'wanita' => 1506
            ],
            // Add more data as needed
        ];

        return response()->json($villageData);
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
            'Islam' => 'fa-star-and-crescent',
            'Hindu' => 'fa-om',
            'Kristen' => 'fa-cross',
            'Katolik' => 'fa-cross',
            'Konghucu' => 'fa-torii-gate',
            'Buddha' => 'fa-yin-yang'
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

        return [
            'demografi' => $demografi,
            'komposisiGenerasi' => $komposisiGenerasi,
            'tingkatPendidikan' => $tingkatPendidikan,
            'komposisiAgama' => $komposisiAgama,
            'strukturPekerjaan' => $strukturPekerjaan
        ];
    }
}
