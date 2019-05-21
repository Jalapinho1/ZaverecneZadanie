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

function submitForm1(url){
    var data = $('#loginForm').serialize();
    $.ajax({
        type : 'POST',
        url  : url,
        data : data,
        success :  function(data){
            if (data == "teamview.php"){
                window.location.href = "teamview1.php";
            }else{
                $("#success").html(data);
            }
        }
    });
}


$("#stats").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);

    $.ajax({
        type: "POST",
        url: 'teamStuff/statistics.php',
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
            console.log(data);
            var numbers = JSON.parse(data);
            var graphData = [{
                values: [numbers[0][1], numbers[0][2], numbers[0][3]],
                labels: ['Súhlasili', 'Nesúhlasili', 'Nevyjadrili sa'],
                type: 'pie'
            }];

            var layout = {
                title: 'Počet študentov '+numbers[0][0],
                height: 400,
                width: 500
            };

            Plotly.newPlot('graphDiv', graphData, layout);

            var graphData2 = [{
                values: [numbers[1][1], numbers[1][2], numbers[1][3]],
                labels: ['Uzatvorené tímy','Treba sa vyjadriť', 'Nesuhlasi s rozdelenim'],
                type: 'pie'
            }];
            var layout2 = {
                title: 'Počet tímov '+numbers[1][0],
                height: 400,
                width: 500
            };

            Plotly.newPlot('graphDiv2', graphData2, layout2);
        }
    });


});
