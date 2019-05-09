function submitForm(url){
    var data = $('#loginForm').serialize();
    $.ajax({
        type : 'POST',
        url  : url,
        data : data,
        success :  function(data){
            if (data == "teamview.php"){
                window.location.href = data;
            }else{
                $("#success").html(data);
            }
        }
    });
}
