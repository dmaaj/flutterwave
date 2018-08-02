@extends('layouts.app')

@section('custom_styles')


@endsection

@section('layout')




    @include('includes.header')
        <main class="">
            @yield('content')
        </main>
    



@endsection
@section('custom_script')


@endsection