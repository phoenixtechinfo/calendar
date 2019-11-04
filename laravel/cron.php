<html>
<body>
<script>

var userAgent = navigator.userAgent || navigator.vendor || window.opera;
      // Windows Phone
        if (/windows phone/i.test(userAgent)) {
            //setTimeout(function () { window.location = "https://itunes.apple.com/appdir"; }, 25);
                window.location = "com.max.sheers://";
        }

        if (/android/i.test(userAgent)) {
           //setTimeout(function () { window.location = "https://play.google.com/store/apps/details?id=com.clubchat&ah=crvB8FAgJ7NzAT29dAd6Yh4AsTg"; }, 25);
                window.location = "com.sheers://";
        }

        // iOS detection from: http://stackoverflow.com/a/9039885/177710
        if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
            //setTimeout(function () { window.location = "https://apps.apple.com/us/app/club-chat-app/id1469504952"; }, 25);
                window.location = "com.max.sheers://";
        }
</script>
</body>
</html>