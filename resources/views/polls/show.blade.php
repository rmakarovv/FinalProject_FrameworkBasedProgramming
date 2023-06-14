@extends('layouts.home')

@section('content')
    <div class="container">
        
        <h4 class="center">
            {{$poll->title}}
        </h4>

        <form action="{{route('poll.vote',[$poll])}}" method="post" class='center'>
            @csrf

            @foreach($poll->options as $option)
               <p>
                    <label>
                    <input name="option_id" type="radio" value="{{$option->id}}" @if ($selectedOption == $option->id) checked @endif />
                    <span>{{$option->content}}</span>
                    </label>
                </p>
            @endforeach

            <button class="waves-effect waves-light btn info darken-2" type="submit">
                vote
            </button>

            <button class="waves-effect waves-light btn white white-text" >
                <a href="/poll">
                    back
                </a>
            </button>

            <br>
            <h5> Current results: </h5>
            @foreach($poll->options as $option)
                <p>
                    <span> Option "{{$option->content}}" has {{$option->votes_count}} votes</span>
                </p>
            @endforeach
        </form>
    </div>
@endsection
