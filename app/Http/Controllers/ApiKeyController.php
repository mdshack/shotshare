<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiKeyController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['string', 'sometimes', 'nullable'],
        ]);

        $token = $request->user()->createToken($request->get('name') ?? 'Unnamed Key');

        return response()->json([
            'token' => $token->plainTextToken,
        ]);
    }

    public function destroy(Request $request, string $id)
    {
        $request->user()->tokens()->whereId($id)->delete();

        return response(status: Response::HTTP_NO_CONTENT);
    }
}
