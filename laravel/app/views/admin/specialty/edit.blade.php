@extends('admin.layouts.admin')

@section('content')
{{ Form::model($item, array('name' => 'adminForm', 'class' => 'form-horizontal', 'url' => 'admin/specialty/edit'))}}

<div class="form-group">
    {{ Form::label('spec_name', 'Specialty Name', array('class' => 'col-sm-2 control-label')) }}
    <div class="col-sm-6">
    {{ Form::text('spec_name', null, array('class' => 'form-control', 'required')) }}
    </div>
</div>


{{Form::hidden('spec_id')}}

{{ Form::close()}}

@stop

@section('footer')
@parent
<script src="{{url('js/jquery.validate.min.js')}}"></script>
@stop