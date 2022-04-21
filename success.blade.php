

@extends('frontend.layouts.social_new')
@section('title', app_name() . ' | TikTok' )
@section('content')


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





