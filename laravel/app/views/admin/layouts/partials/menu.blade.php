<?php $user = \Goxob\Core\Helper\Auth::user()?>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Admin Panel</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{url('admin/user')}}">Users</a></li>
                <li><a href="{{url('admin/language')}}">Languages</a></li>
                <li><a href="{{url('admin/time-zone')}}">Timezones</a></li>
                <li><a href="{{url('admin/country')}}">Countries</a></li>
                <li><a href="{{url('admin/specialty')}}">Specialty</a></li>
                <li><a href="{{url('admin/email-template')}}">Email Templates</a></li>
                <li><a href="{{url('admin/log')}}">Logs</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{url('admin/logout')}}">Log Out</a></li>
            </ul>

        </div><!--/.nav-collapse -->
    </div>
</div>

<script>
    $(document).ready(function(){
        var currentUrl = '{{{\Illuminate\Support\Facades\URL::current()}}}';
        if($('a[href="'+currentUrl+'"]').closest("li.dropdown").size() > 0 ){
            $('a[href="'+currentUrl+'"]').closest("li.dropdown").addClass('active');
        }
        else{
            $('a[href="'+currentUrl+'"]').closest("li").addClass('active');
        }
    });
</script>