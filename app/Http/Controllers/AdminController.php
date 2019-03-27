<?php

namespace App\Http\Controllers;

use Session;
use Image;
use App\User;
use App\UserDetail;
use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Location;

class AdminController extends Controller
{

    public function dashboard(Request $request){
        // $lava = new Lavacharts;
        // $credits  = $lava->DataTable();
        // $data =  User::select("name as 0","creditPoint as 1")->get()->toArray();
        // $credits->addStringColumn("Name")
        //         ->addNumberColumn("CreditPoint")
        //         ->addRows($data);
        // // $lava_tech->BarChart('Credit_Points', $credits_tech);

        // self::barChart_technical($lava);
        // self::barChart_nusiness($lava);
        // , 'lava' => $lava


        $lava = new Lavacharts; // See note below for Laravel

        $population = $lava->DataTable();

        $population->addStringColumn('Months')
                ->addNumberColumn('Number of Users')
                ->addRow(['jan', 623452])
                ->addRow(['Feb', 685034])
                ->addRow(['Mar', 616845])
                ->addRow(['Apr', 757254])
                ->addRow(['May', 778034])
                ->addRow(['Jun', 792353])
                ->addRow(['Jul', 739657])
                ->addRow(['Aug', 842367])
                ->addRow(['Sep', 873490])
                ->addRow(['Oct', 893490])
                ->addRow(['Nov', 953490])
                ->addRow(['Dec', 993490]);

        $lava->AreaChart('Population', $population, [
            'title' => 'Population Growth',
            'legend' => [
                'position' => 'in'
            ]
        ]);

        $users = User::all();
        return view('admin.dashboard.dashboard',['users' => $users, 'lava' => $lava]);
    }

    // private static function barChart_technical($lava_tech){
    //     $credits_tech  = $lava_tech->DataTable();
    //     $data_tech =  User::select("name as 0","creditPoint as 1")->where('role', 1)->get()->toArray();
    //     $credits_tech->addStringColumn("Name")
    //             ->addNumberColumn("CreditPoint")
    //             ->addRows($data_tech);
    //     $lava_tech->BarChart('Credit Points Technical', $credits_tech);
    // }

    // private static function barChart_nusiness($lava_busn){
    //     $credits_busn  = $lava_busn->DataTable();
    //     $data_busn =  User::select("name as 0","creditPoint as 1")->where('role', 2)->get()->toArray();
    //     $credits_busn->addStringColumn("Name")
    //             ->addNumberColumn("CreditPoint")
    //             ->addRows($data_busn);
    //     $lava_busn->BarChart('Credit Points Business', $credits_busn);
    // }

    public function logout(Request $request){
        Session::flush();
        return redirect('/')->with("flash_message_success","User Logged out Successfully");
    }

    public function adminlogin(Request $request){
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        if($request->isMethod('post')){
            $data = $request->input();

            if( Auth::attempt([ 'email'=> $data['email'], 'password'=> $data['password'] ])){
                $users = User::all();

                // $lava = new Lavacharts;
                // $credits  = $lava->DataTable();
                // $data =  User::select("name as 0","creditPoint as 1")->get()->toArray();
                // $credits->addStringColumn("Name")
                //         ->addNumberColumn("CreditPoint")
                //         ->addRows($data);
                // // $lava_tech->BarChart('Credit_Points', $credits_tech);

                // self::barChart_technical($lava);
                // self::barChart_nusiness($lava);

                $lava = new Lavacharts; // See note below for Laravel

                $population = $lava->DataTable();

                $population->addStringColumn('Months')
                        ->addNumberColumn('Number of Users')
                        ->addRow(['jan', 623452])
                        ->addRow(['Feb', 685034])
                        ->addRow(['Mar', 616845])
                        ->addRow(['Apr', 757254])
                        ->addRow(['May', 778034])
                        ->addRow(['Jun', 792353])
                        ->addRow(['Jul', 739657])
                        ->addRow(['Aug', 842367])
                        ->addRow(['Sep', 873490])
                        ->addRow(['Oct', 893490])
                        ->addRow(['Nov', 953490])
                        ->addRow(['Dec', 993490]);

                $lava->AreaChart('Population', $population, [
                    'title' => 'Population Growth',
                    'legend' => [
                        'position' => 'in'
                    ]
                ]);


                return view('admin.dashboard.dashboard',['users' => $users, 'lava'=> $lava]);
            }
            return redirect('/')->with("flash_message_error","invalid Username or password");
        }

        return view('admin.dashboard.admin_login');
    }

    public function settings()
    {
        return view('admin.dashboard.setting');
    }

    public function checkOldPassword(Request $request)
    {
        $data = $request->all();
        $old_password = $data['old_pass'];

        $check_password = Auth::user()->password;
        if(Hash::check($old_password,$check_password)){
            echo "true"; die;
        }
        else{
            echo "false"; die;
        }
    }

    public function updatePassword(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            $old_password = $data['old_pass'];
            $check_password = Auth::user()->password;

            if(Hash::check($old_password,$check_password)){
                $password = bcrypt($data['new_pass']);
                Auth::user()->update(['password'=>$password]);
                return redirect('/settings')->with("flash_message_success","Your Password Updated Successfully");
            }
            else{
                return redirect('/settings')->with("flash_message_error","Incorrect Current Password");
            }
        }
    }

    public function details($id)
    {
        $users = User::find($id);
        $user_id=$users->id;
        $location =Location::where('user_id',$user_id)->get();
        $profile =UserDetail::where('user_id',$user_id)->get();
        return view('admin.users.details',['users'=>$profile,'username'=>$users,'userlocations'=>$location]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index',['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }
    public function saveUser(Request $request)
    {
        $data=$request->input();
        $file_name1 = NULL;
        if($file_data1 = $request->file('avatar')){
            $file_name1 = md5($data['email']).'-Avatar.'. $file_data1->getClientOriginalName();
            Image::make($file_data1)->save(public_path('/storage/'.$file_name1));
        }
        $file_name = NULL;
        if($file_data = $request->file('location_image')){
            $file_name = mt_rand(1000000, 9999999).'-.'. $file_data->getClientOriginalName();
            Image::make($file_data)->save(public_path('/storage/'.$file_name));
        }
        if($file_data1){
              $SaveUser = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'avatar' => $file_name1,
                ]);

                
                $UserDetail = UserDetail::create([
                    'user_id' => $SaveUser->id,
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'gender' => $data['gender'],
                ]);
                $location = Location::create([
                    'user_id' => $SaveUser->id,
                    'location_image' => $file_name,
                    'location_latitude' => $data['location_latitude'],
                    'location_longitude' => $data['location_longitude'],
                    'address' => $data['address'],
                ]);
            if($SaveUser&& $UserDetail && $location )
            {
                return redirect(action("AdminController@index"))->with("flash_message_success","Record Save Successfully");
            }
        }
        else{
            return redirect(action("AdminController@index"))->with("flash_message_error","Don't saved event");
        }
    }
    public function editUser($id)
    {
        $users=User::find($id);
        $userdetail= UserDetail::where('user_id',$id)->first();
        $location= Location::where('user_id',$id)->first();
        return view('admin.users.edit',['users'=>$users,'userdetail'=>$userdetail,'location'=>$location]);
    }
    public function updateUser(Request $request, $id)
    {
        $data=$request->input();
        $file_name1 = NULL;
        if($file_data1 = $request->file('avatar')){
            $file_name1 = md5($data['email']).'-Avatar.'. $file_data1->getClientOriginalName();
            Image::make($file_data1)->save(public_path('/storage/'.$file_name1));
        }
        $file_name = NULL;
        if($file_data = $request->file('location_image')){
            $file_name = mt_rand(1000000, 9999999).'-.'. $file_data->getClientOriginalName();
            Image::make($file_data)->save(public_path('/storage/'.$file_name));
        }
        if($file_data1){
              $SaveUser = User::where('id',$id)->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'avatar' => $file_name1,
                ]);
                $UserDetail = UserDetail::where('user_id',$id)->update([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'gender' => $data['gender'],
                ]);
                $location = Location::where('user_id',$id)->update([
                    'location_image' => $file_name,
                    'location_latitude' => $data['location_latitude'],
                    'location_longitude' => $data['location_longitude'],
                    'address' => $data['address'],
                ]);
            if($SaveUser&& $UserDetail && $location )
            {
                return redirect(action("AdminController@index"))->with("flash_message_success","Record Update Successfully");
            }
        }
        elseif($data){
                $SaveUser = User::where('id',$id)->update([
                  'name' => $data['name'],
                  'email' => $data['email'],
                  'avatar' => $data['avatar'],
                  ]);
                  $UserDetail = UserDetail::where('user_id',$id)->update([
                      'first_name' => $data['first_name'],
                      'last_name' => $data['last_name'],
                      'phone' => $data['phone'],
                      'gender' => $data['gender'],
                  ]);
                  $location = Location::where('user_id',$id)->update([
                      'location_image' => $data['location_image'],
                      'location_latitude' => $data['location_latitude'],
                      'location_longitude' => $data['location_longitude'],
                      'address' => $data['address'],
                  ]);
              if($SaveUser&& $UserDetail && $location )
              {
                  return redirect(action("AdminController@index"))->with("flash_message_success","Record Update Successfully");
              }
            }
        else{
            return redirect(action("AdminController@index"))->with("flash_message_error","Don't update user");
        }
    }
    public function editUserProfile($id)
    {
        $userdetail=UserDetail::find($id);
        return view('admin.users.editprofile',['userdetail'=>$userdetail]);
    }
    public function updateUserProfile(Request $request, $id)
    {
        $data=$request->input();
        if($data){
              $updateUserProfile = UserDetail::where('id',$id)->update([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'gender' => $data['gender'],
                ]);
                $user_id =$data['user_id'];
            if($updateUserProfile && $user_id)
            {
                return redirect(action("AdminController@details",$user_id))->with("flash_message_success","Record Update Successfully");
            }
        }
        else{
            return redirect(action("AdminController@index"))->with("flash_message_error","Don't update user");
        }
    }
    public function editUserLocation($id)
    {
        $location=location::find($id);
        return view('admin.users.editlocation',['location'=>$location]);
    }
    public function updateUserLocation(Request $request, $id)
    {
        $data=$request->input();
        $file_name = NULL;
        if($file_data = $request->file('location_image')){
            $file_name = mt_rand(1000000, 9999999).'-.'. $file_data->getClientOriginalName();
            Image::make($file_data)->save(public_path('/storage/'.$file_name));
        }
        if($file_data){
                $location = Location::where('id',$id)->update([
                    'location_image' => $file_name,
                    'location_latitude' => $data['location_latitude'],
                    'location_longitude' => $data['location_longitude'],
                    'address' => $data['address'],
                ]);
                $user_id =$data['user_id'];
            if($location && $user_id )
            {
                return redirect(action("AdminController@details",$user_id))->with("flash_message_success","Record Update Successfully");
            }
        }
        elseif($data){
                $location = Location::where('id',$id)->update([
                    'location_image' => $data['file_o'],
                    'location_latitude' => $data['location_latitude'],
                    'location_longitude' => $data['location_longitude'],
                    'address' => $data['address'],
                ]);
                $user_id =$data['user_id'];
            if($location && $user_id )
            {
                return redirect(action("AdminController@details",$user_id))->with("flash_message_success","Record Update Successfully");
            }
         }
        else{
            return redirect(action("AdminController@index"))->with("flash_message_error","Don't update user");
        }
    }
    public function deleteUser($id) {
        User::find($id)->delete();
        return redirect()->back()->with("flash_message_success","Record Deleted Successfully");
    }
    public function deleteUserProfile($id) {
        UserDetail::find($id)->delete();
        return redirect()->back()->with("flash_message_success","Record Deleted Successfully");
    }
    public function deleteUserLocation($id) {
        Location::find($id)->delete();
        return redirect()->back()->with("flash_message_success","Record Deleted Successfully");
    }
}
