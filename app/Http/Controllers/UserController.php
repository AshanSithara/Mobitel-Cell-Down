<?php


namespace App\Http\Controllers;



use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if ($user != null) {
            if ($user->usertype==1){
                $query = DB::select("select * from users where status=1");
                return view('add-user')->with("data", $query);
            }else{
                return redirect("home");
            }

        } else {
            return redirect("login");
        }
    }


    public function addUser(Request $request)
    {

        $fullname = $request->input('fullname');
        $email = $request->input('email');
        $mobilenumber = $request->input('mobilenumber');
        $address = $request->input('address');
        $password = $request->input('password');
        $usertype = $request->input('usertype');

        $validatedData = $request->validate([
            'image1' => 'required|image|mimes:png,jpeg,jpg|max:200048',

        ]);
        $name = time() . '_' . $request->file('image1')->getClientOriginalName();

        $image = $request->file('image1');
        $destinationPath = 'image/';
        $image->move($destinationPath, $name);
        $users = array(
            'name' => $fullname,
            'email' => $email,
            'usertype' => $usertype,
            'mobilenumber' => $mobilenumber,
            'file_path' => $name,
            'address' => $address,
            'status' => 1,
            'password' => Hash::make($password),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        );
        $query = DB::table('users')->insert($users);
        if ($query == 1) {
            $array2 = array(
                "code" => 200,
                "message" => "User Created Success",
                "data" => []
            );
        } else {
            $array2 = array(
                "code" => 500,
                "message" => "User Created Failed",
                "data" => []
            );
        }

        return response()->json($array2);
    }

    public function updateUser(Request $request)
    {

        $id = $request->input('id');
        $fullname = $request->input('fullname');
        $email = $request->input('email');
        $mobilenumber = $request->input('mobilenumber');
        $address = $request->input('address');
        $password = $request->input('password');

        if (!empty($request->file('image1'))) {
            $validatedData = $request->validate([
                'image1' => 'required|image|mimes:png,jpeg,jpg|max:200048',

            ]);
            $name = time() . '_' . $request->file('image1')->getClientOriginalName();

            $image = $request->file('image1');
            $destinationPath = 'image/';
            $image->move($destinationPath, $name);
        } else {
            $name = $request->input('image1');
        }

        $users = array(
            'name' => $fullname,
            'mobilenumber' => $mobilenumber,
            'file_path' => $name,
            'address' => $address,
            'password' => Hash::make($password),
            'updated_at' => Carbon::now()
        );
        $query = DB::table('users')->where('id', $id)->update($users);

        if ($query == 1) {
            $array2 = array(
                "code" => 200,
                "message" => "User Updated Success",
                "data" => []
            );
        } else {
            $array2 = array(
                "code" => 500,
                "message" => "User Updated Failed",
                "data" => []
            );
        }

        return response()->json($array2);
    }


    public function displayImage($filename)
    {
        return Storage::download('app/public/files/users/' . $filename);
    }

    public function getSingleUserDetails($id)
    {
        $query = DB::select("select * from users where id='{$id} '");
        return $query;
    }

    public function deleteUser($id)
    {
        $data = DB::DELETE("delete from users where id='{$id}' and status=1 ");

        if ($data == 1) {
            $array2 = array(
                "code" => 200,
                "message" => "User Deleted Success",
                "data" => []
            );
        } else {
            $array2 = array(
                "code" => 500,
                "message" => "User Deleted Failed",
                "data" => []
            );
        }

        return response()->json($array2);
    }

    public function checkemail($email)
    {
        $data = DB::select("select * from users where email='{$email}'  ");

        if (sizeof($data) > 0) {
            $array2 = array(
                "code" => 500,
                "message" => "Your enter Email existed!",
                "data" => []
            );

        } else {
            $array2 = array(
                "code" => 200,
                "message" => "You can you this email ",
                "data" => []
            );
        }

        return response()->json($array2);
    }

    public function viewProfile()
    {
        $user = Auth::user();
        if ($user != null) {
            return view('user-profile');
        } else {
            return redirect("login");
        }
    }

}
