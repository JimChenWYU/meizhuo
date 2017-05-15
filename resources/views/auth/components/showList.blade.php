@if(isset($settings['root']) && $settings['root'] == 'auth.signer')
@include('auth.components.searchSigner')
@elseif(isset($settings['root']) && $settings['root'] == 'auth.applicant')
@include('auth.components.searchApplicant')
@endif

<div class="container-list">
    <md-table-card class="main-content">
        <md-toolbar>
            <h1 class="md-title">{{ $departmentName }}</h1>
            <md-card-content>
                总报名人次：{{ $department['total'] }} 人次
            </md-card-content>
        </md-toolbar>

        <md-table md-sort="dessert" md-sort-type="desc">
            <md-table-header>
                <md-table-row>
                    <md-table-head>序号</md-table-head>
                    <md-table-head>学号</md-table-head>
                    <md-table-head>姓名</md-table-head>
                    <md-table-head>专业</md-table-head>
                    <md-table-head>年级</md-table-head>
                    <md-table-head>面试部门</md-table-head>
                    <md-table-head>报名时间</md-table-head>
                    <md-table-head>简介</md-table-head>
                </md-table-row>
            </md-table-header>

            <md-table-body>
                @foreach($department['data'] as $key => $person)
                    <md-table-row>
                        <md-table-cell>
                            {{ $department['from'] + $key }}
                        </md-table-cell>
                        <md-table-cell>{{ $person['student_id'] }}</md-table-cell>
                        <md-table-cell>{{ $person['name'] }}</md-table-cell>
                        <md-table-cell>{{ $person['major'] }}</md-table-cell>
                        <md-table-cell>{{ $person['grade'] }}</md-table-cell>
                        <md-table-cell>{{ $person['department'] }}</md-table-cell>
                        <md-table-cell>{{ $person['created_at'] }}</md-table-cell>
                        @if(isset($person['has_apply']) && $person['has_apply'] == 0)
                        <md-button disabled="disabled" class="md-raised md-primary">线下报名</md-button>
                        @else
                        <md-button href="{{ url('/auth/person/' . $person['id']) }}" class="md-raised md-primary">详情</md-button>
                        @endif
                    </md-table-row>
                @endforeach
            </md-table-body>
        </md-table>

        <div class="md-table-pagination">

            <span>{{ $department['from'] }}-{{ $department['to'] }} of {{ $department['total'] }}</span>

            <md-button class="md-icon-button md-table-pagination-previous"
                       href="{{ $department['prev_page_url'] }}"
                       :disabled={{ is_null($department['prev_page_url']) ? 'true' : 'false' }}>
                <md-icon>keyboard_arrow_left</md-icon>
            </md-button>

            <md-button class="md-icon-button md-table-pagination-next"
                       href="{{ $department['next_page_url'] }}"
                       :disabled="{{ is_null($department['next_page_url']) ? 'true' : 'false' }}">
                <md-icon>keyboard_arrow_right</md-icon>
            </md-button>
        </div>
    </md-table-card>
</div>