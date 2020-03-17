@extends('admin.layout.index')
@section('content')
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Sửa
                            <small>{{$slide->Ten}}</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                        @if(count($errors)>0)
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                    {{$err }}<br>
                                @endforeach
                            </div>
                        @endif
                        @if(session('thongbao'))
                            <div class="alert alert-success">
                                {{session('thongbao')}}
                            </div>
                        @endif
                        <form action="admin/slide/sua/{{$slide->id}}" method="POST" enctype="multipart/form-data">
                            @csrf
                           
                            <div class="form-group">
                                <label>Tên</label>
                                <input class="form-control" name="Ten" placeholder="Tên" value="{{$slide->Ten}}" />
                            </div>
                            <!-- <div class="form-group">
                                <label>Tóm tắt</label>
                                <input class="form-control" name="TomTat" placeholder="Tóm tắt" />
                            </div>
                            <div class="form-group">
                                <label>Category Keywords</label>
                                <input class="form-control" name="txtOrder" placeholder="Please Enter Category Keywords" />
                            </div> -->
                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea name="NoiDung" id="demo" class="form-control ckeditor" rows="3">
                                    {{$slide->NoiDung}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label>Link</label>
                                <input class="form-control" name="Link" placeholder="Link"  value="{{$slide->link}}" />
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh</label>
                                 <p><img src="upload/slide/{{$slide->Hinh}}" width="400px"></p>
                                <input type="file" name="Hinh" class="form-control">
                            </div>
                            
                            <button type="submit" class="btn btn-default">Sửa</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
@endsection
@section('script')
    <script type="text/javascript">$(document).ready(function(){
        $("#TheLoai").change(function(){
            var idTheLoai = $(this).val();
            $.get("admin/ajax/loaitin/"+idTheLoai, function(data){
                $("#LoaiTin").html(data);
            });
        });
    });</script>
    <script type="text/javascript" language="javascript" src="admin_asset/ckeditor/ckeditor.js" ></script>
@endsection
