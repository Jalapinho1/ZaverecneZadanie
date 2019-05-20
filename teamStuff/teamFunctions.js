$(".eval").click(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.

    var id = $(this).attr('id');
    var res  = id.split("-");
    console.log(res);
    var r = confirm("You accepted your points. If you press OK they can not be changed again.");
    if (r == true) {
        $.ajax({
            type : 'POST',
            url  : "teamStuff/agreementEval.php",
            data : {id:res[0],agreed:res[1],admin:res[2],subject:res[3],schoolyear:res[4]},
            success :  function(data){
                console.log(data);
                location.reload();
            }
        });
    } else {
    }
})

$(".groupForm").submit(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.

    var id = $(this).attr('id');
    var resultDivID =  id + "Result";
    var data = $('#'+id).serialize();
    $.ajax({
        type : 'POST',
        url  : "teamStuff/insertPoints.php",
        data : data,
        success :  function(data){
            console.log(data);
            $("#"+resultDivID).html(data);
        }
    });
})


function saveValues(){
    var values = [];
    var ids = [];
    $( ".sumStudentsPoints" ).each(function( index ) {
        values.push($(this).val());
        ids.push($(this).attr('id'));
        console.log($(this).attr('id'));
        console.log($(this).val());
    });
    $.ajax({
        type : 'POST',
        url  : "teamStuff/splitPoints.php",
        data : {idsArray:ids,valuesArray:values},
        success :  function(data){
            $("#res").html(data);
        }
    });
}

$("input[type='number'].sumStudentsPoints").change(function () {
    var max = $(this).attr('data-total');
    $.each($("input[type='number'].sumStudentsPoints"), function (index, element) {
        var total = 0;
        $.each($("input[type='number'].sumStudentsPoints").not($(element)), function (innerIndex, innerElement) {
            total += parseInt($(innerElement).val());
        });
        if ($(element).val() > max - total) {
            alert("The total value for all inputs can not exceed"+max);
            return false;
        } else {
            $(element).attr("max", max - total);
        }
    });
});
