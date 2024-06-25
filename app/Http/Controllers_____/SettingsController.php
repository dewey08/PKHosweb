<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use App\Models\User;

class SettingsController extends Controller
{

    public function index(){
        return view('settings.index');
    }

    public function save(Request $request){
        $this->changeEnv([
            'DB_HOST'   => $request->DB_HOST,
            'DB_DATABASE'   => $request->DB_DATABASE,
            'DB_USERNAME'   => $request->DB_USERNAME,
            'DB_PASSWORD'   => $request->DB_PASSWORD,
            'DB_PORT'   => $request->DB_PORT,
            'APP_API'   => $request->APP_API,
            'APP_DATACENTER'   => $request->APP_DATACENTER
        ]);
        
        // $this->setEnv('demo', '1234');
        return redirect('/settings')->with('status', 'Update Success!');


    }

    private function setEnv($key, $value)
{
	file_put_contents(app()->environmentFilePath(), str_replace(
		$key . '=' . env($value),
		$key . '=' . $value,
		file_get_contents(app()->environmentFilePath())
	));
}

    protected function changeEnv($data = array()){
        if(count($data) > 0){

            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);;

            // Loop through given data
            foreach((array)$data as $key => $value){

                // Loop through .env-data
                foreach($env as $env_key => $env_value){

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if($entry[0] == $key){
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);
            
            return true;
        } else {
            return false;
        }
    }

    public function moveuser(){
        $users  = User::all();
        foreach($users as $user){
            $model = User::findOrFail($user->id);
            $username = explode('@',$user->email);
            
            $model->username = $username[0];
            $model->save();
        }
        return response()->json('success');
    }
}
