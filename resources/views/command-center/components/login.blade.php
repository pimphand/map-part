<!-- Login Page -->
<div id="login-page"
    class="hidden bg-gray-100 flex items-center justify-center h-screen w-screen fixed top-0 left-0 z-50">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-sm">
        <div class="text-center mb-6">
            <img src="https://placehold.co/80x80/3B82F6/FFFFFF?text=L B" alt="Logo" class="mx-auto mb-3 rounded-full">
            <h1 class="text-2xl font-bold text-gray-800">Sistem Informasi Desa</h1>
            <p class="text-gray-500">Desa Jeringo</p>
        </div>
        <form id="login-form">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Nama Pengguna</label>
                <input type="text" id="username" value="admin"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan nama pengguna" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                <input type="password" id="password" value="jeringo2024"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan kata sandi" required>
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 shadow-md">
                Masuk
            </button>
            <p id="login-error" class="text-red-500 text-sm mt-4 text-center hidden">Nama pengguna atau kata sandi
                salah.</p>
        </form>
    </div>
</div>
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const loginPage = document.getElementById('login-page');
            const loginForm = document.getElementById('login-form');
            const loginButton = loginForm.querySelector('button[type="submit"]');
            const loginError = document.getElementById('login-error');

            // Buat elemen loading overlay
            const loadingOverlay = document.createElement('div');
            loadingOverlay.id = 'loading-overlay';
            loadingOverlay.className = 'fixed inset-0 bg-white bg-opacity-80 flex flex-col items-center justify-center z-50';
            loadingOverlay.innerHTML = `
                                            <div class="w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                                            <p class="mt-4 text-gray-700 font-semibold">Memproses login...</p>
                                        `;
            document.body.appendChild(loadingOverlay);

            // Setelah halaman selesai dimuat → tampilkan loading dulu 1.5 detik
            setTimeout(() => {
                // Sembunyikan loading dan auto-submit login
                loadingOverlay.style.display = 'none';
                loginButton.click();
            }, 150);

            // Simulasi login manual / otomatis
            loginForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Tampilkan loading
                loadingOverlay.style.display = 'flex';
                loadingOverlay.querySelector('p').innerText = 'Sedang memverifikasi...';

                const username = document.getElementById('username').value.trim();
                const password = document.getElementById('password').value.trim();

                // Simulasi validasi
                setTimeout(() => {
                    if (username === 'admin' && password === 'jeringo2024') {
                        // Login berhasil (tanpa redirect)
                        loadingOverlay.querySelector('p').innerText = 'Login berhasil!';
                        setTimeout(() => {
                            loadingOverlay.style.display = 'none';
                        }, 100);
                    } else {
                        // Login gagal
                        loadingOverlay.style.display = 'none';
                        loginError.classList.remove('hidden');
                    }
                }, 100);
            });
        });
    </script>
@endpush
