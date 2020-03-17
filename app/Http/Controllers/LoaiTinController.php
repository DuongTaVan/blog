<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;

class LoaiTinController extends Controller
{
    
    
    public function getDanhSach(){
    	$loaitin = LoaiTin::all();
    	return view('admin.loaitin.danhsach',['loaitin'=>$loaitin]);
    }
    public function getSua($id){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::find($id);
        return view('admin.loaitin.sua', ['loaitin'=>$loaitin,'theloai'=>$theloai]);
    }
     public function postSua(Request $Request, $id){
        $this->validate($Request , ['Ten'=>'required|unique:LoaiTin,Ten|min:3|max:100','TheLoai'=>'required'],
            ['Ten.required'=>'Bạn chưa nhập tên',
             'Ten.unique'=>'Tên loại tin đã tồn tại',
             'Ten.min'=>'Tên phải có ít nhất 3 ký tự',
             'Ten.max'=>'Tên không quá 100 kí tự',
             'TheLoai.required'=>'Bạn chưa chọn thể loại'
            ]);
        $loaitin = LoaiTin::find($id);
        $loaitin->Ten = $Request->Ten;
        $loaitin->TenKhongDau = changeTitle($Request->Ten);
        $loaitin->idTheLoai = $Request->TheLoai;
        $loaitin->save();
        return redirect('admin/loaitin/sua/'.$id)->with('thongbao', 'Sửa thành công!');
    }
    public function getThem(){
        $theloai = TheLoai::all();
    	return view('admin.loaitin.them',['theloai'=>$theloai]);
    }
    public function postThem(Request $Request){
    	//echo $Request->Ten;
    	$this->validate($Request , ['Ten'=>'required|unique:LoaiTin,Ten|min:3|max:100','TheLoai'=>'required'],
    		['Ten.required'=>'Bạn chưa nhập tên',
             'Ten.unique'=>'Tên loại tin đã tồn tại',
    		 'Ten.min'=>'Tên phải có ít nhất 3 ký tự',
    		 'Ten.max'=>'Tên không quá 100 kí tự',
             'TheLoai.required'=>'Bạn chưa chọn thể loại'
    		]);
    	$loaitin = new LoaiTin;
    	$loaitin->Ten = $Request->Ten;
        $loaitin->TenKhongDau = changeTitle($Request->Ten);
        $loaitin->idTheLoai = $Request->TheLoai;
        $loaitin->save();
        return redirect('admin/loaitin/them')->with('thongbao', 'Thêm thành công!');
        //echo changeTitle($Request->Ten);
    }
    public function getXoa($id){
        $loaitin = LoaiTin::find($id);
        $loaitin->delete();
        return redirect('admin/loaitin/danhsach')->with('thongbao', 'Xóa thành công!');
    }

}
