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
    <link href="{{ mix('/css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/vue-material@0.7.1/dist/vue-material.css">

</head>
<body id="app-layout">
<div id="admin">
    <nav class="header-tab">
        <md-toolbar class="md-dense" v-clock>
            @if(! Auth::guest())
                <md-button class="md-icon-button" @click.native="toggleLeftSidenav">
                    <md-icon>menu</md-icon>
                </md-button>
            @else
                <div class="padding-left-40px"></div>
            @endif
            <h2 class="md-title" style="flex: 1"><span v-text="toolbar.header"></span></h2>

            @if(! Auth::guest())
            <md-button>欢迎 {{ Auth::user()->name }}</md-button>
            <md-button href="{{ url('auth/logout') }}">退出</md-button>
            @endif
        </md-toolbar>
    </nav>

    <md-sidenav class="md-left" ref="leftSidenav" @open="open('Left')" @close="close('Left')" v-clock>
        <md-toolbar class="md-large">
            <div class="md-toolbar-container">
                <h3 class="md-title">Sidenav content</h3>
            </div>
        </md-toolbar>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi cupiditate esse necessitatibus beatae nobis, deserunt ut est fugit, tempora deleniti, eligendi commodi doloribus. Nemo, assumenda possimus, impedit inventore perferendis iusto!</p>
    </md-sidenav>
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
        }
      },
      methods: {
        toggleLeftSidenav: function () {
          this.$refs.leftSidenav.toggle();
        },
        open: function (ref) {
          console.log('Opened: ' + ref);
        },
        close: function (ref) {
          console.log('Closed: ' + ref);
        }
      }
    });
</script>
</body>
</html>
