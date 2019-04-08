var slimchatDiv = document.createElement('div');
var protocol = process.env.MIX_PUSHER_WS_HOST == 'slim.chat.test' ? 'http://' : 'https://'
slimchatDiv.innerHTML = `
    <iframe id="slimchat-bubble" src="` + protocol + process.env.MIX_PUSHER_WS_HOST + `/widget/bubble" style="
        width: 70px;
        height: 70px;
        position: fixed;
        bottom: 25px;
        right: 25px;
        border-radius: 9999px;
        box-shadow: 0 15px 30px 0 rgba(0,0,0,0.11),
            0 5px 15px 0 rgba(0,0,0,0.08);
    "></iframe>

    <iframe id="slimchat-window" src="` + protocol + process.env.MIX_PUSHER_WS_HOST + `/widget/window" style="
        width: 0;
        height: 0;
        max-width: calc(100vw - 50px);
        max-height: calc(100vh - 135px);
        position: fixed;
        bottom: 110px;
        right: 25px;
        border-radius: 10px;
        box-shadow: 0 15px 30px 0 rgba(0,0,0,0.11),
            0 5px 15px 0 rgba(0,0,0,0.08);

    "></iframe>
`;
document.body.appendChild(slimchatDiv);

window.addEventListener('message', function (message) {
    console.log('message received by parent');
    console.log(message)

   if (message.data.to === 'parent') {
        if (message.data.open) {
            document.getElementById('slimchat-window').style.width = '350px';
            document.getElementById('slimchat-window').style.height = '500px';
        } else {
            document.getElementById('slimchat-window').style.width = '0px';
            document.getElementById('slimchat-window').style.height = '0px';
        }
    }
}, false);
