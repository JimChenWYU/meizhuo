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
<div id="admin" class="{{ Auth::guest() ? '' : 'container' }}">
    @if(Auth::guest())
    <nav class="header-tab">
        <md-toolbar class="md-dense" v-clock>
            {{--@if(! Auth::guest())--}}
                {{--<md-button class="md-icon-button" @click.native="toggleLeftSidenav">--}}
                    {{--<md-icon>menu</md-icon>--}}
                {{--</md-button>--}}
            {{--@else--}}
                {{--<div class="padding-left-40px"></div>--}}
            {{--@endif--}}
            <div class="padding-left-40px"></div>

            <h2 class="md-title" style="flex: 1"><span v-text="toolbar.header"></span></h2>

            {{--@if(! Auth::guest())--}}
            {{--<md-button>欢迎 {{ Auth::user()->name }}</md-button>--}}
            {{--<md-button href="{{ url('auth/logout') }}">退出</md-button>--}}
            {{--@endif--}}
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
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
<script>
    Vue.use(VueMaterial)

    new Vue({
      el: "#admin",
      data: {
        toolbar: {
          header: '后台管理系统'
        },
        permission: [
          { isPermit: true, name: '移动组', value: '移动组' },
          { isPermit: true, name: 'Web组', value: 'Web组' },
          { isPermit: true, name: '美工组', value: '美工组' },
          { isPermit: true, name: '营销策划', value: '营销策划' }
        ],
        nutrition: [
          {
            dessert: 'Frozen yogurt',
            type: 'ice_cream',
            calories: '159',
            fat: '6.0',
            comment: 'Icy'
          },
          {
            dessert: 'Ice cream sandwich',
            type: 'ice_cream',
            calories: '237',
            fat: '9.0',
            comment: 'Super Tasty'
          },
          {
            dessert: 'Eclair',
            type: 'pastry',
            calories: '262',
            fat: '16.0',
            comment: ''
          },
          {
            dessert: 'Cupcake',
            type: 'pastry',
            calories: '305',
            fat: '3.7',
            comment: ''
          },
          {
            dessert: 'Gingerbread',
            type: 'other',
            calories: '356',
            fat: '16.0',
            comment: ''
          }
        ],
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
