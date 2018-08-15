<?php

namespace App\Http\Controllers;

use App\layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LayoutController extends Controller
{
    private $timestamp;
    private $randomKey;

    /**
    * Set private variable value.
    */
    public function __construct() {
        $this->timestamp = '897318379';
        $this->randomKey = '56987';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timestamp = $this->timestamp;
        $randomKey = $this->randomKey;
        $promo = DB::table('promo')->orderBy('promo', 'ASC')->get();
        $records = DB::table('records')->get();
        return view('admin.layout', compact('promo', 'timestamp', 'randomKey', 'records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = false;
        $layout = $data = $output = array();
        $promo_id = self::decryptID($request->promo_id);
        $layouts = explode('||', $request->layout);
        if(!empty($layouts)) {
            foreach($layouts as $val) {
                $maincontent = explode('|', $val);
                $content2 = explode('~', $maincontent[1]);
                $layout[] = array(
                    'prize_id' => self::decryptID($maincontent[0]),
                    'page' => $content2[0],
                    'layout' => $content2[1]
                );
            }
        }

        if($request->hasFile('bg-image')) {
            $file = $request->file('bg-image');
            $img = $file->getClientOriginalName();

            $data['bg_image'] = $img;

            $destinationPath = 'resources/assets/uploads/img';
            $file->move($destinationPath, $img);
        }

        $check = DB::table('layout')
                                ->select(DB::raw('COUNT(*) as total'))
                                ->where('promo_id', '=', $promo_id)
                                ->get();

        if(!empty($layout)) {
            foreach($layout as $row) {
                if($check[0]->total == 0) {
                    $data['promo_id'] = $promo_id;
                    $data['prize_id'] = $row['prize_id'];
                    $data['page'] = $row['page'];
                    $data['layout'] = serialize($row['layout']);

                    $status = Layout::create($data);
                } else {
                    $updates = array(
                        'layout' => serialize($row['layout'])
                    );
                    if($request->hasFile('bg-image')) {
                        $file = $request->file('bg-image');
                        $img = $file->getClientOriginalName();
                        $updates['bg_image'] = $img;
                    }
                    $status = Layout::where('page', $row['page'])->update($updates);
                }
            }
            if($status) {
                $output = self::showData($promo_id);
            } else {
                $output = array();
            }
        }


        return response()->json(array('status' => $status, 'data' => $output['output'], 'select' => $output['select']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\layout  $layout
     * @return \Illuminate\Http\Response
     */
    public function show(layout $layout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\layout  $layout
     * @return \Illuminate\Http\Response
     */
    public function edit(layout $layout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\layout  $layout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, layout $layout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\layout  $layout
     * @return \Illuminate\Http\Response
     */
    public function destroy(layout $layout)
    {
        //
    }


    /**
    * encrypt id
    *
    * @param int
    * @return int
    */
    public function encryptID($id)
    {
        return base64_encode($this->timestamp . $id . $this->randomKey);
    }

    
    /**
    * decrypt id
    *
    * @param int
    * @return int
    */
    public function decryptID($id)
    {
        $decrypt = str_replace($this->timestamp, '', base64_decode($id));
        return str_replace($this->randomKey, '', $decrypt);
    }


    /**
    * show all data
    *
    * @param int
    * @return array
    */
    public function showData($promo_id) 
    {
        $x = 0;
        $layout = $output = $tabs = $select = '';
        $check = DB::table('layout')
                                ->select(DB::raw('COUNT(*) as total'))
                                ->where('promo_id', '=', $promo_id)
                                ->get();
        $layouts = DB::table('layout')
                            ->where('promo_id', '=', $promo_id)
                            ->get();
        $prizes = DB::table('prize')
                                ->where('promo_id', '=', $promo_id)
                                ->orderBy('prize_order', 'ASC')
                                ->get();

        if($check[0]->total > 0) {
            if(!empty($layouts)) {
                foreach($layouts as $row) {
                    $active = '';
                    if($row->page == 'start-page') {
                        $active = ' in active';
                    }
                    $tabs .= '<li>';
                        $tabs .= '<a href="#'.$row->page.'" data-toggle="tab">'.self::getPrizeName($row->prize_id).'</a>';
                    $tabs .= '</li>';
                    $layout .= '<div id="'.$row->page.'" class="tab-pane fade'.$active.'" data-id="'.self::encryptID($row->prize_id).'">';
                        $layout .= '<div class="layout-content-holder" style="background-image: url('.asset('resources/assets/uploads/img').'/'.$row->bg_image.'); background-size: cover; background-repeat: no-repeat; background-position: center center">'.unserialize($row->layout).'</div>';
                    $layout .= '</div>';
                }
            }
        } else {
            if(!empty($prizes)) {
                $select = '<option value=""></option>';
                foreach($prizes as $prize) {
                    $x++;
                    $info = '';

                    $select .= '<option value="page-'.$x.'">'.$prize->prize.'</option>';

                    $tabs .= '<li>';
                        $tabs .= '<a href="#page-'.$x.'" data-toggle="tab">'.$prize->prize.'</a>';
                    $tabs .= '</li>';

                    if(!empty($prize->image)) {
                        $info .= '<div class="img-holder removable resizable draggable"><img src="'.asset('resources/assets/uploads/img').'/'.$prize->image.'"><span class="remove-elem"><i class="fa fa-times"></i></span></div>';
                    }

                    if(!empty($prize->description)) {
                        $info .= '<div class="des-holder removable resizable draggable"><p>'.$prize->description.'</p><span class="remove-elem"><i class="fa fa-times"></i></span></div>';
                    }

                    if($prize->quantity > 0) {
                        for($i = 1; $i < $prize->quantity + 1; $i++) {
                            $info .= '<div class="winner-holder resizable draggable">Winner '.$i.'</div>';
                        }
                    }

                    $layout .= '<div id="start-page" class="tab-pane fade in active" data-id="'.self::encryptID(-1).'">';
                        $layout .= '<div class="layout-content-holder"></div>';
                    $layout .= '</div>';
                    $layout .= '<div id="page-'.$x.'" class="tab-pane fade" data-id="'.self::encryptID($prize->id).'">';
                        $layout .= '<div class="layout-content-holder">'.$info.'</div>';
                    $layout .= '</div>';
                    $layout .= '<div id="end-page" class="tab-pane fade" data-id="'.self::encryptID(0).'">';
                        $layout .= '<div class="layout-content-holder"></div>';
                    $layout .= '</div>';
                }
                $select .= '<option value="page-end">End Page</option>';
            }
        }

        if(!empty($prizes)) {
            $select = '<option value=""></option>';
            foreach($prizes as $prize) {
                $x++;
                $select .= '<option value="page-'.$x.'">'.$prize->prize.'</option>';
            }
        }

        $output .= '<ul class="nav nav-tabs">';
            $output .= '<li class="active">';
                $output .= '<a href="#start-page" data-toggle="tab">Start</a>';
            $output .= '</li>';
            $output .= $tabs;
            $output .= '<li>';
                $output .= '<a href="#end-page" data-toggle="tab">End</a>';
            $output .= '</li>';
        $output .= '</ul>';

        $output .= '<div class="tab-content">';
            $output .= $layout;
        $output .= '</div>';

        return array('output' => $output, 'select' => $select);
    }


    /**
    * Get all prize per promo
    */
    public function getPrize(Request $request)
    {
        /*$x = 0;
        $output = '';
        $tabs = '';
        $content = '';*/
        $promo_id = self::decryptID($request->promo_id);
        $output = self::showData($promo_id);
        /*$prizes = DB::table('prize')
                                ->where('promo_id', '=', $promo_id)
                                ->orderBy('prize_order', 'ASC')
                                ->get();
        if(!empty($prizes)) {
            $select = '<option value=""></option>';
            foreach($prizes as $prize) {
                $x++;
                $info = '';

                $select .= '<option value="page-'.$x.'">'.$prize->prize.'</option>';

                $tabs .= '<li>';
                    $tabs .= '<a href="#page-'.$x.'" data-toggle="tab">'.$prize->prize.'</a>';
                $tabs .= '</li>';

                if(!empty($prize->image)) {
                    $info .= '<div class="img-holder removable resizable draggable"><img src="'.asset('resources/assets/uploads/img').'/'.$prize->image.'"><span class="remove-elem"><i class="fa fa-times"></i></span></div>';
                }

                if(!empty($prize->description)) {
                    $info .= '<div class="des-holder removable resizable draggable"><p>'.$prize->description.'</p><span class="remove-elem"><i class="fa fa-times"></i></span></div>';
                }

                if($prize->quantity > 0) {
                    for($i = 1; $i < $prize->quantity + 1; $i++) {
                        $info .= '<div class="winner-holder resizable draggable">Winner '.$i.'</div>';
                    }
                }

                $content .= '<div id="page-'.$x.'" class="tab-pane fade" data-id="'.self::encryptID($prize->id).'">';
                    $content .= '<div class="layout-content-holder">'.$info.'</div>';
                $content .= '</div>';
            }

            $select .= '<option value="page-end">End Page</option>';

            $output .= '<ul class="nav nav-tabs">';
                $output .= '<li class="active">';
                    $output .= '<a href="#start-page" data-toggle="tab">Start</a>';
                $output .= '</li>';
                $output .= $tabs;
                $output .= '<li>';
                    $output .= '<a href="#end-page" data-toggle="tab">End</a>';
                $output .= '</li>';
            $output .= '</ul>';
            $output .= '<div class="tab-content">';
                $output .= '<div id="start-page" class="tab-pane fade in active" data-id="'.self::encryptID(-1).'">';
                    $output .= '<div class="layout-content-holder"></div>';
                $output .= '</div>';
                $output .= $content;
                $output .= '<div id="end-page" class="tab-pane fade" data-id="'.self::encryptID(0).'">';
                    $output .= '<div class="layout-content-holder"></div>';
                $output .= '</div>';
            $output .= '</div>';
            $status = true;
        } else {
            $status = false;
        }*/
        return response()->json([
            'status' => true, 
            'data' => $output['output'], 
            'select' => $output['select']
        ]);
    }

    /**
    * get prize name
    *
    * @param int
    * @return string
    */
    public function getPrizeName($prize_id)
    {
        $name = '';
        $prize = DB::table('prize')
                                ->select('prize')
                                ->where('id', '=', $prize_id)
                                ->get();
        if(!empty($prize)) {
            foreach($prize as $p) {
                $name = $p->prize;
            }
        }
        return $name;
    }

}
