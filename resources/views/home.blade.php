
@extends('layouts.app')

@section('content')

<div class="w-screen h-screen bg-black">
  <div id="terminal" class="m-4 absolute pin"></div>
</div>

<script>
    window.webSocket = @json(config('websockets'));

    window.sessionId = @json($sessionId);
</script>

@endsection