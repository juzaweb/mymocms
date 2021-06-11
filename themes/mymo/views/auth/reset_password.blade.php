@extends('layouts.master')

@section('content')
    <div class="row container" id="wrapper">
        <div class="mymo-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-8 hidden-xs">
                        <div class="yoast_breadcrumb">
                            <span>
                                <span>
                                    <a href="{{ route('home') }}">@lang('mymo::app.home')</a> »
                                    <span class="breadcrumb_last" aria-current="page">@lang('mymo::app.verified_success')</span>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-4 text-right">
                        <a href="javascript:;" id="expand-ajax-filter">@lang('mymo::app.filter_movies') <i id="ajax-filter-icon" class="hl-angle-down"></i></a>
                    </div>
                    <div id="alphabet-filter" style="float: right;display: inline-block;margin-right: 25px;"></div>
                </div>
            </div>
            <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                <div class="ajax"></div>
            </div>
        </div>

        <main class="col-xs-12 col-sm-12 col-md-12">
            <div class="post-content panel-body text-center">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <form action="{{ route('password.reset.submit', [$token]) }}" method="post" class="form-ajax">

                            <label>@lang('mymo::app.new_password')</label>
                            <div class="form-group pass_show">
                                <input type="password" class="form-control" name="password" placeholder="@lang('mymo::app.new_password')">
                            </div>

                            <label>@lang('mymo::app.confirm_password')</label>
                            <div class="form-group pass_show">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="@lang('mymo::app.confirm_password')">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">@lang('mymo::app.update')</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
