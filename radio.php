<!DOCTYPE html>
<title>VinterVault Player</title>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="./small.png" />
    <link href="./files/popoutbox.css" rel="stylesheet">
    <link href="./files/radio.css?version=1" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>
  </head>
  <body>
    <img id="backgroundimage" src="<?php require( 'archive_files/'.$_GET["item"].'.php');
    echo $imglink ?>">
    <div id="wrapper">
      <div id="Absolute-Center" class="content">
        <img id="center" src="center.png">
          <a href="#settings"> <img id="albumpic" src="<?php require( 'archive_files/'.$_GET["item"].'.php'); echo $imglink ?>"> </a>
          <div id="video-placeholder"></div>
          <!--Popout-->
          <div id="settings" class="modalDialog">
            <!-- Modal content -->
            <div>
              <a href="#close" title="Close" class="close">X</a>
                <!---
                <span id="mute-toggle" class="material-icons">volume_up</span>
                --->
                <div class="settingsPanelTop">
                  <span id="volumetitle">Volume</span>
                  <input id="volume-input" type="range" max="100" min="0">
                </div>
                <div class="settingsPanelBottom">
                  <a id="downloadBuy" href="<?php require( 'archive_files/'.$_GET["item"].'.php'); echo $downlink ?>">Download or buy this song</a>
                  <a id="mirrorDlBuy" href="<?php require( 'archive_files/'.$_GET["item"].'.php'); echo $mirrorlink ?>">mirror</a>
                </div>
              </div>
            </div>
            <p id="titlebg"><?php require( 'archive_files/'.$_GET["item"].'.php'); echo $displayname ?></p>
            <span id="current-time">0:00</span>
            <input type="range" id="progress-bar" value="0">
            <span id="duration">0:00</span>

            <!--- replaced with spacebar function, keeping for later use
            <i id="play" class="material-icons">play_arrow</i>
            <i id="pause" class="material-icons">pause</i>
            --->
          </div>
        </div>
        <script>
        var player,
        time_update_interval = 0;

      function onYouTubeIframeAPIReady() {
        player = new YT.Player('video-placeholder', {
          width: 0,
          height: 0,
          videoId: <?php require( 'archive_files/'.$_GET["item"].'.php');
            echo "'".$vidlink."'" ?>,
          playerVars: {
            loop: 0,
              autoplay: 1,
          },
          events: {
            onReady: initialize,
            onStateChange: statechange
          }
        });
      }

          function statechange(e){
        if (e.data === YT.PlayerState.ENDED) {
            player.playVideo();
        }
    }

      function initialize() {

        // Update the controls on load
        updateTimerDisplay();
        updateProgressBar();

        // Clear any old interval.
        clearInterval(time_update_interval);

        // Start interval to update elapsed time display and
        // the elapsed part of the progress bar every second.
        time_update_interval = setInterval(function() {
          updateTimerDisplay();
          updateProgressBar();
        }, 1000);


        $('#volume-input').val(Math.round(player.getVolume()));
      }


      // This function is called by initialize()
      function updateTimerDisplay() {
        // Update current time text display.
        $('#current-time').text(formatTime(player.getCurrentTime()));
        $('#duration').text(formatTime(player.getDuration()));
      }


      // This function is called by initialize()
      function updateProgressBar() {
        // Update the value of our progress bar accordingly.
        $('#progress-bar').val((player.getCurrentTime() / player.getDuration()) * 100);
      }


      // Progress bar

      $('#progress-bar').on('mouseup touchend', function(e) {

        // Calculate the new time for the video.
        // new time in seconds = total duration in seconds * ( value of range input / 100 )
        var newTime = player.getDuration() * (e.target.value / 100);

        // Skip video to new time.
        player.seekTo(newTime);

      });


      // Playback

      $('#play').on('click', function() {
        player.playVideo();
      });


      $('#pause').on('click', function() {
        player.pauseVideo();
      });

          var plpa = 0;
document.body.onkeyup = function(e){
    if(e.keyCode == 32 && plpa == 0){
        player.playVideo();
        plpa = 1;
    }else{
    if(e.keyCode == 32 && plpa == 1){
        player.pauseVideo();
        plpa = 0;
    }
    }
}

      // Sound volume


      $('#mute-toggle').on('click', function() {
        var mute_toggle = $(this);

        if (player.isMuted()) {
          player.unMute();
          mute_toggle.text('volume_up');
        } else {
          player.mute();
          mute_toggle.text('volume_off');
        }
      });

      $('#volume-input').on('change', function() {
        player.setVolume($(this).val());
      });


      // Other options


      $('#speed').on('change', function() {
        player.setPlaybackRate($(this).val());
      });

      $('#quality').on('change', function() {
        player.setPlaybackQuality($(this).val());
      });


      // Playlist

      $('#next').on('click', function() {
        player.nextVideo()
      });

      $('#prev').on('click', function() {
        player.previousVideo()
      });


      // Load video

      $('.thumbnail').on('click', function() {

        var url = $(this).attr('data-video-id');

        player.cueVideoById(url);

      });


      // Helper Functions

      function formatTime(time) {
        time = Math.round(time);

        var minutes = Math.floor(time / 60),
          seconds = time - minutes * 60;

        seconds = seconds < 10 ? '0' + seconds : seconds;

        return minutes + ":" + seconds;
      }


      $('pre code').each(function(i, block) {
        hljs.highlightBlock(block);
      });

    </script>
</body></html>
