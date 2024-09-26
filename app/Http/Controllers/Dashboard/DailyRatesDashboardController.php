<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Rate;

class DailyRatesDashboardController extends Controller
{
    public function handleDailyRates(Request $request)
    {
        switch ($request->method()) {
            case 'GET':
                return $this->getRates();
            case 'POST':
                return $this->updateRate( $request);
        
            default:
                return response()->json(['status' => false, 'message' => 'Invalid request method']);
        }
    }
    protected function getRates()
    {
        $rates = Rate::all();
        $currencies = Currency::all()->keyBy('id');
        $ratesWithfroms = $rates->map(function ($rate) use ($currencies) {
            $fromfrom = $currencies->get($rate->from)->name ?? 'Unknown';
            $tofrom = $currencies->get($rate->to)->name ?? 'Unknown';
            return [
                'id' => $rate->id,
                'status' => $rate->status,
                'plan_id' => $rate->plan_id,
                'from' => $rate->from,
                'to' => $rate->to,
                'selling' => $rate->selling,
                'buying' => $rate->buying,
                'from_from' => $fromfrom,
                'to_from' => $tofrom,
            ];
        });
        $groupedRates = $ratesWithfroms
            ->groupBy('from_from')
            ->map(function ($groupedByCurrency) {
                return $groupedByCurrency->groupBy('plan_id')->map(function ($ratesByPlanId) {
                    return [
                        'from' => $ratesByPlanId->first()['from_from'], 
                        'rates' => $ratesByPlanId->values(),
                    ];
                })->values();
            })
            ->values();
    
        return response()->json([
            'status' => true,
            'rates' => $groupedRates,
        ]);
    }
    protected function updateRate(Request $request)
    {
        $request->validate([
            'rate_id' => 'required|integer',
            'fieldName' => 'sometimes|string|in:selling,anotherFieldName',
            'newValue' => 'sometimes|numeric',
            'status' => 'sometimes|boolean',
        ]);
        $rateId = $request->input('rate_id');
        $rate = Rate::where('plan_id', 3)
                    ->where('id', $rateId)
                    ->first();
        if (!$rate) {
            return response()->json(['message' => 'Rate not found or plan_id is not 3'], 404);
        }
        if ($request->has('status')) {
            $status = $request->input('status');
            $status = $status ? 'active' : 'inactive';
            $rate->status = $status;
        }
        if ($request->has('fieldName') && $request->has('newValue')) {
            $fieldName = $request->input('fieldName');
            $newValue = $request->input('newValue');
            if (!in_array($fieldName, ['selling', 'anotherFieldName'])) {
                return response()->json(['message' => 'Invalid field name'], 400);
            }
            if (!is_numeric($newValue)) {
                return response()->json(['message' => 'New value must be numeric'], 400);
            }
            $rate->{$fieldName} = $newValue;
        } else if (!$request->has('status') && !$request->has('fieldName')) {
            return response()->json(['message' => 'No valid fields to update'], 400);
        }
        $rate->save();
        $to = $rate->to;
        $from = $rate->from;
        if ($request->has('newValue')) {
            Rate::where('plan_id', 1)
                ->where('from', $from)
                ->where('to', $to)
                ->update([
                    'selling' => $newValue * 1.01,
                    'status' => $status
                ]);
            Rate::where('plan_id', 2)
                ->where('from', $from)
                ->where('to', $to)
                ->update([
                    'selling' => $newValue * 1.005,
                    'status' => $status
                ]);
        }
        return response()->json(['status' => true], 200);
    }
}