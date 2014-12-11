@extends('admin.layouts.admin')

@section('content')

{{ (new AdminLogGrid())->toHtml() }}

@stop