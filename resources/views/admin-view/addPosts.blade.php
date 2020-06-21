@extends('../../master_layout/admin_master')


@section('title')
<title>New POST</title>
@endsection


@section('page_header')
<section class="content-header">
    <h1>
        NEW POST
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
@endsection



@section('content')
<div class="row">  
    <!-- Horizontal Form -->
    <div class="box box-info">

        <!--        <div class="box-header with-border">
                    <h3 class="box-title">Add Post</h3>
                </div>-->
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="POST" action="{{ URL::to('add-post') }}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">                                

                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" id="" placeholder="Titel">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Publish Date</label>
                    <div class="col-sm-10">
                        <input type="Date" name="publish_date" class="form-control" id="" placeholder="Publish Date">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Expired Date</label>
                    <div class="col-sm-10">
                        <input type="Date" name="expired_date" class="form-control" id="" placeholder="Expired Date">
                    </div>
                </div>                                    
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Video</label>
                    <div class="col-sm-10">
                        <input type="file" name="video"  class="form-control" id="" placeholder="Upload Video">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">poster image</label>
                    <div class="col-sm-10">
                        <input type="file" name="poster_image" class="form-control" id="" placeholder="poster image">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Content</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="content" rows="3" placeholder="contents ..."></textarea>
                    </div>
                </div>                                    
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Submit</button>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>                       
</div>
@endsection