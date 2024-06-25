<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZanySoft\Zip\Zip;
use ZipArchive;
use Storage;
use File;
use Artisan;
use Exception;
use Illuminate\Support\Facades\DB;


class UpdateController extends Controller
{

    public $module = 24;
    public function index(){
        return View('update.index');
    }


    // $module = Infohostname();

    public function download(Request $request){
        

        File::deleteDirectory(public_path('update'));
        File::deleteDirectory(base_path('update'));
        $version = $request->get('version');
        // return $version;
        $fileUrl = env('APP_API').'download/'.$version.'.zip';
        $saveTo = $version.'.zip';

                $ch = curl_init($fileUrl);
                $fp = fopen($saveTo, 'w+');
                curl_setopt($ch, CURLOPT_FILE,$fp);
                // curl_setopt($ch, CURLOPT_TIMEOUT, 100);
                curl_exec($ch);
                if(curl_errno($ch)){
                    throw new Exception(curl_error($ch));
                }
                $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                fclose($fp);
                // return $statusCode;

                if($statusCode == 200){
                    $path = base_path('update') ;
                    if(!File::isDirectory($path)){
                        File::makeDirectory($path, 0777, true, true);
                    }
                    
                    
                    $zip = new ZipArchive;
                    if ($zip->open($version.'.zip') === TRUE) {
                        $zip->extractTo($path);
                        $zip->close();
                        $this->checkModule($this->module);
                        File::delete(base_path($saveTo));
                        return true;
                    } else {
                        return false;
                    }
                    
                    
                } else{
                    return response()->json(["Status Code:" => $statusCode]);
                }
                

            }
            
            private function checkModule($module){
                
                    $dir = base_path('update/source/'.$module);
                    foreach (scandir($dir) as $f) 
                    {
                      if ($f !== '.' and $f !== '..')
                      {
                        //   echo "$f\n";
                          File::moveDirectory(base_path('update/source/'.$module.'/'.$f),base_path('update/source/'.$f));
                      }
                    }
                    
                File::deleteDirectory(base_path('update/source/12'));
                File::deleteDirectory(base_path('update/source/24'));

               


    }

    public function install(Request $request)
    {

            $src = base_path('update/source/');
            $data = [];
            foreach (scandir($src) as $f) 
            {
              if ($f !== '.' and $f !== '..')
              {     
                File::moveDirectory($src.$f,base_path($f),true);
              }
            }

            Artisan::call('migrate');
            $this->changeEnv(['APP_VERSION'   => $request->get('version')]);
            
            return response()->json([
               'status' => true
           ]);  
    }


    public function checkforupdate(){

        $path = Storage::files("public/version/");
    	$files=array();
    	foreach ($path as $key => $value) {
    		$value= str_replace("public/","",$value);
    		array_push($files,$value);
        }
        // return view('update.checkupdate', ['files' => $files]);
        return view('update.check-for-update', ['files' => $files]);

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

}
