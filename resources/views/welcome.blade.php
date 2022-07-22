<!DOCTYPE html>

<html>
    <head>
        <title>Laravel WebSocket Example</title>
    </head>
    <body>
        <div id="div-data"></div>
        <script src='./js/app.js'></script>
        <script>
            window.Echo.channel('EventTriggered')
            .listen('GetRequestEvent', (e) => {
                console.log(e)
                document.querySelector('#div-data').innerHTML = e.message
            })
        </script>
    </body>
</html>
