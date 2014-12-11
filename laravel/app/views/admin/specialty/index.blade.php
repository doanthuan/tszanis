@extends('admin.layouts.admin')

@section('content')

{{ (new AdminSpecialtyGrid())->toHtml() }}

@stop