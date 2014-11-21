@extends('admin.layouts.admin')

@section('content')

{{ (new AdminLanguageGrid())->toHtml() }}

@stop