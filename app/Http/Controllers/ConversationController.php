<?php

namespace App\Http\Controllers;

use App\Business;
use App\Conversation;
use App\Visitor;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->app_id) {
            $business = Business::findByAppId($request->app_id);

            $visitor = Visitor::get($business->id, $request->visitor_uuid);

            return QueryBuilder::for(Conversation::class)
                ->whereBusinessId($business->id)
                ->whereVisitorId($visitor->id)
                ->defaultSort('-updated_at')
                ->paginate($request->limit ?? 25);
        } else {
            $business = Business::findOrFail($request->business_id);

            $this->authorize('view', $business);

            return QueryBuilder::for(Conversation::class)
                ->whereBusinessId($business->id)
                ->defaultSort('-updated_at')
                ->paginate($request->limit ?? 25);
        }
    }

    public function show(Request $request, Conversation $conversation)
    {
        $this->authorize('view', $conversation->business);

        return response()->json([
            'data' => $conversation,
        ]);
    }
}
