<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            padding: 4px 3px;
        }
        th {
            text-align: left;
        }
        .d-block {
            display: block;
        }
        img.image {
            width: auto;
            height: 80px;
            max-width: 150px;
            max-height: 150px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .p-1 {
            padding: 5px 1px 5px 1px;
        }
        .font-10 {
            font-size: 10pt;
        }
        .font-11 {
            font-size: 11pt;
        }
        .font-12 {
            font-size: 12pt;
        }
        .font-13 {
            font-size: 13pt;
        }
        .border-bottom-header {
            border-bottom: 1px solid;
        }
        .border-all, .border-all th, .border-all td {
            border: 1px solid;
        }
        .mt-3 {
            margin-top: 15px;
        }
        .mb-3 {
            margin-bottom: 15px;
        }
        .font-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center">
                <img src="{{ asset('images/polinema-bw.png') }}" width="100%" alt="Logo">
            </td>
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">
                    KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI
                </span>
                <span class="text-center d-block font-13 font-bold mb-1">
                    POLITEKNIK NEGERI MALANG
                </span>
                <span class="text-center d-block font-10">
                    Jl. Soekarno-Hatta No. 9 Malang 65141
                </span>
                <span class="text-center d-block font-10">
                    Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420
                </span>
                <span class="text-center d-block font-10">
                    Laman: www.polinema.ac.id
                </span>
            </td>
        </tr>
    </table>

    <h3 class="text-center">LAPORAN DATA ALUMNI</h3>
    <p class="text-center font-10">Tanggal: {{ $tanggal }}</p>

    <div class="mt-3">
        <h4>Statistik Umum Alumni</h4>
        <table class="border-all">
            <tr>
                <th width="70%">Total Alumni Terdaftar</th>
                <td width="30%" class="text-right">{{ number_format($totalAlumni, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Alumni yang Sudah Mengisi Tracer Study</th>
                <td class="text-right">{{ number_format($filledTracer, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Alumni yang Belum Mengisi Tracer Study</th>
                <td class="text-right">{{ number_format($notFilledTracer, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Alumni yang Sudah Mengisi Survey</th>
                <td class="text-right">{{ number_format($filledSurvey, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Alumni yang Belum Mengisi Survey</th>
                <td class="text-right">{{ number_format($notFilledSurvey, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="mt-3">
        <h4>Kategori Pekerjaan Alumni</h4>
        <table class="border-all">
            <tr>
                <th width="70%">Bekerja di Bidang Infokom</th>
                <td width="30%" class="text-right">{{ number_format($infokomCount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Bekerja di Bidang Non-Infokom</th>
                <td class="text-right">{{ number_format($nonInfokomCount, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    @if($professionDistribution->count() > 0)
    <div class="mt-3">
        <h4>Distribusi Profesi Alumni</h4>
        <table class="border-all">
            <tr>
                <th width="70%">Profesi</th>
                <th width="30%">Jumlah</th>
            </tr>
            @foreach($professionDistribution as $profession)
            <tr>
                <td>{{ ucfirst($profession->profession) }}</td>
                <td class="text-right">{{ number_format($profession->count, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif

    <div class="mt-3 mb-3">
        <h4>Rata-rata Skor Survey Kepuasan Alumni</h4>
        <table class="border-all">
            <tr>
                <th width="70%">Kepuasan terhadap Pendidikan</th>
                <td width="30%" class="text-right">{{ number_format($averageScores['satisfaction'], 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Relevansi Pendidikan dengan Pekerjaan</th>
                <td class="text-right">{{ number_format($averageScores['relevance'], 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Kompetensi yang Didapat</th>
                <td class="text-right">{{ number_format($averageScores['competence'], 2, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <tr>
            <td width="70%"></td>
            <td width="30%" class="text-center">
                <p>Malang, {{ $tanggal }}</p>
                <br><br><br>
                <p>_</p>
                <p>Direktur/Koordinator</p>
            </td>
        </tr>
    </table>
</body>
</html>