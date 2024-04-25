@extends('layouts.layout')

@section('content')
@php
    use App\Models\Contest;
    use App\Models\User;
    use App\Models\Place;
    use App\Models\Character;
    use App\Models\CharacterContest;
@endphp

<div class="container" style="background-color: white; padding: 20px;">
    <h1>Contest Page</h1>
    <br>
    
    @if(session()->has('match0'))
        @php
            $match0 = session('match0');
            $contest0 = $match0->contest;
            $place0 = $contest0->place;
            $hero0 = $match0->hero;
            $enemy0 = $match0->enemy;
        
        @endphp

        <div class="row">
            <div class="col">
                <h3>Contest Details</h3>
                <p><strong>Place:</strong> {{ $place0->name }}</p>

            </div>
            <div class="col">
                <h3>Hero Details</h3>
                <ul>
                    @foreach (['name', 'defence', 'strength', 'accuracy', 'magic'] as $attribute)
                        <li><strong>{{ ucfirst($attribute) }}:</strong> {{ $hero0->$attribute }}</li>
                    @endforeach
                    <li><strong>hp</strong> {{ $match0->hero_hp }}</li>
                </ul>
            </div>
            <div class="col">
                <h3>Enemy Details</h3>
                <ul>
                    @foreach (['name', 'defence', 'strength', 'accuracy', 'magic'] as $attribute)
                        <li><strong>{{ ucfirst($attribute) }}:</strong> {{ $enemy0->$attribute }}</li>
                    @endforeach
                    <li><strong>hp</strong> {{ $match0->enemy_hp }}</li>

                </ul>
            </div>
        </div>
        <div>
            @if(!isset($match0->contest->win))
                <form action="{{ route('contest.attack') }}" method="POST" onsubmit="setClickcount()">
                    @csrf
                    <input type="hidden" name="matchId" value="{{ $match0->id }}">
                    <input type="hidden" name="clickcount" id="clickcount" value="">

                    <button type="submit" name="attackType" value="Melee" class="btn btn-primary">Melee</button>
                    <button type="submit" name="attackType" value="Ranged" class="btn btn-success">Ranged</button>
                    <button type="submit" name="attackType" value="Magic" class="btn btn-info">Magic</button>
                </form>
            @else
                <div class="alert alert-info">
                    @php
                        $outcome=$match0->contest->win?'win':'lose';
                    @endphp
                    <h1 class="display-4"><strong style="font-weight: bold;">
                        @php
                            $outcome=$match0->contest->win?'win':'lose';
                            $message='You: '.$outcome;
                            echo $message;
                        @endphp
                    </strong></h1>

                </div>
               
            @endif
            <div>
                <p><strong>History:</strong></p>
                @php
                    // Remove the trailing '|' character if it exists
                    $history = rtrim($contest0->history, '|');
                    // Explode the history into individual items
                    $historyItems = explode('|', $history);
                @endphp

                <ul>
                    @foreach($historyItems as $historyItem)
                        <li>{{ $historyItem }}</li>
                    @endforeach
                </ul>
            </div>
        </div>


        <script>
             function setClickcount() {
                var clickCount = localStorage.getItem('clickCount');
                document.getElementById('clickcount').value = clickCount;
            }

            setTimeout(function() {
                var clickCount = localStorage.getItem('clickCount');
                clickCount = parseInt(clickCount);

                var outcome = {!! json_encode($match0->contest->win) !!};


                if (clickCount % 2 !== 0&&typeof contestWin == 'undefined') {
                    sendRequest();
                }

                clickCount++;
                localStorage.setItem('clickCount', clickCount);
            
            }, 700);

         
            
            function sendRequest() {
                // Create the form element
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("contest.attack") }}';
                form.style.display = 'none';

                // Create and append the CSRF token input
                var csrfTokenInput = document.createElement('input');
                csrfTokenInput.type = 'hidden';
                csrfTokenInput.name = '_token';
                csrfTokenInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfTokenInput);

                // Create and append the matchId input
                var matchIdInput = document.createElement('input');
                matchIdInput.type = 'hidden';
                matchIdInput.name = 'matchId';
                matchIdInput.value = '{{ $match0->id }}';
                form.appendChild(matchIdInput);

                // Create and append the attackType input
                var attackTypes = ['Melee', 'Ranged', 'Magic'];
                var randomAttackType = attackTypes[Math.floor(Math.random() * attackTypes.length)];
                var attackTypeInput = document.createElement('input');
                attackTypeInput.type = 'hidden';
                attackTypeInput.name = 'attackType';
                attackTypeInput.value = randomAttackType;
                form.appendChild(attackTypeInput);

                // Create and append the clickCount input
                var clickCountInput = document.createElement('input');
                clickCountInput.type = 'hidden';
                clickCountInput.name = 'clickCount';
                clickCountInput.value = localStorage.getItem('clickCount') || 0; // Retrieve clickCount from localStorage or set to 0 if not found
                form.appendChild(clickCountInput);

                // Append the form to the document body and submit it
                document.body.appendChild(form);
                form.submit();
            }
                    
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Reset click count if 'new' is true
                var isNew = '{{ session('new') }}';
                if (isNew) {
                    localStorage.setItem('clickCount', 0);
                }
        
                var clickCount = localStorage.getItem('clickCount');
                if (!clickCount) {
                    clickCount = 0;
                } else {
                    clickCount = parseInt(clickCount);
                }
        
                document.querySelectorAll('button[name="attackType"]').forEach(button => {
                    button.addEventListener('click', function() {
                        clickCount++;
                        localStorage.setItem('clickCount', clickCount);
                    });
                });
            });
           
            function updateClickCountDisplay(clickCount) {
                document.getElementById('clickCount').textContent = clickCount;
            }
        </script>
        

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var placeImage =@if (Str::startsWith($place0->kep, 'http'))
                                    "{{ $place0->kep }}"
                                 @else
                                    "{{ Storage::url($place0->kep) }}"
                                 @endif;
                document.body.style.backgroundImage = "url('" + placeImage + "')";
                document.body.style.backgroundSize = "cover";
                document.body.style.backgroundRepeat = "no-repeat";
                document.body.style.backgroundPosition = "center";
            });
        </script>
    @else
        <div>
            <p>No request received</p>
        </div>
       
    @endif
</div>



@endsection
