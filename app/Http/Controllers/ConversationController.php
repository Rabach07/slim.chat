<?php

namespace App\Http\Controllers;

use App\Business;
use App\Conversation;
use App\ConversationStatus;
use App\Events\ConversationUpdated;
use App\Visitor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
                ->allowedFilters('status')
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

    public function store(Request $request)
    {
        if ($request->app_id) {
            $business = Business::findByAppId($request->app_id);

            $visitor = Visitor::get($business->id, $request->visitor_uuid);

            return response()->json([
                'data' => Conversation::create([
                    'business_id' => $business->id,
                    'visitor_id'  => $visitor->id,
                ]),
            ]);
        } else {
            $business = Business::findOrFail($request->business_id);

            $this->authorize('view', $business);

            return response()->json([
                'data' => Conversation::create([
                    'business_id' => $business->id,
                    'visitor_id'  => $request->visitor_id,
                ]),
            ]);
        }
    }

    public function update(Request $request, Conversation $conversation)
    {
        $this->authorize('update', $conversation->business);

        $validatedData = $request->validate([
            'status' => [
                'required',
                Rule::in(ConversationStatus::getValues()),
            ],
        ]);

        $conversation->update($validatedData);
        event(new ConversationUpdated($conversation));

        return $conversation;
    }
}
