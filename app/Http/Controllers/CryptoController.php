<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class CryptoController extends Controller
{
    public function saveCurrencyData(Request $request)
    {
        $response = Http::get('https://api.coingecko.com/api/v3/coins/markets', [
            'vs_currency' => "brl",
            'ids' => $request->id,
        ]);
        if ($request->id == "bitcoin" || $request->id == "ethereum" || $request->id == "cosmos" || $request->id == "terra-luna-2" || $request->id == "dacxi") {
            $data = collect($response->json());
            $this->insertCurrencyData($data, $request->id);
            return ($response->json());
        } else {
            return ($response->json());
        }
    }

    public function insertCurrencyData($data, $currency)
    {
        $data = $data[0];
        $data = collect($data);
        $data = $data->only(['current_price', 'last_updated']);
        $data = $data->toArray();
        $data['last_updated'] = $this->convertDate($data['last_updated']);
        switch ($currency) {
            case "bitcoin":
                DB::table('bitcoin')->insert($data);
                break;
            case "ethereum":
                DB::table('ethereum')->insert($data);
                break;
            case "cosmos":
                DB::table('cosmos')->insert($data);
                break;
            case "terra-luna-2":
                DB::table('terra-luna-2')->insert($data);
                break;
            case "dacxi":
                DB::table('dacxi')->insert($data);
                break;
            default:
                break;
        }
    }

    public function convertDate($date)
    {
        $date = new DateTime($date);
        $date->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        return $date->format('Y-m-d H:i:s');
    }
    public function getBitcoinDataByDate(Request $request)
    {
        if ($request->id == "bitcoin" || $request->id == "ethereum" || $request->id == "cosmos" || $request->id == "terra-luna-2" || $request->id == "dacxi") {
            $data = DB::table($request->id)->where('last_updated', 'like', $request->date . '%')->get();

            if ($data->isEmpty()) {
                $date = new DateTime($request->date);
                $date = $date->format('d-m-Y');
                $response = Http::get('https://api.coingecko.com/api/v3/coins/' . $request->id . '/history', [
                    'id' => $request->id,
                    'date' => $date,
                    'localization' => "false",
                ]);
                $data = collect($response->json());
                $savedata['current_price'] = $data['market_data']['current_price']['brl'];
                $savedata['last_updated'] = $request->date;

                switch ($request->id) {
                    case "bitcoin":
                        DB::table('bitcoin')->insert($savedata);
                        break;
                    case "ethereum":
                        DB::table('ethereum')->insert($savedata);
                        break;
                    case "cosmos":
                        DB::table('cosmos')->insert($savedata);
                        break;
                    case "terra-luna-2":
                        DB::table('terra-luna-2')->insert($savedata);
                        break;
                    case "dacxi":
                        DB::table('dacxi')->insert($savedata);
                        break;
                    default:
                        break;
                }
                return ($savedata);
            } else {
                return "Valor médio do " . $request->id . " segundo o banco de dados nessa data: " . $data->average('current_price') . " BRL";
            }
        } else {
            $date = new DateTime($request->date);
            $date = $date->format('d-m-Y');
            $response = Http::get('https://api.coingecko.com/api/v3/coins/' . $request->id . '/history', [
                'id' => $request->id,
                'date' => $date,
                'localization' => "false",
            ]);
            return ($response->json());
        }
    }
}
