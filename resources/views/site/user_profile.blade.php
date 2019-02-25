@php \App\Helpers\Content::setData('user_menu', 'video'); @endphp
@section ('user_content')
<div class="heading">
    <i class="fa fa-video-camera"></i>
    <h4>{{ __('Video') }}</h4>
</div>
@foreach ($video as $v)
<div class="profile-video">
    <div class="media-object stack-for-small">
        <div class="media-object-section media-img-content">
            <div class="video-img">
                <img src="{{ $v->image }}" alt="{{ $v->title }}">
            </div>
        </div>
        <div class="media-object-section media-video-content">
            <div class="video-content">
                <h5><a href="{{ route('site.watch', ['alias' => $v->alias]) }}">{{ $v->title }}</a></h5>
                <p>{{ str_limit($v->description, $limit = 20, $end = '...') }}</p>
            </div>
            <div class="video-detail clearfix">
                <div class="video-stats">
                    <span><i class="fa fa-check-square-o"></i>{{ $v->privacy == 1 ? __('Không công khai') : ($v->privacy == 2 ? __('Riêng tư') : __('Công khai')) }}</span>
                    <span><i class="fa fa-clock-o"></i>{{ $v->created_at }}</span>
                    <span><i class="fa fa-eye"></i>{{ $v->views }}</span>
                </div>
                
                <div class="video-btns">
                    @if (\App\Helpers\Content::isMod() || (Auth::user() && Auth::user()->alias = $user->alias))
                    <a class="video-btn" href="{{ route('site.upload.video.edit', ['alias' => $v->alias]) }}"><i class="fa fa-pencil-square-o"></i>{{ __('Chỉnh sửa') }}</a>
                    <a class="video-btn delete-video" data-delete-url="{{ route('site.upload.video.delete', ['alias' => $v->alias]) }}"><i class="fa fa-trash"></i>{{ __('Xóa') }}</a>
                    @else
                    <a class="video-btn" href="{{ route('site.watch', ['alias' => $v->alias]) }}"><i class="fa fa-eye"></i>{{ __('Xem') }}</a>
                    <a class="video-btn" href="{{ route('site.report', ['alias' => $v->alias]) }}"><i class="fa fa-warning"></i>{{ __('Báo cáo') }}</a>
                    @endif
                </div>    
            </div>
        </div>
    </div>
</div>
@endforeach
@includeIf('site/pagination', ['paginator' => $video])
@stop

@includeIf('site/user_template')
@section ('ready-script')
@if (\App\Helpers\Content::isMod() || (Auth::user() && Auth::user()->alias = $user->alias))
$('.delete-video').click(function(){
    var _this = $(this);
    Lobibox.confirm({
        msg: "{{ __('Bạn có muốn xóa video này? Thao tác không thể hoàn lại') }}",
        callback: function (e, selection){
            if (selection == 'yes'){
                $.ajax({
                    url: _this.data('delete-url'),
                    method: 'post',
                    dataType: 'json',
                    data: {
                        _method: 'delete',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(){
                        window.location.reload()
                    }
                })
            }
        },
        buttons: {
            yes: {
                text: "{{ __('Đồng ý') }}",
            },
            no: {
                text: "{{ __('Hủy bỏ') }}"
            }
        }
    });
    
})
@endif
@append