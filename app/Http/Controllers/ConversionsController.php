<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NumberToWords\NumberToWords;

class ConversionsController extends Controller
{
    public function numberToWords(Request $request)
    {
        $request->validate([
            'number' => 'required|string',
            'language' => 'required|string|min:2|max:2',
            'currency' => 'string|min:3|max:3|nullable'
        ]);

        $number = $request->all()['number'];
        $numberToWords = new NumberToWords();

        if($request->all()['currency'] !== null){
            $currencyTransformer = $numberToWords->getCurrencyTransformer($request->all()['language']);
            $value = $currencyTransformer->toWords($request->all()['number'] * 100,  $request->all()['currency']);
        }else{
            $value = NumberToWords::transformNumber($request->all()['language'], $number);
        }

        return response()->json(array(
            'status' => 'success',
            'data' => array(
                'conversion' => 'number to words',
                'value' => $value,
            ),
            'message' => null,
        ),200);
        
    }
}
