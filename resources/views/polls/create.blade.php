@extends('layouts.home')

@section('content')
<div class="container">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <div class="row">
        <form class="col s12" method="post" action="{{route('poll.store')}}">

        @csrf
        <div class="row">
            <div class="input-field col s4 offset-m3">
                <input required="required" id="title" type="text" class="validate" name="title">
                <label for="title">Question</label>
                @error('title')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="row col s12 offset-m3" x-data="{
            optionsNumber:2
        }">
            <h5>
                Options
                <button x-on:click="optionsNumber++" class="btn-floating green" type="button">
                    <i class="material-icons">add</i>
                </button>
                
                <button 
                    x-on:click="optionsNumber > 2 ? optionsNumber-- : alert('There should not be less than 2 options!')"
                    class="btn-floating red" type="button">
                        <i class="material-icons">remove</i>
                </button>
            </h5>
            <template x-for="i,index in optionsNumber">
                <div class="row">
                    <div class="col s4">
                        <input required="required" name="options[][content]" id="title" type="text" class="validate" :placeholder="'Option ' + i">
                    </div>
                </div>
            </template>

            <label>Poll Type</label>
            <select class="browser-default" name="status">
                <option value="OPENED" selected >Opened</option>
                <option value="CLOSED" >Closed</option>
            </select>

            <button class="btn waves-effect waves-light" type="submit" name="action">Create poll
                <i class="material-icons right">send</i>
            </button>
        </div>
    </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dates = document.querySelectorAll('.datepicker');
        var instances = M.Datepicker.init(dates);
        var tiems = document.querySelectorAll('.timepicker');
        var instances = M.Timepicker.init(tiems);
      });
</script>

@endsection