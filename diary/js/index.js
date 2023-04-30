window.onload = function() {
    $('textarea').on('keydown', function(e) {
        if (e.keyCode === 9) { // Tab 鍵的 keyCode 是 9
            e.preventDefault(); // 阻止預設行為（插入 Tab 字符）
            var start = this.selectionStart;
            var end = this.selectionEnd;
            var value = $(this).val();
            $(this).val(value.substring(0, start) + '\t' + value.substring(end));
            this.selectionStart = this.selectionEnd = start + 1; // 將光標移到插入字符後面
        }
    });
    autosize(document.querySelectorAll('textarea'));
      
    document.getElementById('file-input').addEventListener('change', function() {
        $("#photo_path").html(this.files[0].name);
        $("#photo_path").css('display', 'block');
    });
    var send_button = document.querySelector('.sendbutton');
    send_button.onclick = function(event) {
        let content = $('.postArea').val();
        if(content != "") {
            let file = new FormData();
            if($("#photo_path").css("display") == "block") {
                file.append('img', $("#file-input")[0].files[0]);
            }
            
            file.append('content', content);
            $.ajax({
                url: "/diary/add_post.php",
                method: "POST",
                data: file,
                processData: false,
                contentType: false,
            }).done(function( msg ) {
                alert(msg);
                window.location.reload();
            }).fail(function(jqXHR, textStatus) {
                alert( "Ajax Error!" + textStatus);
            });
            textarea.value = "";
            $("#photo_path").css('display', 'none');
        }
        else {
            alert("請先輸入內容！");
        }
    }
    $(function() {
        $('.editbutton').on('click', function() {
            let pic = $(this).closest('.postBox').find('.post_pic');
            let content_area = $(this).closest('.postBox').find('.edit_area');
            let content_text = $(this).closest('.postBox').find('.post_content');
            if($(this).hasClass("editmode")) {
                if(pic.hasClass("post_pic")) {
                    pic.hide();
                }
                content_area.show();
                content_text.hide();
                $(this).addClass("confirmmode");
                $(this).removeClass("editmode");
                $(this).html("確定");
            }
            else {
                if(pic.hasClass("post_pic")) {
                    pic.show();
                }
                content_area.hide();
                content_text.show();
                $(this).removeClass("confirmmode");
                $(this).addClass("editmode");
                $(this).html("修改");
                let origin_post = content_text.html().replace('<br>', '\n').slice(0, -1);
                if(content_area.val() != origin_post) {
                    let timestemp = $(this).closest('.postBox').find(".timestamp").text();
                    let has_pic = "";
                    if(pic.hasClass("post_pic")) {
                        has_pic = pic.attr('src');
                    }
                    else {
                        has_pic = "none";
                    }
                    $('body').css('cursor', 'wait');
                    $.ajax({
                        url: "/diary/edit_post.php",
                        method: "POST",
                        data: {time: timestemp, content : content_area.val(), pic:has_pic},
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
    });
}
