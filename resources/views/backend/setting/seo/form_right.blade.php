<div class="card">
    <div class="card-header bg-primary">
        <h5 class="mb-0 card-title font-weight-bold text-white">@lang('app.home_page_seo')</h5>
    </div>

    <div class="card-body">

        <div class="form-group">
            <label class="col-form-label" for="title">@lang('app.seo_title')</label>

            <input type="text" name="title" id="title" class="form-control" value="{{ get_config('title') }}" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="keywords">@lang('app.seo_keywords')</label>
            <input type="text" name="keywords" id="keywords" class="form-control" value="{{ get_config('keywords') }}" autocomplete="off">
            <em class="description">@lang('app.use_comma_to_separate_keyword')</em>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="description">@lang('app.seo_meta_description')</label>

            <textarea name="description" id="description" class="form-control" rows="4">{{ get_config('description') }}</textarea>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
        <h5 class="mb-0 card-title font-weight-bold text-white">@lang('app.tv_series_page_seo')</h5>
    </div>

    <div class="card-body">

        <div class="form-group">
            <label class="col-form-label" for="author_name">@lang('app.seo_title')</label>

            <input type="text" name="tv_series_title" id="tv_series_title" class="form-control" value="{{ get_config('tv_series_title') }}" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="author_name">@lang('app.seo_keywords')</label>

            <input type="text" name="tv_series_keywords" id="tv_series_keywords" class="form-control" value="{{ get_config('tv_series_keywords') }}" autocomplete="off">
            <em class="description">@lang('app.use_comma_to_separate_keyword')</em>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="tv_series_description">@lang('app.seo_meta_description')</label>
            <textarea name="tv_series_description" id="tv_series_description" class="form-control" rows="4">{{ get_config('tv_series_description') }}</textarea>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
        <h5 class="mb-0 card-title font-weight-bold text-white">@lang('app.social_setting')</h5>
    </div>

    <div class="card-body">
        <div class="form-group">
            <label class="col-form-label" for="facebook">Facebook URL</label>

            <input type="text" name="facebook" id="facebook" class="form-control" value="{{ get_config('facebook') }}" autocomplete="off">
        </div>

        <div class="form-group">
            <label class="col-form-label" for="twitter">Twitter URL</label>

            <input type="text" name="twitter" id="twitter" class="form-control" value="{{ get_config('twitter') }}" autocomplete="off">
        </div>

        <div class="form-group">
            <label class="col-form-label" for="linkedin">Linkedin URL</label>

            <input type="text" name="linkedin" id="linkedin" class="form-control" value="{{ get_config('linkedin') }}" autocomplete="off">
        </div>

        <div class="form-group">
            <label class="col-form-label" for="youtube">Youtube URL</label>

            <input type="text" name="youtube" id="youtube" class="form-control" value="{{ get_config('youtube') }}" autocomplete="off">
        </div>

    </div>
</div>