// In blade use


@if($tik_tok_access)
<div id="notification_social_container">
    <div class="notification_social_card">    
        <div class="notification_social_card_header" style="justify-content: space-between">
            <div style="display:flex; align-items:center;">
            <div>
                <img id="instagram_icon_in_profile" src="{{url('/')}}/assets/media/icons/socialbuttons/tiktok.png?v=2" alt="Immagine profilo">
            </div>
            <div id="menu_fontcolor">
                <strong>TikTok</strong>
            </div>
            </div>
            @if($my_profile)
                <div style="display: flex;align-items: center;">
                    <a href="{{ url('/tiktok-test') }}"><i class="material-icons-round" id="menu_fontcolor">more_horiz</i></a>
                </div>
            @endif
        </div>     
        <div class="instagram_post_row" style="justify-content:flex-start;">

<?php

$tik_token = $tik_tok_access;
$tik_open_tk = $tik_open;
$url = 'https://open-api.tiktok.com/video/list/?open_id='.$tik_open_tk.'&access_token='.$tik_token.'&cursor=%d&max_count=%d';
$json = @file_get_contents($url);
if($json === FALSE) {
    // console log
} else {
$jo = json_decode($json, true);

foreach ($jo["data"]["video_list"] as $area) {
    echo '<img id="instagram_post" src="'.$area["cover_image_url"].'" data-toggle="modal" data-target="#tiktokImageModal-'.$area['id'].'">';

     echo '<div class="modal fade" id="tiktokImageModal-'.$area['id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog">
      
      <div class="modal-content" style="background-color:transparent; box-shadow:none; border:none; margin-top: -40px;">
        <div class="modal-body" style="display: flex;justify-content: center;align-items: center;align-content: center;flex-wrap: nowrap;flex-direction: column; border-top-left-radius: 20px;border-top-right-radius: 20px;">
            <div>
                <div>  
                    <div id="dismiss_modal_x" type="button">
                        <i class="material-icons" data-dismiss="modal" style="z-index:1!important;">cancel</i>
                    </div>
                    
                        <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@tiktok/video/'.$area['id'].'" data-video-id="'.$area['id'].'" style="max-width: 605px;min-width: 325px; border-left:none; padding:0px; transform: scale(0.8);" > <section> <a target="_blank" title="@leytonnightingale" href="https://www.tiktok.com/@tiktok">@tiktok</a> <p></p> <a target="_blank" title="'.$area['video_description'].'" href="https://www.tiktok.com/music/original-sound-'.$area['id'].'">'.$area['video_description'].'</a> </section> </blockquote> <script async src="https://www.tiktok.com/embed.js"></script>
                    
                </div>
                <div id="post-caption-modal">
                    <p class="caption-text"></p>
                </div>
            </div>
           
        </div>
        
      </div>
      
    </div>
  </div>';
}
}

?>

        </div>
    </div>
</div>
@endif
