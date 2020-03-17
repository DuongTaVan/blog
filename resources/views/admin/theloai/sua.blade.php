@extends('admin.layout.index')
@section('content')
 <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Thể loại
                            <small>{{$theloai -> Ten}}</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                        <form action="admin/theloai/sua/{{$theloai->id}}" method="POST">
                            <!-- <input type="hidden" name="_token" value="{{csrf_token()}}"/> -->
                            @csrf
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
                           <!--  <div class="form-group">
                                <label>Category Parent</label>
                                <select class="form-control">
                                    <option value="0">Please Choose Category</option>
                                    <option value="">Tin Tức</option>
                                </select>
                            </div> -->
                            <div class="form-group">
                                <label>Tên thể loại</label>
                                <input class="form-control" name="Ten" placeholder="Tên thể loại" value="{{$theloai -> Ten}}" />
                            </div>
                            <!-- <div class="form-group">
                                <label>Category Order</label>
                                <input class="form-control" name="txtOrder" placeholder="Please Enter Category Order" />
                            </div>
                            <div class="form-group">
                                <label>Category Keywords</label>
                                <input class="form-control" name="txtOrder" placeholder="Please Enter Category Keywords" />
                            </div>
                            <div class="form-group">
                                <label>Category Description</label>
                                <textarea class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Category Status</label>
                                <label class="radio-inline">
                                    <input name="rdoStatus" value="1" checked="" type="radio">Visible
                                </label>
                                <label class="radio-inline">
                                    <input name="rdoStatus" value="2" type="radio">Invisible
                                </label>
                            </div> -->
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