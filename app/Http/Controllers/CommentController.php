<?php

namespace App\Http\Controllers;
use App\Quotation;
use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Comment;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    
    
    public function getDanhSach(){
    	$tintuc = TinTuc::orderBy('id','DESC')->get();
    	return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);
    }
    public function getSua($id){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        $tintuc = TinTuc::find($id);
        return view('admin.tintuc.sua', ['loaitin'=>$loaitin,'theloai'=>$theloai, 'tintuc'=>$tintuc]);
    }
     public function postSua(Request $Request, $id){
        $tintuc = TinTuc::find($id);
        $this->validate($Request , ['LoaiTin'=>'required',
                                    'TieuDe'=>'required|min:3|unique:TinTuc,TieuDe',
                                    'TomTat'=>'required',
                                    'NoiDung'=>'required'
                                    ],
            ['LoaiTin.required'=>'Bạn chưa nhập loại tin',
             'TieuDe.unique'=>'Tiêu đề loại tin đã tồn tại',
             'TieuDe.min'=>'Tiêu đề phải có ít nhất 3 ký tự',
             'TieuDe.required'=>'Bạn chưa nhập tiêu đề',
             'TomTat.required'=>'Bạn chưa nhập tóm tắt',
             'NoiDung.required'=>'Bạn chưa nhập nội dung',
            ]);
        //$tintuc = new TinTuc;
        $tintuc->TieuDe = $Request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($Request->TieuDe);
        $tintuc->idLoaiTin = $Request->LoaiTin;
        $tintuc->TomTat = $Request->TomTat;
        $tintuc->NoiDung = $Request->NoiDung;
        //$tintuc->SoLuotXem = 0;
        if($Request -> hasFile('Hinh') ){
            $file = $Request->file('Hinh');
            $name = $file->getClientoriginalName();
            $Hinh = rand(1, 999)."_".$name;
            
            $file->move('upload/tintuc', $Hinh);
            unlink('upload/tintuc/'.$tintuc->Hinh);
            $tintuc->Hinh = $Hinh;
        }
       
        $tintuc->save();
        return redirect('admin/tintuc/sua/'.$id)->with('thongbao', 'Sửa thành công!');
    }
    public function getThem(){
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
    	return view('admin.tintuc.them',['theloai'=>$theloai,'loaitin'=>$loaitin]);
    }
    public function postThem(Request $Request){
    	//echo $Request->Ten;
    	$this->validate($Request , ['LoaiTin'=>'required',
                                    'TieuDe'=>'required|min:3|unique:TinTuc,TieuDe',
                                    'TomTat'=>'required',
                                    'NoiDung'=>'required'
                                    ],
    		['LoaiTin.required'=>'Bạn chưa nhập loại tin',
             'TieuDe.unique'=>'Tiêu đề loại tin đã tồn tại',
    		 'TieuDe.min'=>'Tiêu đề phải có ít nhất 3 ký tự',
             'TieuDe.required'=>'Bạn chưa nhập tiêu đề',
    		 'TomTat.required'=>'Bạn chưa nhập tóm tắt',
             'NoiDung.required'=>'Bạn chưa nhập nội dung',
    		]);
    	$tintuc = new TinTuc;
    	$tintuc->TieuDe = $Request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($Request->TieuDe);
        $tintuc->idLoaiTin = $Request->LoaiTin;
        $tintuc->TomTat = $Request->TomTat;
        $tintuc->NoiDung = $Request->NoiDung;
        $tintuc->SoLuotXem = 0;
        if($Request -> hasFile('Hinh') ){
            $file = $Request->file('Hinh');
            $name = $file->getClientoriginalName();
            $Hinh = rand(1, 999)."_".$name;
            
            $file->move('upload/tintuc', $Hinh);
            $tintuc->Hinh = $Hinh;
        }
        else
        {
            $tintuc -> Hinh = "";
        }
        $tintuc->save();
        return redirect('admin/tintuc/them')->with('thongbao', 'Thêm thành công!');
        //echo changeTitle($Request->Ten);
    }
    public function getXoa($id, $idTinTuc){
        $comment = Comment::find($id);
        $comment->delete();
        return redirect('admin/tintuc/sua/' .$idTinTuc)->with('thongbao', 'Xóa thành công!');
    }
    public function postcomment($id, Request $Request){
        $idTinTuc = $id;
        $tintuc = TinTuc::find($id);
        $comment = new Comment;
        $comment->idTinTuc = $idTinTuc;
        $comment->idUser = Auth::user()->id;
        $comment->NoiDung = $Request->NoiDung;
        $comment->save();
        return redirect("tintuc/$id/" .$tintuc->TieuDeKhongDau.".html")->with('thongbao', 'Viết bình luận thành công!');
    }

}
