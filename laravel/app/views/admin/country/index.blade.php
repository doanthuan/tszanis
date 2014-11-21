@extends('admin.layouts.admin')

@section('content')

{{ (new AdminCountryGrid())->toHtml() }}

@stop