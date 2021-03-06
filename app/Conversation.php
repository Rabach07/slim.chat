<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    const CLOSED = 0;
    const OPEN = 1;
    const UNREAD = 2;

    protected $fillable = ['business_id', 'visitor_id', 'status'];

    protected $casts = [
        'business_id' => 'integer',
        'visitor_id'  => 'integer',
        'status'      => 'integer',
    ];

    protected $appends = ['name', 'subject', 'user_last_active', 'most_recent_message'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the latest conversation, or create one.
     *
     * @param int $business_id
     * @param int $visitor_id
     *
     * @return type
     */
    public static function get(int $business_id, int $visitor_id): ?Conversation
    {
        $conversation = Conversation::whereBusinessId($business_id)
            ->whereVisitorId($visitor_id)
            ->whereStatus(ConversationStatus::OPEN)
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $conversation) {
            $conversation = Conversation::create([
                'business_id' => $business_id,
                'visitor_id'  => $visitor_id,
                'status'      => ConversationStatus::OPEN,
            ]);
        }

        return $conversation;
    }

    public function getNameAttribute()
    {
        return 'Visitor #'.$this->id;
    }

    public function getSubjectAttribute()
    {
        return optional(
            $this->messages()
                ->orderBy('created_at')
                ->first()
        )->message;
    }

    public function getUserLastActiveAttribute()
    {
        return optional($this->most_recent_message)->created_at;
    }

    public function getMostRecentMessageAttribute()
    {
        return $this->messages()
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
