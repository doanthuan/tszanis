@extends('admin.layouts.admin')

@section('content')

{{ (new AdminAccountGrid())->toHtml() }}

@stop