<?php

namespace App\Http\Controllers;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Slide;
use Illuminate\Http\Request;


class PageController extends Controller
{
    function __construct(){
    	$theloai = TheLoai::all();
    	$slide = Slide::all();
    
    	view()->share('slide',$slide);
    	view()->share('theloai',$theloai);
        if(Auth::check())
        {
            view()->share('nguoidung',Auth::user());
        }
    }
    function trangchu(){
    	$theloai = TheLoai::all();
    	return view('pages.trangchu');
    }
    function lienhe(){
    	$theloai = TheLoai::all();
    	return view('pages.lienhe');
    }
    function gioithieu(){
        $theloai = TheLoai::all();
        return view('pages.gioithieu');
    }
    function loaitin($id){
    	$loaitin = LoaiTin::find($id);
    	$tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
    	return view('pages.loaitin', ['loaitin'=>$loaitin, 'tintuc'=>$tintuc]);
    }
    function tintuc($id){
        $tintuc = TinTuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();
        $tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc', ['tintuc'=>$tintuc, 'tinnoibat'=>$tinnoibat, 'tinlienquan'=>$tinlienquan]);
    }
    function getdangnhap(){
        return view('pages.dangnhap');
    }
    function postdangnhap(Request $Request){
        $this->validate($Request,[
                                    'email'=>'required',
                                    'password'=>'required|min:3|max:32'
                                ],[
                                    'email.required'=>'Bạn chưa nhập email',
                                    'password.required'=>'Bạn chưa nhập password',
                                    'password.min'=>'Mật khẩu có ít nhất 3 kí tự',
                                    'email.max'=>'Mật khẩu có không quá 32 kí tự'
                                ]);
        if(Auth::attempt(['email'=>$Request->email,'password'=>$Request->password]))
        {
            return redirect('trangchu');
        }
        else{
            return redirect('dangnhap')->with('thongbao', 'Đăng nhập không thành công!');
        }
    }
    function getdangxuat(){
      
        Auth::logout();
        return redirect('trangchu');
    }
   function getnguoidung(){
        $user = Auth::user();
        return view('pages/nguoidung',['nguoidung'=>$user]);
    } 
    function postnguoidung(Request $Request){
      $this->validate($Request , ['name'=>'required|min:3'],
            ['name.required'=>'Bạn chưa nhập tên',
            'name.min'=>'Tên phải có ít nhất 3 kí tự',
            ]);
        $user = Auth::user();
        $user->name = $Request->name;
       
        
        if($Request->changePassword == 'on')
        {
            $this->validate($Request , [
                                    'password'=>'required|min:3|max:32',
                                    'passwordAgain'=>'required|same:password',
                                    ],
            [
             'password.required'=>'Bạn chưa nhâp password',
             'password.min'=>'password phải có ít nhất 3 kí tự',
             'password.max'=>'password phải có nhiều nhất 32 kí tự',
             'passwordAgain.required'=>'Bạn chưa nhập lại password',
             'passwordAgain.same'=>'Password không trùng với password vừa nhập',
            ]);
            $user->password = bcrypt($Request->password);
        }

        $user->save();
        return redirect('nguoidung')->with('thongbao', 'Sửa thành công!');
        
    } 
    function getdangki(){
        return view('pages/dangki');
    }
    function postdangki(Request $Request){
        $this->validate($Request , ['name'=>'required|min:3',
                                    'email'=>'required|email|unique:users,email',
                                    'password'=>'required|min:3|max:32',
                                    'passwordAgain'=>'required|same:password',
                                    ],
            ['name.required'=>'Bạn chưa nhập tên',
            'name.min'=>'Tên phải có ít nhất 3 kí tự',
             'email.required'=>'Bạn chưa nhập email',
             'email.email'=>'Email chưa đúng dạng',
             'email.unique'=>'Email đã tồn tại',
             'password.required'=>'Bạn chưa nhâp password',
             'password.min'=>'password phải có ít nhất 3 kí tự',
             'password.max'=>'password phải có nhiều nhất 32 kí tự',
             'passwordAgain.required'=>'Bạn chưa nhập lại password',
             'passwordAgain.same'=>'Password không trùng với password vừa nhập',
            ]);
        $user = new User;
        $user->name = $Request->name;
        $user->email = $Request->email;
        $user->password = bcrypt($Request->password);
        $user->quyen = 0;
        $user->save();
        return redirect('dangki')->with('thongbao', 'Chúc mừng bạn đã đăng kí thành công!');
    }
    function getTimKiem(Request $request)
    {
        // $tukhoa = $request->tukhoa;
        $tukhoa=$request->get('tukhoa');
        $tintuc = TinTuc::where('TieuDe','like','%'.$tukhoa.'%')->orWhere('TomTat','like','%'.$tukhoa.'%')->orWhere('NoiDung','like','%'.$tukhoa.'%')->take(5)->paginate(5);
        return view('pages/timkiem',['tukhoa'=>$tukhoa,'tintuc'=>$tintuc]);
    }
}
