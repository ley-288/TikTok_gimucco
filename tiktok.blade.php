
@extends('frontend.layouts.social_new')
@section('title', app_name() . ' | TikTok' )
@section('content')



<div>

@if($errors->any())
   <a href="{{$errors->first()}}"></a>
@endif



<?php
session_start(); // Important! Required for STATE Variable check and prevent CSRF attacks

use gimucco\TikTokLoginKit;

// Example passing the Configuration parameters via .ini file
$_TK = TikTokLoginKit\Connector::fromIni(__DIR__.'/env.ini');
if (TikTokLoginKit\Connector::receivingResponse()) {
    try {
		$token = $_TK->verifyCode($_GET[TikTokLoginKit\Connector::CODE_PARAM]);
		$user = $_TK->getUser();
		$videos = $_TK->getUserVideoPages();
	} catch (Exception $e) {
		echo "Error: ".$e->getMessage();
		echo '<br /><a href="?">Retry</a>';
	}
    } else {
	    $tiktok_connect_button = '<a href="'.$_TK->getRedirect().'"><button class="btn btn-secondary" style="color:white!important;">Connect to TikTok</button></a>';
}
?>



    <div class="whole_page">
        </br>
        <div class="row_1">
            <div style="display:flex; font-size:24px; font-weight:bold;">
                <a href="{{ URL::previous() }}">
                    <i id="back_chevron" class="material-icons nav__icon">chevron_left</i>
                </a>
                @lang('TikTok')
            </div>
            <div>
                <a href="#" data-toggle="modal" data-target="#verticalMenu" style="color:black;">
                    <i style="font-size:24px;" class="material-icons">more_vert</i>
                </a>
            </div>
        </div>
        <div>
            <div id="new_modal_buttons">


                    <div class="card_layout">
                        <div class="custom_card">
                    @if($entry)
                            <div><h5><strong>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong></h5></div></br>


                            <div><img class="material-icons-round" id="instagram_icon" src="{{url('/')}}/assets/media/icons/socialbuttons/tiktok2.png?v=2"></div></br>
                            <div>
                                <h4 style="text-align:center;">@lang('You are connected to TikTok')</h4>
                            </div>
                            </br>
                            </br>
                            <div class="in_profile_select">
                                <div><h6>@<strong>{{Auth::user()->name}}</strong></h6></div>
                                <div><i class="material-icons-round" id="check_circle_tick">check_circle</i></div>
                            </div>

                            </br>

                           

                    @else
                            <div><img class="material-icons-round" id="instagram_icon" src="{{url('/')}}/assets/media/icons/socialbuttons/tiktok2.png?v=2"></div></br>
                            <div><h4 style="text-align:center;">@lang('Connect to TikTok?')</h4></div>
                            <div class="text-muted">@lang('Your TikTok videos will be visibile to your followers in your profile')</div>
                            </br>
                            </br>

                            
                                <?php  echo $tiktok_connect_button; ?>


                            </br>
                        </div>

                    @endif

                        </br>
                        @if($entry)
                            <div class="custom_card">
                                <div id="cancel_button_text">
                                    <div>Cancel your TikTok Connection? </div>
                                    <a href="#" data-toggle="modal" data-target="#cancelTiktokModal-{{$entry->id}}">
                                        <div><button type="submit" class="btn btn-primary">Disconnect</button></div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
            </div>
        </div>
       </br></br></br></br>
    </div>
</div>



@if($entry)
<!-- Modal -->
<div class="modal fade" id="cancelTiktokModal-{{$entry->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div style="display:flex; justify-content:center;">
        <form method="post" action="{{ url('/tiktok/delete') }}">
            @csrf
            <div class="cancel_modal_layout">
            </br>
                <div><img class="material-icons-round" id="instagram_icon" src="{{url('/')}}/assets/media/icons/socialbuttons/tiktok2.png?v=2"></div></br>
                <h4 style="text-align:center;">Disconnect from Tiktok</h4>
                <h5 class="text-muted">
                    You can always connect again later
                    </br>
                    Are you sure?
                </h5>
                <input type="hidden" name="entry2_username" id="entry2_username" value="{{Auth::user()->id}}">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <div>
            <div style="display: flex;justify-content: space-around;">
                <button type="submit" class="btn btn-primary">Disconnect</button>

            </div>
            </br>
            <div>
                <p style="font-size:8px; text-align:left;" class="text-muted"> After clicking disconnect, it is adivsed that you remove Spidergain from your TikTok Account.</br>
                    To do this visit your TikTok 'Settings and Privacy' > 'Security and login' > 'Manage app permissions' > 'Spidergain' > 'Remove'.</p>
            </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
@endif



@endsection

