<div id="interview" class="container-list">
    <md-table-card class="main-content">
        <md-toolbar>
            <h1 class="md-title">{{ $name }}</h1>
            <md-card-content>
                总数：{{ count($group) }}
            </md-card-content>
        </md-toolbar>

        <md-table>
            <md-table-header>
                <md-table-row>
                    <md-table-head>序号</md-table-head>
                    <md-table-head>组名</md-table-head>
                    <md-table-head>组数</md-table-head>
                    <md-table-head>正在登录用户ID(或过期用户ID)</md-table-head>
                    <md-table-head>操作</md-table-head>
                </md-table-row>
            </md-table-header>

            <md-table-body>
                @foreach($group as $key => $perGroup)
                    <md-table-row>
                        <md-table-cell>
                            {{ $key + 1 }}
                        </md-table-cell>
                        <md-table-cell>{{ $perGroup['department'] }}</md-table-cell>
                        <md-table-cell>{{ $perGroup['number'] }}</md-table-cell>
                        <md-table-cell>{{ $perGroup['unique_id'] }}</md-table-cell>
                        @if((is_null($perGroup['unique_id'])
                            || empty($perGroup['unique_id']))
                            && $perGroup['is_login'] == 0)
                            <md-button disabled="disabled" class="md-raised md-warn" type="button">
                                强制退出</md-button>
                        @else
                            <md-button class="md-raised md-warn"
                                       type="button"
                                       @click.native="confirmForce()">强制退出</md-button>

                            <form action="{{ url('/auth/interviewer/' . $perGroup['id']) }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $perGroup['id'] }}" name="id" />
                                <md-button
                                        id="true-submit"
                                        style="display: none"
                                        class="md-raised md-warn"
                                        type="submit">强制退出</md-button>
                            </form>
                        @endif
                    </md-table-row>
                @endforeach
            </md-table-body>
        </md-table>
    </md-table-card>
    @if(isset($errors) && isset($errors->msg))
        <script> window.alert({{ $errors->msg }}) </script>
    @endif
    <script>
        function confirmForce() {
            var true_button = document.querySelector('#true-submit')
            true_button.addEventListener('click', function () {})
            if (confirm('您确定要强制退出吗？')) {
                true_button.click()
            }
        }
    </script>
</div>