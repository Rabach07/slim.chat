<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/solid.css" integrity="sha384-r/k8YTFqmlOaqRkZuSiE9trsrDXkh07mRaoGBMoDcmA58OHILZPsk29i2BsFng1B" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/fontawesome.css" integrity="sha384-4aon80D8rXCGx9ayDt85LbyUHeMWd3UiBaWliBlJ53yzm9hqN21A+o1pqoyK04h+" crossorigin="anonymous">

    <link href="{{ env('APP_ENV') == 'local' ? mix('/css/widget.css') : '/css/widget.css' }}" rel="stylesheet">

    <script>
        // For testing
        window.slimchat = {
            app_id: '12345'
        };
    </script>
</head>
<body>
    <div id="app">
        <chat-widget v-if="ready" :app_id="app_id" :visitor_uuid="visitor_uuid"
        :settings="{logo:'',colors:{primary:'',contrast:''}}" />
    </div>

    <script src="{{ env('APP_ENV') == 'local' ? mix('js/widget.js') : '/js/widget.js' }}"></script>
</body>
</html>
