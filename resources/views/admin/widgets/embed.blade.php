<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <script>
        var s = document.createElement('script');
        s.src = "http://localhost:8000/storage/embed.js";
        s.async = true;
        // This global is picked up by init.js whenever it loads
        window.kodsana_options = {
            widget_id: 29
        };
        document.body.appendChild(s);
    </script>
    <div id="load_widget">Loading...</div>
</body>

</html>