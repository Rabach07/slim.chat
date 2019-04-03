var slimchatDiv = document.createElement('div');
slimchatDiv.innerHTML = `
    <iframe id="slimchat-bubble" src="https://slim.chat.test/widget/bubble" style="
        width: 70px;
        height: 70px;
        position: fixed;
        bottom: 25px;
        right: 25px;
        border-radius: 9999px;
        box-shadow: 0 15px 30px 0 rgba(0,0,0,0.11),
            0 5px 15px 0 rgba(0,0,0,0.08);
    "></iframe>

    <iframe id="slimchat-window" src="https://slim.chat.test/widget/window" style="
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

    if (message.data.to === 'bubble') {
        document.getElementById('slimchat-bubble').contentWindow.postMessage({
            open: message.data.open
        })
    } else if (message.data.to === 'window') {
        document.getElementById('slimchat-window').contentWindow.postMessage({
            open: message.data.open
        })
    } else if (message.data.to === 'parent') {
        document.getElementById('slimchat-window').style.width = message.data.data.width;
        document.getElementById('slimchat-window').style.height = message.data.data.height;
    }
}, false);
