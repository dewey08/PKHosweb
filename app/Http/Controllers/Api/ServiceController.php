<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use Illuminate\Http\JsonResponse;
use App\Models\Supplies;
use App\Models\Assetarticle;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'uesr' => User::count('id'),
            'person' => $this->person(),
            'asset' => $this->asset()
        ]);
        // $data = DB::table('asset_article')->limit(2)->get();
       
        // ->leftJoin('supplies', 'supplies.SUP_FSN_NUM', '=', 'asset_article.SUP_FSN')
        // ->limit(10)
        // ->get();

        // return response()->json($data,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        // return JsonResponse::create($data, 200, array('Content-Type'=>'application/json; charset=utf-8' ));
    }


    private function person(){
        return Person::count('id');
    }

    private function asset(){
        $subtotal = Assetarticle::leftJoin('supplies', function($join) {
            $join->on('supplies.SUP_FSN_NUM', '=', 'asset_article.SUP_FSN');
            })
            ->select(
                'asset_article.ARTICLE_NAME',
                'asset_article.ARTICLE_NAME',
                'supplies.SUP_FSN_NUM',
                'supplies.SUP_NAME', 
        // DB::raw('COUNT(asset_article.SUP_FSN) as total')
        )
        // ->groupBy('supplies.SUP_FSN_NUM')
        ->get();
        // get([
        //         'asset_article.ARTICLE_NAME',
        //         'supplies.SUP_FSN_NUM',
        //         'supplies.SUP_NAME',
        //         DB::raw('COUNT(asset_article.ARTICLE_NUM) as total')
        //     ]);

        return [
            'total' => Assetarticle::count('ARTICLE_ID'),
            'subtotal' => $subtotal
        ];
    }

    public function checkUser(Request $request)
    {
        return response()->json($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
