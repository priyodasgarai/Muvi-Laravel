@extends('../../master_layout/admin_master')


@section('title')
<title>POST</title>
@endsection

@section('custom_js')
<script>
    function video_count(){
    var id = {{$post->id}};
    $.ajax({
      type: "PUT",
      url: 'api/update_count/'+ id,
      data: {count_video: 0},
      success:function (data, status) {
    if (data.result == true) {
        window.location = "{{ url('/')}}";   
    } else{
        alert(data.message);
         window.location = "{{ url('/')}}";
    }
    }
    }) 
    };
    // Get the video element with id="myVideo"
var vid = document.getElementById("myVideo"); 
vid.addEventListener('ended',function(){
    alert("Expired Time Reached");
   video_count();
    });
//    vid.addEventListener('videoTracks',function(){
//    alert(vid.videoTracks.length);
//    });
// Assign an ontimeupdate event to the video element, and execute a function if the current playback position has changed
vid.ontimeupdate = function() {myFunction()};

function myFunction() {  
  document.getElementById("demo").innerHTML = vid.currentTime
}
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
<!-- row -->
<div class="row">
    <div class="col-md-12">
        <!-- The time line -->
        <ul class="timeline">


            <!-- timeline item -->
            <li>
                <i class="fa fa-video-camera bg-maroon"></i>

                <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> 5 days ago</span>



                    <div class="timeline-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            @if(!empty($post->video))
                            <video id="myVideo" width="320" height="240" autoplay controls>
                                <source src="{{asset('public/assets/images/'.$post->video)}}" type="video/mp4">
                                <source src="movie.ogg" type="video/ogg">
                                Your browser does not support HTML5 video.
                            </video>
                            <p>Playback position: <span id="demo"></span></p>


                            @endif

                        </div>
                    </div>
                    <div class="timeline-footer">
                       
                    </div>
                </div>
            </li>

        </ul>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection