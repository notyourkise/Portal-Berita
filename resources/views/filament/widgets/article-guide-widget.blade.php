<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            📝 Panduan Upload Berita
        </x-slot>

        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                    <h3 class="font-bold text-lg mb-2 flex items-center gap-2">
                        <span class="text-2xl">📁</span>
                        Kategori Utama
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                        Pilih 1 kategori yang paling sesuai:
                    </p>
                    <ul class="text-sm space-y-1 text-gray-700 dark:text-gray-300">
                        <li>• <strong>Politik</strong> - Berita pemerintahan & politik</li>
                        <li>• <strong>Ekonomi</strong> - Bisnis & keuangan</li>
                        <li>• <strong>Teknologi</strong> - Gadget & inovasi</li>
                        <li>• <strong>Olahraga</strong> - Sepakbola, basket, dll</li>
                        <li>• <strong>Hiburan</strong> - Film, musik, selebriti</li>
                        <li>• <strong>Gaya Hidup</strong> - Fashion, kuliner, wisata</li>
                        <li>• <strong>Kesehatan</strong> - Tips sehat & nutrisi</li>
                        <li>• <strong>Pendidikan</strong> - Sekolah & beasiswa</li>
                    </ul>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg">
                    <h3 class="font-bold text-lg mb-2 flex items-center gap-2">
                        <span class="text-2xl">🏷️</span>
                        Tag / Sub-Kategori
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                        Pilih tag yang lebih spesifik (opsional, bisa lebih dari 1):
                    </p>
                    <div class="text-sm space-y-2 text-gray-700 dark:text-gray-300">
                        <div>
                            <strong>Contoh 1:</strong>
                            <div class="ml-4 mt-1">
                                Kategori: <span class="bg-blue-100 dark:bg-blue-800 px-2 py-1 rounded text-xs">Olahraga</span><br>
                                Tag: <span class="bg-yellow-100 dark:bg-yellow-800 px-2 py-1 rounded text-xs">Sepakbola</span> + <span class="bg-yellow-100 dark:bg-yellow-800 px-2 py-1 rounded text-xs">Liga Indonesia</span>
                            </div>
                        </div>
                        <div>
                            <strong>Contoh 2:</strong>
                            <div class="ml-4 mt-1">
                                Kategori: <span class="bg-blue-100 dark:bg-blue-800 px-2 py-1 rounded text-xs">Teknologi</span><br>
                                Tag: <span class="bg-yellow-100 dark:bg-yellow-800 px-2 py-1 rounded text-xs">Gadget</span> + <span class="bg-yellow-100 dark:bg-yellow-800 px-2 py-1 rounded text-xs">Startup</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <h3 class="font-bold text-lg mb-2 flex items-center gap-2">
                    <span class="text-2xl">✅</span>
                    Tips
                </h3>
                <ul class="text-sm space-y-1 text-gray-700 dark:text-gray-300">
                    <li>✓ Kategori wajib dipilih, tag opsional tapi sangat disarankan</li>
                    <li>✓ Gunakan tag untuk memudahkan pembaca menemukan berita serupa</li>
                    <li>✓ Semakin spesifik tag, semakin mudah pembaca menemukan artikel Anda</li>
                    <li>✓ Tag akan muncul di menu dropdown website</li>
                </ul>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
