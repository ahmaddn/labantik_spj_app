@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade-show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Welcome, {{ Auth::user()->namalengkap }}!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Admin</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Development Progress</h3>

                        <div class="cd-horizontal-timeline">
                            <div class="timeline">
                                <div class="events-wrapper">
                                    <div class="events">
                                        <ol>
                                            <li><a href="#0" data-date="21/03/2025" class="selected">21 Mar</a>
                                            <li><a href="#0" data-date="22/03/2025">22 Mar</a>
                                            <li><a href="#0" data-date="08/04/2025">08 Apr</a>
                                            <li><a href="#0" data-date="11/04/2025">11 Apr</a>
                                            <li><a href="#0" data-date="12/04/2025">12 Apr</a>
                                            <li><a href="#0" data-date="14/04/2025">14 Apr</a>
                                            <li><a href="#0" data-date="16/05/2025">16 Mei</a>
                                            <li><a href="#0" data-date="19/05/2025">19 Mei</a>
                                            <li><a href="#0" data-date="21/05/2025">21 Mei</a>
                                            <li><a href="#0" data-date="18/06/2025">18 Jun</a>
                                            <li><a href="#0" data-date="20/06/2025">20 Jun</a>
                                            <li><a href="#0" data-date="21/06/2025">21 Jun</a>
                                            <li><a href="#0" data-date="22/06/2025">22 Jun</a>
                                            <li><a href="#0" data-date="23/06/2025">23 Jun</a>
                                            <li><a href="#0" data-date="24/06/2025">24 Jun</a>
                                            <li><a href="#0" data-date="26/06/2025">26 Jun</a>
                                            <li><a href="#0" data-date="27/06/2025">26 Jun</a>
                                            </li>
                                        </ol>
                                        <span class="filling-line" aria-hidden="true"></span>
                                    </div>

                                </div>
                                <ul class="cd-timeline-navigation">
                                    <li><a href="#0" class="prev inactive">Prev</a></li>
                                    <li><a href="#0" class="next">Next</a></li>
                                </ul>

                            </div>

                            <div class="events-content">
                                <ol>
                                    <li class="selected" data-date="21/03/2025">
                                        <h3><small>Initial github and change framework</small></h3>
                                        <p class="m-t-40">
                                            Projek SPJ dikerjakan ulang oleh tim berisi 2 orang siswa (
                                            sekarang
                                            alumni ) Pengembangan Perangkat Lunak dan Gim (PPLG) SMKN 1 Talaga yaitu Najmy
                                            Ahmad Maulana
                                            dan Azmy Gilar Bharizqi. Disini kami menginisialisasi projek ini ke github lalu
                                            mengubah framework PHP yang semula menggunakan Codeigniter 3 menjadi Laravel 12.
                                        </p>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Membuat repository, inisial commit ke github dan membuat branch untuk kami
                                            berdua dengan main sebagai branch utamanya
                                        </p>
                                    </li>
                                    <li data-date="22/03/2025">
                                        <h3><small>Add Database</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Menambahkan migrasi dan model Website SPJ
                                        </p>
                                    </li>
                                    <li data-date="08/04/2025">
                                        <h3><small>New Template</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Menambahkan dan mengimplementasikan template tampilan yang baru.
                                        </p>
                                    </li>
                                    <li data-date="11/04/2025">
                                        <h3><small>Frontend Dashboard, Login, Register & Backend Login and Register</small>
                                        </h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Menambahkan tampilan login dan fungsinya. <br>
                                            2. Menambahkan tampilan register dan fungsinya. <br>
                                            3. Menambahkan tampilan dashboard.
                                        </p>
                                    </li>
                                    <li data-date="12/04/2025">
                                        <h3><small>Logout function</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Menambahkan fungsi logout <br>
                                            2. Menyesuaikan tampilan dashboardnya (termasuk sidebar, topbar, dll).
                                        </p>
                                    </li>
                                    <li data-date="14/04/2025">
                                        <h3><small>Kegiatan Page</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Menambahkan tampilan halaman kegiatan.
                                        </p>
                                    </li>
                                    <li data-date="16/05/2025">
                                        <h3><small>CRUD Internal</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Menambahkan tampilan CRUD di semua submenu yang ada dalam menu internal. <br>
                                            2. Menambahkan fungsi CRUD di semua submenu internal.
                                        </p>
                                    </li>
                                    <li data-date="19/05/2025">
                                        <h3><small>CRD Eksternal & CRUD Pesanan</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Menambahkan tampilan CRUD di semua submenu yang ada dalam menu eksternal.
                                            <br>
                                            2. Menambahkan fungsi CRD ( Tambah, Tampilkan, dan Hapus ) di submenu barang,
                                            kegiatan, penyedia. <br>
                                            3. Menambahkan fungsi CRUD ( Tambah, Tampilkan, Edit, Hapus ) di submenu
                                            pesanan
                                        </p>
                                    </li>
                                    <li data-date="21/05/2025">
                                        <h3><small>Template Print</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Menambahkan tampilan Print PDF.
                                        </p>
                                    </li>
                                    <li data-date="18/06/2025">
                                        <h3><small>Helper Terbilang</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Menambahkan helper untuk mendeskripsikan "terbilang".
                                        </p>
                                    </li>
                                    <li data-date="20/06/2025">
                                        <h3><small>Fixing Error and Adjust Feature</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Update AppServiceProvider.php<br>
                                            2. Update RegisterUserController.php<br>
                                            3. Memperbaiki tampilan dan env serta kesalahan kodenya<br>
                                            4. Memperbaiki show data budget<br>
                                            5. Memperbaiki default value role user<br>
                                            6. Memperbaiki validasi tanggal dan tampilannya<br>
                                            7. Menambahkan validasi tambahan saat registrasi username<br>
                                            8. Memperbaiki delete timestamps false in model<br>
                                            9. Memperbaiki validasi username<br>
                                            10. Memperbaiki memperbaiki tampilan budget pesanan dan menambahkan validasi
                                            minimal
                                            di input date<br>
                                            11. Menambahkan fungsi softdeletes di semua model kecuali user<br>
                                            12. Menambahkan halaman edit pesanan dan perbaikan detail kecil yang lain<br>
                                            13. Memperbaiki typo judul<br>
                                            14. Menambahkan package bahasa indonesia<br>
                                            15. Menambahkan input kategori di barang<br>
                                            16. Menambahkan end tag<br>
                                            17. Memperbaiki rendering content
                                            18. Mendeploy website
                                        </p>
                                    </li>
                                    <li data-date="21/06/2025">
                                        <h3><small>Fixing Error and Adjust Feature</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Memperbaiki tampilan login dan register di mobile<br>
                                            2. Memperbaiki terbilang miliaran dan menampilkan nilai
                                            edit dari kategori satuan<br>
                                            4. Memperbaiki typo kode<br>
                                            5. Memperbaiki route action<br>
                                            6. Menambahkan halaman 4 dan 5 di halaman print<br>
                                        </p>
                                    </li>
                                    <li data-date="22/06/2025">
                                        <h3><small>Fixing Error and Adjust Feature</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Menambahkan faktur di halaman print<br>
                                            2. Memperbaiki beberapa kesalahan logika antara tampilan dan be,
                                            serta menambah halaman submission sebagai form penerimaan, menambah logika
                                            tombol, menambah kolom migrasi tambahan, serta penyesuaian kolom pada tabel
                                            kegiatan, pesanan, dan lainnya agar sesuai dengan kebutuhan print pdf<br>
                                            3. Memperbaiki type date accepted<br>
                                            4. Memperbaiki datetime acceppted<br>
                                            5. Memperbaiki PesananController, Pesanan Model, and template view<br>
                                            6. Memperbaiki url logo<br>
                                            7. Menghapus file html template<br>
                                            8. Memperbaiki typo value bendahara<br>
                                            9. Menambahkan favicon<br>
                                            10. Menambahkan migration, model pesanan_barang dan memperbaiki select barang
                                            menjadi multiple select serta menyesuaikan logika backend store dan edit
                                            pesanannya<br>
                                        </p>
                                    </li>
                                    <li data-date="23/06/2025">
                                        <h3><small>Fixing Error and Adjust Feature</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Memperbaiki logika payload form penerimaan/penyerahan dan penanganan
                                            backend-nya, menyesuaikan migrasi pesanan dan pesanan barang, serta menyesuaikan
                                            tampilan di form penerimaan/penyerahan. <br>
                                            2. Menyesuaikan dengan format PDF. <br>
                                            3. Merapikan format tulisan agar sesuai dengan sampel. <br>
                                            4. Menambahkan timeline di halaman dashboard. <br>
                                        </p>
                                    </li>
                                    <li data-date="24/06/2025">
                                        <h3><small>Fixing Error and Adjust Feature</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Memperbaiki fitur edit bendahara, kepsek, dan penerima serta menampilkan
                                            semua
                                            input jika error di halaman form penyerahan
                                        </p>
                                    </li>
                                    <li data-date="26/06/2025">
                                        <h3><small>Fixing Error and Adjust Feature</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Memperbaiki workflow (alur kerja) pesanan. <br>
                                            2. Mengubah form add pesanan menjadi form wizard. <br>
                                            3. Menyesuaikan migrasi pesanan dan relasi pesanan. <br>
                                            4. Menghapus menu barang dan inputan yang tidak diperlukan. <br>
                                            5. Mengintegrasikan input barang ke form wizard pesanan. <br>
                                        </p>
                                    </li>
                                    <li data-date="27/06/2025">
                                        <h3><small>Fixing Error and Adjust Feature</small></h3>
                                        <p class="m-t-40"><strong>
                                                Berikut merupakan beberapa perubahan di tanggal ini:</strong>
                                        </p>
                                        <p class="m-t-10">
                                            1. Menambahkan form wizard single page di halaman tambah barang. <br>
                                            2. Menyesuaikan tampilan edit pesanan. <br>
                                            3. Memperbaiki dan menyesuaikan fungsi update pesanan. <br>
                                            3. Menyesuaikan tampilan print dengan sample pdf. <br>
                                            4. Menambahkan input pajak dan ongkos kirim di form pesanan. <br>
                                            5. Menambahkan seeder user.
                                        </p>
                                    </li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
