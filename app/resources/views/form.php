<!DOCTYPE html>
<html lang="en">
<head>
    <title>Insurance Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<div class="container">

    <div class="col-md-6 offset-md-3 mt-4">
        <form method="POST" id="send-form">
            <div class="form-group">
                <label for="car_value">Value of the car</label>
                <input type="text" name="car_value" class="form-control" placeholder="Value of the car">
                <small id="car_value" class="form-text text-danger"></small>
            </div>
            <div class="form-group">
                <label for="tax">Tax Percentage</label>
                <input type="text" name="tax" class="form-control" placeholder="Tax Percentage">
                <small id="tax" class="form-text text-danger"></small>
            </div>
            <div class="form-group">
                <label for="quantity">Number of instalments</label>
                <input type="number" name="quantity" class="form-control" placeholder="Number of instalments" min="1">
                <small id="quantity" class="form-text text-danger"></small>
            </div>

            <button type="submit" class="btn btn-primary">Calculate</button>
        </form>
    </div>

    <table id="insurance-table" class="table mt-4" style="width: auto"></table>

</div>
</body>
<script>

    document.querySelector('#send-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const inputs = document.querySelector("form").elements;
        const values = {};

        for (var i = 0; i < inputs.length; i++) {
            values[inputs[i].name] = inputs[i].value;
        }

        var d = new Date();
        values['userTime'] = "" + d.getHours() + d.getMinutes();
        values['userDay'] = d.getDay();

        var formData = JSON.stringify(values);

        // event handler
        function reqListener () {
            //
        }

        // get new XHR object
        var newXHR = new XMLHttpRequest();

        // "load" is fired when the response to our request is completed and without error.
        newXHR.addEventListener( 'load', reqListener );
        newXHR.open( 'POST', 'insurance/calculate' );
        newXHR.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

        newXHR.onload = function () {
            if (newXHR.status === 200) {

                let response = JSON.parse(newXHR.responseText);

                //clearing errors
                let errorFields = document.getElementsByTagName('small');

                for (var i = 0; i < errorFields.length; i++) {
                    errorFields[i].innerText = '';
                }

                //set errors, if exist
                Object.entries(response.errors).forEach(entry => {
                    document.getElementById(entry[0]).innerText = entry[1];
                });

                //clear table data
                let table = document.getElementById("insurance-table");
                table.innerHTML = '';

                if (response.code !== 200) {
                    return;
                }

                //building table
                let tBody = table.createTBody();
                let tr, td;
                let count = 0;

                Object.entries(response.data.row_titles).forEach(([key, entry]) => {

                    tr = tBody.insertRow();

                    //adding row titles
                    td = tr.insertCell();
                    td.innerHTML = entry;
                    tr.appendChild(td);

                    //adding policy data
                    td = tr.insertCell();
                    td.innerHTML = response.data.policy[key];
                    tr.appendChild(td);

                    //adding instalments
                    Object.entries(response.data.instalments).forEach(([instalmentKey, instalment]) => {

                        td = tr.insertCell();
                        td.innerHTML = instalment[Object.keys(instalment)[count]];
                        tr.appendChild(td);

                    });

                    count ++;
                });
            }
        };

        newXHR.send( formData );
    });

</script>
</html>