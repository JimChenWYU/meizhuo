@extends('layouts.admin')

@section('content')
    <form role="form" method="post" action="{{ url('/auth/register') }}">
        {{ csrf_field() }}
        <md-layout md-gutter>
            <md-layout></md-layout>
            <md-layout md-flex="40">

                <md-input-container class="{{ $errors->has('name') ? 'md-input-invalid' : '' }}">
                    <label>名字</label>
                    <md-input type="text" name="name" value="{{ old('name') }}" required></md-input>
                </md-input-container>

                <md-input-container class="{{ $errors->has('email') ? 'md-input-invalid' : '' }}">
                    <label>账户</label>
                    <md-input type="email" name="email" value="{{ old('email') }}" required></md-input>
                    @if($errors->has('email'))
                        <span class="md-error">{{ $errors->first('email') }}</span>
                    @endif
                </md-input-container>

                <md-input-container md-has-password class="{{ $errors->has('password') ? 'md-input-invalid' : '' }}">
                    <label>密码</label>
                    <md-input type="password" name="password" required></md-input>
                    @if($errors->has('password'))
                        <span class="md-error">{{ $errors->first('password') }}</span>
                    @endif
                </md-input-container>

                <md-input-container md-has-password class="{{ $errors->has('password_confirmation') ? 'md-input-invalid' : '' }}">
                    <label>确认密码</label>
                    <md-input type="password" name="password_confirmation" required></md-input>
                    @if($errors->has('password_confirmation'))
                        <span class="md-error">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </md-input-container>
            </md-layout>
            <md-layout></md-layout>
        </md-layout>
        <p></p>
        <md-layout md-gutter>
            <md-layout md-flex="30"></md-layout>
            <md-layout>
                <md-button class="md-raised md-primary" type="reset">重置</md-button>

                <md-button class="md-raised md-accent" type="submit">注册</md-button>
            </md-layout>
        </md-layout>
    </form>
@endsection
