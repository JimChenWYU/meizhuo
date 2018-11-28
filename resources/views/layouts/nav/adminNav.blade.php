<nav class="header-tab">
    <md-toolbar class="md-dense" v-clock>
        @if(! Auth::guest())
            <md-button class="md-icon-button" @click.native="toggleLeftSidenav"
                       v-display-button>
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