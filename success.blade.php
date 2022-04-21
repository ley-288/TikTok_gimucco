

@extends('frontend.layouts.social_new')
@section('title', app_name() . ' | TikTok' )
@section('content')

<style>

    #table_centered_tik{
        width:100vw;
        display:flex;
        justify-content:center;
    }

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
            background-color: white;
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
            background-color: white;
            margin-left:0px;
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

</style>

<div>

@if($errors->any())
   <a href="{{$errors->first()}}"></a>
@endif

<?php

$requrl = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

?>

<?php

session_start();
use gimucco\TikTokLoginKit;
$_TK = TikTokLoginKit\Connector::fromIni(__DIR__.'/env.ini');
if (TikTokLoginKit\Connector::receivingResponse()) { 
    try {
		$token = $_TK->verifyCode($_GET[TikTokLoginKit\Connector::CODE_PARAM]);

		$user = $_TK->getUser();
        
		$videos = $_TK->getUserVideoPages();

        echo <<<HTML
		
HTML;
		$trs = [];
		$videos = array_slice($videos, 0, 3); // Only show the first 3 videos
		
		foreach ($videos as $v) {
			$trs[] = <<<HTML

            <td width="100"><img src="{$v->getCoverImageURL()}"></td>	
		
HTML;
		}
		$trs = implode("\n", $trs);
	} catch (Exception $e) {
		echo "<div style='display:none;'>Error: ".$e->getMessage(). '</div>';
        $new_tiktok_button = '<div><a href="'.$_TK->getRedirect().'"><button class="btn btn-secondary" style="color:white!important">Connect to TikTok</button></a></div>';
	}
    } else {
	    $new_tiktok_button = '<div><a href="'.$_TK->getRedirect().'"><button class="btn btn-secondary" style="color:white!important">Connect to TikTok</button></a></div>';
}


?>



        <div class="whole_page">
            <div class="row_1">
            </div>
            <div>
                <div id="new_modal_buttons">
                </br></br></br></br>
                    <div class="card_layout">
                        <div class="custom_card">
                            <div><img class="material-icons-round" id="instagram_icon" src="{{url('/')}}/assets/media/icons/socialbuttons/tiktok2.png?v=2"></div></br>
                                @if(isset($e) && strpos($e, 'Invalid') !== false)
                                    <div><h4 style="text-align:center; color:#e72b38;">@lang('Oh no')!</h4></div>
                                    <div class="text-muted">@lang('Your TikTok profile could not be connected')</div>
                                    </br>
                                    </br>
                                    <h6>
                                        There was an error, please try again
                                    </h6>
                                    </br>
                                    <?php  echo $new_tiktok_button ?>
                                @else
                                    @if (strpos($requrl,'cancelled') !== false)
                                        <div><h4 style="text-align:center; color:#e72b38;">@lang('Oh no')!</h4></div>
                                        <div class="text-muted">@lang('Your TikTok profile could not be connected')</div>
                                        </br>
                                        </br>
                                        <h6>
                                            Return to the TikTok Menu to try to reconnect
                                        </h6>
                                        </br>
                                        <a href="{{url('/')}}/tiktok-test">
                                            <button type="submit" class="btn btn-primary">Settings</button>
                                        </a>
                                    @else
                                        <div><h4 style="text-align:center; color:#2dd36f;">@lang('Success')!</h4></div>
                                        <div class="text-muted">@lang('Your TikTok profile is now connected and you can show your videos in your profile')</div>
                                        </br>
                                        </br>
                                        <h6>
                                            Return to the TikTok Menu to view your account
                                        </h6>
                                        </br>
                                        <a href="{{url('/')}}/tiktok-test">
                                            <button type="submit" class="btn btn-primary">Settings</button>
                                        </a>
                                    @endif
                                    </br>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                </br></br></br></br>
            </div>
        </div>


@endsection





