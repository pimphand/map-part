# Command Center - Dashboard Peta Desa Jeringo

## Struktur Folder

```
resources/views/command-center/
├── layouts/
│   └── app.blade.php              # Layout utama dengan head, scripts, dan styles
├── components/
│   ├── login.blade.php            # Komponen login page
│   ├── header.blade.php           # Komponen header dashboard
│   ├── control-buttons.blade.php  # Komponen tombol kontrol kiri
│   ├── analysis-panel.blade.php   # Panel analisa & rekomendasi
│   ├── draw-panel.blade.php       # Panel alat gambar peta
│   ├── cctv-panel.blade.php       # Panel monitoring CCTV
│   ├── livestream-panel.blade.php # Panel siaran langsung
│   ├── disaster-panel.blade.php   # Panel mitigasi bencana
│   ├── food-price-panel.blade.php # Panel harga pangan
│   ├── ai-lab-panel.blade.php     # Panel AI Lab Anti-Hoax
│   ├── dashboard-sidebar.blade.php # Sidebar informasi desa
│   └── modals.blade.php           # Komponen modal-modal
├── index.blade.php                # File utama command center
└── README.md                      # Dokumentasi ini

public/command/
├── css/
│   └── app.css                    # Styles kustom untuk command center
└── js/
    ├── app.js                     # Utilities dan fungsi global
    └── command-center.js          # Logika utama aplikasi
```

## Cara Menggunakan

1. **Akses Command Center**: Kunjungi `/command-center` di browser
2. **Login**: Gunakan username `admin` dan password `jeringo2024`
3. **Navigasi**: Gunakan tombol-tombol di sisi kiri untuk membuka panel berbeda

## Fitur Utama

### 1. Dashboard Interaktif
- Peta desa dengan Leaflet.js
- Markers untuk lokasi penting
- Informasi demografi real-time

### 2. Analisa & Rekomendasi AI
- Analisa offline kondisi desa
- Rekomendasi program pembangunan
- Export laporan PDF

### 3. Alat Gambar Peta
- Gambar batas desa/dusun
- Gambar kondisi jalan
- Kalkulasi area otomatis

### 4. Monitoring CCTV
- Feed CCTV real-time
- Fullscreen viewer
- Multiple camera locations

### 5. Siaran Langsung
- Live stream acara desa
- YouTube integration

### 6. Mitigasi Bencana
- Data gempa BMKG
- Prakiraan cuaca
- Alert system

### 7. Informasi Harga Pangan
- Harga bahan pokok
- Update harga harian
- Data sayuran

### 8. AI Lab Anti-Hoax
- Analisa gambar/video
- Verifikasi berita online
- Deteksi hoax

## API Endpoints

- `GET /command-center` - Halaman utama
- `GET /api/village-data` - Data desa (JSON)
- `POST /api/village-data` - Update data desa

## Customization

### Menambah Data Desa
Edit file `resources/views/command-center/index.blade.php` bagian `villageData` JavaScript object.

### Menambah Panel Baru
1. Buat komponen baru di `resources/views/command-center/components/`
2. Include di `index.blade.php`
3. Tambahkan tombol kontrol di `control-buttons.blade.php`
4. Tambahkan event listeners di `command-center.js`

### Styling
Edit file `public/command/css/app.css` untuk mengubah tampilan.

## Dependencies

- Laravel 9+
- Tailwind CSS
- Leaflet.js
- Leaflet.draw
- Font Awesome
- jsPDF

## Browser Support

- Chrome 80+
- Firefox 75+
- Safari 13+
- Edge 80+
