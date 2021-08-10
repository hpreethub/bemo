<?php

namespace App\Http\Controllers;

use App\Models\card;
use App\Models\column;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\DbDumper\Databases\MySql;
use Response;

class dashboardController extends Controller
{
    public function index()
    {
        $data['column'] = column::all();
        return view('dashboard.index',compact('data'));
    }

    public function columnSave(Request $request): RedirectResponse
    {
        $request->validate([
                'title' =>'required'
            ]);
        $data = $request->except('_token');

        column::create($data);
        return back()->with('success','Column Added');

    }

    public function cardSave(Request $request): RedirectResponse
    {
        $request->validate([
            'title' =>'required',
            'column_id'=>'required'
        ]);
        $data = $request->except('_token');
        $data['order'] = card::max('order')+1; // todo add column id for max
        card::create($data);
        return back()->with('success','Card Added');
    }

    public function cardSort(Request $request)
    {
        $cards = card::all();
//dd($request->cardsData);
        foreach($cards as $card){
            $id = $card->id;

            // loop through and update all
            foreach($request->cardsData as $newCard){
                if($id == $newCard['id']){
                    card::where('id',$id)
                        ->update([
                            'order'=>$newCard['order'],
                        ]);
                }
            }
        }

}
    public function cardMove(Request $request, $id)
    {
        card::where('id',$id)->update([
            'column_id'=>$request['column']
        ]);


        return response("success", 200);
    }

    public function cardUpdate(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'title'=>'required',
        ]);
        $data = $request->except('_token','_method','id');
        $card = card::where('id',$request->id)
            ->update($data);

        return back()->with('success','Updated successfully');
    }

    /**
     * @throws \Spatie\DbDumper\Exceptions\DumpFailed
     * @throws \Spatie\DbDumper\Exceptions\CannotStartDump
     */
    public function databaseDump()
    {

         MySql::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->dumpToFile('dump.sql');

        $filepath = public_path('dump.sql');
        return Response::download($filepath);

    }
}
