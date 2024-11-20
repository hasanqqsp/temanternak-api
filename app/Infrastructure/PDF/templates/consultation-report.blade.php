<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=595">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Consultation Report</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            width: 100%;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        .content {
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            margin-bottom: 20px;
            width: 100%;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #6c757d;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .mb-1 {
            margin-bottom: 0.25rem;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="content">
        <h1 class="fs-2">Hasil Konsultasi</h1>
        <table class="table">
            <tr>
                <td class="text-nowrap fw-bold">Nama Pelanggan</td>
                <td>:</td>
                <td>{{ $bookerName }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Layanan</td>
                <td>:</td>
                <td>{{ $serviceName }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Waktu Konsultasi</td>
                <td>:</td>
                <td>@php
                    echo (new DateTime($startTime))->setTimeZone($timezone)->format('d F Y H:i T');
                @endphp s.d. @php
                    echo (new DateTime($endTime))->setTimeZone($timezone)->format('d F Y H:i T');
                @endphp</td>
            </tr>
            <tr>
                <td class="fw-bold">Nama Dokter</td>
                <td>:</td>
                <td>{{ $veterinarianNameAndTitle }}</td>
            </tr>
        </table>
        <section>
            <p class="fw-bold">Hasil Konsultasi</p>
            @if (isset($result) && $result)
                {!! $result !!}
            @else
                <p class="text-center text-muted">Dokter belum mengirimkan hasil konsultasi</p>
            @endif
        </section>

        @if (isset($chatLogs) && $chatLogs)

            <section>
                <p class="fw-bold">Riwayat Percakapan (Chat)</p>

                @for ($i = 0; $i < count($chatLogs); $i++)
                    <div class="border-bottom">
                        <p class="mb-1" style="font-size: 12px">
                            {{ $chatLogs[$i]['userId'] === $veterinarianId ? $veterinarianNameAndTitle : $bookerName }}
                            ({{ (new DateTime($chatLogs[$i]['timestamp']))->setTimeZone($timezone)->format('H:i') }})
                        </p>
                        @if (str_starts_with($chatLogs[$i]['message'], 'WITHFILE:'))
                            @php
                                $fileUrl = explode(':', $chatLogs[$i]['message'])[1];
                                $messageParts = explode('END;', $chatLogs[$i]['message']);
                                $fileUrl = str_replace('WITHFILE:', '', $messageParts[0]);
                                $messageContent = $messageParts[1];
                            @endphp

                            <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents('https://api.temanternak.h14.my.id/' . $fileUrl)) }}"
                                alt="File Image" class="img-fluid mb-1" style="max-width: 80%; max-height:400px">

                            <p style="font-size: 14px">{{ $messageContent }}</p>
                        @else
                            <p style="font-size: 14px">{{ $chatLogs[$i]['message'] }}</p>
                        @endif
                    </div>
                @endfor

            </section>
        @endif
        @if (isset($callLogs) && $callLogs)
            <section>
                <p>Riwayat Panggilan</p>
                <table class="table">

                    @for ($i = 0; $i < count($callLogs); $i++)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $callLogs[$i]['userId'] === $veterinarianId ? $veterinarianNameAndTitle : $bookerName }}
                            </td>
                            <td>{{ (new DateTime($callLogs[$i]['time']))->setTimeZone($timezone)->format('H:i T') }}
                            </td>
                            <td>{{ strtoupper($callLogs[$i]['state']) === 'CONNECTED' ? 'TERHUBUNG' : 'TERPUTUS' }}
                            </td>
                        </tr>
                    @endfor

                </table>
            </section>
        @endif

    </div>
</body>

</html>
