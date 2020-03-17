<?php

namespace App\Http\Controllers;
use App\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Comment;
use App\Slide;
use App\User;
class UserController extends Controller
{
    
    
    public function getDanhSach(){
    	$user = User::all();
    	return view('admin.user.danhsach',['user'=>$user]);
    }
    public function getSua($id){
        
        $user = User::find($id);
        return view('admin.user.sua', ['user'=>$user]);
    }
     public function postSua(Request $Request, $id){
       $this->validate($Request , ['name'=>'required|min:3'],
    		['name.required'=>'Bạn chưa nhập tên',
    		'name.min'=>'Tên phải có ít nhất 3 kí tự',
    		]);
    	$user = User::find($id);
    	$user->name = $Request->name;
       
        $user->quyen = $Request->quyen;
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
        return redirect('admin/user/sua/'.$id)->with('thongbao', 'Sửa thành công!');
    }
    public function getThem(){
    	return view('admin.user.them');
    }
    public function postThem(Request $Request){
    	//echo $Request->Ten;
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
        $user->quyen = $Request->quyen;
        $user->save();
        return redirect('admin/user/them')->with('thongbao', 'Thêm thành công!');
        //echo changeTitle($Request->Ten);
    }
    public function getXoa($id){
        $user = User::find($id);
        $user->delete();
        return redirect('admin/user/danhsach')->with('thongbao', 'Xóa thành công!');
    }
    public function getdangnhapAdmin(){
    	return view('admin.login');
    }
    public function postdangnhapAdmin(Request $Request){
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
    		return redirect('admin/theloai/danhsach');
    	}
    	else{
    		return redirect('admin/dangnhap')->with('thongbao', 'Đăng nhập không thành công!');
    	}

	}
	public function getlogoutAdmin(){
		Auth::logout();
		return redirect('admin/dangnhap');
	}
}
