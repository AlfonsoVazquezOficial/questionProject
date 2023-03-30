<head>
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{URL::to('/')}}/logo.png">
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class=" font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @yield('title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-dark dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                @yield('content')
            </div>
        </div>
    </div>
</x-app-layout>