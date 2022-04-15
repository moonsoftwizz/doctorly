@if(!empty($notification_count))
    @foreach ($notification_count as $item)
        <a href="/notification/{{ $item->id }}" class="text-reset notification-item">
            <div class="media">
                <img src="@if($item->user->profile_photo != ''){{ URL::asset('storage/images/users/' . $item->user->profile_photo) }}@else{{ URL::asset('assets/images/users/noImage.png') }}@endif"
                    class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                <div class="media-body">
                    <h6 class="mt-0 mb-1">{{$item->user->first_name .' '.$item->user->last_name}}</h6>
                    <div class="font-size-12 text-muted">
                        <p class="mb-1">{{$item->title }}</p>
                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> {{ $item->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
@endif
