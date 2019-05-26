@extends('layouts.web')

@section('content')
    @include('chunks.report', ['report' => $report, 'result' => $result, 'resultMark' => $resultMark, 'user' => $user])
@endsection
