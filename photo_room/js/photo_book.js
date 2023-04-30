window.onload = function() {
    //album page
    var modButton = document.querySelectorAll(".butt");
    for(let i = 0; i < modButton.length; ++i) {
        modButton[i].onclick = function(event) {
            if(this.classList.contains("modbutton")) {
                this.classList.remove("modbutton");
                this.classList.add("confirmbutton");
                this.innerHTML = "確定";
            }
            else {
                this.classList.add("modbutton");
                this.classList.remove("confirmbutton");
                this.innerHTML = "編輯";

            }
        }
    }
    $(".add_photo").on("click", function(){
        let album_name = prompt("請輸入新相簿名字");
        if(album_name != null) {
            $.ajax({
                url: "add_album.php",
                method: "POST",
                data: {album: album_name, mode: "add"},
            }).done(function( msg ) {
                $('body').css('cursor', 'default');
                alert(msg);
                window.location.reload();
            }).fail(function(jqXHR, textStatus) {
                alert( "Ajax Error!" + textStatus);
            });
        }
    });
    $(".Photo").on("click", function(){
        let album_name = $(this).closest(".photo_describe_container").find(".album_name"); 
        if($(".butt").hasClass("modbutton")) {
            window.open("inside_album.php?album="+album_name.html());
        }
        else {
            let confirm_but = confirm("確定刪除" + album_name.html() + "?");
            if(confirm_but) {
                $.ajax({
                url: "add_album.php",
                method: "POST",
                data: {album: album_name.html(), mode: "delete"},
                }).done(function( msg ) {
                    $('body').css('cursor', 'default');
                    alert(msg);
                    window.location.reload();
                }).fail(function(jqXHR, textStatus) {
                    alert( "Ajax Error!" + textStatus);
                });
            }
            
        }
    });
}