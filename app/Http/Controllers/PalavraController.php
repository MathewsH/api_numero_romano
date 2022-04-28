<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PalavraController extends Controller
{

    public function search(Request $request)
    {

        $text = $request->all();
        $tostring = implode(array_values($text));
        $arr1 = str_split($tostring);
        $NumRO = ['I','V','X','L','C','D','M'];
        $ValorRo = [1,5,10,50,100,500,1000];

        $Array = [];
        $valor=0;
        $condicao = 0;
        $number1= [];
        $arrayRO = [];
        $arrayValor = [];

        for ($j = 0; $j < count($arr1); $j++){
            if($arr1[$j] == 'I'||'V'||'X'||'L'||'C'||'D'||'M'){
                for ($a = 0; $a< 7; $a++){
                    if($arr1[$j] == $NumRO[$a]){
                        $number1= [$arr1[$j]];
                        array_push($arrayRO, implode($number1));
                        $number1=[];

                        if($ValorRo[$a] > $condicao){
                        $valor += $ValorRo[$a];
                        $valor -=$condicao*2;
                        }

                        else{
                            $valor += $ValorRo[$a];
                            $condicao =0;
                        }

                        $condicao =$ValorRo[$a];
                        continue;
                    }
                } 
            }
            if($arr1[$j] <> 'I'&& $arr1[$j] <> 'V'&& $arr1[$j] <> 'X'&& $arr1[$j] <> 'L'&& $arr1[$j] <>'C'&& $arr1[$j] <>'D'&& $arr1[$j] <>'M'){
              
                array_push($Array, implode($arrayRO));
                array_push($arrayValor, $valor);
                $arrayRO= [];
                $valor =0;
                continue;

            }
            if($j==count($arr1)-1){
                array_push($Array, implode($arrayRO));
                array_push($arrayValor, $valor);
                $arrayRO= [];
                $valor =0;
                continue;
            } 
        }
        $ValorMax=0;
        $LocalArray=0;
        for($x = 0; $x < count($arrayValor); $x++){
            if($ValorMax<$arrayValor[$x]){
                $ValorMax=$arrayValor[$x];
                $LocalArray=$x;       
            }
        }
        return response()->json([
            'text' => $tostring,
            'number' => $Array[$LocalArray] ,
            'values' => $ValorMax
        ]);
    }
}
