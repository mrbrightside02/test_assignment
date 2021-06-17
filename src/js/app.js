var tableOrder = [
    'Continent', 'Region',
    'Countries', 'lifeDuration',
    'Population', 'Cities', 'languages'
];

function requestWithCallback(data, callback) {
    var xhr = createXMLHTTPObject(),
        url = window.location.href,
        table = document.getElementById('content');

    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            table.innerHTML = "";
            var json = JSON.parse(xhr.responseText);
            json.forEach(function (item) {
                var tr = document.createElement('tr');
                tableOrder.map(function (key) {
                    var tableCell = document.createElement('td');
                    tableCell.innerText = item[key] || 0;
                    tr.appendChild(tableCell)
                });
                table.appendChild(tr)
            });

            callback();
        }
    };

    xhr.send(urlEncode(data));
}

(function () {
    var uiElements = Array.prototype.slice.call(document.getElementsByTagName('th'));
    uiElements.forEach(function (item) {
        item.addEventListener('click', function (e) {
            var clicked = e.target,
                orderField = clicked.getAttribute('data-order'),
                desc = !clicked.classList.contains('up');

            requestWithCallback({
                order: orderField,
                desc: desc
            }, function () {
                clicked.classList.remove(desc ? 'down' : 'up');
                clicked.classList.add(desc ? 'up' : 'down');
            });

            uiElements.filter(function (item) {
                return item !== clicked
            }).forEach(function (item) {
                item.classList.remove('up')
                item.classList.remove('down')
            });
        });
    })
})();
