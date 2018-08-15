<?php

namespace App\Http\Controllers;

use App\Prize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prize = DB::table('prize')
                            ->join('promo', 'prize.promo_id', '=', 'promo.id')
                            ->select('prize.id', 'prize', 'image', 'quantity', 'promo.promo', 'draw_up')
                            ->orderBy('id', 'DESC')
                            ->get();
        $promo = DB::table('promo')->orderBy('promo', 'ASC')->get();
        return view('admin.prize', compact('prize', 'promo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request  $request)
    {
        $data = $request->all();
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $img = $file->getClientOriginalName();

            $data['image'] = $img;

            $destinationPath = 'resources/assets/uploads/img';
            $file->move($destinationPath, $img);
        }

        if($request->method == '_save') {
            $data['draw_up'] = 0;
            $status = Prize::create($data);
        } else {
            $updates = array(
                'prize' => $request->prize,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'promo_id' => $request->promo_id,
                'prize_order' => $request->prize_order,
            );
            if($request->hasFile('image')) {
                $updates['image'] = $img;
            }
            $status = Prize::where('id', $request->id)->update($updates);
        }
        
        if($status) {
            $prize = self::showData();
        } else {
            $prize = array();
        }

        return response()->json(array(
            'status' => $status,
            'data' => $prize,
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prize  $prize
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Prize $prize)
    {
        if($request->multiple == 'true') {
            $status = Prize::whereIn('id', $request->prize_id)->delete();
        } else {
            $status = Prize::where('id', '=', $request->prize_id)->delete();
        }
        
        $data = self::showData();

        return response()->json(array('status' => $status, 'data' => $data));
    }

    /**
    * Show all promo data
    */
    public function showData()
    {
        $i = 1;
        $output = '';
        $prizes = DB::table('prize')
                            ->join('promo', 'prize.promo_id', '=', 'promo.id')
                            ->select('prize.id', 'prize', 'image', 'quantity', 'promo.promo', 'draw_up')
                            ->orderBy('id', 'DESC')
                            ->get();
        if(!empty($prizes)) {
            foreach($prizes as $prize) {
                $draw_up = ($prize->draw_up === 0) ? '<span class="label label-danger">No</span>' : '<span class="label label-success">Yes</span>';

                $output .= '<tr>';
                    $output .= '<td class="text-center"><input type="checkbox" name="toDelPrize" value="'.$prize->id.'"></td>';
                    $output .= '<td>'.$prize->promo.'</td>';
                    $output .= '<td>'.$prize->prize.'</td>';
                    $output .= '<td class="text-center">';
                        if(empty($prize->image)) {
                            $output .= '<img src="'.asset('resources/assets/img/no-image.jpg').'" width="50" height="50">';
                        } else {
                            $output .= '<img src="'.asset('resources/assets/uploads/img').'/'.$prize->image.'" width="50" height="50">';
                        }
                    $output .= '</td>';
                    $output .= '<td class="text-center">'.$prize->quantity.'</td>';
                    $output .= '<td class="text-center">'.$draw_up.'</td>';
                    $output .= '<td class="text-center">';
                        $output .= '<button type="button" class="btn btn-info btn-view-prize" value="'.$prize->id.'"><i class="fa fa-eye"></i></button>';
                        $output .= '<button type="button" class="btn btn-info btn-edit-prize" value="'.$prize->id.'"><i class="fa fa-pencil"></i></button>';
                        $output .= '<button type="button" class="btn btn-danger btn-del-prize" value="'.$prize->id.'"><i class="fa fa-trash"></i></button>';
                    $output .= '</td>';
                $output .= '</tr>';
            }
        }
        return $output;
    }

    /*
    * Get all data
    */
    public function getData(Request $request) 
    {
        $id = $request->prize_id;
        $prize = DB::table('prize')
                            ->join('promo', 'prize.promo_id', '=', 'promo.id')
                            ->select('prize.id', 'prize', 'description', 'image', 'quantity', 'promo.promo', 'prize.promo_id', 'prize_order', 'draw_up')
                            ->where('prize.id', '=', $id)
                            ->get();
        if(!empty($prize)) {
            $status = true;
        } else {
            $status = false;
            $prize = array();
        }
        return response()->json(array('status' => $status, 'data' => $prize));
    }
}
