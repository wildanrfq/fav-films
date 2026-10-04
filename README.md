# 🎬 my 4 favorite films &mdash; Cinema Portfolio

Website portfolio sinematik personal berbasis **WordPress & Static Export Ready** untuk publikasi online instan di **GitHub Pages** atau **Vercel** secara **100% GRATIS tanpa kartu kredit**. Dirancang dengan estetika editorial *dark-room cinema* (terinspirasi dari Criterion Channel & Letterboxd), tipografi modern **Figtree**, poster teatrikal resmi kualitas tinggi, dan ulasan personal.

---

## ✨ Fitur Utama

1. **Judul Utama di Tengah Atas**:
   - Menampilkan tulisan **`my 4 favorite films`** secara proporsional dan elegan di bagian atas layar.
2. **4 Film Favorit Terkurasi**:
   - **Drive My Car (2021)** &bull; Dir. Ryusuke Hamaguchi &bull; Rating: **`★★★★★ 5/5`** &bull; Ditonton: **`5x`**
   - **Like Father, Like Son (2013)** &bull; Dir. Hirokazu Kore-eda &bull; Rating: **`★★★★★ 5/5`** &bull; Ditonton: **`6x`**
   - **Aftersun (2022)** &bull; Dir. Charlotte Wells &bull; Rating: **`★★★★★ 5/5`** &bull; Ditonton: **`6x`**
   - **A Separation (2011)** &bull; Dir. Asghar Farhadi &bull; Rating: **`★★★★★ 5/5`** &bull; Ditonton: **`5x`**
3. **Desain & Tipografi**:
   - Tipografi **Figtree** yang bersih dan elegan di seluruh elemen halaman.
   - Poster teatrikal asli dalam rasio 2:3 dengan frame berbingkai di dalam card.
   - Ulasan interaktif yang dapat diperluas (*Baca Ulasan Lengkap / Tutup Ulasan*).
   - Sepenuhnya responsif untuk smartphone, tablet, dan desktop.
4. **Deployable Anywhere**:
   - Dapat di-host langsung di **GitHub Pages** atau **Vercel** tanpa memerlukan server PHP online atau kartu kredit.
   - Tetap memiliki backend lokal WordPress (SQLite) untuk mengelola data sewaktu-waktu.

---

## 🌐 Cara Publish Gratis Tanpa Kartu Kredit (GitHub Pages & Vercel)

Karena Render mewajibkan verifikasi kartu kredit (CC), opsi terbaik dan paling cepat adalah menggunakan **GitHub Pages** atau **Vercel**. Keduanya **100% Gratis Selamanya tanpa perlu input kartu kredit**.

### 🌟 Opsi 1: GitHub Pages (Paling Praktis & Langsung Aktif)

File static sudah diekspor ke folder `docs/` yang siap dibaca oleh GitHub Pages.

1. **Push kode ke GitHub**:
   ```bash
   git add .
   git commit -m "feat: add static export for GitHub Pages and Vercel"
   git push origin main
   ```

2. **Aktifkan GitHub Pages di Repository**:
   - Buka repo Anda di GitHub: `https://github.com/wildanrfq/fav-films`
   - Klik tab **Settings** (di menu atas).
   - Di sidebar kiri, klik **Pages** (di bagian *Code and automation*).
   - Di bagian **Build and deployment**:
     - **Source**: Pilih `Deploy from a branch`
     - **Branch**: Pilih `main` dan ganti foldernya dari `/(root)` menjadi `/docs`.
     - Klik **Save**.
   - Tunggu sekitar 1–2 menit, website Anda sudah online di:
     👉 `https://wildanrfq.github.io/fav-films/`

---

### ⚡ Opsi 2: Vercel (1 Klik Import)

Vercel juga **100% gratis tanpa kartu kredit** dan menyediakan performa edge network global yang sangat cepat.

1. Buka [vercel.com](https://vercel.com) dan login menggunakan akun GitHub Anda.
2. Klik tombol **Add New...** -> **Project**.
3. Pilih repository **`fav-films`** dan klik **Import**.
4. Pengaturan akan otomatis terbaca dari file `vercel.json` (output folder: `docs`).
5. Klik **Deploy**!
   Dalam waktu ~15 detik, website Anda akan langsung aktif dengan domain gratis seperti:
   👉 `https://fav-films.vercel.app`

---

## 🔄 Cara Memperbarui Konten di Masa Depan

Jika di kemudian hari Anda ingin mengubah ulasan, rating, atau film:

1. Buka admin lokal:
   ```bash
   php -S 127.0.0.1:8000 router.php
   ```
   Akses `http://127.0.0.1:8000/wp-admin/` (User: `admin` | Pass: `admin123`) dan lakukan perubahan.

2. Jalankan perintah ekspor 1-baris:
   ```bash
   php bin/export-static.php
   ```

3. Simpan dan push ke GitHub:
   ```bash
   git add docs/
   git commit -m "update: refresh film portfolio content"
   git push origin main
   ```
   GitHub Pages / Vercel akan otomatis meng-update website Anda dalam hitungan detik!

---

## 💻 Menjalankan Server Lokal (Development)

Untuk melihat preview lokal dinamis dengan database:

```bash
# Jalankan server
php -S 127.0.0.1:8000 router.php
```

- **Halaman Utama**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Dashboard Admin**: [http://127.0.0.1:8000/wp-admin/](http://127.0.0.1:8000/wp-admin/)
  - Username: `admin`
  - Password: `admin123`
