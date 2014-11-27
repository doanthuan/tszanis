@extends('admin.layouts.admin')

@section('content')

{{ (new AdminEmailTemplateGrid())->toHtml() }}

@stop