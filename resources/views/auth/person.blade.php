@extends('layouts.admin')

@section('content')
    @include('layouts.nav.adminNav')

    @include('auth.components.menu')

    <div class="container-person">
        <md-table-card class="main-content">
                <md-table>
                    <md-table-header>
                        <md-table-row>
                            <md-table-head>学号</md-table-head>
                            <md-table-head>姓名</md-table-head>
                            <md-table-head>专业</md-table-head>
                            <md-table-head>联系方式</md-table-head>
                            <md-table-head>年级</md-table-head>
                            <md-table-head>意向部门</md-table-head>
                        </md-table-row>
                    </md-table-header>

                    <md-table-body>
                        <md-table-row>
                            <md-table-cell>{{ $person['student_id'] }}</md-table-cell>
                            <md-table-cell>{{ $person['name'] }}</md-table-cell>
                            <md-table-cell>{{ $person['major'] }}</md-table-cell>
                            <md-table-cell>{{ $person['phone_num'] }}</md-table-cell>
                            <md-table-cell>{{ $person['grade'] }}</md-table-cell>
                            <md-table-cell>{{ $person['department'] }}</md-table-cell>
                        </md-table-row>
                        <md-table-row>
                            <md-table-head colspan="6" style="text-align: center">
                                简介
                            </md-table-head>
                        </md-table-row>
                        <md-table-row>
                            <md-table-cell colspan="6">{{ $person['introduce'] }}</md-table-cell>
                        </md-table-row>
                    </md-table-body>
                </md-table>
            </md-table-card>
    </div>
@endsection