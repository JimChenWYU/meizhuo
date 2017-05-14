@extends('layouts.admin')

@section('content')
    @include('layouts.nav.adminNav')

    @include('auth.components.menu')

    @include('auth.components.interviewerList')
@endsection