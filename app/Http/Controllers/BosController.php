<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\models\BosBalance;
use App\models\BosCounter;
use App\models\BosHistory;

class BosController extends Controller
{
    function store(Request $request) {
        $processing = $this->processing($request,'STOR');
        return response()->json($processing);
    }
    
    
    function transfer(Request $request) {
        $processing = $this->processing($request,'TRANSFER');
        return response()->json($processing);
    }
    
    
    function tarik(Request $request) {
        $processing = $this->processing($request,'TARIK');
        return response()->json($processing);
    }

    
    public function processing(Request $request,$note) {
        $currDate = date("Ymd");
        $countId = '';
        $currencyId = $request->currency_id;
        $originRek = intval($request->origin_rek);
        $destinationRek = intval($request->destination_rek);
        $amount = $request->ammount;
        
        DB::beginTransaction();

        try {
            $modelCounter = BosCounter::orderByDesc('created_at')->first();
            $modelBalance = BosBalance::where('accountId',$originRek)->where('currencyId',$currencyId)->first();
            
            if ($amount <= 0) {
                DB::rollBack();
                return [
                    'status'=>401,
                    'data'=> [],
                    'message' => 'The number you entered is incorrect'
                ];
            }
            
            if (!empty($modelBalance) && $modelBalance->decAmount < 0 ) {
                DB::rollBack();
                return [
                    'status'=>400,
                    'data'=> [],
                    'message' => 'Your account not enough balance'
                ];
            } elseif (empty($modelBalance)) {
                DB::rollBack();
                return [
                    'status'=>404,
                    'data'=> [],
                    'message' => 'Your account not found'
                ];
            }
            
            $jml = 0;
            if ($note == "STOR") {
                $jml = $modelBalance->decAmount+$amount;  
            }
            else 
            {
                if ($note == "TRANSFER" && !empty($destinationRek)){
                    
                    $modelBalance2 = BosBalance::where('accountId',$destinationRek)->where('currencyId',$currencyId)->first();
                    if (empty($modelBalance2)) {
                        DB::rollBack();
                        return [
                            'status'=>404,
                            'data'=> [],
                            'message' => 'Destionation account not found'
                        ];
                    }
                }

                $jml = $modelBalance->decAmount-$amount; 
            }
            
            // save data counter
            $integerPart = 0;
            $decimalPart = 0;
            
            if (empty($modelCounter)) {
                $integerPart = 0;
                $decimalPart = 0;
            }
            else
            {
                if (!empty($modelCounter)) {
                    $x = explode('-',$modelCounter->counterId); 
                    $y = explode('.',$x[1]);
                    $decimalPart = intval($y[1])+1;
                }
                else
                {
                    $decimalPart++;
                }
                
                if ($decimalPart > 99999) { 
                    $decimalPart = 1;
                    $integerPart++;
                }
            }
            
            $formattedIntegerPart = sprintf('%05d', $integerPart);
            $formattedDecimalPart = sprintf('%05d', $decimalPart);
            $formattedNumber = $currDate.'-'.$formattedIntegerPart.'.'.$formattedDecimalPart;

            $lastnumber = $this->getLastChar($originRek);
            $mCounter = new BosCounter;
            $mCounter->counterId = $formattedNumber;
            $mCounter->lastNumber = $lastnumber;
            $mCounter->save();

            
            $mBalance = BosBalance::where('accountId',$originRek)->where('currencyId',$currencyId)->first();
            if (!empty($mBalance)) {
                DB::unprepared('update bos_balance set decAmount = '.$jml.' where currencyId = "'.$currencyId.'" and accountId = "'.$originRek.'"');
            }

            if ($note == "TRANSFER" && !empty($destinationRek)){
                $mBalance = BosBalance::where('accountId',$destinationRek)->where('currencyId',$currencyId)->first();
                if (!empty($mBalance)) {
                    $jml = $mBalance->decAmount+$amount;
                    DB::unprepared('update bos_balance set decAmount = '.$jml.' where currencyId = "'.$currencyId.'" and accountId = "'.$destinationRek.'"');
                }
            }
            

            $mHistory = new BosHistory;
            $mHistory->transactionId = $formattedNumber;
            $mHistory->accountId = $originRek;
            $mHistory->currencyId = $currencyId;
            $mHistory->dtmTransaction = date("Y-m-d");
            $mHistory->decAmount = $amount;
            $mHistory->note = $note;
            $mHistory->save();

            DB::commit();

            if ($note == "STOR") {
                return [
                    'status'=>200,
                    'data' => [
                        'accountId' => $originRek,
                        'balance' => $jml,
                        'currencyId' => $currencyId
                    ],
                    'message' => 'STORE success'
                ];
            }
            else
            {
                return [
                    'status'=>200,
                    'data' => [
                        'accountId' => $originRek,
                        'balance' => $jml,
                        'currencyId' => $currencyId,
                        'destinationId' => $destinationRek,
                        'amount' => $amount
                    ],
                    'message' => $note.' success'
                ];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                    'status'=>500,
                    'data' => [],
                    'message' => 'There was an error in the transaction, please contact admin. Error Message :'.$e->getMessage()
            ];
        }

        
    }

    public function getLastChar($string) {
        $txt = strlen($string) - 5;
        return substr($string, -$txt);
    }

    public function history() {
        $model = BosHistory::orderByDesc('created_at')->get();
        return response()->json(['status'=>200,'data'=>$model,'message'=>'sukses']);        
    }

}
