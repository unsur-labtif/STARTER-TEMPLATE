@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(auth()->user()->roles_id == 1)
                        Anda login sebagai Admin
                    @else
                        Anda login sebagai User
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
