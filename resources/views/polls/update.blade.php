@extends('layouts.home')

@section('content')
<div class="container">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <div class="row">
        <form class="col s12" method="post" action="{{route('poll.update', [$poll])}}">
        @method('PUT')
        @csrf
        <div class="row">
        </div>

        <div class="row">
            <div class="input-field col s4 offset-m3">
                <input required="required" id="title" type="text" class="validate" name="title" value="{{$poll->title}}">
                <label for="title">Question</label>
                @error('title')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="row col s12 offset-m3" x-data="{
            optionsNumber:{{count($poll->options)}},
            options: {{json_encode($poll->options)}},

            addOption(){
                this.options.push({id:Math.random()});
                this.optionsNumber = this.options.length;
            },

            removeOption() {
                if (this.optionsNumber == 2) {
                    alert('The poll must have at least two options');
                    return ;
                }

                this.options.pop();

                this.optionsNumber = this.options.length;
            }
        }">
            <h5>
                Options
                <button x-on:click="addOption()" class="btn-floating green" type="button">
                    <i class="material-icons">add</i>
                </button>
                
                <button 
                    x-on:click="removeOption()"
                    class="btn-floating red" type="button">
                        <i class="material-icons">remove</i>
                </button>
            </h5>

            <template x-for="option,i in options">
                <div class="row">
                    <div class="col s4">
                        <input required="required" name="options[][content]" id="title" type="text" class="validate" :placeholder="'Option ' + (i + 1)" :value="option.content">
                    </div>
                </div>
            </template>

            <label>Poll Type</label>
            <select class="browser-default" name="status">
                <option value="OPENED" @if ("OPENED" == $poll->status) selected @endif >Opened</option>
                <option value="CLOSED" @if ("CLOSED" == $poll->status) selected @endif >Closed</option>
            </select>
            
            <button class="btn waves-effect waves-light" type="submit">Save
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
