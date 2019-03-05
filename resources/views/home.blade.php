@extends('master')

@section('content')
    <div class="py-8 bg-grey-lightest">
        <div class="container mx-auto flex items-center">
            <div class="w-1/2 mr-16">
                <h1 class="text-5xl">Chat marketing & support for makers.</h1>
                <p class="text-2xl leading-tight">
                    An intuitive, real-time chat platform designed for independant makers and start-ups.
                </p>
                <form class="mt-8 flex">
                    <div class="xl:w-2/3 mr-3">
                        <input type="email" class="input" placeholder="Email address...">
                    </div>
                    <div>
                        <button class="button blue">
                            Start Free Trial
                        </button>
                    </div>
                </form>
            </div>
            <div class="w-1/2">
                <img src="/images/home/group_chat.svg">
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="container mx-auto text-center">
            <h1 class="text-5xl">Engage Website Visitors</h1>
            <span class="text-2xl">Turn visitors into leads with conversational marketing</span>
        </div>
        <div class="container mx-auto flex items-center">
            <div class="w-1/2">
                <img src="/images/home/assist.svg">
            </div>
            <div class="w-1/2 ml-16">
                <p class="text-2xl leading-tight">
                    People visiting your website don't want to listen to <i>marketing-speak</i> or <i>wait hours</i> for an email reply when they're trying to find out about your product.
                </p>
                <p class="text-2xl leading-tight">
                    Have an honest real-time conversation to sell your product to potential customers.
                </p>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="container mx-auto text-center">
            <h1 class="text-5xl">Gather User Feedback</h1>
            <span class="text-2xl">Actively survey the people who know your product best</span>
        </div>
        <div class="container mx-auto flex items-center">
            <div class="w-1/2 mr-16">
                <p class="text-2xl leading-tight">
                    You probably don't hear too much from your users, which means they're happy right?... Right?
                </p>
                <p class="text-2xl leading-tight">
                    Flick them a message, have a quick chat. They might have insight into something you're missing.
                </p>
            </div>
            <div class="w-1/2">
                <img src="/images/home/users_check.svg">
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="container mx-auto text-center">
            <h1 class="text-5xl">Support Them When They're Lost</h1>
            <span class="text-2xl">Let your users reach-out for support</span>
        </div>
        <div class="container mx-auto flex items-center">
            <div class="w-1/2 text-center">
                <img src="/images/home/lost_users.svg" style="max-height: 500px;">
            </div>
            <div class="w-1/2 ml-16">
                <p class="text-2xl leading-tight">
                    Don't leave your customers aimless in looking for help.
                </p>
                <p class="text-2xl leading-tight">
                    You're at your desk anyway, why not give them a hand?
                </p>
            </div>
        </div>
    </div>
@endsection
