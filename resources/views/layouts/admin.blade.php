<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>后台管理系统</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Styles -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}
    <link rel="stylesheet" href="https://unpkg.com/vue-material@0.7.1/dist/vue-material.css">
    <link href="{{ mix('/css/admin.css') }}" rel="stylesheet">

</head>
<body id="app-layout">
<div id="admin" class="{{ Auth::guest() ? '' : 'container' }}" v-cloak>
    @if(Auth::guest())
    <nav class="header-tab">
        <md-toolbar class="md-dense">
            <div class="padding-left-40px"></div>
            <h2 class="md-title" style="flex: 1"><span v-text="toolbar.header"></span></h2>
        </md-toolbar>
    </nav>
    @endif

    @yield('content')
</div>
<!-- JavaScripts -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>--}}
<script src="https://unpkg.com/vue@2.3.2/dist/vue.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/vue-material@0.7.1" crossorigin="anonymous"></script>
{{--<script src="https://cdn.bootcss.com/socket.io/1.7.4/socket.io.min.js" crossorigin="anonymous"></script>--}}
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
@if(config('app.debug'))
<script src="http://localhost:35729/livereload.js?snipver=1.0.0"></script>
@endif
<script>
    Vue.use(VueMaterial)

    new Vue({
        el: "#admin",
        data: {
            toolbar: {
                header: '后台管理系统'
            },
        },
        methods: {
            toggleLeftSidenav: function () {
                this.$refs.leftSidenav.toggle();
            },
            onPagination(pagination) {
                console.log(pagination)
            }
        },
        directives: {
            displayButton: {
                update: function (el) {

                    function on() {
                        if (window.innerWidth <= 1281) {
                            el.style.visibility = 'visible'
                        } else {
                            el.style.visibility = 'hidden'
                        }
                    }

                    on()

                    window.addEventListener('resize', on)
                }
            }
        }
    });
</script>
</body>
</html>
