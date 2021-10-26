<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Blog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->dateTime('tanggal');
            $table->string('judul', 250);
            $table->string('slug', 250);
            $table->string('meta', 250)->nullable();
            $table->string('tag', 200)->nullable();
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->longText('featured')->nullable();
            $table->longText('konten');
            $table->string('status', 20)->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('blog', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('kategori_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kategori_id')->references('id')->on('kategori')->onUpdate('cascade')->onDelete('cascade');
        });

        DB::table('blog')->insert(
            [
                'id' => 1,
                'user_id' => 1,
                'tanggal' => '2021-10-10 10:10:59',
                'judul' => 'Anak Muda di Wajo Buat Aplikasi Allirita, Sebuah Upaya Merawat Tradisi Lisan',
                'slug' => 'Anak-Muda-di-Wajo-Buat-Aplikasi-Allirita',
                'meta' => 'Anak Muda di Wajo Buat Aplikasi Allirita, Sebuah Upaya Merawat Tradisi Lisan',
                'tag' => 'blog, artikel, pertama',
                'kategori_id' => 1,
                'featured' => 'storage/files/superadmin/bali.png',
                'konten' => '<p style="margin-left:0px;"><strong>TRIBUNWAJO.COM, SENGKANG -</strong> Sekelompok anak muda di Kabupaten Wajo, Sulawesi Selatan cukup resah dengan terdegradasinya budaya lisan masyarakat.</p><p style="margin-left:0px;">Mulanya, ada lima orang yang menggagas platform digital yang fokus mengangkat isu kebudayaan.</p><p style="margin-left:0px;">Tim kerja yang berafiliasi dengan Yayasan Budaya Wajo itu pin mendapatkan kucuran dana fasilitasi Bidang Kebudayaan Kementerian Pendidikan dan Kebudayaan Republik Indonesia.</p><p style="margin-left:0px;"><br>Kini, aplikasi Allirita telah dilaunching, Sabtu (5/12/2020) malam. Aplikasi yang didominasi warna jingga itu, sebagai simbol warna Kerajaan Wajo masa lampau.</p><p style="margin-left:0px;">Nama Allirita sendiri bermakna tiang dalam Bahasa Bugis. Tentu, diharapkan menjadi tiang penopang budaya yang terancam punah digerus teknologi informasi terbarukan.</p><p style="margin-left:0px;">Menurut Muhammad Ichlas Sudarmin, keberadaan tradisi lisan di Kabupaten Wajo mengalami pengikisan.</p><p style="margin-left:0px;">Boleh jadi karena globalisasi, penuturnya kian berkurang, atau kesadaran masyarakat yang belum terbentuk. Namun, bisa jadi ketiga alasan itu kompleks.</p><p style="margin-left:0px;">"Kami juga melihat kondisi ini dari refleksi masa kecil yang tidak dikenalkan pada tradisi lisan di daerah sendiri. Melainkan tumbuh dengan pengenalan budaya, dongeng, cerita rakyat yang berasal dari luar daerah Bugis, atau Wajo ini sendiri," katanya.</p><p style="margin-left:0px;">Cerita rakyat seperti Nene Pakande atau La Welle sudah sangat jarang didengar. Menyimak orang menuturkannya saja adalah hal langka.</p><p style="margin-left:0px;">Ichlas yang kuliah di Universitas Brawijaya Malang itu menyebut masalah ini cukup penting untuk dipecahkan.</p><p style="margin-left:0px;"><br>"Jika masa kecil anak-anak Bugis dibesarkan dengan budayanya sendiri, maka mereka akan berkembang menjadi identitas yang dipegang teguh, sehingga bisa menjadi pondasi pemajuan kebudayaan Indonesia," katanya.</p><p style="margin-left:0px;">Platform digital Allirita memang berfokus pada tradisi lisan masyarakat. Elong-kelong (lagu-lagu), pacarita (pencerita) atawa cerita rakyat dikemas dengan apik dan menarik dalam aplikasi Allirita.</p><p style="margin-left:0px;">Kini, platform digital itu diasuh oleh 20 orang dalam tim kerja Allirita. Semuanya anak muda Kabupaten Wajo.<br><br>Sekretaris Daerah Kabupaten Wajo, Amiruddin yang turut hadir pada launching aplikasi Allirita di Ruang Pola Kantor Bupati Wajo, memberi apresiasi yang setinggi-tingginya.</p><p style="margin-left:0px;">"Ini sebuah simbol, kita di Wajo bisa melahirkan informasi kebudayaan. Kita punya nilai budaya yang belum terinventarisir dengan baik dan dengan lahirnya aplikasi Allirita, ini selangkah lebih maju lompatannya," katanya.</p><p style="margin-left:0px;">Perkataan Amiruddin berdasar. Jika kabupaten atau daerah lain masih sibuk mendiskusikan kebudayan asli mereka, Kabupaten Wajo telah mendeklarasikan diri dengan mendokumentasikan kebudayaannya.</p><p style="margin-left:0px;">"Ini menjadi kebanggan kita, pemerintah dan masyarakat Wajo," katanya.<strong>(*)</strong><br><br>Artikel ini telah tayang di <a href="https:">tribun-timur.com</a> dengan judul Anak Muda di Wajo Buat Aplikasi Allirita, Sebuah Upaya Merawat Tradisi Lisan, <a href="https://makassar.tribunnews.com/2020/12/06/anak-muda-di-wajo-buat-aplikasi-allirita-sebuah-upaya-merawat-tradisi-lisan?page=2">https://makassar.tribunnews.com/2020/12/06/anak-muda-di-wajo-buat-aplikasi-allirita-sebuah-upaya-merawat-tradisi-lisan?page=2</a>.<br>Penulis: Hardiansyah Abdi Gunawan<br>Editor: Hasriyani Latif</p>',
                'status' => 'terbit'
            ]
        );

        DB::table('blog')->insert(
            [
                'id' => 2,
                'user_id' => 1,
                'tanggal' => '2021-10-10 14:15:55',
                'judul' => 'Kadindikbud Purbalingga Buka Workshop dan Pentas Teater di Gor Mahesa Jenar',
                'slug' => 'Kadindikbud-Purbalingga-Buka-Workshop-dan-Pentas-Teater-di-Gor-Mahesa-Jenar',
                'meta' => 'Kadindikbud Purbalingga Buka Workshop dan Pentas Teater di Gor Mahesa Jenar',
                'tag' => 'blog, artikel, kedua',
                'kategori_id' => 2,
                'featured' => 'storage/files/superadmin/bocah.png',
                'konten' => '<p>TRIBUNJATENG.COM, PURBALINGGA - Workshop dan Pentas Teater yang diselenggarakan Komunitas Teater Sastra Perwira (Katasapa) Purbalingga program Fasilitasi Bidang Kebudayaan (FBK) Kementerian Pendidikan dan Kebudayaan (Kemendikbud) resmi dibuka. Sebanyak 40 peserta workshop mendapatkan materi terkait penulisan naskah teater oleh Asa Jatmiko.</p><p>Ketua Katasapa Purbalingga, Ryan Rachman mengatakan workshop dan pentas teater ini diajukan pada program FBK untuk menghidupkan teater di Purbalingga yang masih tertinggal dari daerah lain. Workshop dan pentas teater ini akan mengangkat budaya lokal dan cerita rakyat yang berkembang di Purbalingga.</p><p>"Kami ingin mengangkat tema cerita rakyat yang berkembang di Purbalingga dengan menggunakan bahasa penginyongan," katanya, saat Pembukaan Workshop dan Pentas Teater di Gor Mahesa Jenar Purbalingga, Kamis (22/10)</p><p>Ia berharap, dengan adanya Workshop dan Pentas Teater ini, kehidupan teater di Purbalingga akan semakin berkembang. Bahkan, beberapa sekolah di Purbalingga sudah mulai ada teater yang dimainkan oleh para pelajar.</p><p>Kepala Dindikbud Purbalingga, Setyadi mengapresiasi, meski di tengah pandemi covid-19, komunitas itu tetap bisa memberikan ruang bagi pelajar maupun masyarakat untuk berkreasi melalui teater. Masyarakat diberikan ruang untuk berekspresi sekaligus menyalurkan minat dan bakatnya.</p><p>"Teater tidak hanya soal pentas atau akting tapi mencakup semua aspek dalam teater," jelasnya. (*)</p>',
                'status' => 'terbit'
            ]
        );

        DB::table('blog')->insert(
            [
                'id' => 3,
                'user_id' => 1,
                'tanggal' => '2021-10-10 14:15:55',
                'judul' => 'Ditjen Kebudayaan Kucurkan Dana Rp 80 Miliar untuk Fasilitasi Bidang Kebudayaan',
                'slug' => 'Ditjen-Kebudayaan-Kucurkan-Dana-Rp-80-Miliar-untuk-Fasilitasi-Bidang-Kebudayaan',
                'meta' => 'Ditjen Kebudayaan Kucurkan Dana Rp 80 Miliar untuk Fasilitasi Bidang Kebudayaan',
                'tag' => 'blog, artikel, kedua',
                'kategori_id' => 1,
                'featured' => 'storage/files/superadmin/rumah.png',
                'konten' => '<p style="text-align:justify;"><span style="color:rgb(42,42,42);">KOMPAS.com - Direktorat Jenderal Kebudayaan (Ditjen Kebudayaan) Kemendikbud mengalokasikan dana Rp 80 miliar melalui program Fasilitasi Bidang Kebudayaan (FBK).&nbsp;FBK merupakan program stimulus yang diberikan kepada perseorangan maupun kelompok seniman atau budayawan. "Dana tersebut dapat dimanfaatkan sebaik-baiknya untuk kemajuan kebudayaan di tanah air, baik kelompok maupun perorangan," ujar Dirjen Kebudayaan Hilmar Farid melalui rilis resmi (19/11/2020). Lebih jauh Hilmar menjelaskan, "FBK sebagai salah satu stimulus yang diberikan kepada perseorangan atau kelompok, bersifat non-fisik dan non-komersil, serta dapat diapresiasi masyarakat dan pemangku kepentingan secara luas." Ia berharap dana itu menjadi wadah penyediaan ruang keragaman ekspresi dan mendorong interaksi budaya dan inisiatif-inisiatif baru dalam upaya pemajuan kebudayaan Indonesia sesuai UU No.5 Tahun 2017 tentang Pemajuan Kebudayaan.</span><br><br><span style="color:rgb(42,42,42);"><strong>Pertanggungjawaban dana</strong>&nbsp;</span></p><p style="text-align:justify;"><span style="color:rgb(42,42,42);">Hilmar juga mengingatkan dana bantuan negara&nbsp;ini&nbsp;harus digunakan secara bertanggung jawab. "Ini kan (anggaran FBK) menggunakan uang negara. Nilainya juga besar, jadi penggunaan, pelaporan hingga pertanggungjawabannya harus betul-betul tercatatat, transparan dan tertib administrasi,” tegasnya. Hilmar menyampaikan FBK menjadi cikal bakal Dana Abadi Kebudayaan yang digagas pada Kongres Kebudayaan Indonesia 2018. Penerima FBK dari komunitas game online kebudayaan,&nbsp;Muhammad Abdul Karim, mengaku senang dan bahagia karena merasa terbantu dengan program dijalankan Dirjen Kebudayaan. Abdul yang sudah enam tahun berkecimpung dalam game online kebudayaan bersyukur saat kelompok game onlinenya yang diberi nama Sengkala Dev dinyatakan lolos menerima bantuan sebesar 17 juta rupiah. Menurutnya program bantuan dana dapat memfasilitasi ruang kreatif bagi pelaku seni. "Pastinya berterima kaish kepada Kemendikbud&nbsp; yaitu Dirjen Kebudayaan karena sudah memberikan bantuan dana. Sudah 80 persen kita terima, dan sisanya bilamna pekerjaanya sudah selesai," katanya. "Biasanya gagal terus untuk mendapatkannya dari publisher, investor, dan program lomba atau hibah sejak mencobanya dari lomba PKUB Kemenag 2015 sampai penggalangan dana di Indiegogo 2019 yang gagal semua," ungkapnya. Abdul menceritakan telah mengembangkan gim sejarah di tanah air, seperti gim dari Pedalahusa (2014), Pedalahusa Fall of Bali (2017), Perang Laut Maritime Warfare (2019), dan Surabaya Inferno (2020). Hal sama juga dirasakan komunitas musik Riau Rhythm. Dari 4.000 proposal kelompok musik, komunitas ini terpilih sebagai penerima FBk.&nbsp; "Perasaan kami tentu saja senang, karena proposal kami berhasil diterima di antara 190-an dari 4.000an proposal pengusul. Nilai proposal kami Rp 893 jutaan untuk memfasilitasi konser Riau Rhythm," jelasnya.</span><br><br><span style="color:rgb(42,42,42);">Dijelaskan bahwa dana tersebut untuk menunjung kegiatan konser, yakni sebanyak 128 orang terdiri musisi orkestra, musisi tradisional, pelaku panggung, video mapping dan lainnya. "Artinya proposal kegiatan ini akan melibatkan seniman dan pelaku seni di Riau yang selama pandemi ini tidak memiliki pemasukan sebagaimana biasanya," jelasnya. Selain FBK, bantuan pemerintah bidang kebudayaan meliputi Fasilitasi Kegiatan Kesenian, Fasilitasi Sarana Kesenian, Fasilitasi Penulisan Buku Sejarah, dan Fasilitasi Komunitas Budaya di Masyarakat.</span><br><br>&nbsp;</p>',
                'status' => 'terbit'
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog');
    }
}
