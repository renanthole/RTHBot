@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => 'Dashboard', 'breadcrumbs' => [['url' => route('home'), 'label' => 'Dashboard']]])

@section('content')
    <h1>You are logged in!</h1>
@endsection
