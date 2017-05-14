<md-sidenav class="main-sidebar md-left md-fixed" ref="leftSidenav">
    <md-toolbar class="md-large admin-list__logo">
        <div>
            <img class="" src="{{ url('/images/mz.png') }}" alt="meizhuo logo">
            @if(Auth::guest())
                <span>您未登录，
                    <a href="{{ url('/auth/login') }}" class="md-raised md-primary">
                        请登录
                    </a>
                </span>
            @else
            @endif
            <span>欢迎&nbsp;{{ Auth::user()->name }}，
                    <a href="{{ url('/auth/logout') }}" class="md-raised md-primary">
                      退出
                    </a>
		        </span>
        </div>
    </md-toolbar>

    <div class="main-sidebar-links">
        <md-list class="md-double-line md-dense">
            <md-subheader>Navigation</md-subheader>

            {{--<md-list-item v-for="p of permission" v-if="p.isPermit">--}}
            {{--<a href="" class="md-list-item-container md-button router-link-active">--}}
            {{--<md-icon>send</md-icon>&nbsp;<span>@{{ p.name }}</span>--}}
            {{--</a>--}}
            {{--</md-list-item>--}}
            <md-list-item>
                <a href="{{ url('/auth/home') }}"
                   class="md-list-item-container md-button {{ !isset($all) ?:'router-link-active' }}">
                    <md-icon>send</md-icon>&nbsp;<span>所有人</span>
                </a>
            </md-list-item>

            <md-list-item>
                <a href="{{ url('/auth/android') }}"
                   class="md-list-item-container md-button {{ !isset($android) ?:'router-link-active' }}">
                    <md-icon>send</md-icon>&nbsp;<span>移动组</span>
                </a>
            </md-list-item>

            <md-list-item>
                <a href="{{ url('/auth/web') }}"
                   class="md-list-item-container md-button {{ !isset($web) ?:'router-link-active' }}">
                    <md-icon>send</md-icon>&nbsp;<span>Web组</span>
                </a>
            </md-list-item>

            <md-list-item>
                <a href="{{ url('/auth/design') }}"
                   class="md-list-item-container md-button {{ !isset($design) ?:'router-link-active' }}">
                    <md-icon>send</md-icon>&nbsp;<span>美工组</span>
                </a>
            </md-list-item>

            <md-list-item>
                <a href="{{ url('/auth/marking') }}"
                   class="md-list-item-container md-button {{ !isset($marking) ?:'router-link-active' }}">
                    <md-icon>send</md-icon>&nbsp;<span>营销策划</span>
                </a>
            </md-list-item>

            <md-subheader>管理</md-subheader>

            <md-list-item>
                <a href="{{ url('/auth/interviewer') }}"
                   class="md-list-item-container md-button {{ !isset($interview) ?:'router-link-active' }}">
                    <md-icon>send</md-icon>&nbsp;<span>强制面试官退出</span>
                </a>
            </md-list-item>
        </md-list>
    </div>
</md-sidenav>