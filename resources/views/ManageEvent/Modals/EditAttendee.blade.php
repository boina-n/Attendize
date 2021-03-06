<div role="dialog"  class="modal fade" style="display: none;">
   {!! Form::model($attendee, array('url' => route('postEditAttendee', array('event_id' => $event->id, 'attendee_id' => $attendee->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">
                    <i class="ico-edit"></i>
                    @lang('manageevent_modals_editattendee.edit') <b>{{$attendee->full_name}} <b></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                   {!! Form::label('ticket_id', __('manageevent_modals_editattendee.ticket'), array('class'=>'control-label required')) !!}
                                   {!! Form::select('ticket_id', $tickets, $attendee->ticket_id, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('gender', __('manageevent_modals_editattendee.gender'), array('class'=>'control-label required')) !!}
                                    {!! Form::select(
                                        'gender',
                                        array('M' => __('manageevent_modals_editattendee.gender_male'), 'W' => __('manageevent_modals_editattendee.gender_female')),
                                        null,
                                        ['required' => 'required', 'class' => "required form-control"]
                                    ) !!}
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    {!! Form::label('first_name', __('manageevent_modals_editattendee.firstname'), array('class'=>'control-label required')) !!}
                                    {!! Form::text('first_name', Input::old('first_name'),
                                            array(
                                            'class'=>'form-control'
                                        ))  !!}
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    {!! Form::label('last_name', __('manageevent_modals_editattendee.lastname'), array('class'=>'control-label required')) !!}
                                    {!! Form::text('last_name', Input::old('last_name'),
                                            array(
                                            'class'=>'form-control'
                                        ))  !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('email', __('manageevent_modals_editattendee.email'), array('class'=>'control-label required')) !!}

                                    {!! Form::text('email', Input::old('email'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('phone', __('manageevent_modals_editattendee.phone'), array('class'=>'control-label required')) !!}

                                    {!! Form::text('phone', Input::old('phone'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('address1', __('manageevent_modals_editattendee.address1'), array('class'=>'control-label required')) !!}

                                    {!! Form::text('address1', Input::old('address1'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('address2', __('manageevent_modals_editattendee.address2'), array('class'=>'control-label')) !!}

                                    {!! Form::text('address2', Input::old('address2'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('postal_code', __('manageevent_modals_editattendee.postcode'), array('class'=>'control-label required')) !!}

                                    {!! Form::text('postal_code', Input::old('postal_code'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('city', __('manageevent_modals_editattendee.city'), array('class'=>'control-label required')) !!}

                                    {!! Form::text('city', Input::old('city'),
                                            array(
                                            'class'=>'form-control'
                                            ))  !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
               {!! Form::hidden('attendee_id', $attendee->id) !!}
               {!! Form::button(__('manageevent_modals_editattendee.cancel'), ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
               {!! Form::submit(__('manageevent_modals_editattendee.edit_submit'), ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
       {!! Form::close() !!}
    </div>
</div>
