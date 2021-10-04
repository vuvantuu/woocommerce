<?php 
namespace App\Http\Controllers\auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('auth.passwords.change');
    }
    public function change(Request $request){
       
        $this->validate($request, [
            'oldpassword' => 'required',
            'password' => 'required|confirmed'
        ]);
        $hashedPassword = Auth::user()->password;
        if(Hash::check($request->oldpassword, $hashedPassword)){
         
            $user = User::find(Auth::id());// find in data record which content id equal id session auth
            $user->password = Hash::make($request->password);/// set password in data equal pass send from form
            $user->save();// update pass
            $user->save();
            Auth::logout();
            return redirect()->route('login')->with('susscessMsg', 'Change password susscessfully');
        } else{
            return redirect()->back()->with('errorMsg', 'Change password fails');
        }
    }
}

