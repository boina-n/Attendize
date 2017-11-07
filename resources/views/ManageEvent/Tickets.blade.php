@extends('Shared.Layouts.Master')

@section('title')
    @parent
    @lang('manageevent_tickets.title')
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('page_title')
    <i class="ico-ticket mr5"></i>
    @lang('manageevent_tickets.title')
@stop

@section('head')
    <script>
        $(function () {
            $('.sortable').sortable({
                handle: '.sortHandle',
                forcePlaceholderSize: true,
                placeholderClass: 'col-md-4 col-sm-6 col-xs-12',
            }).bind('sortupdate', function (e, ui) {

                var data = $('.sortable .ticket').map(function () {
                    return $(this).data('ticket-id');
                }).get();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('postUpdateTicketsOrder' ,['event_id' => $event->id]) }}',
                    dataType: 'json',
                    data: {ticket_ids: data},
                    success: function (data) {
                        showMessage(data.message);
                    },
                    error: function (data) {
                        showMessage(__('manageevent_tickets.wrong'));
                    }
                });
            });
        });
    </script>
@stop

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('page_header')
    <div class="col-md-9">
        <!-- Toolbar -->
        <div class="btn-toolbar" role="toolbar">
            <div class="btn-group btn-group-responsive">
                <button data-modal-id='CreateTicket'
                        data-href="{{route('showCreateTicket', array('event_id'=>$event->id))}}"
                        class='loadModal btn btn-success' type="button"><i class="ico-ticket"></i> @lang('manageevent_tickets.create_ticket')
                </button>
            </div>
            @if(false)
                <div class="btn-group btn-group-responsive ">
                    <button data-modal-id='TicketQuestions'
                            data-href="{{route('showTicketQuestions', array('event_id'=>$event->id))}}" type="button"
                            class="loadModal btn btn-success">
                        <i class="ico-question"></i> @lang('manageevent_tickets.questions')
                    </button>
                </div>
                <div class="btn-group btn-group-responsive">
                    <button type="button" class="btn btn-success">
                        <i class="ico-tags"></i> @lang('manageevent_tickets.coupon')
                    </button>
                </div>
            @endif
        </div>
        <!--/ Toolbar -->
    </div>
    <div class="col-md-3">
        {!! Form::open(array('url' => route('showEventTickets', ['event_id'=>$event->id,'sort_by'=>$sort_by]), 'method' => 'get')) !!}
        <div class="input-group">
            <input name='q' value="{{$q or ''}}" placeholder="@lang('manageevent_tickets.search')" type="text" class="form-control">
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="ico-search"></i></button>
        </span>
            {!!Form::hidden('sort_by', $sort_by)!!}
        </div>
        {!! Form::close() !!}
    </div>
@stop

@section('content')
    @if($tickets->count())
        <div class="row">
            <div class="col-md-3 col-xs-6">
                <div class='order_options'>
                    <span class="event_count">@lang('manageevent_tickets.tickets', ['number' => $tickets->count()]) </span>
                </div>
            </div>
            <div class="col-md-2 col-xs-6 col-md-offset-7">
                <div class='order_options'>
                    {!! Form::select('sort_by_select', $allowed_sorts, $sort_by, ['class' => 'form-control pull right']) !!}
                </div>
            </div>
        </div>
    @endif
    <!--Start ticket table-->
    <div class="row sortable">
        @if($tickets->count())

            @foreach($tickets as $ticket)
                <div id="ticket_{{$ticket->id}}" class="col-md-4 col-sm-6 col-xs-12">
                    <div class="panel panel-success ticket" data-ticket-id="{{$ticket->id}}">
                        <div style="cursor: pointer;" data-modal-id='ticket-{{ $ticket->id }}'
                             data-href="{{ route('showTicketDetails', ['event_id' => $event->id, 'ticket_id' => $ticket->id]) }}"
                             class="panel-heading loadLink">
                            <h3 class="panel-title">
                                @if($ticket->is_hidden)
                                    <i title="This ticket is hidden"
                                       class="ico-eye-blocked ticket_icon mr5 ellipsis"></i>
                                @else
                                    <i class="ico-ticket ticket_icon mr5 ellipsis"></i>
                                @endif
                                {{$ticket->title}}
                                <span class="pull-right">
                                    {{ ($ticket->is_free) ? __('manageevent_tickets.free') : money($ticket->price, $event->currency) }}
                                </span>
                            </h3>
                        </div>
                        <div class='panel-body'>
                            <ul class="nav nav-section nav-justified mt5 mb5">
                                <li>
                                    <div class="section">
                                        <h4 class="nm">{{ $ticket->quantity_sold }}</h4>

                                        <p class="nm text-muted">@lang('manageevent_tickets.sold')</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="section">
                                        <h4 class="nm">
                                            {{ ($ticket->quantity_available === null) ? '&infin;' : $ticket->quantity_remaining }}
                                        </h4>

                                        <p class="nm text-muted">@lang('manageevent_tickets.remaining')</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="section">
                                        <h4 class="nm hint--top"
                                            title="{{money($ticket->sales_volume, $event->currency)}} + {{money($ticket->organiser_fees_volume, $event->currency)}} Organiser Booking Fees">
                                            {{money($ticket->sales_volume + $ticket->organiser_fees_volume, $event->currency)}}
                                            <sub title="Doesn't account for refunds.">*</sub>
                                        </h4>
                                        <p class="nm text-muted">@lang('manageevent_tickets.revenue')</p>
                                    </div>
                                </li>
                            </ul>
                            <ul class="nav nav-section nav-justified mt5 mb5">
                                <li>
                                    <div class="section">
                                        <h4 class="nm">{{ $ticket->options->count() }}</h4>

                                        <p class="nm text-muted">@lang('manageevent_tickets.options')</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="panel-footer" style="height: 56px;">
                            <div class="sortHandle" title="Drag to re-order">
                                <i class="ico-paragraph-justify"></i>
                            </div>
                            <ul class="nav nav-section nav-justified">
                                <li>
                                    <a href="javascript:void(0);">
                                        @if($ticket->sale_status === config('attendize.ticket_status_on_sale'))
                                            @if($ticket->is_paused)
                                                @lang('manageevent_tickets.paused') &nbsp;
                                                <span class="pauseTicketSales label label-info"
                                                      data-id="{{$ticket->id}}"
                                                      data-route="{{route('postPauseTicket', ['event_id'=>$event->id])}}">
                                                    <i class="ico-play4"></i> @lang('manageevent_tickets.resume')
                                                </span>
                                            @else
                                                @lang('manageevent_tickets.on_sale') &nbsp;
                                                <span class="pauseTicketSales label label-info"
                                                      data-id="{{$ticket->id}}"
                                                      data-route="{{route('postPauseTicket', ['event_id'=>$event->id])}}">
                                                    <i class="ico-pause"></i> @lang('manageevent_tickets.pause')
                                                </span>
                                            @endif

                                            @if($ticket->quantity_sold == 0)
                                                {!! Form::model($ticket, ['url' => route('postDeleteTicket', ['event_id' => $event->id]), 'class' => 'ajax pull-right']) !!}

                                                {{ csrf_field() }}
                                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                                                <button class="btn btn-danger btn-xs">@lang('manageevent_tickets.delete')</button>
                                                {!! Form::close() !!}
                                            @endif
                                        @else
                                            {{\App\Models\TicketStatus::find($ticket->sale_status)->name}}
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            @if($q)
                @include('Shared.Partials.NoSearchResults')
            @else
                @include('ManageEvent.Partials.TicketsBlankSlate')
            @endif
        @endif
    </div><!--/ end ticket table-->
    <div class="row">
        <div class="col-md-12">
            {!! $tickets->appends(['q' => $q, 'sort_by' => $sort_by])->render() !!}
        </div>
    </div>
@stop
