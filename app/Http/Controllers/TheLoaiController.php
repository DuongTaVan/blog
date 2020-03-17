<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaiController extends Controller
{
    
    
    public function getDanhSach(){
    	$theloai = TheLoai::all();
    	return view('admin.theloai.danhsach',['theloai'=>$theloai]);
    }
    public function getSua($id){
        $theloai = TheLoai::find($id);
        return view('admin.theloai.sua', ['theloai'=>$theloai]);
    }
     public function postSua(Request $Request, $id){
        $theloai = TheLoai::find($id);
        $this->validate($Request, ['Ten'=>'required|unique:TheLoai,Ten|min:3|max:100'],
                                    ['Ten.required'=>'Bạn chưa nhập tên',
                                     'Ten.min'=>'Tên phải có ít nhất 3 ký tự',
                                     'Ten.max'=>'Tên không quá 100 kí tự',
                                     'Ten.unique'=>'Tên thể loại đã tồn tại'
                                    ]);
        $theloai->Ten = $Request->Ten;
        $theloai->TenKhongDau = changeTitle($Request->Ten);
        $theloai->save();
        return redirect('admin/theloai/sua/'.$id)->with('thongbao', 'Sửa thành công!');
    }
    public function getThem(){
    	return view('admin.theloai.them');
    }
    public function postThem(Request $Request){
    	//echo $Request->Ten;
    	$this->validate($Request , ['Ten'=>'required|min:3|max:100'],
    		['Ten.required'=>'Bạn chưa nhập tên',
    		 'Ten.min'=>'Tên phải có ít nhất 3 ký tự',
    		 'Ten.max'=>'Tên không quá 100 kí tự',
            
    		]);
    	$theloai = new TheLoai;
    	$theloai->Ten = $Request->Ten;
        $theloai->TenKhongDau = changeTitle($Request->Ten);
        $theloai->save();
        return redirect('admin/theloai/them')->with('thongbao', 'Thêm thành công!');
        //echo changeTitle($Request->Ten);
    }
    public function getXoa($id){
        $theloai = TheLoai::find($id);
        $theloai->delete();
        return redirect('admin/theloai/danhsach')->with('thongbao', 'Xóa thành công!');
    }

}
