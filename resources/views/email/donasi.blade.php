<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Email Informasi Donasi</title>

        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="antialiased">
        <div class="container w-full mx-auto m-4">
            <div class="w-full mx-auto p-4">  
              <div class="w-full lg:w-3/4 mx-auto">
                <div class="mt-1 p-1">
                  <span class="text-green-500 font-semibold">Konfirmasi Donasi Anda untuk {{ $donasi->judul }}</span>
                </div>
                <div class="p-2 rounded shadow flex flex-col text-green-700">
                    <div class="w-full text-base lg:text-xl font-bold">
                        Silahkan lakukan transfer donasi anda ke
                    </div><br>
                    <ul class="m-2 p-2">
                        <li class="text-sm lg:text-base font-semibold">
                            Bank: {{ $donasi->bank }}
                        </li>
                        <li class="text-sm lg:text-base font-semibold">
                            No. Rekening: {{ $donasi->rekening }}
                        </li>
                        <li class="text-sm lg:text-base font-semibold">
                            Nama Rekening: {{ $donasi->nama_rekening }}
                        </li>
                    </ul>
                </div>
              </div>
            </div>
        </div>
    </body>
</html>
