@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-md-offset">
            <img src="{{ $user->avatar }} " style="width: 150px;height:150px; float: left; border-radius: 50%"/>
            <h2>Profil użytkownika {{ $user->name }}</h2>
            <form enctype="multipart/form-data" action="profile" method="POST">
                <label>Nowe zdjęcie</label><br/>
                <input type="file" name="avatar"><br/>
                @csrf
                <input type="submit" value="Dodaj zdjęcie" class="pull-right btn btn-sm btn-primary"><br/>
            </form>
        </div>
    </div>
</div>
@endsection
