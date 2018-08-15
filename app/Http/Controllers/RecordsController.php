<?php

namespace App\Http\Controllers;

use App\Records;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RecordsController extends Controller
{
    private $timestamp;
    private $randomKey;

    /**
     * Set private variable value.
     *
     */
    public function __construct() {
        $this->timestamp = '263423781';
        $this->randomKey = '53672';
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
        $files = DB::table('file')
                            ->join('promo', 'file.promo_id', '=', 'promo.id')
                            ->select('file.id', 'file', 'promo_id', 'promo', 'file.status')
                            ->orderBy('file.id', 'DESC')
                            ->get();
        $promo = DB::table('promo')->orderBy('promo', 'ASC')->get();
        return view('admin.records', compact('files', 'promo', 'timestamp', 'randomKey'));
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
        $data = $request->all();
        if($request->hasFile('records')) {
            $keys = array();
            $records = array();
            $file = $request->file('records');
            $filename = str_replace(' ', '_', $file->getClientOriginalName());


            $excel = Excel::load($file->getRealPath(), function($reader){})->get();
            if(!empty($excel) && $excel->count()) {
                foreach($excel as  $value) {
                    foreach($value as $rows) {
                        $records[] = $rows;
                        foreach($rows as $key => $row) {
                            if(!in_array($key, $keys)) {
                                $keys[] = $key;
                            }
                        }
                    }
                }
            }

            $data['status'] = 0;
            $data['file'] = $filename;
            $data['columns'] = serialize($keys);
            $data['records'] = serialize($records);

            //$destinationPath = 'resources/assets/uploads/file';
            //$file->move($destinationPath, $filename);

            $check = DB::table('file')
                                ->where('file', $filename)
                                ->where('promo_id', $request->promo_id)
                                ->where('records', serialize($records))
                                ->where('columns', serialize($keys))
                                ->count();

            if($check == 0) {
                $status = Records::create($data);
                if($status) {
                    $file_record = self::showData();
                } else {
                    $file_record = array();
                }
            } else {
                $status = false;
                $file_record = self::showData();
            }
        }
        return response()->json(
            array(
                'status' => $status,
                'data' => $file_record
            )
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Records  $records
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Records $records)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Records  $records
     * @return \Illuminate\Http\Response
     */
    public function edit(Records $records)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Records  $records
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Records $records)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Records  $records
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Records $records)
    {
        $id = self::decryptID($request->record_id);
        $records = DB::table('records')
                                ->select('id')
                                ->where('file_id', '=', $id)
                                ->get();
        if(!empty($records)) {
            foreach($records as $row) {
                DB::table('records_meta')->where('records_id', '=', $row->id)->delete();
            }
            DB::table('records')->where('file_id', '=', $id)->delete();
        }

        $status = Records::where('id', '=', $id)->delete();
        $data = self::showData();

        return response()->json(array('status' => $status, 'data' => $data));
    }

    /**
    * Generate tickets per record
    */
    public function generateTickets(Request $request)
    {
        $ticket_start = 1000;
        $ticket_end = 0;
        $id = self::decryptID($request->record_id);
        $file = DB::table('file')
                                ->select('records')
                                ->where('file.id', '=', $id)
                                ->get();
        $records = unserialize($file[0]->records);

        if(!empty($records)) {
            foreach($records as $row) {
                if(!empty($row[$request->name]) && !empty($row[$request->entries])) {
                    $ticket_end = ($row[$request->entries] > 1) ? ($ticket_start + ($row[$request->entries] - 1)) : $ticket_start;
                    $uname = (!empty($request->uname)) ? $row[$request->uname] : '';
                    $data = array(
                        'name' => $row[$request->name],
                        'uname' => $uname,
                        'entries' => $row[$request->entries],
                        'ticket_no_start' => $ticket_start,
                        'ticket_no_end' => $ticket_end,
                        'file_id' => $id,
                    );
                    $ticket_start = $ticket_end + 1;
                    $save = DB::table('records')->insertGetId($data);

                    if(!empty($request->others)) {
                        foreach($request->others as $other) {
                            $others = array(
                                'records_id' => $save,
                                'meta_name' => $other,
                                'meta_value' => $row[$other]
                            );
                            DB::table('records_meta')->insert($others);
                        }
                    }
                }
            }
        }

        if($save > 0) {
            DB::table('file')->where('id', $id)->update(['status' => 1]);
            $status = true;
            $data = self::showData();
        } else {
            $status = false;
            $data = array();
        }

        return response()->json(array(
            'status' => $status,
            'data' => $data
        ));
    }

    /**
    * show all records data
    */
    public function showData()
    {
        $output = '';
        $timestamp = $this->timestamp;
        $randomKey = $this->randomKey;
        $files = DB::table('file')
                            ->join('promo', 'file.promo_id', '=', 'promo.id')
                            ->select('file.id', 'file', 'promo_id', 'promo', 'file.status')
                            ->orderBy('file.id', 'DESC')
                            ->get();
        if(!empty($files)) {
            foreach($files as $file) {
                $status = ($file->status === 0) ? '<span class="label label-danger">No</span>' : '<span class="label label-success">Yes</span>';
                $id = base64_encode($timestamp . $file->id . $randomKey);

                $output .= '<tr>';
                    $output .= '<td></td>';
                    $output .= '<td>'.str_replace('_', ' ', $file->file).'</td>';
                    $output .= '<td>'.$file->promo.'</td>';
                    $output .= '<td class="text-center">'.$status.'</td>';
                    $output .= '<td class="text-center">';
                        if($file->status === 0) {
                            $output .= '<button type="button" class="btn btn-info btn-generate-record" value="'.$id.'">Generate Tickets</button>';
                        } else {
                            $output .= '<button type="button" class="btn btn-info btn-view-record" value="'.$id.'"><i class="fa fa-eye"></i>
                                </button>';
                        }
                        $output .= '<button type="button" class="btn btn-danger btn-del-record" value="'.$id.'"><i class="fa fa-trash"></i></button>';
                    $output .= '</td>';
                $output .= '</tr>';
            }
        }
        return $output;
    }

    /**
    * get records data
    */
    public function getData(Request $request) 
    {
        $id = self::decryptID($request->record_id);
        $records = DB::table('file')
                                ->select('columns')
                                ->where('file.id', '=', $id )
                                ->get();
        if(!empty($records)) {
            $columns = unserialize($records[0]->columns);
            $status = true;
        } else {
            $status = false;
            $records = array();
        }
        return response()->json(array(
            'status' => $status, 
            'data' => $columns, 
            'file' => $id
        ));
    }

    /**
    * view all records data
    */
    public function viewRecordsData(Request $request)
    {   
        $id = self::decryptID($request->record_id);
        $data = self::showRecordsData($id, true);

        return response()->json($data);
    }
    public function showRecordsData($record_id, $ajax)
    {   
        $output = '';
        $timestamp = $this->timestamp;
        $randomKey = $this->randomKey;
        $records = DB::table('records')
                                ->select('records.id', 'name', 'uname', 'entries', 'ticket_no_start', 'ticket_no_end')
                                ->where('records.file_id', '=', $record_id)
                                ->orderBy('name', 'ASC')
                                ->get();

        if(!empty($records)) {
            foreach($records as $row) {
                $rec_id = base64_encode($timestamp . $row->id . $randomKey);
                $output .= '<tr>';
                    $output .= '<td class="text-center">';
                        //$output .= '<input type="checkbox" name="toDelRecFile" value="'.$rec_id.'">';
                    $output .= '</td>';
                    $output .= '<td>'.$row->name.'</td>';
                    $output .= '<td>'.$row->uname.'</td>';
                    $output .= '<td class="text-center">'.$row->entries.'</td>';
                    $output .= '<td class="text-center">'.$row->ticket_no_start.'</td>';
                    $output .= '<td class="text-center">'.$row->ticket_no_end.'</td>';
                    $output .= '<td class="text-center">';
                        $output .= '<button type="button" class="btn btn-info btn-view-record-meta" value="'.$rec_id.'"><i class="fa fa-eye"></i></button>';
                        /*$output .= '<button type="button" class="btn btn-danger btn-del-record-meta" value="'.$rec_id.'"><i class="fa fa-trash"></i></button>';*/
                    $output .= '</td>';
                $output .= '</tr>';
            }
            $status = true;
        } else {
            $status = false;
        }

        if($ajax) {
            return ['status' => $status, 'data' => $output];
        } else {
            return $output;
        }
    }

    /**
    * view all records meta data
    */
    public function viewRecordsMetaData(Request $request)
    {
        $output = '';
        $id = self::decryptID($request->fr_id);
        $metas = DB::table('records_meta')
                                ->select('meta_name', 'meta_value')
                                ->where('records_id', '=', $id)
                                ->get();

        if(!empty($metas)) {
            $output .= '<div class="form-horizontal p-t-20">';
            foreach($metas as $meta) {
                $output .= '<div class="form-group row">';
                    $output .= '<label class="col-sm-4 control-label"><h4>'.$meta->meta_name.':</h4></label>';
                    $output .= '<label class="col-sm-8 control-label"><h4><strong>'.$meta->meta_value.'</strong></h4></label>';
                $output .= '</div>';
            }
            $output .= '</div>';
            $status = true;
        } else {
            $status = false;
        }

        return response()->json(['status' => $status, 'data' => $output]);
    }

    /**
    * delete file record data
    */
    public function delRecordData(Request $request)
    {
        $del = 1;
        $record_id = self::decryptID($request->record_id);
        if($request->multiple == 'true') {
            $ids = array();
            if(!empty($request->fr_id)) {
                foreach($request->fr_id as $frid) {
                    $ids[] = self::decryptID($frid);
                }
            }
            $del = DB::table('records')->whereIn('id', $ids)->delete();
            DB::table('records_meta')->whereIn('records_id', $ids)->delete();
        } else {
            $id = self::decryptID($request->fr_id);
            $del =  DB::table('records')->where('id', '=', $id)->delete();
            DB::table('records_meta')->where('records_id', '=', $id)->delete();
        }

        $check = DB::table('records')
                                ->select(DB::raw('count(*) as total'))
                                ->where('file_id', '=', $record_id)
                                ->get();
        if($check[0]->total == 0) {
            DB::table('file')->where('id', $record_id)->update(['status' => 0]);
        }

        $status = ($del > 0) ? true : false;
        $data = self::showRecordsData($record_id, false);
        $file = self::showData();

        return response()->json(['status' => $status, 'data' => $data, 'file' => $file]);
    }

    /**
    * decrypt id
    */
    public function decryptID($id)
    {
        $timestamp = $this->timestamp;
        $randomKey = $this->randomKey;
        $id = base64_decode($id);
        $decrypt = str_replace($timestamp, '', $id);
        $decrypted = str_replace($randomKey, '', $decrypt);

        return $decrypted;
    }
}
