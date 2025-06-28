<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>@if(View::hasSection('title')) @yield('title') | @endif {{env('APP_NAME')}}</title>

        <!-- CSS files -->
        <link href="{{url('/')}}/assets/admin/layouts/css/tabler.min.css?1692870487" rel="stylesheet" />
        <link href="{{url('/')}}/assets/admin/layouts/css/tabler-flags.min.css?1692870487" rel="stylesheet" />
        <link href="{{url('/')}}/assets/admin/layouts/css/tabler-payments.min.css?1692870487" rel="stylesheet" />
        <link href="{{url('/')}}/assets/admin/layouts/css/tabler-vendors.min.css?1692870487" rel="stylesheet" />
        <link href="{{url('/')}}/assets/admin/layouts/css/demo.min.css?1692870487" rel="stylesheet" />

        <style>
            @import url('https://rsms.me/inter/inter.css');

            :root {
                --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
            }

            body {
                font-feature-settings: "cv03", "cv04", "cv11";
            }
        </style>

        <!--page lavel css-->
        @stack('css')        
        <!--./page lavel css-->

        <script type="text/javascript">
            const  base_url = '{{env("APP_URL")}}';
            const  SITE_URL = '{{env("SITE_URL")}}';
        </script>
    </head>

    <body>
        <div class="page">
            @include('admin.layouts.sidebar')

            @include('admin.layouts.navbar')

            <div class="page-wrapper">
                @include('admin.layouts.page-header')

                <!-- Page body -->
                <div class="page-body">
                    <div class="container-xl">
                        @yield('content')
                    </div>
                </div>

                <!-- Page Footer -->
                @include('admin.layouts.footer')
                <!-- Page Footer -->
            </div>
        </div>

        <!--/#app -->
        <script src="{{url('/')}}/plugins/jquery/jquery-2.2.4.min.js" type="text/javascript"></script>

        <!-- Tabler Core -->
        <script src="{{url('/')}}/assets/admin/layouts/js/tabler.min.js?1692870487" defer></script>
        <script src="{{url('/')}}/assets/admin/layouts/js/demo.min.js?1692870487" defer></script>
        <script src="{{url('/')}}/assets/admin/layouts/js/demo-theme.min.js?1692870487"></script>

        <!--page lavel scripts-->
        @stack('scripts')             
        <!--./page lavel scripts-->

    </body>

</html>
