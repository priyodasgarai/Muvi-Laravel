@extends('../../master_layout/admin_master')


@section('title')
<title>ALL POSTS</title>
@endsection


@section('page_header')
<section class="content-header">
    <h1>
        Posts 
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
<!--                        <div class="input-group-btn">
                            <a  href="{{url('add-post')}}" class="btn btn-mini btn-primary pull-right button_class">{{trans('labels.17')}}</a>
                        </div>-->
                    </div>
                </div>
            </div><!-- /.box-header -->

            @if(!empty($posts))
            <div class="box-body table-responsive no-padding">

                <table class="table table-hover">
                    <tr>                       
                        <th>Poster Image</th>
                    </tr>
                    @foreach($posts as $cat) 
                    <tr>                       
                        <td>
                            <div class="row margin-bottom">
                                <a href="{{ url('post-details-'.base64_encode($cat->id.'||'.env('APP_KEY')))}}"  class="btn btn-mini mergin_one" > 
                            @if(!empty($cat->poster_image))
                            <img src="{{asset('public/assets/images/'.$cat->poster_image)}}" alt="Photo" class="img-responsive" height="100" width="100">
                            @else 
                            <img src="{{asset('public/assets/images/01.png')}}" alt="Photo" class="img-responsive" height="100" width="100">
                            @endif
                                </a>
                            </div>
                            <div>
                                <a href="{{ url('post-details-'.base64_encode($cat->id.'||'.env('APP_KEY')))}}"  class="btn btn-mini mergin_one" >                               
                                {{$cat->title}}
                                </a>
                            </div>
                        </td>
                       
                    </tr>
                    @endforeach
                </table>
            </div><!-- /.box-body -->

            @else
            <div class="box-body table-responsive no-padding">
                <h3>  {{trans('messages.7')}} </h3>
            </div>
            @endif

        </div><!-- /.box -->
    </div>
</div>

@endsection