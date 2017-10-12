function AppModule() {
    function search(q) {
        fetch('api.php?q='+q).then(function(response) {
            return response.json();
        }).then(function(body) {
            var resultDiv = document.getElementById('results');

            body.forEach(function(result) {
                var img = document.createElement('img');
                img.src = result.url;
                resultDiv.appendChild(img);
            });
        });
    }

    return {
        search: search,
    }
}
