# 🎬 my 4 favorite films &mdash; WordPress Film Portfolio

Website portfolio sinematik personal berbasis **WordPress** dengan integrasi **Database PHP**. Dirancang dengan estetika editorial *dark-room cinema* (terinspirasi dari Criterion Channel & Letterboxd), bebas dari template klise "AI slop", dengan tipografi mewah dan data film yang terhubung langsung ke database.

---

## ✨ Fitur Utama

1. **Judul Utama di Tengah Atas**:
   - Menampilkan tulisan **`my 4 favorite films`** secara proporsional dan elegan di bagian atas layar.
2. **4 Film Favorit Terkurasi**:
   - **Drive My Car (2021)** &bull; Dir. Ryusuke Hamaguchi &bull; Rating: **`9.9 / 10`** &bull; Ditonton: **`5x`**
   - **Bound (1996)** &bull; Dir. Lana &amp; Lilly Wachowski &bull; Rating: **`9.6 / 10`** &bull; Ditonton: **`7x`**
   - **Aftersun (2022)** &bull; Dir. Charlotte Wells &bull; Rating: **`10 / 10`** &bull; Ditonton: **`6x`**
   - **A Separation (2011)** &bull; Dir. Asghar Farhadi &bull; Rating: **`9.8 / 10`** &bull; Ditonton: **`5x`**
3. **Integrasi Data per Film (Tersimpan di Database)**:
   - **Rating Saya**: Skor apresiasi personal (contoh: `10 / 10`, `9.8 / 10`).
   - **Berapa Kali Saya Sudah Tonton**: Penghitung jumlah re-watch (contoh: `8x`, `6x`, `11x`, `5x`) lengkap dengan tombol interaktif **+1 Tonton** yang langsung mengupdate database via AJAX.
   - **Deskripsi Kenapa Saya Suka Filmnya**: Ulasan mendalam, personal, dan berbobot tanpa kata-kata hampa atau template generik.
   - **Poster Teatrikal Berkualitas Tinggi**: Visual poster format 2:3 bertekstur *film grain*.
   - **Kutipan Berkesan (Iconic Quote)** &amp; Detail Sutradara/Tahun Rilis.
4. **Integrasi Database PHP**:
   - Menggunakan engine database SQLite bawaan PHP (`pdo_sqlite`) melalui plugin resmi *WordPress SQLite Database Integration*, sehingga **tidak memerlukan instalasi server MySQL terpisah**.
   - Data tersimpan aman di `wp-content/database/.ht.sqlite`.
   - Menggunakan arsitektur WordPress Custom Post Type (`favorite_film`) dan Custom Fields (`wp_postmeta`), serta kueri langsung via `$wpdb`.
5. **Panel Admin WordPress Lengkap**:
   - Anda dapat menambah, mengubah, atau menghapus film langsung dari dashboard `/wp-admin`.

---

## 🚀 Panduan Step-by-Step Menjalankan Preview Web

Ikuti langkah-langkah mudah di bawah ini untuk melihat dan menjalankan website ini di komputer Anda:

### Langkah 1: Buka Terminal di Folder Project
Pastikan terminal berada di direktori project:
```bash
cd /Users/wildanrfq/code/filmwp
```

### Langkah 2: Jalankan Server Lokal
Cukup jalankan satu perintah berikut:
```bash
./start.sh
```
*Atau jika menggunakan perintah langsung:*
```bash
php -S 127.0.0.1:8000
```

### Langkah 3: Buka Browser Anda
Buka browser (Google Chrome, Safari, Firefox, atau Arc) dan akses tautan berikut:
👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

Halaman utama akan langsung terbuka menampilkan:
- Tulisan tengah atas: **`my 4 favorite films`**
- Kartu 4 film lengkap dengan poster, rating, jumlah tontonan, dan ulasan personal.

---

## 🛠️ Mengelola Data Film Lewat WP-Admin (Opsional)

Jika Anda ingin mengubah rating, menambah jumlah tontonan, atau mengedit ulasan film melalui antarmuka grafis:

1. Buka: **[http://127.0.0.1:8000/wp-admin](http://127.0.0.1:8000/wp-admin)**
2. Masukkan kredensial admin:
   - **Username**: `admin`
   - **Password**: `admin123`
3. Masuk ke menu **Favorite Films** di bilah navigasi samping kiri.
4. Klik **Edit** pada salah satu film untuk mengubah data:
   - *Rating Saya*
   - *Berapa Kali Sudah Ditonton*
   - *Tahun Rilis & Sutradara*
   - *Deskripsi Kenapa Saya Suka Filmnya*
5. Klik **Update** &mdash; perubahan akan langsung tersimpan di database dan tampil di halaman utama!

---

## 📁 Struktur File & Tema

```
filmwp/
├── wp-content/
│   ├── database/
│   │   └── .ht.sqlite             # File database SQLite PHP lokal
│   ├── plugins/
│   │   └── sqlite-database-integration/ # Driver database PHP SQLite untuk WordPress
│   └── themes/
│       └── film-portfolio/        # Tema kustom buatan khusus
│           ├── assets/
│           │   ├── js/main.js     # Interaktivitas sorting & AJAX database updater
│           │   └── posters/       # 4 Poster film teatrikal resolusi tinggi
│           ├── functions.php      # Custom Post Type, Meta Boxes, & handler $wpdb
│           ├── index.php          # Template utama (Header, 4 Film, Metrik, Footer)
│           └── style.css          # Estetika dark-mode sinematik editorial
├── install-and-seed.php           # Script instalasi otomatis skema database
├── seed-films.php                 # Script seeder pengisi 4 data film ke database
├── start.sh                       # Script starter praktis 1-klik
└── wp-config.php                  # Konfigurasi WordPress dengan dynamic URL & SQLite
```

---

## 🎬 Detail 4 Film Terpilih

| # | Judul Film | Tahun | Sutradara | Rating | Ditonton | Catatan Kunci |
|---|---|---|---|---|---|---|
| 1 | **Drive My Car** | 2021 | Ryusuke Hamaguchi | **5 / 5** | 5x | Meditasi hening tentang duka, rasa bersalah, dan pelukan di salju Hokkaido. |
| 2 | **Bound** | 1996 | Lana &amp; Lilly Wachowski | **5 / 5** | 7x | Neo-noir subversif pembalik arketipe femme fatale dengan tensi ruang sempit. |
| 3 | **Aftersun** | 2022 | Charlotte Wells | **5 / 5** | 6x | Fragmen MiniDV emosional dan perpisahan tanpa suara di lantai dansa. |
| 4 | **A Separation** | 2011 | Asghar Farhadi | **5 / 5** | 5x | Skenario moral paling kedap cela tentang benturan kelas dan etika di Teheran. |
