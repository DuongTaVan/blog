<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\TheLoai;
Route::get('/', function () {
    return view('welcome');
});
Route::get('abc', function () {
     return view('admin.login');
});
Route::get('thu', function(){
	$theloai = TheLoai::find(2);
	foreach ($theloai->loaitin as $loaitin) {
		echo $loaitin->Ten.'<br>';
	}
});
Route::get('admin/dangnhap', 'UserController@getdangnhapAdmin');
Route::post('admin/dangnhap', 'UserController@postdangnhapAdmin');
Route::get('admin/logout', 'UserController@getlogoutAdmin');
Route::group(['prefix'=>'admin', 'middleware'=>'adminLogin'], function(){
	Route::group(['prefix'=>'theloai'], function(){
		Route::get('them', 'TheLoaiController@getThem');
		Route::post('them', 'TheLoaiController@postThem');
		Route::get('sua/{id}', 'TheLoaiController@getSua');
		Route::post('sua/{id}', 'TheLoaiController@postSua');
		Route::get('danhsach', 'TheLoaiController@getDanhSach');
		Route::get('xoa/{id}', 'TheLoaiController@getXoa');
	});
	Route::group(['prefix'=>'loaitin'], function(){
		Route::get('them', 'LoaiTinController@getThem');
		Route::post('them', 'LoaiTinController@postThem');
		Route::get('sua/{id}', 'LoaiTinController@getSua');
		Route::post('sua/{id}', 'LoaiTinController@postSua');
		Route::get('danhsach', 'LoaiTinController@getDanhSach');
		Route::get('xoa/{id}', 'LoaiTinController@getXoa');
	});
	Route::group(['prefix'=>'tintuc'], function(){
		Route::get('them', 'TinTucController@getThem');
		Route::post('them', 'TinTucController@postThem');
		Route::get('sua/{id}', 'TinTucController@getSua');
		Route::post('sua/{id}', 'TinTucController@postSua');
		Route::get('danhsach', 'TinTucController@getDanhSach');
		Route::get('xoa/{id}', 'TinTucController@getXoa');
	});
	Route::group(['prefix'=>'slide'], function(){
		Route::get('them', 'SlideController@getThem');
		Route::post('them', 'SlideController@postThem');
		Route::get('sua/{id}', 'SlideController@getSua');
		Route::post('sua/{id}', 'SlideController@postSua');
		Route::get('danhsach', 'SlideController@getDanhSach');
		Route::get('xoa/{id}', 'SlideController@getXoa');
	});
	Route::group(['prefix'=>'user'], function(){
		Route::get('them', 'UserController@getThem');
		Route::post('them', 'UserController@postThem');
		Route::get('sua/{id}', 'UserController@getSua');
		Route::post('sua/{id}', 'UserController@postSua');
		Route::get('danhsach', 'UserController@getDanhSach');
		Route::get('xoa/{id}', 'UserController@getXoa');
	});
	Route::group(['prefix'=>'comment'], function(){
		Route::get('xoa/{id}/{idTinTuc}', 'CommentController@getXoa');
	});
	Route::group(['prefix'=>'ajax'], function(){
		Route::get('loaitin/{idTheLoai}', 'AjaxController@getLoaiTin');
	
	});

});
Route::get('trangchu','PageController@trangchu');
Route::get('lienhe','PageController@lienhe');
Route::get('gioithieu','PageController@gioithieu');
Route::get('loaitin/{id}/{TenKhongDau}.html','PageController@loaitin');
Route::get('tintuc/{id}/{TenKhongDau}.html','PageController@tintuc');
Route::get('dangnhap', 'PageController@getdangnhap');
Route::post('dangnhap', 'PageController@postdangnhap');
Route::get('dangxuat', 'PageController@getdangxuat');
Route::post('comment/{id}', 'CommentController@postcomment');
Route::get('nguoidung', 'PageController@getnguoidung');
Route::post('nguoidung', 'PageController@postnguoidung');
Route::get('dangki', 'PageController@getdangki');
Route::post('dangki', 'PageController@postdangki');
Route::get('timkiem', 'PageController@getTimKiem');
