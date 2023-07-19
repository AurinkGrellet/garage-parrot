function filter(reqId) {
    var value = document.getElementById(reqId).value;
    if (value != "") {
        data = { value: value };

        if (reqId.includes('price')) {
            var secondId;
            if (reqId == 'pricelow') {
                secondId = 'pricehigh';
            }
            else {
                secondId = 'pricelow';
            }
            secondValue = document.getElementById(secondId).value;
            if (secondValue > 0) {
                var lowValue = Math.min(value, secondValue);
                var highValue = Math.max(value, secondValue);
                document.getElementById('pricelow').value = lowValue
                document.getElementById('pricehigh').value = highValue
                data = { valuehigh: highValue, valuelow: lowValue }
                reqId = 'pricebetween';
                console.log(data);
            }
        }
        else if (reqId.includes('km')) {
            var kmType = document.getElementById('kmType').value;
            data = { value: value, type: kmType };
        }

        var url = window.location.href + '/filter/' + reqId;
        $.ajax({
            type: "POST",
            data: data,
            url: url,
            cache: false,
            success: function(response) {
                document.getElementById('car-loop-container').innerHTML = response.template;
            }
        });
    }
}