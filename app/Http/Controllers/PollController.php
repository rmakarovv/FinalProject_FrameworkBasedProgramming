<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreatePollRequest;
use App\Enums\PollStatus;
use App\Http\Requests\UpdatePollRequest;
use App\Http\Requests\VoteRequest;
use App\Models\Option;
use App\Models\Poll;
use App\Models\Vote;

class PollController extends Controller
{
    public function store(CreatePollRequest $request) {
        $poll = auth()->user()->polls()->create(['title' => $request->safe()['title'], 
                                                 'status' => $request['status']]);
        $poll->options()->createMany($request->options);
        return redirect()->route('poll.index');
    }

    public function index() {
        $polls = auth()->user()->polls()->select('title','status','id')->paginate(10);
        return view('polls.list', compact('polls'));
    }

    public function edit(Poll $poll) {
        if (auth()->user()->isNot($poll->user)) {
            abort( response('You cannot edit this poll', 403) );
        }
        $poll = $poll->load('options');
        return view('polls.update', compact('poll'));
    }

    public function update(UpdatePollRequest $request, Poll $poll) {
        if (auth()->user()->isNot($poll->user)) {
            abort( response('You cannot edit this poll', 403) );
        }

        $poll->update(['title' => $request['title'], 'status' => $request['status']]);
        
        if (sizeof($poll->votes) == 0) {
            $poll->options()->delete();
            $poll->options()->createMany($request->options);
        }

        return redirect()->route('poll.index');
    }

    public function delete(Poll $poll) {
        if ($poll->status != "CLOSED") {
            abort( response('You can only delete polls that are not running! Close the poll first!', 404) );
        }
        
        $poll->votes()->delete();
        $poll->options()->delete();
        $poll->delete();
        return back();
    }

    public function show(Poll $poll) {
        $poll = $poll->load('options');

        $selectedOption = $poll->votes()->where('user_id', auth()->id())->first()?->option_id;

        if ($poll->user->is(auth()->user())) {
            return view('polls.show', compact('poll' ,'selectedOption'));
        }

        if ($poll->status != "OPENED") {
            abort( response('This poll is currently closed!', 404) );
        }

        return view('polls.show', compact('poll', 'selectedOption'));
    }

    public function vote(VoteRequest $request, Poll $poll) {
        if ($poll->status != "OPENED") {
            abort( response('This poll is currently closed!', 404) );
        }

        $selectedOption = $poll->votes()->where('user_id', auth()->id())->first()?->option;

        $poll->votes()->updateOrCreate(['user_id' => auth()->id()], ['option_id' => $request->option_id]);

        $newOption = Option::find($request->option_id);
        $newOption->increment('votes_count');
        if ($selectedOption) {
            $selectedOption->decrement('votes_count');
        }

        $selectedOption = $newOption;
        return back();
    }
}
