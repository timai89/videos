@section('module')
{{ __('Danh sách phát') }}
@stop
@section('function')
{{ __('Xóa danh sách phát') }}
@stop
@section('content')
<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">{{ __('Thông tin cơ bản') }}</h3>
    </div>
    <div class="box-body">
        @if ($errors->count() > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div> 
        @endif
        <div class="alert alert-warning">
            {{ Form::open(['url' => route('admin.playlist.delete', ['alias' => $playlist->alias]), 'method' => 'delete']) }}
                <p>{{ __('Bạn có muốn xóa danh sách phát :title không?', ['title' => $playlist->title]) }}</p>
                <button type="submit" class="btn btn-danger">{{ __('Xóa ngay') }}</button>
                <a href="{{ route('admin.playlist.index') }}"><button type="button" class="btn btn-default">{{ __('Hủy bỏ') }}</button></a>
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop