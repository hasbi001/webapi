<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Users;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "ada";
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listpengguna(Request $request) {
        $totalpage = intval($request->totalpage);
        $page = intval($request->currentpage);
        $action = intval($request->action);

        if ($action == 'next') {
            $page += 1;
        } elseif ($action == 'nextpage') {
            $page += $totaldata;
        } elseif ($action == 'prev') {
            $page -= 1;
        } elseif ($action == 'prevpage') {
            $page -= $totaldata;
        }
        // $firstpage = $request->firstpage;
        // $lastpage = $request->lastpage;
        // $first = 0;
        // $last = 0;
        // $totaldata = Users::count();
        // if ($firstpage !== "TRUE" && $lastpage !== "TRUE") {
        //     if ($beforepage == $afterpage) {
        //         $page = $afterpage;
        //     } elseif ($beforepage > $afterpage) {
        //         $page = ($after-1)*$totalpage;
        //     } else {
        //         $page = ($before+1)*$totalpage;
        //     }
        // }
        // else {
        //     if ($firstpage == "TRUE") {
        //         $page = 0;
        //     }
        //     else
        //     {
        //         $page = ceil($totaldata/$totalpage)*$totalpage;
        //     }
        // }

        // echo $page;
        // die();
        $data = [];
        $model = DB::select('SELECT * FROM table_user LIMIT '.$page.','.$totalpage);
        $index =0;
        foreach ($model as $key => $value) {
            if ($index <= 5) {
                $data[$index]['no']=$index+1;
                $data[$index]['id']=$value->id;
                $data[$index]['id']=$value->id;
                $data[$index]['name']=$value->name;
                $data[$index]['birthdate']=$value->birthdate;
                
                $tanggalLahir = Carbon::parse($value->birthdate);
                $sekarang = Carbon::now();
                $tahun = $tanggalLahir->diffInYears($sekarang);
                $tanggalLahir->addYears($tahun);

                $bulan = $tanggalLahir->diffInMonths($sekarang);
                $tanggalLahir->addMonths($bulan);

                $hari = $tanggalLahir->diffInDays($sekarang);

                $data[$index]['age']= $tahun.' Tahun, '.$bulan.' Bulan, '.$hari.' hari';
            }

            $index++;
        }
        // if ($firstpage !== "TRUE" && $lastpage !== "TRUE") {
        //     if ($beforepage != 0 && $afterpage != 0) {
        //         unset($data[0]);
        //         unset($data[1]);
        //     }
        // }
        return response()->json(['list'=>$data,'page'=>$page]);
    }   
}
