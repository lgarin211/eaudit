@extends('template')
@section('content')
    <div class="container">
        <p style="margin-left: 10px; margin-top:10px; color:black"> Hai <b>{{ session('name') }}  </b> dengan <b>{{ session('username') }}</b> serta <i>{{ session('level') }}</i></p>
    </div>
@endsection
