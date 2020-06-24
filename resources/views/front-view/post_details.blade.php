@extends('../../master_layout/admin_master')


@section('title')
<title>POST</title>
@endsection

@section('custom_js')
<script>
    function video_count(id){
    var dec = window.atob(id);
    var res = dec.split('||');
    var item_id = res[1];
    $.ajax({
      type: "PUT",
      url: 'api/update_count/'+ item_id,
      data: {count_video: 1},
      success:function (data, status) {
    if (data.result == true) {
        window.location.href = "{{ url('play-video-'.base64_encode($post->id.'||'.env('APP_KEY')))}}";    
    } else{
        alert(data.message);   
    }
    }
    }) 
    };
</script>
@endsection

@section('page_header')
<section class="content-header">
    <h1>
        Post Details
    </h1>
</section>
@endsection

@section('message')
@if ($errors->any())
<div class="callout callout-danger">
    <h4>Error!</h4>
    @foreach ($errors->all() as $error)
    <p>{{$error}}</p>
    @endforeach

</div>
@endif
@if(Session::has('flash_message'))
<div class="alert alert-info">
    <a class="close" data-dismiss="alert">×</a>
    {{Session::get('flash_message')}}<strong> !</strong> 
    {{Session::forget('flash_message')}}
</div>
@endif
@endsection


@section('content')

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">

                <div class="box-tools">
                    <div class="input-group" style="width: 150px;">                     
                       
                    </div>
                </div>
            </div><!-- /.box-header -->

            @if(!empty($post))
            <div class="col-md-3"></div>
            <div class="box-body box-profile col-md-6">              
                @if(!empty($post->poster_image))
                <img src="{{asset('public/assets/images/'.$post->poster_image)}}" alt="Photo" class="profile-user-img img-responsive img-circle" height="100" width="100">
                @else 
                <img src="{{asset('public/assets/images/01.png')}}" alt="Photo" class="profile-user-img img-responsive img-circle" height="100" width="100">
                @endif

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Titel</b> <a class="pull-right">{{$post->title}} </a>
                    </li>
                    <li class="list-group-item">
                        <b>Publish Date</b> <a class="pull-right">{{$post->publish_date}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Expired Date</b> <a class="pull-right">{{$post->expired_date}}</a>
                    </li>
                </ul>              
                    
                    @if($post->publish_date >= date("Y-m-d"))
                    <b>Display Coming Soon</b>
                    @elseif($post->expired_date <= date("Y-m-d"))
                    <b>Display Expired</b>
                    @elseif($post->publish_date <= date("Y-m-d") && $post->expired_date >= date("Y-m-d"))
                     <a class="btn btn-mini mergin_one" onclick="video_count('{{base64_encode(env('APP_KEY').'||'.$post->id)}}')">
                    <b>Play</b>
                    </a>
                    @endif                    
               

                <!-- /.box -->

            </div><!-- /.box-body -->
            <div class="col-md-3"></div>
            @else
            <div class="box-body table-responsive no-padding">
                <h3>  {{trans('messages.7')}} </h3>
            </div>
            @endif

        </div><!-- /.box -->
    </div>
</div>

@endsection