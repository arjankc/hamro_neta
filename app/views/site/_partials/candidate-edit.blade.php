<div id="page-title" style="display:none">{{ $title }}</div>

{{ Form::open(['method'=>'put', 'route'=>['candidates.update', $candidate->id], 'files'=>true, 'class'=>'no-ajax']) }}
    <h1 class="candidate_h1">
        {{ Form::text('name_ne', $candidate->name_ne) }} <br>
        <span class="subtitle">{{ Form::text('name_en', $candidate->name_en) }}</span>
    </h1>

    <div id="profile_box">
        <div id="party_info" class="floatRight">
            <h2>Party Information</h2>
            <?php $party = Party::find($candidate->party); ?>
            <div class="ajax">
                <a href="{{ URL::to('parties/' . $party->id) }}">
                    {{ HTML::image($party->logo, $party->name, ['width'=>120, 'title'=>$party->name]) }}
                </a>
                <a href="{{ URL::to('parties/' . $party->id) }}">
                    {{ HTML::image($party->vote_sign, $party->name, ['width'=>120, 'title'=>$party->name]) }}
                </a>
            </div>
            <span class="photo marg">दल चिन्ह</span>
            <span class="photo">दल चुनाव चिन्ह</span>

        </div>

        <div id="canid_main" class="floatLeft">
            <div id="picture_div" class="floatLeft">
                {{ HTML::image($candidate->photo, $candidate->name_en) }}
                {{ Form::label('image', 'Change Picture: ') }}
                {{ Form::file('image') }}<br><br>
                <div class="clearBoth"></div>
            </div>

            <div id="info_can_div" class="ajax floatLeft">
                <label for="">उमेर :</label><span>{{ Form::text('age', $candidate->age) }}</span>
                <label for="">लिंग :</label>
                <span>
                    {{ Form::select('gender', ['Male'=>'Male', 'Female'=>'Female', 'Third Gender'=>'Third Gender'], $candidate->gender) }}
                </span>
                <label for="">पार्टी :</label><span><a href="{{ URL::to('parties/' . $party->id) }}">{{ Party::name($candidate->party, 'ne') }}</a></span>
                <label for="">सम्पर्क :</label><span>{{ Form::text('contact', $candidate->contact) }}</span>
                <label for="">शिक्षा :</label><span>{{ Form::text('education', $candidate->education) }}</span>
                <label for="" class="vote_this">प्राप्त मत :</label>
                <span class="vote_this">{{ Form::text('vote', $candidate->actual_votes) }}</span>
                <label for="">जन्म जिल्ला :</label><span>{{ Form::text('address', $candidate->address) }}</span>
                <label for="">निर्वाचन क्षेत्र :</label><span>{{ Form::select('district', Party::districts(), $candidate->district) }}-{{ Form::text('area', $candidate->area) }}</span>
                <div class="clearBoth"></div>
            </div>

            <div id="political_history" class="floatLeft">
                <h3>थप विवरण </h3>
                <p>
                    {{ Form::textarea('history', $candidate->history) }}
                </p>
            </div>

            <div class="clearBoth"></div>

        </div>

        <div class="clearBoth"></div>
        {{ Form::submit('Save') }}
        {{ Form::close() }}

        <div class="clearBoth"></div>
    </div>
