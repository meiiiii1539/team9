window.onload = function() {
    //album page
    let album_name = $("h2").html();
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
    $("#auto_add_pic").on("change", function(){
        let dataForm = new FormData();
        dataForm.append('img', $(this).prop("files")[0]);
        
        dataForm.append('album', album_name);
        dataForm.append('mode', 'insert');
        $.ajax({
            url: "add_album.php",
            method: "POST",
            data: dataForm,
            processData: false,
            contentType: false,
        }).done(function( msg ) {
            console.log(msg);
            window.location.reload();
        }).fail(function(jqXHR, textStatus) {
            alert( "Ajax Error!" + textStatus);
        });
    });
    $(".Photo").on("click", function(){
        if($(".butt").hasClass("modbutton")) {
            ;
        }
        else {
            let photo = $(this).siblings(".photo_path");
            let confirm_but = confirm("確定刪除?");
            if(confirm_but) {
                $.ajax({
                url: "add_album.php",
                method: "POST",
                data: {album: album_name, mode: "remove", photo: photo.html()},
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