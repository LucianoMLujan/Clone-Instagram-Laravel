var  url = 'http://clone-instagram.com.devel';

window.addEventListener("load", function() {

    $('.btn-like').css('cursor', 'pointer');
    $('btn-dislike').css('cursor', 'pointer');

    //Button like
    function like() {
        $('.btn-like').unbind('click').click(function() {
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src', url+'/img/heart-red.png');

            $.ajax({
                url: url+'/like/'+$(this).data('id'),
                type: 'GET',
                success: function(response) {
                    if(response.like) {
                        console.log('Like');
                    }else{
                        console.log('Error al dar like');
                    }
                }
            });

            dislike();
        });
    }
    like();

    //Button dislike
    function dislike() {
        $('.btn-dislike').unbind('click').click(function() {
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src', url+'/img/heart-gray.png');

            $.ajax({
                url: url+'/dislike/'+$(this).data('id'),
                type: 'GET',
                success: function(response) {
                    if(response.like) {
                        console.log('Dislike');
                    }else{
                        console.log('Error al dar dislike');
                    }
                }
            });

            like();
        });
    }
    dislike();



})