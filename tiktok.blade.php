
@extends('frontend.layouts.social_new')
@section('title', app_name() . ' | TikTok' )
@section('content')

<style>

    #desktop_layout{
        margin-top:5px;
    }

    .alert.alert-danger{
        width:100vw;
    }

    .text-muted{
        text-align:center;
    }

    #campaign_icon{
        font-size:80px;
    }

    .row_1{
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
        margin-top: 25px;
        padding-bottom: 20px;
        width: 100vw;
        justify-content: space-between;
        padding-left: 5px;
        padding-right: 15px;
    }

    .profile-description{
        box-shadow:none;
        margin-left:15px;
        margin-right:15px;
    }

    .form-control{
        border:none;
        box-shadow:none;
        border-radius:0px;
        height: 40px;
    }

    .privacy_details{
        margin: 15px;
        background-color: white;
        padding: 15px;
        border-radius: 15px;
    }

    #profile_image_new{
        height: 50px;
        width: 50px;
        border-radius: 100%;
        margin-right:10px;
    }

    .prof_card_in_details{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        margin: 15px;
        padding: 15px;
        border-radius:15px;
        background-color:white;
    }

    body.modal-open{
        margin-top:0px;
    }

    .list_lang{
        border-bottom: 1px solid #F7F5F8;
        background-color: white;
        height: 50px;
        padding-left: 15px;
        padding-right: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .custom_card{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color:white;
        border-radius:15px;
        padding:15px;
    }

    .anun_card{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        background-color: white;
        border-radius: 15px;
        padding: 15px;
        flex-wrap: wrap;
        height: 250px;
        align-content: space-between;
    }

    .avatar_name_menu{
        display: flex;
        flex-direction: row;
        align-items: center;
        flex-wrap: nowrap;
        width: 100%;
        justify-content: space-between;
    }

    .avatar_name{
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    .avatar_ann{
        max-height:50px;
        border-radius:100%;
        margin-right:10px;
    }

    .anun_icon_container{
        display: flex;
        width: 100%;
        justify-content: flex-start;
        flex-wrap: nowrap;
        flex-direction: row;
        align-items: center;
        overflow-x: scroll;
        padding-left:5px;
        padding-right:5px;
    }

    .anun_social_icon{
        height:30px;
        width:30px;
        filter:brightness(1.1);
        margin-right: 10px;
        border-radius:100%;
    }

    #body_announce_modal{
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #profile_verified_new{
        max-height:60px;
        border-radius:100%;
        filter:brightness(1.3);
    }

    @media screen and (min-width: 1024px){

        .row_1{
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: center;
            margin-top: 25px;
            padding-bottom: 20px;
            width: 100vw;
            justify-content: space-between;
            padding-left: 5px;
            padding-right: 250px;
        }

        .card_layout{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            //width:100vw;
            padding:15px;
        }

        .whole_page{
            padding-left: 130px;
            padding-right: 130px;
            margin-left:0px;
            width:100vw;
            height:100vh;
            background-color: #F7F5F8;
        }

    }

    @media screen and (max-width: 1024px){

        .row_1{
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: center;
            margin-top: 25px;
            padding-bottom: 20px;
            width: 100vw;
            justify-content: space-between;
            padding-left: 15px;
            padding-right: 15px;
        }

        .card_layout{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width:100vw;
            padding:15px;
        }

        .whole_page{
            width:100vw;
            height:100vh;
            background-color: #F7F5F8;
            margin-left:0px;
        }

        .custom_card{
            width: 90vw;
        }

    }

    #instagram_icon{
        width:100px;
        filter:brightness(1.3);
    }

    .btn-secondary{
        background-color:#008aff!important;
        filter:brightness(1.3)!important;
    }

    .in_profile_select{
        display: flex;
        justify-content: space-between;
        width: 80vw;
        align-items: center;
    }

    .kt-switch input:empty{
        position:relative;
    }

    .kt-switch input:checked~span:after{
        background-color:#008aff;
        filter:brightness(1.3);
        font-family: "Material Icons";
        content: "\e5ca";
    }

    #check_circle_tick{
        color:#2dd36f;
    }

    #cancel_button_text{
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 80vw;
    }

    .cancel_modal_layout{
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }

</style>

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

