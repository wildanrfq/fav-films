#!/usr/bin/env bash

# Script untuk menjalankan preview website Film Portfolio WordPress secara lokal

echo "=================================================="
echo "  🎬 My 4 Favorite Films - WordPress Portfolio"
echo "=================================================="

# Pastikan database sudah terpasang
if [ ! -f "wp-content/database/.ht.sqlite" ]; then
    echo "📦 Menyiapkan database awal..."
    php install-and-seed.php
    php seed-films.php
fi

echo "🚀 Menjalankan local server di http://127.0.0.1:8000 ..."
echo "🌐 Buka browser Anda di: http://127.0.0.1:8000"
echo "🔑 Dashboard Admin WP:  http://127.0.0.1:8000/wp-admin/"
echo "   Username: admin"
echo "   Password: admin123"
echo "--------------------------------------------------"
echo "Tekan CTRL + C untuk menghentikan server."
echo "=================================================="

# Jalankan PHP built-in server dengan router
php -S 127.0.0.1:8000 router.php
