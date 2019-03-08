<?php

namespace App\Http\Controllers;

use App\Business;
use App\Conversation;
use App\Events\NewMessage;
use App\Message;
use App\Visitor;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $conversation = Conversation::findOrFail($request->conversation_id);

        $this->authorize('view', $conversation->business);

        return QueryBuilder::for(Message::class)
            ->whereConversationId($conversation->id)
            ->defaultSort('created_at')
            ->paginate($request->limit ?? 25);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! $request->visitor_id) {
            $conversation = Conversation::findOrFail($request->conversation_id);

            $this->authorize('update', $conversation->business);

            $message = Message::create([
                'conversation_id' => $conversation->id,
                'from_user_id'    => auth()->user()->id,
                'message'         => $request->message,
            ]);
        } else {
            // TODO Authorise visitor

            // Get the Business
            $business = Business::byAppId($request->app_id);
            if (! $business) {
                return abort(404, 'Business does not exist.');
            }

            // Get the visitor
            $visitor = Visitor::get($business->id, $request->visitor_id);

            // Get the conversation
            $conversation = Conversation::get($business->id, $visitor->id);

            $message = Message::create([
                'conversation_id' => $conversation->id,
                'message'         => $request->message,
            ]);
        }

        event(new NewMessage($message));

        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
