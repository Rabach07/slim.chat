<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/solid.css" integrity="sha384-r/k8YTFqmlOaqRkZuSiE9trsrDXkh07mRaoGBMoDcmA58OHILZPsk29i2BsFng1B" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/fontawesome.css" integrity="sha384-4aon80D8rXCGx9ayDt85LbyUHeMWd3UiBaWliBlJ53yzm9hqN21A+o1pqoyK04h+" crossorigin="anonymous">

    <link href="{{ mix('/css/widget.css') }}" rel="stylesheet">

    <style>
        div.sc-bubble {
            display: flex;
            align-items: center;
            width: 70px;
            height: 70px;
            line-height: 1em;
            font-size: 45px;
            color: white;
            border-radius: 9999px;
            background-color: green;
            box-shadow: 0 2px 4px 0 rgba(0,0,0,0.10);
            cursor: pointer;
        }
        div.sc-bubble div {
            flex: 1;
            text-align: center;
            line-height: 1em;
        }
    </style>
</head>
<body>
    <div class="sc-bubble" onclick="toggle()">
        <div>
            <i id="open" class="fas fa-fw fa-times" style="display: none;"></i>
            <i id="closed" class="fas fa-fw fa-life-ring"></i>
        </div>
    </div>

    <script>
        var open = false

        function toggle() {
            open = !open;

            document.getElementById('open').style.display = open ? 'inline' : 'none';
            document.getElementById('closed').style.display = open ? 'none' : 'inline';

            window.parent.postMessage({
                to: 'window',
                open: open
            });
        }
    </script>
</body>
</html>
