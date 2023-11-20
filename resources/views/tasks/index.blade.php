@extends('layouts.app')

@section('content')
    <h1>Task Management</h1>

    <div id="app">
        <task-manager></task-manager>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
@endsection
