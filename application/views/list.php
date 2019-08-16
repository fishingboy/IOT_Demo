<!doctype html>
<html>
<head>
    <title>IOT DEMO</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        window.setTimeout(function () {
            window.location.reload();
        }, 5000);

        var rows = <?= json_encode($rows) ?>;
        var labels = [];
        var celsius_array = [];
        var humidity_array = [];
        for (i in rows) {
            var row = rows[i];
            labels.push(row['time']);
            celsius_array.push(row['celsius']);
            humidity_array.push(row['humidity']);
        }

        $(function () {
            var ctx = document.getElementById('celsius_chart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: labels,
                    datasets: [{
                        label: '溫度監控圖表(攝氏)',
                        backgroundColor: 'rgb(233, 242, 254)',
                        borderColor: 'rgb(45, 130, 250)',
                        data: celsius_array
                    }]
                },

                // Configuration options go here
                options: {}
            });

            var ctx2 = document.getElementById('humidity_chart').getContext('2d');
            var chart = new Chart(ctx2, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: labels,
                    datasets: [{
                        label: '濕度監控圖表(%)',
                        backgroundColor: 'rgb(233, 242, 254)',
                        borderColor: 'rgb(45, 130, 250)',
                        data: humidity_array
                    }]
                },

                // Configuration options go here
                options: {}
            });
        });
    </script>
</head>
<body>
<h4>IOT DEMO</h4>
<div class="table-responsive" style="margin: 0 auto;">
    <br><h5>溫度濕度監控圖表</h5>
    <div >
        <div style="float: left; width: 49%;"><canvas id="celsius_chart"></canvas></div>
        <div style="float: right; width: 49%;"><canvas id="humidity_chart"></canvas></div>
        <div style="clear: both;"></div>
    </div>

    <br><h5>溫度濕度監控明細</h5>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>時間</th>
            <th>溫度</th>
            <th>濕度</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $row): ?>
        <tr>
            <td><?= $row['created_at'] ?></td>
            <td><?= $row['celsius'] ?></td>
            <td><?= $row['humidity'] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
