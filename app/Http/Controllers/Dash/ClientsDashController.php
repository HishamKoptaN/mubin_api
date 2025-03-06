<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClientResource;
use App\Models\Client;

class ClientsDashController extends Controller
{
    public function handleReq(
        Request $request,
        $id = null,
    ) {
        switch ($request->method()) {
            case 'GET':
                return $this->getClients();
            case 'POST':
                return $this->create(
                    $request,
                );
            default:
                return failureRes();
        }
    }
    public function getClients()
    {
        try {
            $clients = Client::paginate(10);
            return successRes(
                paginateRes(
                    $clients,
                    ClientResource::class,
                    'clients',
                )
            );
        } catch (\Exception $e) {
            return failureRes(
                $e->getMessage(),
            );
        }
    }
    public function create(Request $request,
    )
    {
        try {
            $client = Client::create(
                [
                    'name' => $request->name,
                ],
            );
            return successRes(
                new ClientResource(
                    $client->fresh(),
                ),
            );
        } catch (\Exception $e) {
            return failureRes(
                $e->getMessage(),
            );
        }
    }
    public function destroy($id)
    {
        $order = Client::findOrFail($id);
        $order->delete();
        return  successRes(
            null,
            204,
        );
    }
}
