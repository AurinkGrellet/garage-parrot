addEventListener('input', e => {
    let _t = e.target;
    _t.parentNode.style.setProperty(`--${_t.id}`, +_t.value)
  }, false);

function filter() {
    var divIds = $.map($('#filterDiv > div'), div => div.id);
    var filterIds = {};
    for (const id of divIds) {
        var inputs = $.map($('#'+id+' > input'), input => input);
        for (const input of inputs) {
            var inputValue = document.getElementById(input.id).value;
            filterIds[input.id] = inputValue;
        }
    }

    var url = window.location.href + '/filter';
    $.ajax({
        type: "POST",
        data: filterIds,
        url: url,
        cache: false,
        success: function(response) {
            document.getElementById('car-loop-container').innerHTML = response.template;
        }
    });
}