<?php

namespace App\Http\Controllers;

use App\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promo = DB::table('promo')->orderBy('id', 'DESC')->get();
        return view('admin.promo', compact('promo'));
                //->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$promo = Promo::latest()->paginate(5);
        return response()->json($promo);*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Promo $promo)
    {
        /*request()->validate([
            'promo' => 'required',
            'raffle_date' => 'required'
        ]);*/

        if($request->method == '_save') {
            $request->request->add(['status' => 0]);
            $status = Promo::create($request->all());
        } else {
            $updates = array(
                'promo' => $request->promo,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'raffle_date' => $request->raffle_date,
                'mechanics' => $request->mechanics,
                'updated_at' => $request->updated_at,
            );
            $status = Promo::where('id', $request->id)->update($updates);
        }
        
        if($status) {
            $promo = self::showData();
        } else {
            $promo = array();
        }

        return response()->json(array(
            'status' => $status,
            'data' => $promo,
        ));
        /*return redirect()->route('promo.index')
                ->with('success', 'Promo created successfully.');*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    /*public function show(Promo $promo)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    /*public function edit(Promo $promo)
    {
        return view('promo.edit', compact('promo'));
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    /*public function update(Request $request, Promo $promo)
    {
        request()->validate([
            'promo' => 'required',
            'raffle_date' => 'required'
        ]);

        //$request->request->add(['status' => 0]);
        $promo->update($request->all());

        return redirect()->route('promo.index')
                ->with('success', 'Promo updated successfully.');
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Promo $promo)
    {
        if($request->multiple == 'true') {
            $status = Promo::whereIn('id', $request->promo_id)->delete();
        } else {
            $status = Promo::where('id', '=', $request->promo_id)->delete();
        }
        
        $data = self::showData();

        return response()->json(array('status' => $status, 'data' => $data));
        /*$promo->delete();
        return redirect()->route('promo.index')
                ->with('success', 'Promo deleted successfully.');*/
    }

    /**
    * Show all promo data
    */
    public function showData()
    {
        $i = 1;
        $output = '';
        $promos = DB::table('promo')->orderBy('id', 'DESC')->get();
        if(!empty($promos)) {
            foreach($promos as $promo) {
                $status = ($promo->status === 0) ? '<span class="label label-danger">Inactive</span>' : '<span class="label label-success">Active</span>';

                $output .= '<tr>';
                    $output .= '<td class="text-center"><input type="checkbox" name="toDelPromo" value="'.$promo->id.'"></td>';
                    $output .= '<td>'.$promo->promo.'</td>';
                    $output .= '<td>';
                        $output .= (empty($promo->start_date)) ? '---' : \Carbon\Carbon::parse($promo->start_date)->format('F d, Y');
                    $output .= '</td>';
                    $output .= '<td>';
                        $output .= (empty($promo->end_date)) ? '---' : \Carbon\Carbon::parse($promo->end_date)->format('F d, Y');
                    $output .= '</td>';
                    $output .= '<td>';
                        $output .= (empty($promo->raffle_date)) ? '---' : \Carbon\Carbon::parse($promo->raffle_date)->format('F d, Y');
                    $output .= '</td>';
                    $output .= '<td>'.$status.'</td>';
                    $output .= '<td class="text-center">';
                        $output .= '<button type="button" class="btn btn-info btn-view-promo" value="'.$promo->id.'"><i class="fa fa-eye"></i></button>';
                        $output .= '<button type="button" class="btn btn-info btn-edit-promo" value="'.$promo->id.'"><i class="fa fa-pencil"></i></button>';
                        $output .= '<button type="button" class="btn btn-danger btn-del-promo" value="'.$promo->id.'"><i class="fa fa-trash"></i></button>';
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
        $id = $request->promo_id;
        $promo = DB::table('promo')->where('id', '=', $id)->get();
        if(!empty($promo)) {
            $status = true;
        } else {
            $status = false;
            $promo = array();
        }
        return response()->json(array('status' => $status, 'data' => $promo));
    }
    
}
