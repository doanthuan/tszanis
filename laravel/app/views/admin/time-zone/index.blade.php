@extends('admin.layouts.admin')

@section('content')

{{ (new AdminTimeZoneGrid())->toHtml() }}

@stop