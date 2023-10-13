<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
    <title>admin panel</title>
</head>

<body class="bg-gray-100">
    @livewire('util.alert',[
      'isAdmin' => true,
    ])
    @include('layouts.admin.header')
    <div class="flex flex-row admin_content-width">
        @include('layouts.admin.aside')
        <div class="w-full">
            @yield('content')
        </div>
    </div>
    @livewireScripts
</body>

</html>
