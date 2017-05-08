@extends('layouts.admin')

@section('content')
    @include('layouts.nav.adminNav')

    @include('auth.department.components.menu')

    @include('auth.department.components.showList')
@endsection