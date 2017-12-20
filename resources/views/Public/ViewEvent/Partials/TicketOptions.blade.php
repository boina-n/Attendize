@foreach ($tickets as $ticket)
    <div class="ticket-options ticket-options-{{$ticket->id}} hide form-group">
        @foreach ($ticket->options_enabled as $option)
            <div class="form-group">
                {!! Form::label("attendee_1_ticket_{$ticket->id}_options_$option->id", $option->title, ['class' => $option->is_required ? 'required' : '']) !!}
                @if($option->ticket_options_type_id == config('attendize.ticket_options_dropdown_single'))
                    {!! Form::select("attendee_1_ticket_{$ticket->id}_options_$option->id", array('' => 'Please select one option') + $option->options->pluck('title', 'id')->toArray(), null, [$option->is_required ? 'required' : '', 'class' =>  "form-control"]) !!}
                @elseif($option->ticket_options_type_id == config('attendize.ticket_options_dropdown_multi'))
                    {!! Form::select("attendee_1_ticket_{$ticket->id}_options_$option->id",$option->options->pluck('title', 'id'), null, [$option->is_required ? 'required' : '' => $option->is_required ? 'required' : '', 'multiple' => 'multiple','class' => "form-control"]) !!}
                @elseif($option->ticket_options_type_id == config('attendize.ticket_options_checkbox_multi'))
                    <br>
                    @foreach($option->options as $detail)
                        <?php
                            $checkbox_id = md5("1".$ticket->id.$option->id.$detail->title);
                        ?>
                        <div class="custom-checkbox">
                            {!! Form::checkbox("attendee_1_ticket_{$ticket->id}_options_$option->id[]",$detail->id, false,['class' => "", 'id' => $checkbox_id]) !!}
                            <label for="{{ $checkbox_id }}">{{$detail->title}}</label>
                        </div>
                    @endforeach
                @elseif($option->ticket_options_type_id == config('attendize.ticket_options_radio_single'))
                    <br>
                    @foreach($option->options as $detail)
                        <?php
                            $radio_id = md5("1".$ticket->id.$option->id.$detail->title);
                        ?>
                    <div class="custom-radio">
                        {!! Form::radio("attendee_1_ticket_{$ticket->id}_options_$option->id",$detail->id, false, ['id' => $radio_id, 'class' => ""]) !!}
                        <label for="{{ $radio_id }}">{{$detail->title}}</label>
                    </div>
                    @endforeach
                @endif
  
            </div>
        @endforeach
    </div>
@endforeach
