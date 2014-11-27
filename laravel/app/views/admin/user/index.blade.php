@extends('admin.layouts.admin')

@section('content')

{{ (new AdminUserGrid())->toHtml() }}

@stop