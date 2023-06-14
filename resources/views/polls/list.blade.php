@extends('layouts.home')

@section('content')
    <div class="container">
        <h2 class="center">
            Polling System
        </h2>

        <div class="row">
            <h5 class="center-align">Final Project on Framework-based Programming</h5> 
            <h6 class="center-align">Roman Makarov & Adela Krylova</h6>
        </div>

        <hr>

        <h4 class="center">
            List of your polls
        </h4>

        <div class="center">
            <a class="waves-effect waves-light btn-floating btn-large cyan pulse" href="{{route('poll.create')}}">
                Add
            </a>
        </div>
    
    <table class="centered highlight responsive-table">
            <thead>
            <tr>
                <th>Question</th>
                <th>Status</th>
                <th>Manage the Poll</th>
            </tr>
            </thead>

            <tbody>
                @foreach($polls as $poll)
                <tr>
                    <td>{{$poll->title}}</td>
                    <td>{{$poll->status}}</td>
                    <td>
                        <a class="waves-effect waves-light btn info darken-2" href="{{route('poll.edit', [$poll])}}">
                        update
                        </a>

                        <a class="waves-effect waves-light btn red darken-2" href="{{route('poll.delete', [$poll])}}">
                        delete
                        </a>

                        <a class="waves-effect waves-light btn green lighten-0" href="{{route('poll.show', [$poll])}}">
                        show
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
