window._ = require('lodash');
import Echo from 'laravel-echo';

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
let baseURL = document.head.querySelector('meta[name="base-url"]');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseURL = baseURL.content;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });




//購読するチャネルの設定
/*let channel = window.Echo.channel('favorite')
    .listen('Favorited', (e) => {
        console.log("イベントが発生した");
        console.log(e);
    });
channel.error((error)=>{
    console.log(error);
    console.log("エラー発生");
})
console.log(window.Echo.connector.socket);*/


/*window.Echo.connector.socket.on('connect', () => {
    //your code
    console.log("接続完了");
});
window.Echo.connector.socket.on('reconnecting', (attemptNumber) => {
    //your code
    console.log(`%cSocket reconnecting attempt ${attemptNumber}`, 'color:orange; font-weight:700;');
  });
window.Echo.connector.socket.on('connect', ()=>{
    console.log("接続完了");
})
window.Echo.connector.socket.on('connectiong', ()=>{
    console.log("接続を試行しています");
})
window.Echo.connector.socket.on('disconnect', ()=>{
    console.log("切断されました");
})

window.Echo.connector.socket.on('connect_failed', ()=>{
    console.log("接続に失敗しました");
})

window.Echo.connector.socket.on('message', (msg)=>{
    console.log('メッセージを受信しました')
    console.log(msg);
})

window.Echo.connector.socket.on('error', ()=>{
    console.log("エラーが発生しました");
})

window.Echo.connector.socket.on('reconnect', ()=>{
    console.log("再接続しました");
})

window.Echo.connector.socket.on('reconnectiong', ()=>{
    console.log('再接続しています');
})

window.Echo.connector.socket.on('reconnect_failed', ()=>{
    console.log('再接続に失敗しました');
})

//console.log(channel);
console.log(window.Echo);
console.log("初期処理完了");
*/
/*setInterval(()=>{
    console.log(window.Echo);
    console.log(window.Echo.connector);
    window.Echo.connect();
}, 2000);
*/
/*window.Echo.connector.socket.on('connect', function(){
    console.log('connected');
    this.isConnected = true
})

window.Echo.connector.socket.on('disconnect', function(){
    console.log('dissconnect');
    this.isConnected = false
})

window.Echo.private('contacts').listen('ContactUpdated', event => {
    console.log(event)
})
*/